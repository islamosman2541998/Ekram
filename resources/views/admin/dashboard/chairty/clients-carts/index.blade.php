@extends('admin.app')

@section('title', trans('donors.show_donors'))
@section('title_page', trans('donors.donors'))

@section('content')
    <div class="card">
        <div class="card-body search-group">
            <form action="{{ route('admin.clients-carts.index') }}" method="get">
                <div class="row d-flex align-items-center justify-content-center mt-3">
                    <div class="col-md-2">
                        <input type="text" name="item_name" value="{{ request('item_name') }}" class="form-control"
                            placeholder="{{ trans('pages.type') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="mobile" value="{{ request('mobile') }}" class="form-control"
                            placeholder="{{ trans('pages.search_mobile') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control"
                            placeholder="@lang('pages.min_price')">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control"
                            placeholder="@lang('pages.max_price')">
                    </div>
                    <div class="col-md-2 mb-3 ">
                        <label for="from_date">من تاريخ</label>

                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="to_date">الي تاريخ</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="bx bx-search-alt"></i></button>
                        <a href="{{ route('admin.clients-carts.index') }}" class="btn btn-success btn-sm"><i
                                class="bx bx-refresh"></i></a>
                                                        <button type="submit" name="export" value="excel" class="btn btn-secondary btn-sm"><i class="bx bx-file"></i> Excel</button>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered dt-responsive nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('admin.cookies')</th>
                        <th>@lang('users.name')</th>
                        <th>@lang('users.mobile')</th>
                        <th>@lang('users.email')</th>
                        <th>@lang('admin.product')</th>
                        <th>@lang('item_sub_type')</th>
                        <th>@lang('quantity')</th>
                        <th>@lang('price')</th>
                        <th>@lang('Total')</th>
                        <th>@lang('admin.date')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carts as $cart)
                        <tr>
                            <td>{{ $loop->iteration + ($carts->currentPage() - 1) * $carts->perPage() }}</td>
                            <td>{{ $cart->cookeries }}</td>
                            <td>{{ @$cart->donor->full_name }}</td>
                            <td>{{ @$cart->donor->mobile }}</td>
                            <td>{{ $cart->donor->account->email ?? '' }}</td>
                            <td>{{ $cart->item_name }}</td>
                            <td>{{ $cart->item_sub_type }}</td>
                            <td>{{ $cart->quantity }}</td>
                            <td>{{ $cart->price }}</td>
                            <td>{{ $cart->price * $cart->quantity }}</td>
                            <td>{{ $cart->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                    <tr class="table-info">
                        <td colspan="9" class="text-end">@lang('admin.total_sum'):</td>
                        <td>{{ $totalSum }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-3">{{ $carts->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection



@section('script')
    @livewireScripts
@endsection
