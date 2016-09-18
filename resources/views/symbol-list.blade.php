@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            แสดง :
            <input type="checkbox" onclick="$('.s').toggle();" checked> การซื้อขายที่ถูกระงับ |
            <input type="checkbox" onclick="$('.less_five').toggle();" checked> ราคาต่ำกว่า 5
        </div>
        <div class="col-md-6 col-xs-12">
            <h1>SET</h1>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>สัญลักษณ์</td>
                        <td>ราคา</td>
                        <td>ซื้อ / ขาย</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $symbol)
                        @if ($symbol->market == 'SET')
                            <tr class="symbol{{ $symbol->is_suspended ? ' s' : ($symbol->close_price < 5 ? ' less_five' : '')}}">
                                <td>{{ $symbol->symbol }}</td>
                                @if ($symbol->is_suspended)
                                    <td> - </td>
                                    <td><a href="#" class="btn btn-default" disabled>การซื้อขายถูกระงับ</a></td>
                                @else
                                    <td class="money">{{ $symbol->close_price }}</td>
                                    @if ($symbol->close_price < 5)
                                        <td><a href="{{ url('/symbol/'.$symbol->symbol) }}" class="btn btn-default">ขาย</a></td>
                                    @else
                                        <td><a href="{{ url('/symbol/'.$symbol->symbol) }}" class="btn btn-default">ซื้อ / ขาย</a></td>
                                    @endif
                                @endif
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-6 col-xs-12">
            <h1>mai</h1>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>สัญลักษณ์</td>
                        <td>ราคา</td>
                        <td>ซื้อ / ขาย</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $symbol)
                        @if ($symbol->market == 'mai')
                            <tr class="symbol{{ $symbol->is_suspended ? ' s' : ($symbol->close_price < 5 ? ' less_five' : '')}}">
                                <td>{{ $symbol->symbol }}</td>
                                @if ($symbol->is_suspended)
                                    <td> - </td>
                                    <td><a href="#" class="btn btn-default" disabled>การซื้อขายถูกระงับ</a></td>
                                @else
                                    <td class="money">{{ $symbol->close_price }}</td>
                                    @if ($symbol->close_price < 5)
                                        <td><a href="{{ url('/symbol/'.$symbol->symbol) }}" class="btn btn-default">ขาย</a></td>
                                    @else
                                        <td><a href="{{ url('/symbol/'.$symbol->symbol) }}" class="btn btn-default">ซื้อ / ขาย</a></td>
                                    @endif
                                @endif
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
