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
                            <span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(58, 174, 19);">ดำเนินการแล้ว</span>
                        @elseif($import->status === 'processing')
                        <span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(251, 169, 46);">กำลังดำเนินการ</span>
                        @else
                        <span style="border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(113, 113, 113);">รอดำเนินการ</span>
                        @endif
                    </td>
                    <td scope="row" style="color:#9C9C9C; text-align: center;  padding:20px; width: 20%;">{{ $import->success_count }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
