@extends('admin.app')

@section('title', trans('manager.show_manager'))
@section('title_page', trans('manager.managers') )
@section('title_route', route('admin.charity.managers.index') )
@section('button_page')
    <a href="{{ route('admin.charity.managers.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
@endsection


@section('content')
    <div class="card">
        <div class="card-body  search-group">
            {{-- Start Form Search User Search By name,email,role,status --}}
            <form action="{{ route('admin.charity.managers.index') }}" method="get">

                <div class="row mt-3">
                    <div class="col-md-2 mt-1">
                        <input type="text" value="{{ request()->name != '' ? request()->name : '' }}" name="name" placeholder="{{ trans('manager.name') }}" class="form-control">
                    </div>
                    <div class="col-md-2 mt-1">
                        <input type="text" value="{{ request()->email != '' ? request()->email : '' }}" name="email" placeholder="{{ trans('manager.email') }}" class="form-control">
                    </div>
                    <div class="col-md-2 mt-1">
                        <input type="text" value="{{ request()->mobile != '' ? request()->mobile : '' }}" name="mobile" placeholder="{{ trans('manager.mobile') }}" class="form-control">
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
                        <a class="btn btn-success btn-sm" href="{{ route('admin.charity.managers.index') }}" data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>
                    </div>
                </div>
            </form>
            {{-- End Form Search User Search By name,email,role,status --}}

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <form id="update-pages" action="{{ route('admin.charity.managers.actions') }}" method="post">
                    @csrf
                </form>
                <table id="main-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                        <tr class="bluck-actions" style="display: none" scope="row">
                            <td colspan="8">
                                <div class="col-md-12 mt-0 mb-0 text-center">
                                    <button form="update-pages" class="btn btn-neutral text-success btn-sm" type="submit" name="publish" value="1"> <i class="bx bxs-check-square"></i></button>
                                    <button form="update-pages" class="btn btn-neutral text-warning btn-sm" type="submit" name="unpublish" value="1"> <i class="bx bx-no-entry"></i></button>
                                    <button form="update-pages" class="btn btn-neutral text-danger btn-sm" type="submit" name="delete_all" value="1"> <i class="bx bxs-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <th style="width: 1px">
                            <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all" id="check-all">
                        </th>
                        <th>#</th>
                        <th>@lang('manager.name')</th>
                        <th>@lang('manager.email')</th>
                        <th>@lang('manager.mobile')</th>
                        <th>@lang('manager.created_at')</th>
                        <th>@lang('manager.updated_at')</th>
                        <th>@lang('users.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($managers as $key => $item)
                        <tr>
                            <td>
                                <input form="update-pages" class="checkbox-check" type="checkbox" name="record[{{ $item->id }}]" value={{ $item->id }}>
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->account->email }}</td>
                            <td>{{ $item->account->mobile }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>

                            <td>
                                <div class="d-flex justify-content-center">
                                    @if ($item->status == 1)
                                    <a href="{{ route('admin.charity.managers.update-status', $item->id) }}" class="btn btn-neutral text-success"><i class="bx bxs-check-square"></i></a>
                                    @else
                                    <a href="{{ route('admin.charity.managers.update-status', $item->id) }}" class="btn btn-neutral text-warning"><i class="bx bx-no-entry"></i></a>
                                    @endif
                                    <a href="{{ route('admin.charity.managers.edit', $item->id) }}" class="btn btn-neutral text-warning" data-hover="{{ trans('button.edit') }}"><i class="bx bxs-edit"></i></a>
                                    <a href="{{ route('admin.charity.managers.show', $item->id) }}" data-hover="@lang('admin.show')" class="btn btn-neutral text-info"><i class="bx bxs-show"></i></a>

                                    <a type="button" class="btn btn-neutral text-danger" class="color-red" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
                                        <i class="bx bxs-trash"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>


                        @include('admin.layouts.delete', ['route'=> 'admin.charity.managers.destroy'])


                        @endforeach



                    </tbody>


                </table>

            </div>

            <div class="col-md-12 text-center mt-3">
                {{ $managers->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection


