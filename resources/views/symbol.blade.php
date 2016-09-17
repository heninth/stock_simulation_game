@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <h1>{{ $symbol->symbol }}</h1>
        </div>
        <div class="col-xs-6 right">
            <h2>เงินสด : <span class="money">{{ $cash }}</span> บาท</h2>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6 col-xs-12">
            @if ($errors->has('buy'))
                <div class="alert alert-danger" role="alert">{{ $errors->first('buy') }}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">ซื้อ</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/symbol/{{ $symbol->symbol }}/buy" id="buy">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-4 control-label">ราคา</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static money">{{ $symbol->close_price }}</span>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('buy_volume') ? ' has-error' : '' }}">
                            <label for="buy_volume" class="col-md-4 control-label">จำนวน</label>

                            <div class="col-md-6">
                                <input type="number" class="form-control" name="buy_volume" value="{{ old('buy_volume', '0') }}" min="0" step="1" required>

                                @if ($errors->has('buy_volume'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('buy_volume') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">ค่าธรรมเนียม ({{ $fee }}%)</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static fee money">0</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">ภาษี ({{ $tax }}%)</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static tax money">0</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">รวม</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static total money">0</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-success">
                                    ซื้อ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">ขาย</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/symbol/{{ $symbol->symbol }}/sell" id="sell">
                        {{ csrf_field() }}
                        <input type="hidden" name="op" value="buy">
                        <div class="form-group">
                            <label class="col-md-4 control-label">มีอยู่</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static">{{ $own->volume or '0' }}</span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">ราคา</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static money">{{ $symbol->close_price }}</span>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('sell_volume') ? ' has-error' : '' }}">
                            <label for="sell_volume" class="col-md-4 control-label">จำนวน</label>

                            <div class="col-md-6">
                                <input type="number" class="form-control" name="sell_volume" value="{{ old('sell_volume', '0') }}" min="0" step="1" required>

                                @if ($errors->has('sell_volume'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sell_volume') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">ค่าธรรมเนียม ({{ $fee }}%)</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static fee money">0</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">ภาษี ({{ $tax }}%)</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static tax money">0</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">รวม</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static total money">0</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-danger">
                                    ขาย
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
    var price = {{ $symbol->close_price }};
    var fee_rate = {{ $fee / 100 }};
    var tax_rate = {{ $tax /100 }};
    $(document).ready(function () {
        $('input[name="buy_volume"]').change(function (e) {
            var type = e.target.parentNode.parentNode.parentNode.id;
            var volume = $('#'+type+' input[type=number]').val();
            var cost = Math.round((volume * price) * 100) / 100;
            var fee =  Math.round((cost * fee_rate) * 100) / 100;
            var tax =  Math.round((fee * tax_rate) * 100) / 100;
            var total =  Math.round((cost + fee + tax) * 100) / 100;
            $('#'+type+' .fee').text(fee.formatMoney());
            $('#'+type+' .tax').text(tax.formatMoney());
            $('#'+type+' .total').text(total.formatMoney());
        });
        $('input[name="sell_volume"]').change(function (e) {
            var type = e.target.parentNode.parentNode.parentNode.id;
            var volume = $('#'+type+' input[type=number]').val();
            var cost = Math.round((volume * price) * 100) / 100;
            var fee =  Math.round((cost * fee_rate) * 100) / 100;
            var tax =  Math.round((fee * tax_rate) * 100) / 100;
            var total =  Math.round((cost - fee - tax) * 100) / 100;
            $('#'+type+' .fee').text(fee.formatMoney());
            $('#'+type+' .tax').text(tax.formatMoney());
            $('#'+type+' .total').text(total.formatMoney());
        });
        $('.money').each(function(i, el) {
            el.textContent = Number(el.textContent).formatMoney();
        });
    });
</script>
@endpush
