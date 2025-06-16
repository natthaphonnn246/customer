{{-- <div id="import-status">
    {{ $status->status }}
</div> --}}

@if($importStatus->status == 'completed')
<div class="alert alert-success" id="import-status">
    {{ 'รายการล่าสุด'.' '.'('.$importStatus?->created_at.')'.' '.': ดำเนินการแล้ว' }}
</div>  
@else
<div class="alert alert-warning" id="import-status">
    {{ 'รายการล่าสุด'.' '.'('.$importStatus?->created_at.')'.' '.': กำลังดำเนินการ' }}
</div>  
@endif