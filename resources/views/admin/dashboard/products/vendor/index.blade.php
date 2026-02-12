@extends('admin.app')

@section('title', trans('vendor.show_vendors'))
@section('title_page', trans('vendor.vendors'))
@section('title_route', route('admin.eccommerce.vendors.index') )
@section('button_page')
<a href="{{ route('admin.eccommerce.vendors.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
@endsection


@section('content')

<div class="card">

    <div class="card-body  search-group">
        {{-- Start Form Search User Search By name,email,role,status --}}
        <form action="{{ route('admin.eccommerce.vendors.index') }}" method="get">

            <div class="row mt-3">
                <div class="col-md-2 mt-1">
                    <input type="text" value="{{ request()->title != '' ? request()->title : '' }}" name="title" placeholder="{{ trans('vendor.title_vendor') }}" class="form-control">
                </div>
                <div class="col-md-2 mt-1">
                    <input type="text" value="{{ request()->responsible_person != '' ? request()->responsible_person : '' }}" name="responsible_person" placeholder="{{ trans('pages.search_name') }}" class="form-control">
                </div>
                <div class="col-md-2 mt-1">
                    <input type="text" value="{{ request()->email != '' ? request()->email : '' }}" name="email" placeholder="{{ trans('pages.search_email') }}" class="form-control">
                </div>
                <div class="col-md-2 mt-1">
                    <input type="text" value="{{ request()->mobile != '' ? request()->mobile : '' }}" name="mobile" placeholder="{{ trans('pages.search_mobile') }}" class="form-control">
                </div>

                <div class="col-md-2 mt-1">
                    <select class="select form-control" name="status">
                        <option selected value=""> @lang('admin.status') </option>
                        <option value="1" {{ old('status', request()->input('status')) == 1 ? 'selected' : '' }}>
                            @lang('admin.active') </option>
                        <option value="0" {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null ? 'selected' : '' }}>
                            @lang('admin.dis_active') </option>

                    </select>
                </div>
                <div class="search-input col-md-2">
                    <button class="btn btn-primary btn-sm" type="submit" data-hover="{{ trans('pages.search') }}"><i class="bx bx-search-alt"> </i></button>
                    <a class="btn btn-success btn-sm" href="{{ route('admin.eccommerce.vendors.index') }}" data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>
                </div>
            </div>
        </form>
        {{-- End Form Search User Search By name,email,role,status --}}

    </div>

</div>

<div class="card">

    <div class="card-body table-responsive">
        <form id="update-pages" action="{{ route('admin.eccommerce.vendors.actions') }}" method="post">
            @csrf
        </form>
        <table id="main-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr class="bluck-actions" style="display: none" scope="row">
                    <td colspan="10">
                        <div class="col-md-12 mt-0 mb-0 text-center">
                            <button form="update-pages" class="btn btn-neutral text-success btn-sm" type="submit" name="publish" value="1"> <i class="bx bxs-check-square"></i></button>
                            <button form="update-pages" class="btn btn-neutral text-warning btn-sm" type="submit" name="unpublish" value="1"> <i class="bx bx-no-entry"></i></button>
                            <button form="update-pages" class="btn btn-neutral text-danger btn-sm" type="submit" name="delete_all" value="1"> <i class="bx bxs-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th style="width: 1px">
                        <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all" id="check-all">
                    </th>
                    <th>#</th>
                    <th>@lang('users.image')</th>
                    <th>@lang('admin.title')</th>
                    {{-- <th>@lang('admin.description')</th> --}}
                    <th>@lang('users.name')</th>
                    <th>@lang('users.email')</th>
                    <th>@lang('users.mobile')</th>
                    <th>@lang('articles.sort')</th>
                    <th>@lang('users.action')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendor as $key => $item)
                <tr>
                    <td>
                        <input form="update-pages" class="checkbox-check" type="checkbox" name="record[{{ $item->id }}]" value={{ $item->id }}>
                    </td>
                    <td>{{ $loop->iteration }}</td>
                    <td> <a href="{{ getImage($item->logo) }}" target="_blank"> <img src="{{ getImageThumb($item->logo) }}" alt="" style="width: 50px"></a> </td>
                    <td>{{ $item->trans->where('locale', $current_lang)->first()->title }}</td>
                    {{-- <td>{{ substr(removeHTML($item->trans->where('locale', $current_lang)->first()->description), 0, 30) }} --}}
                    </td>
                    <td>{{ $item->responsible_person }}</td>

                    <td>{{ $item->account->email }}</td>
                    <td>{{ $item->account->mobile }}</td>
                    <td>{{ $item->sort }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            @if ($item->status == 1)
                            <a href="{{ route('admin.eccommerce.vendors.update-status', $item->id) }}" class="btn btn-xs btn-neutral text-success btn-sm m-1"><i class="bx bxs-check-square"></i></a>
                            @else
                            <a href="{{ route('admin.eccommerce.vendors.update-status', $item->id) }}" class="btn btn-xs btn-neutral text-warning btn-sm m-1"><i class="bx bx-no-entry"></i></a>
                            @endif
                            @if ($item->feature == 1)
                            <a href="{{ route('admin.eccommerce.vendors.update-featured', $item->id) }}" data-hover="@lang('admin.feature')" class="btn btn-xs btn-neutral text-warning btn-sm m-1"><i class="bx bxs-star"></i></a>
                            @else
                            <a href="{{ route('admin.eccommerce.vendors.update-featured', $item->id) }}" data-hover="@lang('admin.feature')" class="btn btn-xs btn-neutral text-secondary btn-sm m-1"><i class="bx bxs-star"></i></a>
                            @endif
                            <a href="{{ route('admin.eccommerce.vendors.show', $item->id) }}" data-hover="@lang('admin.show')" class="btn btn-xs btn-neutral text-info btn-sm m-1"><i class="bx bxs-show"></i></a>
                            <a href="{{ route('admin.eccommerce.vendors.edit', $item->id) }}" class="btn btn-neutral text-warning btn-sm m-1" data-hover="{{ trans('button.edit') }}"><i class="bx bxs-edit"></i></a>

                            <a type="button" class="btn btn-neutral text-danger btn-sm m-1" class="color-red" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
                                <i class="bx bxs-trash"></i>
                            </a>

                        </div>
                </tr>
                </tr>



                @include('admin.layouts.delete', ['route'=> 'admin.eccommerce.vendors.destroy'])

                @endforeach



            </tbody>


        </table>

    </div>

</div>



@endsection
