@extends('admin.app')

@section('title', trans('volunteers.show_ideas'))
@section('title_page', trans('volunteers.show_ideas'))
@section('title_route', route('admin.volunteers-ideas.index') )



@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body search-group">

                    {{-- <div class="row">
                        <div class="col-md-12 text-end">
                            <a href="{{ route('admin.volunteers-ideas.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
                        </div>
                    </div> --}}
                    <form action="{{ route('admin.volunteers-ideas.index') }}" method="get">
                        <div class="row mt-3">
                            <div class="col-md-2 mt-2">
                                <input type="text" value="{{ request()->name != '' ? request()->name : '' }}" name="name" placeholder="{{ trans('volunteers.name') }}" class="form-control">
                            </div>
                            <div class="col-md-2 mt-2">
                                <input type="text" value="{{ request()->subject != '' ? request()->subject : '' }}" name="subject" placeholder="{{ trans('volunteers.subject') }}" class="form-control">
                            </div>
                            <div class="col-md-2 mt-2">
                                <input type="text" value="{{ request()->message != '' ? request()->message : '' }}" name="identity" placeholder="{{ trans('volunteers.idea') }}" class="form-control">
                            </div>
                            <div class="col-md-2 mt-2">
                                <select class="select form-control" name="status">
                                    <option selected value=""> @lang('admin.status') </option>
                                    <option value="1" {{ old('status', request()->input('status')) == 1 ? 'selected' : '' }}> @lang('admin.active') </option>
                                    <option value="0" {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null ? 'selected' : '' }}> @lang('admin.dis_active') </option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-2">
                                <input type="date" name="search_created_from" placeholder="{{ trans('orders.created_from') }}" class="form-control">
                            </div>
                            <div class="col-md-2 mt-2">
                                <input type="date" name="search_created__to" placeholder="{{ trans('orders.created_to') }}" class="form-control">
                            </div>
                            <div class="col-md-2 mt-2">
                                <button class="btn btn-primary btn-sm" type="submit" data-hover="@lang('pages.search')"><i class="bx bx-search-alt"> </i></button>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.volunteers-ideas.index') }}" data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body mt-0 pt-0">
                    <form id="update-pages" action="{{ route('admin.volunteers-ideas.actions') }}" method="post">
                        @csrf
                    </form>
                    <div class="table-responsive">
                        <table id="main-datatable" class="table table-bordered table-striped table-table-success table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr class="bluck-actions" style="display: none" scope="row">
                                    <td colspan="13">
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
                                    <th>@lang('volunteers.name')</th>
                                    <th>@lang('volunteers.subject')</th>
                                    <th>@lang('volunteers.idea')</th>
                                    <th>@lang('volunteers.loves')</th>
                                    <th>@lang('volunteers.comments')</th>
                                    <th>@lang('admin.created_at')</th>
                                    <th>@lang('admin.actions')</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($items as $key => $item)
                                <tr>
                                    <td>
                                        <input form="update-pages" class="checkbox-check" type="checkbox" name="record[{{ $item->id }}]" value={{ $item->id }}>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->subject }}</td>
                                    <td>{{ substr($item->message, 0, 50) }} ... </td>
                                    <td>{{ $item->loves->count() }} <i class="bx bxs-heart text-danger"></i></td>
                                    <td>{{ $item->comments->count() }}  <i class='bx bxs-chat text-primary'></i> </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if ($item->status == 1)
                                            <a href="{{ route('admin.volunteers-ideas.update-status', $item->id) }}" class="btn btn-neutral text-success"><i class="bx bxs-check-square"></i></a>
                                            @else
                                            <a href="{{ route('admin.volunteers-ideas.update-status', $item->id) }}" class="btn btn-neutral text-warning "><i class="bx bx-no-entry"></i></a>
                                            @endif
                                            <a href="{{ route('admin.volunteers-ideas.show',$item->id) }}" data-hover="@lang('admin.show')" class="btn btn-neutral text-info"><i class="bx bxs-show"></i></a>
                                            {{-- <a href="{{ route('admin.volunteers-ideas.edit', $item->id) }}" class="btn btn-neutral text-warning" data-hover="{{ trans('button.edit') }}"><i class="bx bxs-edit"></i></a> --}}
                                            <a type="button" class="btn btn-neutral text-danger" class="color-red" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}"> <i class="bx bxs-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @include('admin.layouts.delete', ['route'=> 'admin.volunteers-ideas.destroy'])
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="col-md-12 text-center">
                        {{ $items->links('pagination::bootstrap-5') }}
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
