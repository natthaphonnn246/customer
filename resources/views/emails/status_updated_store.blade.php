<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Status Updated</title>
</head>
<body>
    <h1>สถานะลูกค้าได้ถูกอัปเดต</h1>
    <p>Admin Area: {{ $status_store?->admin_area }}</p>
    <p>Sale Area: {{ $status_store?->sale_area }}</p>
    <p>Status: {{ $status_store->status_update }}</p>
    <p>ประเภทเอกสาร: ใบอนุญาตขายยา</p>
    <p>วันที่อัปเดต: {{ $status_store->updated_at }}</p>
    
    <img src="{{ $cidImage }}" alt="" width="100%">
    
    

    
    
    
    


</body>
</html>
