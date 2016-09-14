@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Summary</div>

                <div class="panel-body">
                    <span>Portfolio Value: {{ $user->port_value }} บาท</span><br>
                    <span>Cash: {{ $user->cash }} บาท</span>
                </div>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>สัญลักษณ์</th>
                    <th>ตลาด</th>
                    <th>จำนวน</th>
                    <th>ราคาปัจจุบัน</th>
                    <th>มูลค่ารวม</th>
                    <th>ซื้อ / ขาย</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $stock)
                    <tr>
                        <td>{{ $stock->symbol }}</td>
                        <td>{{ $stock->symbol()->first()->market }}</td>
                        <td>{{ $stock->volume }}</td>
                        @if ($stock->symbol()->first()->is_suspended)
                            <td> - </td>
                            <td> - </td>
                            <td><a href="#" class="btn btn-default" disabled>การซื้อขายถูกระงับ</a></td>
                        @else
                            <td>{{ $stock->symbol()->first()->close_price }}</td>
                            <td>{{ $stock->symbol()->first()->close_price * $stock->volume }}</td>
                            @if ($stock->symbol()->first()->close_price < 10)
                                <td><a href="{{ url('/symbol/'.$stock->symbol) }}" class="btn btn-default">ขาย</a></td>
                            @else
                                <td><a href="{{ url('/symbol/'.$stock->symbol) }}" class="btn btn-default">ซื้อ / ขาย</a></td>
                            @endif
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
