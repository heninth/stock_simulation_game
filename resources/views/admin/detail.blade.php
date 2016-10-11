@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="col-md-8 col-md-offset-2 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Summary : {{ $user->name }}</div>

                    <div class="panel-body">
                        <span>Portfolio Value: <span class="money">{{ $user->port_value }}</span> บาท</span><br>
                        <span>Cash: <span class="money">{{ $user->cash }}</span> บาท</span>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-hover">
            <h2>Own</h2>
            <thead>
                <tr>
                    <th>สัญลักษณ์</th>
                    <th>ตลาด</th>
                    <th>จำนวน</th>
                    <th>ราคาปัจจุบัน</th>
                    <th>มูลค่ารวม</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $stock)
                    <tr>
                        <td>{{ $stock->symbol }}</td>
                        <td>{{ $stock->symbol()->first()->market }}</td>
                        <td class="volume">{{ $stock->volume }}</td>
                        @if ($stock->symbol()->first()->is_suspended)
                            <td> - </td>
                            <td> - </td>
                        @else
                            <td class="money">{{ $stock->symbol()->first()->close_price }}</td>
                            <td class="money">{{ $stock->symbol()->first()->close_price * $stock->volume }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <table class="table table-hover">
            <h2>History</h2>
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
                    <tr style="background: {{ ($history->type == 'buy') ? '#ccffcc' : '#ffcccc' }};">
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
