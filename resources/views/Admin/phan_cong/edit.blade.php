@extends('layouts.admin')

@section('title', 'Cập nhật phân công')

@push('styles')
<style>
    /* Custom Dropdown Wrapper */
    .custom-dropdown-wrapper {
        position: relative;
    }

    /* Style cho ô input tìm kiếm */
    .search-input-group {
        cursor: pointer;
    }

    .search-input-group .input-group-text {
        background-color: #fff;
        border-right: none;
    }

    .search-input-group .form-control {
        border-left: none;
        cursor: pointer;
    }

    .search-input-group .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }

    .search-input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        border-radius: 0.375rem;
    }

    .search-input-group:focus-within .input-group-text,
    .search-input-group:focus-within .form-control {
        border-color: #86b7fe;
    }

    /* Khung Dropdown chứa checkbox */
    .custom-dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        max-height: 250px;
        overflow-y: auto;
        z-index: 1050;
        padding: 0.5rem;
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 5px;
    }

    .custom-dropdown-menu.show {
        display: block;
        animation: fadeIn 0.2s ease-in-out;
    }

    /* Các item checkbox bên trong */
    .custom-dropdown-item {
        cursor: pointer;
        transition: all 0.2s;
        border-radius: 6px;
    }

    .custom-dropdown-item:hover {
        background-color: #f1f5f9;
    }

    .custom-dropdown-item .form-check-input {
        cursor: pointer;
        margin-top: 0;
    }

    /* Tùy chỉnh thanh cuộn cho dropdown */
    .custom-dropdown-menu::-webkit-scrollbar {
        width: 6px;
    }

    .custom-dropdown-menu::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .custom-dropdown-menu::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }

    .custom-dropdown-menu::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

</style>
@endpush

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('Admin.phan-cong.index') }}" class="text-decoration-none">Quản lý phân công</a>
</li>
<li class="breadcrumb-item active">Cập nhật phân công</li>
@endsection

