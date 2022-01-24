@extends('layouts.back-end.app')

@section('title', 'Withdraw Request')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="{{ route('admin.dashboard') }}">{{ trans('messages.Dashboard') }}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{ trans('messages.Withdraw') }} </li>
            </ol>
        </nav>

        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ trans('messages.Withdraw Request Table') }}</h5>
                        <select name="withdraw_status_filter" onchange="status_filter(this.value)"
                            class="custom-select float-right" style="width: 200px">
                            <option value="all"
                                {{ session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'all' ? 'selected' : '' }}>
                                Tous</option>
                            <option value="approved"
                                {{ session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'approved' ? 'selected' : '' }}>
                                Apprové</option>
                            <option value="denied"
                                {{ session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'denied' ? 'selected' : '' }}>
                                Decliné</option>
                            <option value="pending"
                                {{ session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'pending' ? 'selected' : '' }}>
                                En Attente</option>

                        </select>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table id="datatable"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ trans('messages.SL#') }}</th>
                                        <th>{{ trans('messages.amount') }}</th>
                                        {{-- <th>{{trans('messages.note')}}</th> --}}
                                        <th>{{ trans('messages.Name') }}</th>
                                        <th>{{ trans('messages.request_time') }}</th>
                                        <th>{{ trans('messages.status') }}</th>
                                        <th style="width: 5px">{{ trans('messages.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($withdraw_req as $k => $wr)


                                        <tr>
                                            <td scope="row">{{ $k + 1 }}</td>
                                            <td>{{ $wr->amount }}</td>
                                            <td>{{ $wr->seller_id }}</td>
                                            <td>
                                                {{ $wr->created_at }} </a>
                                            </td>
                                            {{-- <td>{{$wr->created_at}}</td> --}}
                                            <td>
                                                @if ($wr->status == 0)
                                                    <label class="badge badge-warning">En Attente</label>
                                                @elseif($wr->status==2)
                                                    <label class="badge badge-success">Confirmé</label>
                                                @elseif($wr->status==3)
                                                    <label class="badge badge-primary">Approuvé</label>
                                                @else
                                                    <label class="badge badge-danger">Decliner</label>
                                                @endif
                                            </td>
                                            <td class="row">
                                                @if ($wr->status == 4)
                                                    <form action="{{ route('admin.sellers.confirm-withdraw') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $wr->id }}">
                                                        <input type="hidden" name="status" value="2">
                                                        <button class="btn btn-success" disabled> Confirmé </button>
                                                    </form>
                                                    <form action="{{ route('admin.sellers.confirm-withdraw') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="3">
                                                        <input type="hidden" name="id" value="{{ $wr->id }}">
                                                        <button class="btn btn-primary" disabled> Apprové </button>
                                                    </form>
                                                    <form action="{{ route('admin.sellers.confirm-withdraw') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="amount" value="{{ $wr->amount }}">
                                                        <input type="hidden" name="seller_id"
                                                            value="{{ $wr->seller_id }}">
                                                        <input type="hidden" name="id" value="{{ $wr->id }}">
                                                        <input type="hidden" name="status" value="4">
                                                        <button class="btn btn-danger" disabled> declined </button>
                                                    </form>
                                                @endif

                                                @if ($wr->status != 4)

                                                    <form action="{{ route('admin.sellers.confirm-withdraw') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $wr->id }}">
                                                        <input type="hidden" name="status" value="2">
                                                        <button class="btn btn-success"> Confirmé </button>
                                                    </form>
                                                    <form action="{{ route('admin.sellers.confirm-withdraw') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="3">
                                                        <input type="hidden" name="id" value="{{ $wr->id }}">
                                                        <button class="btn btn-primary"> Apprové </button>
                                                    </form>
                                                    <form action="{{ route('admin.sellers.confirm-withdraw') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="amount" value="{{ $wr->amount }}">
                                                        <input type="hidden" name="seller_id"
                                                            value="{{ $wr->seller_id }}">
                                                        <input type="hidden" name="id" value="{{ $wr->id }}">
                                                        <input type="hidden" name="status" value="4">
                                                        <button class="btn btn-danger"> declined </button>
                                                    </form>

                                                @endif

                                            </td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $withdraw_req->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('script_2')
    <script>
        function status_filter(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.withdraw.status-filter') }}',
                data: {
                    withdraw_status_filter: type
                },
                beforeSend: function() {
                    $('#loading').show()
                },
                success: function(data) {
                    location.reload();
                },
                complete: function() {
                    $('#loading').hide()
                }
            });
        }
        }
    </script>
@endpush
