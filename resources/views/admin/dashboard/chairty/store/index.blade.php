@extends('admin.app')

@section('title', trans('vendor.vendor'))
@section('title_page', trans('vendor.show_vendor'))


@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
@endsection

@section('content')

    <div class="container-fluid">


        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body  search-group">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('admin.store.create') }}"
                                    class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
                            </div>
                        </div>
                        {{-- Start Form Search User Search By name,email,role,status --}}
                        <form action="{{ route('admin.store.index') }}" method="get">

                            <div class="row mt-3">
                                <div class="col-md-2 mt-1">
                                    <input type="text"
                                        value="{{ request()->full_name != '' ? request()->full_name : '' }}"
                                        name="full_name" placeholder="{{ trans('pages.search_name') }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-2 mt-1">
                                    <input type="text" value="{{ request()->email != '' ? request()->email : '' }}"
                                        name="email" placeholder="{{ trans('pages.search_email') }}" class="form-control">
                                </div>
                                <div class="col-md-2 mt-1">
                                    <input type="text" value="{{ request()->mobile != '' ? request()->mobile : '' }}"
                                        name="mobile" placeholder="{{ trans('pages.search_mobile') }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-2 mt-1">
                                    <select class="select form-control" name="status">
                                        <option selected value=""> @lang('admin.status') </option>
                                        <option
                                            value="1"{{ old('status', request()->input('status')) == 1 ? 'selected' : '' }}>
                                            @lang('admin.active') </option>
                                        <option value="0"
                                            {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null ? 'selected' : '' }}>
                                            @lang('admin.dis_active') </option>

                                    </select>
                                </div>
                                <div class="search-input col-md-2">
                                    <button class="btn btn-primary btn-sm" type="submit"
                                        data-hover="{{ trans('pages.search') }}"><i class="bx bx-search-alt"> </i></button>
                                    <a class="btn btn-success btn-sm" href="{{ route('admin.store.index') }}"
                                        data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>
                                </div>
                            </div>
                        </form>
                        {{-- End Form Search User Search By name,email,role,status --}}

                    </div>



                    <div class="card-body table-responsive">
                        <form id="update-pages" action="{{ route('admin.store.actions') }}" method="post">
                            @csrf
                        </form>
                        <table id="main-datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                <tr class="bluck-actions" style="display: none" scope="row">
                                    <td colspan="8">
                                        <div class="col-md-12 mt-0 mb-0 text-center">
                                            <button form="update-pages" class="btn btn-success btn-sm" type="submit"
                                                name="publish" value="1"> <i class="bx bxs-check-square"></i></button>
                                            <button form="update-pages" class="btn btn-warning btn-sm" type="submit"
                                                name="unpublish" value="1"> <i class="bx bx-no-entry"></i></button>
                                            <button form="update-pages" class="btn btn-danger btn-sm" type="submit"
                                                name="delete_all" value="1"> <i class="bx bxs-trash"></i></button>
                                        </div>
                                    </td>

                                </tr>
                                <th style="width: 1px">
                                    <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all"
                                        id="check-all">
                                </th>
                                <th>#</th>
                                <th>@lang('store.name_store')</th>
                                <th>@lang('users.name')</th>
                                <th>@lang('users.email')</th>
                                <th>@lang('users.mobile')</th>
                                <th>@lang('store.employee_name')</th>
                                <th>@lang('store.employee_number')</th>
                                <th>@lang('store.department')</th>
                                <th>@lang('store.ax_store_number')</th>
                                <th>@lang('store.location')</th>
                                <th>@lang('users.image')</th>
                                <th>@lang('users.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($store as $key => $item)
                                    <tr>
                                        <td>
                                            <input form="update-pages" class="checkbox-check" type="checkbox"
                                                name="record[{{ $item->id }}]" value={{ $item->id }}>
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->trans->where('locale', $current_lang)->first()->title }}</td>
                                        <td>{{ $item->full_name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->mobile }}</td>
                                        <td>{{ $item->employee_name }}</td>
                                        <td>{{ $item->employee_number }}</td>
                                        <td>{{ $item->department }}</td>
                                        <td>{{ $item->ax_store_number }}</td>
                                        <td>{{ $item->location }}</td>

                                        <td> <a href="{{ getImage($item->image) }}" target="_blank"> <img
                                                    src="{{ getImageThumb($item->image) }}" alt="" style="width: 50px"></a>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('admin.store.edit', $item->id) }}"
                                                    class="btn btn-outline-warning btn-sm m-1"
                                                    data-hover="{{ trans('button.edit') }}"><i
                                                        class="bx bxs-edit"></i></a>
                                                <a href="{{ route('admin.store.show', $item->id) }}"
                                                    data-hover="@lang('admin.show')"
                                                    class="btn btn-xs btn-outline-info btn-sm m-1"><i
                                                        class="bx bxs-show"></i></a>

                                                @if ($item->status == 1)
                                                    <a href="{{ route('admin.store.update-status', $item->id) }}"
                                                        class="btn btn-xs btn-outline-success btn-sm m-1"><i
                                                            class="bx bxs-check-square"></i></a>
                                                @else
                                                    <a href="{{ route('admin.store.update-status', $item->id) }}"
                                                        class="btn btn-xs btn-outline-warning btn-sm m-1"><i
                                                            class="bx bx-no-entry"></i></a>
                                                @endif
                                                <a type="button" class="btn btn-outline-danger btn-sm m-1"
                                                    class="color-red" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $item->id }}">
                                                    <i class="bx bxs-trash"></i>
                                                </a>

                                            </div>
                                    </tr>
                                    </tr>

                                    @include('admin.layouts.delete', ['route'=> 'admin.store.destroy'])



                                @endforeach



                            </tbody>


                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div> <!-- container-fluid -->

@endsection


@section('script')


@endsection