@section('content')
<div class="fade-in">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark">Cập Nhật Phân Công</h3>
            <p class="text-muted mb-0">Chỉnh sửa hướng dẫn viên và phương tiện</p>
        </div>
        <a href="{{ route('Admin.phan-cong.index') }}" class="btn btn-light border shadow-sm rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <!-- Main Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
            <h5 class="mb-0 text-primary fw-bold">
                <i class="fas fa-edit me-2"></i>Thông Tin Chỉnh Sửa
            </h5>
        </div>
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card-body p-4">
            <form action="{{ route('Admin.phan-cong.update', $phanCong->id) }}" method="POST">
                @csrf
                @method('PUT')

                @php
                // Xử lý mảng cho HDV đã chọn
                $rawHdvIds = old('hdv_ids', $phanCong->hdv_ids ?? [$phanCong->hdv_id ?? null]);
                $selectedHdvIds = is_array($rawHdvIds) ? $rawHdvIds : [$rawHdvIds];
                // Loại bỏ giá trị rỗng/null
                $selectedHdvIds = array_filter($selectedHdvIds);

                // Xử lý mảng cho Phương tiện đã chọn
                $rawVehicleIds = old('phuong_tien_ids', $phanCong->phuong_tien_ids ?? [$phanCong->phuong_tien_id ?? null]);
                $selectedVehicleIds = is_array($rawVehicleIds) ? $rawVehicleIds : [$rawVehicleIds];
                // Loại bỏ giá trị rỗng/null
                $selectedVehicleIds = array_filter($selectedVehicleIds);
                @endphp

                <!-- Info Lịch Khởi Hành -->
                <div class="bg-light p-3 rounded-3 border mb-4">
                    <input type="hidden" name="lich_khoi_hanh_id" value="{{ $phanCong->lichKhoiHanh->id }}">
                    <div class="d-flex justify-content-between align-items-center border rounded p-3 bg-light shadow-sm">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-route text-primary fs-4 me-3"></i>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark">
                                    {{ $phanCong->lichKhoiHanh->tour->ten_tour }}
                                </h5>
                                <small class="text-muted">
                                    Mã lịch: #{{ $phanCong->lichKhoiHanh->id }}
                                </small>
                            </div>
                        </div>

                        <span class="badge bg-primary fs-6 px-3 py-2">
                            {{ $phanCong->lichKhoiHanh->so_cho_da_dat }}/{{ $phanCong->lichKhoiHanh->so_cho }} Chỗ
                        </span>
                    </div>
                    <div class="text-muted d-flex align-items-center">
                        <div class="bg-white px-3 py-1 rounded border shadow-sm">
                            <i class="far fa-calendar-alt text-success me-2"></i>
                            <span class="fw-bold text-dark">{{ date('d/m/Y', strtotime($phanCong->lichKhoiHanh->ngay_khoi_hanh)) }}</span>
                        </div>
                        <i class="fas fa-long-arrow-alt-right mx-3 text-muted"></i>
                        <div class="bg-white px-3 py-1 rounded border shadow-sm">
                            <i class="far fa-calendar-check text-danger me-2"></i>
                            <span class="fw-bold text-dark">{{ date('d/m/Y', strtotime($phanCong->lichKhoiHanh->ngay_ket_thuc)) }}</span>
                        </div>
                    </div>
                    @error('lich_khoi_hanh_id')
                    <div class="text-danger mt-2 small"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-4">
                    <!-- Phương Tiện -->
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 h-100">
                            <label class="form-label fw-bold text-dark mb-3">
                                <i class="fas fa-bus text-primary me-2"></i>Chọn Phương Tiện
                                <span class="badge bg-secondary ms-1 fw-normal">Tối thiểu 1</span>
                            </label>

                            <div class="custom-dropdown-wrapper">
                                <!-- Thanh tìm kiếm -->
                                <div class="input-group mb-2 search-input-group" id="vehicle-search-wrapper">
                                    <span class="input-group-text"><i class="fas fa-search text-muted"></i></span>
                                    <input type="text" id="vehicle-search" class="form-control" placeholder="Bấm để tìm và chọn phương tiện..." autocomplete="off">
                                </div>

                                <!-- Dropdown Danh sách Checkbox -->
                                <div class="custom-dropdown-menu" id="vehicle-dropdown">
                                    <div class="text-center p-3">
                                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                                            <span class="visually-hidden">Đang tải...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Vùng hiển thị tag -->
                            <div id="vehicle-selected-tags" class="d-flex flex-wrap gap-2 mt-2"></div>

                            <div class="small text-primary mt-3">
                                <i class="fas fa-info-circle me-1"></i>Vui lòng chọn phương tiện để kích hoạt danh sách Hướng dẫn viên.
                            </div>

                            @error('phuong_tien_ids')
                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Hướng Dẫn Viên -->
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 h-100 bg-white" id="guide-container">
                            <label class="form-label fw-bold text-dark mb-3">
                                <i class="fas fa-user-tie text-success me-2"></i>Chọn Hướng Dẫn Viên
                                <span class="badge bg-secondary ms-1 fw-normal">Phụ thuộc số xe</span>
                            </label>

                            <div class="custom-dropdown-wrapper">
                                <!-- Thanh tìm kiếm -->
                                <div class="input-group mb-2 search-input-group" id="guide-search-wrapper">
                                    <span class="input-group-text"><i class="fas fa-search text-muted"></i></span>
                                    <input type="text" id="guide-search" class="form-control" placeholder="Bấm để tìm và chọn Hướng dẫn viên..." autocomplete="off" disabled>
                                </div>

                                <!-- Dropdown Danh sách Checkbox -->
                                <div class="custom-dropdown-menu" id="guide-dropdown">
                                    <div class="text-center p-3">
                                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                                            <span class="visually-hidden">Đang tải...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Vùng hiển thị tag -->
                            <div id="guide-selected-tags" class="d-flex flex-wrap gap-2 mt-2"></div>

                            <div class="small text-muted mt-3 fw-medium" id="guide-help">
                                <i class="fas fa-lock me-1"></i>Vui lòng chọn phương tiện trước.
                            </div>

                            @error('hdv_ids')
                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Ghi chú -->
                    <div class="col-md-12 mt-4">
                        <label class="form-label fw-bold text-dark">
                            <i class="fas fa-sticky-note text-warning me-2"></i>Ghi Chú Phân Công
                        </label>
                        <textarea name="ghi_chu" class="form-control bg-light @error('ghi_chu') is-invalid @enderror" rows="4" placeholder="Nhập lưu ý hoặc yêu cầu đặc biệt cho phân công này...">{{ old('ghi_chu', $phanCong->ghi_chu) }}</textarea>
                        @error('ghi_chu')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4 text-muted">

                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('Admin.phan-cong.index') }}" class="btn btn-light border px-4 rounded-pill">
                        Hủy Bỏ
                    </a>
                    <button type="submit" class="btn btn-primary px-4 shadow rounded-pill">
                        <i class="fas fa-save me-2"></i>Cập Nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const vehicleSearch = document.getElementById('vehicle-search');
        const vehicleDropdown = document.getElementById('vehicle-dropdown');
        const vehicleTags = document.getElementById('vehicle-selected-tags');

        const guideSearch = document.getElementById('guide-search');
        const guideDropdown = document.getElementById('guide-dropdown');
        const guideTags = document.getElementById('guide-selected-tags');

        const guideContainer = document.getElementById('guide-container');
        const guideHelp = document.getElementById('guide-help');

        const phanCongId = {{ $phanCong->id }};
        const selectedVehicleIdsOld = {!! json_encode($selectedVehicleIds) !!};
        const selectedGuideIdsOld = {!! json_encode($selectedHdvIds) !!};
        
        let availableVehicles = [];
        let availableGuides = [];
        let selectedVehicleIds = [...selectedVehicleIdsOld];
        let selectedGuideIds = [...selectedGuideIdsOld];

        // Hàm mở/đóng dropdown
        function toggleDropdown(inputEl, dropdownEl, forceOpen = false) {
            if (inputEl.disabled) return;

            // Đóng tất cả các dropdown khác trước
            document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
                if (menu !== dropdownEl) menu.classList.remove('show');
            });

            if (forceOpen) {
                dropdownEl.classList.add('show');
            } else {
                dropdownEl.classList.toggle('show');
            }
        }

        // Gọi API lấy danh sách xe không bị trùng lịch (exclude current phan cong)
        async function loadAvailableVehicles() {
            try {
                const response = await fetch(`{{ route('phan-cong.api.available-vehicles') }}?lich_khoi_hanh_id={{ $phanCong->lichKhoiHanh->id }}&exclude_phan_cong_id=${phanCongId}`);
                const data = await response.json();
                
                if (data.success) {
                    availableVehicles = data.data;
                    renderVehicleDropdown();
                } else {
                    vehicleDropdown.innerHTML = '<div class="text-muted text-center p-2 small">Không thể tải danh sách phương tiện</div>';
                }
            } catch (error) {
                console.error('Lỗi tải danh sách xe:', error);
                vehicleDropdown.innerHTML = '<div class="text-danger text-center p-2 small">Lỗi khi tải danh sách</div>';
            }
        }

        // Render dropdown phương tiện
        function renderVehicleDropdown() {
            vehicleDropdown.innerHTML = '';

            if (availableVehicles.length === 0) {
                vehicleDropdown.innerHTML = '<div class="text-muted text-center p-2 small">Không có phương tiện khả dụng</div>';
                return;
            }

            availableVehicles.forEach(xe => {
                const label = document.createElement('label');
                label.className = 'custom-dropdown-item d-flex align-items-center p-2 mb-1 w-100';
                
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.id = `vehicle_${xe.id}`;
                checkbox.name = 'phuong_tien_ids[]';
                checkbox.value = xe.id;
                checkbox.className = 'form-check-input me-2 vehicle-checkbox';
                checkbox.checked = selectedVehicleIds.includes(xe.id);
                
                const span = document.createElement('span');
                span.className = 'text-dark';
                span.innerHTML = `🚌 ${xe.bien_so_xe} &nbsp;|&nbsp; <span class="text-muted">${xe.loai_phuong_tien}</span>`;
                
                label.appendChild(checkbox);
                label.appendChild(span);
                vehicleDropdown.appendChild(label);
                
                checkbox.addEventListener('change', updateVehicleState);
            });
        }

        // Gọi API lấy danh sách HDV không bị trùng lịch (exclude current phan cong)
        async function loadAvailableGuides() {
            try {
                const response = await fetch(`{{ route('phan-cong.api.available-guides') }}?lich_khoi_hanh_id={{ $phanCong->lichKhoiHanh->id }}&exclude_phan_cong_id=${phanCongId}`);
                const data = await response.json();
                
                if (data.success) {
                    availableGuides = data.data;
                    renderGuideDropdown();
                } else {
                    guideDropdown.innerHTML = '<div class="text-muted text-center p-2 small">Không thể tải danh sách hướng dẫn viên</div>';
                }
            } catch (error) {
                console.error('Lỗi tải danh sách HDV:', error);
                guideDropdown.innerHTML = '<div class="text-danger text-center p-2 small">Lỗi khi tải danh sách</div>';
            }
        }

        // Render dropdown HDV
        function renderGuideDropdown() {
            guideDropdown.innerHTML = '';

            if (availableGuides.length === 0) {
                guideDropdown.innerHTML = '<div class="text-muted text-center p-2 small">Không có hướng dẫn viên khả dụng</div>';
                return;
            }

            availableGuides.forEach(hdv => {
                const label = document.createElement('label');
                label.className = 'custom-dropdown-item d-flex align-items-center p-2 mb-1 w-100';
                
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.id = `guide_${hdv.id}`;
                checkbox.name = 'hdv_ids[]';
                checkbox.value = hdv.id;
                checkbox.className = 'form-check-input me-2 guide-checkbox';
                checkbox.disabled = true;
                checkbox.checked = selectedGuideIds.includes(hdv.id);
                
                const span = document.createElement('span');
                span.className = 'text-dark';
                span.innerHTML = `👤 ${hdv.ho_ten}`;
                
                label.appendChild(checkbox);
                label.appendChild(span);
                guideDropdown.appendChild(label);
                checkbox.addEventListener('change', updateGuideState);
            });
        }

        // Cập nhật giao diện Phương Tiện
        function updateVehicleState() {
            vehicleTags.innerHTML = '';
            selectedVehicleIds = [];

            const checkboxes = vehicleDropdown.querySelectorAll('.vehicle-checkbox');
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    selectedVehicleIds.push(parseInt(cb.value));
                    const vehicle = availableVehicles.find(v => v.id == cb.value);
                    if (vehicle) {
                        const tag = document.createElement('span');
                        tag.className = 'badge bg-primary px-3 py-2 shadow-sm fw-normal d-inline-flex align-items-center';
                        tag.innerHTML = `🚌 ${vehicle.bien_so_xe} <i class="fas fa-times ms-2" style="cursor:pointer" onclick="uncheckById('${cb.id}')"></i>`;
                        vehicleTags.appendChild(tag);
                    }
                }
            });

            // Kích hoạt/vô hiệu hóa HDV dựa trên số xe
            const guideCheckboxes = guideDropdown.querySelectorAll('.guide-checkbox');
            if (selectedVehicleIds.length > 0) {
                guideSearch.disabled = false;
                guideCheckboxes.forEach(cb => cb.disabled = false);
                guideContainer.classList.remove('bg-light', 'opacity-75');
                guideHelp.classList.remove('text-muted');
                guideHelp.classList.add('text-success');
                guideHelp.innerHTML = `<i class="fas fa-check-circle me-1"></i>Đã chọn <b>${selectedVehicleIds.length}</b> xe. Bạn cần chọn tối thiểu <b>${selectedVehicleIds.length}</b> Hướng dẫn viên.`;
            } else {
                guideSearch.disabled = true;
                guideCheckboxes.forEach(cb => {
                    cb.disabled = true;
                    cb.checked = false;
                });
                selectedGuideIds = [];
                updateGuideState();

                guideContainer.classList.add('bg-light', 'opacity-75');
                guideHelp.classList.remove('text-success');
                guideHelp.classList.add('text-muted');
                guideHelp.innerHTML = `<i class="fas fa-lock me-1"></i>Vui lòng chọn phương tiện trước.`;
            }
        }

        // Cập nhật giao diện HDV
        function updateGuideState() {
            guideTags.innerHTML = '';
            selectedGuideIds = [];

            const checkboxes = guideDropdown.querySelectorAll('.guide-checkbox');
            checkboxes.forEach(cb => {
                if (cb.checked && !cb.disabled) {
                    selectedGuideIds.push(parseInt(cb.value));
                    const guide = availableGuides.find(g => g.id == cb.value);
                    if (guide) {
                        const tag = document.createElement('span');
                        tag.className = 'badge bg-success px-3 py-2 shadow-sm fw-normal d-inline-flex align-items-center';
                        tag.innerHTML = `👤 ${guide.ho_ten} <i class="fas fa-times ms-2" style="cursor:pointer" onclick="uncheckById('${cb.id}')"></i>`;
                        guideTags.appendChild(tag);
                    }
                }
            });
            const requiredGuides = selectedVehicleIds.length;

const guideCheckboxes = guideDropdown.querySelectorAll('.guide-checkbox');

if (selectedGuideIds.length >= requiredGuides) {
    guideCheckboxes.forEach(cb => {
        if (!cb.checked) {
            cb.disabled = true;
        }
    });
} else {
    guideCheckboxes.forEach(cb => {
        cb.disabled = false;
    });
}
        }

        // Bấm vào ô input để mở danh sách
        vehicleSearch.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleDropdown(vehicleSearch, vehicleDropdown, true);
        });

        guideSearch.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleDropdown(guideSearch, guideDropdown, true);
        });

        // Bấm ra ngoài để đóng dropdown
        document.addEventListener('click', () => {
            document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        });

        // Ngăn sự kiện click bên trong dropdown làm đóng nó
        document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
            menu.addEventListener('click', (e) => e.stopPropagation());
        });

        // Chức năng tìm kiếm realtime
        function setupFilter(searchEl, dropdownEl) {
            searchEl.addEventListener('input', function() {
                toggleDropdown(searchEl, dropdownEl, true);
                const filter = this.value.toLowerCase();
                const items = dropdownEl.querySelectorAll('.custom-dropdown-item');

                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(filter) ? 'flex' : 'none';
                });
            });
        }
        setupFilter(vehicleSearch, vehicleDropdown);
        setupFilter(guideSearch, guideDropdown);

        // Hàm bỏ chọn qua Tag
        window.uncheckById = function(checkboxId) {
            const cb = document.getElementById(checkboxId);
            if (cb && !cb.disabled) {
                cb.checked = false;
                cb.dispatchEvent(new Event('change'));
            }
        };

        // Tải danh sách lúc khởi động
        loadAvailableVehicles();
        loadAvailableGuides();
    });
</script>
@endpush
@endsection
