<!DOCTYPE html>
<html>
<head>
    <title>Status Updated</title>
</head>
<body>
    <h1>สถานะลูกค้าได้ถูกอัปเดต</h1>
    <p>Admin Area: {{ $status?->admin_area }}</p>
    <p>Sale Area: {{ $status?->sale_area }}</p>
    <p>Status: {{ $status->status_update }}</p>
    <p>ประเภท: ทั้งหมด</p>
    <p>วันที่อัปเดต: {{ $status->updated_at }}</p>
</body>
</html>
