@extends('admin.app')

@section('title', trans('beneficiaries.index'))
@section('title_page', trans('beneficiaries.beneficiaries'))
@section('title_route', route('admin.beneficiaries.index'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body search-group">
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <a href="{{ route('admin.beneficiaries.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
                        </div>
                    </div>
                    <form action="{{ route('admin.beneficiaries.index') }}" method="get">
                        <div class="row mt-3">
                            <div class="col-md-2 mt-2">
                                <input type="text" name="first_name" placeholder="{{ trans('beneficiaries.first_name') }}" class="form-control" value="{{ request()->first_name }}">
                            </div>
                            <div class="col-md-2 mt-2">
                                <input type="text" name="last_name" placeholder="{{ trans('beneficiaries.last_name') }}" class="form-control" value="{{ request()->last_name }}">
                            </div>
                            <div class="col-md-2 mt-2">
                                <select class="form-control" name="gender">
                                    <option value="">@lang('beneficiaries.gender')</option>
                                    <option value="male" {{ request()->gender == 'male' ? 'selected' : '' }}>@lang('beneficiaries.male')</option>
                                    <option value="female" {{ request()->gender == 'female' ? 'selected' : '' }}>@lang('beneficiaries.female')</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-2">
                                <input type="text" name="phone" placeholder="{{ trans('beneficiaries.phone') }}" class="form-control" value="{{ request()->phone }}">
                            </div>
                            <div class="col-md-2 mt-2">
                                <select class="form-control" name="status">
                                    <option value="">@lang('admin.status')</option>
                                    <option value="1" {{ request()->status == '1' ? 'selected' : '' }}>@lang('admin.active')</option>
                                    <option value="0" {{ request()->status == '0' ? 'selected' : '' }}>@lang('admin.dis_active')</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-2">
                                <button class="btn btn-primary btn-sm" type="submit">@lang('pages.search')</button>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.beneficiaries.index') }}">@lang('button.reset')</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body mt-0 pt-0">
                    <form id="update-pages" action="{{ route('admin.beneficiaries.actions') }}" method="post">
                        @csrf
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="check-all"></th>
                                    <th>#</th>
                                    <th>@lang('beneficiaries.first_name')</th>
                                    <th>@lang('beneficiaries.last_name')</th>
                                    <th>@lang('beneficiaries.gender')</th>
                                    <th>@lang('beneficiaries.phone')</th>
                                    <th>@lang('beneficiaries.status')</th>
                                    <th>@lang('admin.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td><input type="checkbox" name="record[{{ $item->id }}]" value="{{ $item->id }}"></td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->first_name }}</td>
                                        <td>{{ $item->last_name }}</td>
                                        <td>{{ trans('beneficiaries.' . $item->gender) }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->status ? trans('admin.active') : trans('admin.dis_active') }}</td>
                                        <td>
                                            <a href="{{ route('admin.beneficiaries.show', $item->id) }}" class="btn btn-info btn-sm">@lang('admin.show')</a>
                                            <a href="{{ route('admin.beneficiaries.edit', $item->id) }}" class="btn btn-warning btn-sm">@lang('admin.edit')</a>
                                            <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">@lang('admin.delete')</a>
                                        </td>
                                    </tr>
                                    @include('admin.layouts.delete', ['route' => 'admin.beneficiaries.destroy', 'id' => $item->id])
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