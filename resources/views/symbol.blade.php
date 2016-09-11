@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h1>{{ $symbol->symbol }}</h1>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Buy</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/symbol/{{ $symbol->symbol }}/buy" id="buy">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-4 control-label">Price</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static">{{ $symbol->close_price }}</span>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('buy_volumn') ? ' has-error' : '' }}">
                            <label for="buy_volumn" class="col-md-4 control-label">Volumn</label>

                            <div class="col-md-6">
                                <input type="number" class="form-control" name="buy_volumn" value="{{ old('buy_volumn', '0') }}" min="0" step="1" required>

                                @if ($errors->has('buy_volumn'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('buy_volumn') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Fee ({{ $fee }}%)</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static fee">0</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Tax ({{ $tax }}% of Fee)</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static tax">0</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Total</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static total">0</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-success">
                                    Buy
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Sell</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/symbol/{{ $symbol->symbol }}/sell" id="sell">
                        {{ csrf_field() }}
                        <input type="hidden" name="op" value="buy">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Own</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static">{{ $own->volumn or '0' }}</span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Price</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static">{{ $symbol->close_price }}</span>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('sell_volumn') ? ' has-error' : '' }}">
                            <label for="sell_volumn" class="col-md-4 control-label">Volumn</label>

                            <div class="col-md-6">
                                <input type="number" class="form-control" name="sell_volumn" value="{{ old('sell_volumn', '0') }}" min="0" step="1" required>

                                @if ($errors->has('sell_volumn'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sell_volumn') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Fee ({{ $fee }}%)</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static fee">0</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Tax ({{ $tax }}% of Fee)</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static tax">0</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total</label>

                            <div class="col-md-6" style="padding-top: 6px;">
                                <span class="form-control-static total">0</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-danger">
                                    Sell
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
    var fee = {{ $fee / 100 }};
    var tax = {{ $tax /100 }};
    $(document).ready(function () {
        $('input[name="volumn"]').change(function (e) {
            var type = e.target.parentNode.parentNode.parentNode.id;
        })
    });
</script>
@endpush
