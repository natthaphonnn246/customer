<div class="container w-full max-w-full break-words" style="width:95%;">
            
 {{--    @if(session('import'))
        <div class="alert alert-success">{{ session('import') }}</div>
    @endif --}}

    <table class="table table-striped">

        <tbody id="import-table-body">
            @foreach($imports as $import)
                <tr style="">
                    <td scope="row" style="color:#9C9C9C; text-align: left;  padding:20px; width: 20%;">{{ $import->created_at->format('Y-m-d H:i') }}</td>
                    <td scope="row" style="color:#9C9C9C; text-align: center;  padding:20px; width: 20%;">
                        @if($import->status === 'completed')
                            <span class="inline-block border-2 border-green-600 text-green-600 px-3 py-2 rounded-lg text-base">ดำเนินการแล้ว</span>
                        @elseif($import->status === 'processing')
                        <span class="inline-block border-2 border-yellow-500 text-yellow-500 px-3 py-2 rounded-lg text-base">กำลังดำเนินการ</span>
                        @else
                        <span class="inline-block border-2 border-red-500 text-red-500 px-3 py-2 rounded-lg text-base">รอดำเนินการ</span>
                        @endif
                    </td>
                    <td scope="row" style="color:#9C9C9C; text-align: center;  padding:20px; width: 20%;">{{ $import->success_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
