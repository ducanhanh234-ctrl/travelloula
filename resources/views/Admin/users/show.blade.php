@extends('layouts.admin')

@section('content')
    <style>
        .user-detail-page {
            padding: 24px 0;
        }

        .user-detail-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        .user-detail-header {
            background: linear-gradient(135deg, #0d6efd, #5b9dff);
            color: #fff;
            padding: 20px 24px;
        }

        .user-detail-header h3 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }

        .user-detail-body {
            padding: 24px;
            background: #fff;
        }

        .detail-row {
            display: flex;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid #edf2f7;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            width: 180px;
            min-width: 180px;
            font-weight: 700;
            color: #334155;
        }

        .detail-value {
            flex: 1;
            color: #475569;
            word-break: break-word;
        }

        .role-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 999px;
            background: #e7f1ff;
            color: #0d6efd;
            font-size: 13px;
            font-weight: 700;
        }

        .detail-actions {
            margin-top: 18px;
            display: flex;
            gap: 10px;
        }

        .detail-actions .btn {
            min-width: 100px;
            border-radius: 8px;
            font-weight: 600;
        }

        @media (max-width: 576px) {
            .user-detail-body {
                padding: 18px;
            }

            .detail-row {
                align-items: flex-start;
                flex-direction: column;
                gap: 6px;
            }

            .detail-label {
                width: 100%;
                min-width: unset;
            }

            .detail-actions {
                flex-direction: column;
            }

            .detail-actions .btn {
                width: 100%;
            }
        }
    </style>

    <div class="container user-detail-page">
        <div class="card user-detail-card">
            <div class="user-detail-header">
                <h3>Chi tiết người dùng</h3>
            </div>

            <div class="user-detail-body">
                <div class="detail-row">
                    <div class="detail-label">Tên:</div>
                    <div class="detail-value">{{ $user->name }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value">{{ $user->email }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Điện thoại:</div>
                    <div class="detail-value">{{ $user->phone }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Địa chỉ:</div>
                    <div class="detail-value">{{ $user->address }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Vai trò:</div>
                    <div class="detail-value">
                        <span class="role-badge">
                            {{ $user->vaiTros->pluck('ten_vai_tro')->join(', ') ?: 'Chưa có vai trò' }}
                        </span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Ngày tạo:</div>
                    <div class="detail-value">{{ $user->created_at }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Cập nhật:</div>
                    <div class="detail-value">{{ $user->updated_at }}</div>
                </div>

                <div class="detail-actions">
                    <a class="btn btn-secondary" href="{{ route('Admin.users.index') }}">
                        Quay lại
                    </a>

                    @php $currentUser = auth()->user(); @endphp
                    @if ($currentUser && $currentUser->hasPermission('users.edit'))
                        <a class="btn btn-primary" href="{{ route('Admin.users.edit', $user->id) }}">
                            Sửa
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
