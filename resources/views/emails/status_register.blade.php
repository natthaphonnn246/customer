<!DOCTYPE html>
<html>
<head>
    <title>Status Register</title>
</head>
<body>
    <h1>ลงทะเบียนใหม่</h1>
    <p>Admin Area: {{ $status?->admin_area }}</p>
    <p>Sale Area: {{ $status?->sale_area }}</p>
    <p>Status: {{ $status->status }}</p>
    <p>ประเภท: ลงทะเบียนใหม่</p>
    <p>วันที่ลงทะเบียน: {{ $status->updated_at }}</p>
</body>
</html>