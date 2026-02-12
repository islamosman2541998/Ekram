@extends('admin.app')

@section('title', trans('decease.show_deceases_request'))
@section('title_page', trans('decease.decease_request'))
@section('title_route', route('admin.deceases.request.index'))
@section('button_page')
    <a href="{{ route('admin.deceases.request.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body search-group">
        <form action="{{ route('admin.deceases.request.index') }}" method="get">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" 
                           name="search_name" 
                           value="{{ request('search_name') }}" 
                           placeholder="@lang('decease.search_name')" 
                           class="form-control form-control-sm">
                </div>
                <div class="col-md-2">
                    <input type="text" 
                           name="search_deceased_name" 
                           value="{{ request('search_deceased_name') }}" 
                           placeholder="@lang('decease.search_deceased_name')" 
                           class="form-control form-control-sm">
                </div>
                <div class="col-md-2">
                    <input type="text" 
                           name="search_mobile" 
                           value="{{ request('search_mobile') }}" 
                           placeholder="@lang('decease.search_mobile')" 
                           class="form-control form-control-sm">
                </div>
                <div class="col-md-2">
                    <select class="form-select form-select-sm" name="status" onchange="this.form.submit()">
                        <option value="">@lang('admin.status')</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>@lang('admin.active')</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>@lang('admin.dis_active')</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex">
                    <button class="btn btn-primary btn-sm" type="submit" data-hover="{{ trans('pages.search') }}">
                        <i class="bx bx-search-alt"></i>
                    </button>
                    <!-- @if(request()->anyFilled(['search_name', 'search_deceased_name', 'search_mobile', 'status']))
                        <a href="{{ route('admin.deceases.request.index') }}" class="btn btn-secondary btn-sm mr-2" data-hover="{{ trans('button.reset') }}">
                            <i class="bx bx-x"></i>
                        </a>
                    @endif -->
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form id="update-pages" action="{{ route('admin.deceases.request.actions') }}" method="post">
            @csrf
        </form>
        <div class="table-responsive">
            <table id="main-datatable" class="table table-bordered text-center table-striped table-hover table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr class="bluck-actions" style="display: none" scope="row">
                        <td colspan="12">
                            <div class="col-md-12 mt-0 mb-0 text-center">
                                <button form="update-pages" class="btn btn-neutral text-success" type="submit" name="publish" value="1"> 
                                    <i class="bx bxs-check-square"></i>
                                </button>
                                <button form="update-pages" class="btn btn-neutral text-warning" type="submit" name="unpublish" value="1"> 
                                    <i class="bx bx-no-entry"></i>
                                </button>
                                <button form="update-pages" class="btn btn-neutral text-danger" type="submit" name="delete_all" value="1"> 
                                    <i class="bx bxs-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 1px">
                            <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all" id="check-all">
                        </th>
                        <th>#</th>
                        <th>@lang('users.name')</th>
                        <th>@lang('users.mobile')</th>
                        <th>@lang('decease.target_price')</th>
                        <th>@lang('decease.project')</th>
                        <th>@lang('decease.deceased_name')</th>
                        <th>@lang('decease.relative_relation')</th>
                        <th>@lang('decease.created_at')</th>
                        <th>@lang('decease.updated_at')</th>
                        <th>@lang('users.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($decease as $key => $item)
                    <tr>
                        <td>
                            <input form="update-pages" class="checkbox-check" type="checkbox" name="record[{{ $item->id }}]" value="{{ $item->id }}">
                        </td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->mobile }}</td>
                        <td>{{ $item->target_price }}</td>
                        <td>{{ @$item->project->trans?->where('locale', $current_lang)->first()->title }}</td>
                        <td>{{ $item->deceased_name }}</td>
                        <td>{{ $item->relative_relation }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                @if ($item->confirmed == 1)
                                    <a class="btn btn-neutral text-success">
                                        <i class="bx bxs-check-square"></i>
                                    </a>
                                @else
                                    <a href="{{ route('admin.deceases.request.show', $item->id) }}" class="btn btn-neutral text-warning">
                                        <i class="bx bx-no-entry"></i>
                                    </a>
                                @endif
                                <a href="{{ route('admin.deceases.request.show', $item->id) }}" data-hover="@lang('admin.show')" class="btn btn-neutral text-info">
                                    <i class="bx bxs-show"></i>
                                </a>
                                <a type="button" class="btn btn-neutral text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                    <i class="bx bxs-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @include('admin.layouts.delete', ['route'=> 'admin.deceases.request.destroy'])
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $decease->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection