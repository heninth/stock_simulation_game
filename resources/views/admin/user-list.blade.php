@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-xs-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Cash</th>
                            <th>Port Value</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->cash }}</td>
                                <td>{{ $user->port_value }}</td>
                                <td>
                                    <a href="{{ url('admin/'.$user->id) }}" class="btn btn-primary">Detail</a>
                                </td>
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
