@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Symbol</td>
                        <td>Price</td>
                        <td>Buy / Sell</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $symbol)
                        <tr>
                            <td>{{ $symbol->symbol }}</td>
                            @if ($symbol->is_suspended)
                                <td> - </td>
                                <td><a href="#" class="btn btn-default" disabled>Buy / Sell</a></td>
                            @else
                                <td>{{ $symbol->close_price }}</td>
                                <td><a href="{{ url('/symbol/'.$symbol->symbol) }}" class="btn btn-default">Buy / Sell</a></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
