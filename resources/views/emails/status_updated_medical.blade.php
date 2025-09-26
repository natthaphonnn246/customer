<!DOCTYPE html>
<html>
<head>
    <title>Status Updated</title>
</head>
<body>
    <h1>สถานะลูกค้าได้ถูกอัปเดต</h1>
    <p>Admin Area: {{ $status_medical?->admin_area }}</p>
    <p>Sale Area: {{ $status_medical?->sale_area }}</p>
    <p>Status: {{ $status_medical->status_update }}</p>
    <p>ประเภทเอกสาร: ใบประกอบวิชาชีพ</p>
    <p>วันที่อัปเดต: {{ $status_medical->updated_at }}</p>
    
    <img src="{{ $cidImage }}" alt="" width="100%">
</body>
</html>
