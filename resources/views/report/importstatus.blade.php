<div class="container w-full max-w-full break-words">
    <h3>Import Status</h3>

    <p>ไฟล์: {{ $importStatus->file_name }}</p>
    <p>สถานะ: 
        @if($importStatus->status == 'pending')
            <span class="badge bg-secondary">รอดำเนินการ</span>
        @elseif($importStatus->status == 'processing')
            <span class="badge bg-info">กำลังประมวลผล</span>
        @elseif($importStatus->status == 'completed')
            <span class="badge bg-success">เสร็จสิ้น</span>
        @elseif($importStatus->status == 'failed')
            <span class="badge bg-danger">ล้มเหลว</span>
        @endif
    </p>

    @if($importStatus->status == 'completed')
        <p>จำนวนเรคคอร์ดที่ import ได้: {{ $importStatus->total_rows }}</p>
    @endif

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if(in_array($importStatus->status, ['pending', 'processing']))
        <p>โปรดรอระบบทำการ import ให้เสร็จ...</p>
        <meta http-equiv="refresh" content="5"> <!-- รีเฟรชหน้า 5 วินาที -->
    @endif

</div>