@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-xs-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>วัน เวลา</th>
                        <th>ประเภท</th>
                        <th>สัญลักษณ์</th>
                        <th>จำนวน</th>
                        <th>ราคาต่อหุ้น</th>
                        <th>รวม</th>
                        <th>ราคารวม</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $history)
                        <tr>
                            <td>{{ $history->created_at }}</td>
                            <td>{{ $history->type }}</td>
                            <td>{{ $history->symbol }}</td>
                            <td class="volume">{{ $history->volume }}</td>
                            <td class="money">{{ $history->cost / $history->volume }}</td>
                            <td class="money">{{ $history->cost }}</td>
                            <td class="money">{{ $history->total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('.money').each(function(i, el) {
            el.textContent = Number(el.textContent).formatMoney();
        });
        $('.volume').each(function(i, el) {
            el.textContent = Number(el.textContent).formatMoney(0);
        });
    });
</script>
@endpush
