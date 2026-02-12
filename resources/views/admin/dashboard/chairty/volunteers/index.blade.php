@extends('admin.app')

@section('title', trans('volunteers.show_volunteers'))
@section('title_page', trans('volunteers.show_volunteers'))
@section('title_route', route('admin.volunteers.index'))



@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body search-group">

                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('admin.volunteers.create') }}"
                                    class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
                            </div>
                        </div>
                        <form action="{{ route('admin.volunteers.index') }}" method="get">
                            <div class="row mt-3">
                                <div class="col-md-2 mt-2">
                                    <select class="form-control" name="type">
                                        <option value="">@lang('volunteers.type')</option>
                                        <option value="volunteer" {{ request('type') == 'volunteer' || request('type') == '1' ? 'selected' : '' }}>
                                            @lang('volunteers.volunteer')
                                        </option>
                                        <option value="team" {{ request('type') == 'team' || request('type') === '0' ? 'selected' : '' }}>
                                            @lang('volunteers.team')
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <input type="text" 
                                           value="{{ request('name') }}" 
                                           name="name" 
                                           placeholder="{{ trans('volunteers.name') }}" 
                                           class="form-control">
                                </div>
                                {{-- <div class="col-md-2 mt-2">
                                    <input type="text"
                                        value="{{ request('team_name') }}"
                                        name="team_name" 
                                        placeholder="{{ trans('volunteers.team_name') }}"
                                        class="form-control">
                                </div> --}}
                                <div class="col-md-2 mt-2">
                                    <input type="text" 
                                           name="identity" 
                                           value="{{ request('identity') }}"
                                           placeholder="@lang('volunteers.identity')" 
                                           class="form-control">
                                </div>
                                <div class="col-md-2 mt-2">
                                    <input type="text" 
                                           value="{{ request('mobile') }}"
                                           name="mobile" 
                                           placeholder="{{ trans('volunteers.mobile') }}" 
                                           class="form-control">
                                </div>
                                <div class="col-md-2 mt-2">
                                    <input type="text" 
                                           value="{{ request('email') }}"
                                           name="email" 
                                           placeholder="{{ trans('volunteers.email') }}" 
                                           class="form-control">
                                </div>

                                <div class="col-md-2 mt-2">
                                    <select class="form-control" name="gender">
                                        <option value="">@lang('volunteers.gender')</option>
                                        <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>
                                            @lang('volunteers.female')
                                        </option>
                                        <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>
                                            @lang('volunteers.male')
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <input type="text"
                                        value="{{ request('nationality') }}"
                                        name="nationality" 
                                        placeholder="{{ trans('volunteers.nationality') }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-2 mt-2">
                                    <select class="select form-control" name="status">
                                        <option value="">@lang('admin.status')</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                            @lang('admin.active')
                                        </option>
                                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>
                                            @lang('admin.dis_active')
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <input type="date" 
                                           name="search_created_from"
                                           value="{{ request('search_created_from') }}"
                                           placeholder="{{ trans('orders.created_from') }}" 
                                           class="form-control">
                                </div>
                                <div class="col-md-2 mt-2">
                                    <input type="date" 
                                           name="search_created__to"
                                           value="{{ request('search_created__to') }}"
                                           placeholder="{{ trans('orders.created_to') }}" 
                                           class="form-control">
                                </div>
                                <div class="col-md-2 mt-2">
                                    <button class="btn btn-primary btn-sm" type="submit" data-hover="@lang('pages.search')"><i
                                            class="bx bx-search-alt"> </i></button>
                                    <a class="btn btn-warning btn-sm" href="{{ route('admin.volunteers.index') }}"
                                        data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body mt-0 pt-0">
                        <form id="update-pages" action="{{ route('admin.volunteers.actions') }}" method="post">
                            @csrf
                        </form>
                        <div class="table-responsive">
                            <table id="main-datatable"
                                class="table table-bordered table-striped table-table-success table-hover"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr class="bluck-actions" style="display: none" scope="row">
                                        <td colspan="18">
                                            <div class="col-md-12 mt-0 mb-0 text-center">
                                                <button form="update-pages" class="btn btn-neutral text-success btn-sm"
                                                    type="submit" name="publish" value="1"> <i
                                                        class="bx bxs-check-square"></i></button>
                                                <button form="update-pages" class="btn btn-neutral text-warning btn-sm"
                                                    type="submit" name="unpublish" value="1"> <i
                                                        class="bx bx-no-entry"></i></button>
                                                <button form="update-pages" class="btn btn-neutral text-danger btn-sm"
                                                    type="submit" name="delete_all" value="1"> <i
                                                        class="bx bxs-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 1px">
                                            <input form="update-pages" class="checkbox-check flat" type="checkbox"
                                                name="check-all" id="check-all">
                                        </th>
                                        <th>#</th>
                                        <th>@lang('volunteers.type')</th>
                                        <th>@lang('volunteers.name')</th>
                                        <th>@lang('volunteers.identity')</th>
                                        <th>@lang('volunteers.image')</th>
                                        <th>@lang('volunteers.mobile')</th>
                                        <th>@lang('volunteers.email')</th>
                                        <th>@lang('volunteers.gender')</th>
                                        <th>@lang('volunteers.nationality')</th>
                                        <th>@lang('volunteers.date_of_birth')</th>
                                        <th>@lang('volunteers.educational_qualification')</th>
                                        <th>@lang('volunteers.preferred_fields')</th>
                                        <th>@lang('volunteers.preferred_times')</th>
                                        <th>@lang('volunteers.goal')</th>
                                        <th>@lang('admin.created_at')</th>
                                        <th>@lang('admin.updated_at')</th>
                                        <th>@lang('admin.actions')</th>
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
                                            <td>{{ trans('volunteers.' . $item->type) }}</td>
                                            <td>{{ $item->name }}
                                                {{ $item->team_name ? '(' . $item->team_name . ')' : '' }}</td>
                                            <td>{{ $item->identity }}</td>
                                            <td> <a href="{{ getImage($item->image) }}" target="_blank"> <img
                                                        src="{{ getImageThumb($item->image) }}" alt=""
                                                        style="width: 50px" class="rounded"></a></td>
                                            <td>{{ $item->mobile }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->gender === '1' || $item->gender === 1 ? trans('volunteers.female') : trans('volunteers.male') }}</td>
                                            <td>{{ $item->nationality }}</td>
                                            <td>{{ $item->date_of_birth }}</td>
                                            <td>{{ $item->educational_qualification }}</td>
                                            <td>{{ implode(', ', json_decode($item->preferred_fields ?? '[]')) }}</td>
                                            <td>{{ implode(', ', json_decode($item->preferred_times ?? '[]')) }}</td>
                                            <td>{{ $item->goal }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    @if ($item->status == 1)
                                                        <a href="{{ route('admin.volunteers.update-status', $item->id) }}"
                                                            class="btn btn-neutral text-success"><i
                                                                class="bx bxs-check-square"></i></a>
                                                    @else
                                                        <a href="{{ route('admin.volunteers.update-status', $item->id) }}"
                                                            class="btn btn-neutral text-warning "><i
                                                                class="bx bx-no-entry"></i></a>
                                                    @endif
                                                    <a href="{{ route('admin.volunteers.show', $item->id) }}"
                                                        data-hover="@lang('admin.show')"
                                                        class="btn btn-neutral text-info"><i class="bx bxs-show"></i></a>
                                                    <a href="{{ route('admin.volunteers.edit', $item->id) }}"
                                                        class="btn btn-neutral text-warning"
                                                        data-hover="{{ trans('button.edit') }}"><i
                                                            class="bx bxs-edit"></i></a>
                                                    <a type="button" class="btn btn-neutral text-danger"
                                                        class="color-red" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $item->id }}"> <i
                                                            class="bx bxs-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @include('admin.layouts.delete', [
                                            'route' => 'admin.volunteers.destroy',
                                        ])
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
