# TODO: Fix Check-in Guide Bug

## Bug

Khi guide check-in xuất phát (CONFIRM_XUATPHAT) cho hoạt động đầu tiên của ngày 1, nhưng khi truy cập hoạt động thứ hai của ngày 1 bị chặn vì kiểm tra sai.

## Steps

- [x]   1. Analyze the code and identify the bug
- [x]   2. Get user approval
- [x]   3. Fix: Remove `->where('chi_tiet_lich_trinh_id', $chiTietId)` from the departure confirmation check in `show()` method
- [x]   4. Verify the fix
