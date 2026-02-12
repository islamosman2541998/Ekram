@extends('admin.app')

@section('title', trans('attribute.attrbiutesSet'))
@section('title_page', trans('attribute.attrbiutesSet'))


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
                                <a href="{{ route('admin.eccommerce.attributes-set.create') }}"
                                    class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
                            </div>

                        </div>
                        {{-- Start Form Search User Search By name,email,role,status --}}
                        <form action="{{ route('admin.eccommerce.attributes-set.index') }}" method="get">

                            <div class="row mt-3">
                                <div class="col-md-2 mt-1">
                                    <input type="text" value="{{ request()->title != '' ? request()->title : '' }}"
                                        name="title" placeholder="{{ trans('vendor.title_vendor') }}"
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
                                    <a class="btn btn-success btn-sm" href="{{ route('admin.eccommerce.attributes-set.index') }}"
                                        data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>


                                    {{-- @lang('attribute.create_attributes') --}}
                                </div>
                            </div>
                        </form>
                        {{-- End Form Search User Search By name,email,role,status --}}

                    </div>



                    <div class="card-body table-responsive">
                        <form id="update-pages" action="{{ route('admin.eccommerce.attributes-set.actions') }}" method="post">
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
                                <th>@lang('admin.title')</th>
                                <th>@lang('articles.sort')</th>
                                <th>@lang('attribute.display_layout')</th>
                                <th>@lang('attribute.attributeValue')</th>

                                <th>@lang('users.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $key => $item)
                                    <tr>
                                        <td>
                                            <input form="update-pages" class="checkbox-check" type="checkbox"
                                                name="record[{{ $item->id }}]" value={{ $item->id }}>
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->trans->where('locale', $current_lang)->first()->title }}</td>
                                        </td>
                                        <td>{{ $item->sort }}</td>
                                        <td>{{ $item->display_layout }}</td>
                                        <td>
                                            @if (@$item->attribute->first() == null)
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('admin.eccommerce.attributes.add', $item->id) }}"
                                                        class="btn btn-outline-success btn-sm m-1"
                                                        data-hover="{{ trans('button.create') }}"><i
                                                            class="fas fa-plus-circle"></i></a>
                                                </div>
                                            @else
                                                <div class="d-flex justify-content-center">

                                                    <a href="{{ route('admin.eccommerce.attributes.index', $item->id) }}"
                                                        class="btn btn-outline-info btn-sm m-1"
                                                        data-hover="{{ trans('button.show') }}">
                                                        <i class="bx bxs-show"></i></a>

                                                    <a href="{{ route('admin.eccommerce.attributes.add', $item->id) }}"
                                                        class="btn btn-outline-success btn-sm m-1"
                                                        data-hover="{{ trans('button.create') }}"><i
                                                            class="fas fa-plus-circle"></i></a>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('admin.eccommerce.attributes-set.edit', $item->id) }}"
                                                    class="btn btn-outline-warning btn-sm m-1"
                                                    data-hover="{{ trans('button.edit') }}"><i
                                                        class="bx bxs-edit"></i></a>
                                                <a href="{{ route('admin.eccommerce.attributes-set.show', $item->id) }}"
                                                    data-hover="@lang('admin.show')"
                                                    class="btn btn-xs btn-outline-info btn-sm m-1"><i
                                                        class="bx bxs-show"></i></a>

                                                @if ($item->status == 1)
                                                    <a href="{{ route('admin.eccommerce.attributes-set.update-status', $item->id) }}"
                                                        class="btn btn-xs btn-outline-success btn-sm m-1"><i
                                                            class="bx bxs-check-square"></i></a>
                                                @else
                                                    <a href="{{ route('admin.eccommerce.attributes-set.update-status', $item->id) }}"
                                                        class="btn btn-xs btn-outline-warning btn-sm m-1"><i
                                                            class="bx bx-no-entry"></i></a>
                                                @endif
                                                @if ($item->feature == 1)
                                                    <a href="{{ route('admin.eccommerce.attributes-set.update-featured', $item->id) }}"
                                                        data-hover="@lang('admin.feature')"
                                                        class="btn btn-xs btn-warning btn-sm m-1"><i
                                                            class="bx bxs-star"></i></a>
                                                @else
                                                    <a href="{{ route('admin.eccommerce.attributes-set.update-featured', $item->id) }}"
                                                        data-hover="@lang('admin.feature')"
                                                        class="btn btn-xs btn-outline-secondary btn-sm m-1"><i
                                                            class="bx bxs-star"></i></a>
                                                @endif

                                                <a type="button" class="btn btn-outline-danger btn-sm m-1"
                                                    class="color-red" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $item->id }}">
                                                    <i class="bx bxs-trash"></i>
                                                </a>

                                            </div>
                                    </tr>
                                    </tr>



                                    @include('admin.layouts.delete', ['route'=> 'admin.eccommerce.attributes-set.destroy'])

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
