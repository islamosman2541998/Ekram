@extends('admin.app')

@section('title', trans('donors.show_donors'))
@section('title_page', trans('donors.donors'))
@section('title_route', route('admin.reports.donors.index'))


@section('style')
    @livewireStyles
@endsection

@section('content')

    <div class="card">
        <div class="card-body search-group">
            <form action="{{ route('admin.reports.donors.index') }}" method="get">
                <div class="row mt-3">
                    <div class="col-md-2 mb-3">
                        <input type="text" value="{{ request()->name ?? '' }}" name="name"
                            placeholder="{{ trans('pages.search_name') }}" class="form-control">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="text" value="{{ request()->email ?? '' }}" name="email"
                            placeholder="{{ trans('pages.search_email') }}" class="form-control">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="text" value="{{ request()->mobile ?? '' }}" name="mobile"
                            placeholder="{{ trans('pages.search_mobile') }}" class="form-control">
                    </div>
                    <div class="col-md-2 mb-3">
                        <select class="select form-control" name="status">
                            <option selected value=""> @lang('admin.status') </option>
                            <option value="1" {{ request()->status == 1 ? 'selected' : '' }}> @lang('admin.active')
                            </option>
                            <option value="0" {{ request()->status == '0' ? 'selected' : '' }}> @lang('admin.dis_active')
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="text" value="{{ request()->refer_name ?? '' }}" name="refer_name"
                            class="form-control" placeholder="البحث باسم المسوق">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-2 mb-3">
                        <input type="date" value="{{ request()->date_from ?? '' }}" name="date_from"
                            class="form-control" placeholder="@lang('pages.date_from')">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="date" value="{{ request()->date_to ?? '' }}" name="date_to" class="form-control"
                            placeholder="@lang('pages.date_to')">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-2 mb-3">
                        <input type="number" value="{{ request()->orders_from ?? '' }}" name="orders_from"
                            class="form-control" placeholder="عدد الطلبات من">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="number" value="{{ request()->orders_to ?? '' }}" name="orders_to"
                            class="form-control" placeholder="عدد الطلبات إلى">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="number" value="{{ request()->price_from ?? '' }}" name="price_from"
                            class="form-control" placeholder="إجمالي السعر من">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="number" value="{{ request()->price_to ?? '' }}" name="price_to" class="form-control"
                            placeholder="إجمالي السعر إلى">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-sm" type="submit" data-hover="{{ trans('pages.search') }}">
                            <i class="bx bx-search-alt"></i>
                        </button>
                        <a class="btn btn-success btn-sm" href="{{ route('admin.reports.donors.index') }}"
                            data-hover="{{ trans('button.reset') }}">
                            <i class="bx bx-refresh"></i>
                        </a>
                        <button type="submit" name="submit" value="export" class="btn btn-info btn-sm">Export</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="table-responsive">

                <table id="main-datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                        <tr class="bluck-actions" style="display: none" scope="row">
                            <th colspan="9">
                                <div class="col-md-12 mt-0 mb-0 text-center">
                                    <button form="update-pages" class="btn btn-neutral text-success btn-sm" type="submit"
                                        name="publish" value="1"> <i class="bx bxs-check-square"></i></button>
                                    <button form="update-pages" class="btn btn-neutral text-warning btn-sm"
                                        type="submit" name="unpublish" value="1"> <i
                                            class="bx bx-no-entry"></i></button>
                                    <button form="update-pages" class="btn btn-neutral text-danger btn-sm" type="submit"
                                        name="delete_all" value="1"> <i class="bx bxs-trash"></i></button>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th style="width: 1px">
                                <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all"
                                    id="check-all">
                            </th>
                            <th> # </th>
                            <th> @lang('users.name') </th>
                            <th> @lang('users.email') </th>
                            <th> @lang('users.mobile') </th>
                            <th> @lang('users.referer') </th>
                            <th> @lang('users.created_at') </th>
                            <th> @lang('users.status') </th>
                            <th> @lang('users.order_count') </th>
                            <th> @lang('users.total_price') </th>
                            <th>@lang('admin.actions') </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($donor as $key => $item)
                            <tr>
                                <td>
                                    <input form="update-pages" class="checkbox-check" type="checkbox"
                                        name="record[{{ $item->id }}]" value={{ $item->id }}>
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td> {{ $item->full_name }} </td>
                                <td> {{ $item->account?->email }} </td>
                                <td> {{ $item->mobile }} </td>
                                <td> {{ $item->refer?->name }} </td>
                                <td> {{ $item->created_at }} </td>
                                <td>
                                    {{-- {{ $item->status == 1 ? @lang('admin.active') : ($item->status == 0 ? @lang('admin.dis_active') : $item->status) }} --}}
                                    @if ($item->status == 1)
                                        @lang('admin.active')
                                    @else
                                        @lang('admin.dis_active')
                                    @endif
                                </td>
                                <td> {{ $item->orders->count() ?? '' }} </td>
                                <td> {{ $item->orders->sum('total') ?? '' }} </td>
                                <td>
                                    @livewire('admin.charity.donor-reports.show', ['donor_id' => $item->id], key($item->id))
                                </td>
                            </tr>
                            @include('admin.layouts.delete', ['route' => 'admin.donors.destroy'])
                        @empty
                        @endforelse
                        @php
                            $totalOrders = $donor->sum(function ($item) {
                                return $item->orders->count();
                            });

                            $totalPrice = $donor->sum(function ($item) {
                                return $item->orders->sum('total');
                            });
                        @endphp
                        <tr style="background-color: lightblue;">
                            <td></td>
                            <td></td>
                            <td> </td>
                            <td> الكمية</td>
                            <td> {{ $totalOrders }} </td>
                            <td> المجموع</td>
                            <td> {{ $totalPrice }} </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection




@section('script')
    @livewireScripts
@endsection
