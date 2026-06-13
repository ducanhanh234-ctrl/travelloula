<?php
// Script to analyze and fix migration ordering based on foreign key dependencies

$migrationsDir = __DIR__ . '/database/migrations';
$files = array_diff(scandir($migrationsDir), ['.', '..']);
sort($files);

$migrations = [];
$dependencies = [];

// Parse each migration file to extract table name and dependencies
foreach ($files as $file) {
    if (!str_ends_with($file, '.php')) continue;

    $content = file_get_contents("$migrationsDir/$file");

    // Extract table name from Schema::create('table_name'
    if (preg_match("/Schema::create\('([^']+)'/", $content, $matches)) {
        $tableName = $matches[1];
        $migrations[$file] = $tableName;

        // Find all foreign key references
        $refs = [];

        // Match ->on('table') pattern
        if (preg_match_all("/->on\('([^']+)'\)/", $content, $matches)) {
            $refs = array_merge($refs, $matches[1]);
        }

        // Match ->constrained('table') pattern
        if (preg_match_all("/->constrained\('([^']+)'\)/", $content, $matches)) {
            $refs = array_merge($refs, $matches[1]);
        }

        $dependencies[$file] = array_unique($refs);
    }
}

// Sort migrations based on dependencies
$sorted = topologicalSort($migrations, $dependencies);

// Rename files with new timestamps
$counter = 0;
$renameMap = [];

foreach ($sorted as $oldFile) {
    // Generate new timestamp that's after 2026_06_12_050000
    $newTimestamp = '2026_06_12_' . str_pad(50000 + ($counter++ * 100), 6, '0', STR_PAD_LEFT);
    $tableName = $migrations[$oldFile];

    // Extract description from filename
    preg_match('/\d+_(.+)\.php$/', $oldFile, $matches);
    $description = $matches[1];

    $newFile = "{$newTimestamp}_{$description}.php";
    $renameMap[$oldFile] = $newFile;

    echo "Rename: $oldFile -> $newFile\n";
}

// Output a PowerShell script to do the renames
echo "\n\n=== PowerShell Rename Commands ===\n";
foreach ($renameMap as $old => $new) {
    echo "ren \"$old\" \"$new\"\n";
}

function topologicalSort($migrations, $dependencies) {
    $sorted = [];
    $visited = [];
    $visiting = [];

    $files = array_keys($migrations);

    foreach ($files as $file) {
        if (!isset($visited[$file])) {
            visit($file, $migrations, $dependencies, $visited, $visiting, $sorted);
        }
    }

    return $sorted;
}

function visit($file, $migrations, $dependencies, &$visited, &$visiting, &$sorted) {
    if (isset($visiting[$file])) {
        // Cycle detected
        return;
    }

    if (isset($visited[$file])) {
        return;
    }

    $visiting[$file] = true;

    $tableCreated = $migrations[$file];
    $deps = $dependencies[$file] ?? [];

    // Find which files create the tables this file depends on
    foreach ($files = array_keys($migrations) as $otherFile) {
        if ($otherFile === $file) continue;

        $otherTable = $migrations[$otherFile];

        if (in_array($otherTable, $deps)) {
            visit($otherFile, $migrations, $dependencies, $visited, $visiting, $sorted);
        }
    }

    unset($visiting[$file]);
    $visited[$file] = true;
    $sorted[] = $file;
}
?>
