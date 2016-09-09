@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $symbol->symbol }}</div>

                <div class="panel-body">
                    <div class="col-md-6 col-xs-12">
                        {{ Form::open() }}
                        {{ Form::input() }}
                        {{ Form::close() }}
                    </div>
                    <div class="col-md-6 col-xs-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
