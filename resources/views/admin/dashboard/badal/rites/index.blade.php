@extends('admin.app')

@section('title', trans('rites.rites'))
@section('title_page', trans('rites.show_rites'))
@section('title_route', route('admin.badal.rites.index') )
@section('button_page')
<a href="{{ route('admin.badal.rites.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
@endsection


@section('content')

<div class="card">
    <div class="card-body  search-group">
        {{-- Start Form search --}}
        <form action="{{route('admin.badal.rites.index')}}" method="get">

            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" value="{{ old('title', request()->input('title')) }}" name="title" placeholder="{{ trans('admin.title') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="status" aria-label=".form-select-sm example">
                        <option selected value=""> @lang('admin.status') </option>
                        <option value="1" {{ old('status', request()->input('status')) == 1? "selected":"" }}>@lang('admin.active') </option>
                        <option value="0" {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null? "selected":"" }}> @lang('admin.dis_active') </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select select2" name="project_id">
                        <option value="" selected>@lang('rites.project')</option>
                        @foreach ($projects as $item)
                            <option value="{{ $item->id }}" {{ old('project_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->trans->where('locale', $current_lang)->first()->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="search-input col-md-2">
                    <button class="btn btn-primary btn-sm" type="submit" data-hover="{{ trans('button.search') }}"><i class="bx bx-search-alt"> </i></button>
                    <a class="btn btn-success btn-sm" href="{{route('admin.badal.rites.index')}}" data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>
                </div>
            </div>
        </form>
        {{-- End Form search --}}
    </div>

</div>

<div class="card">
    <div class="card-body mt-0 pt-0">
        <form id="update-pages" action="{{route('admin.badal.rites.actions')}}" method="post">
            @csrf
        </form>
        <div class="table-responsive">
            <table id="main-datatable" class="table table-bordered  dt-responsive nowrap table-striped table-table-success table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr class="bluck-actions" style="display: none" scope="row">
                        <td colspan="9">
                            <div class="col-md-12 mt-0 mb-0 text-center">
                                <button form="update-pages" class="btn btn-neutral text-success btn-sm" type="submit" name="publish" value="1"> <i class="bx bxs-check-square"></i></button>
                                <button form="update-pages" class="btn btn-neutral text-warning btn-sm" type="submit" name="unpublish" value="1"> <i class="bx bx-no-entry"></i></button>
                                <button form="update-pages" class="btn btn-neutral text-danger btn-sm" type="submit" name="delete_all" value="1"> <i class="bx bxs-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th tyle="width: 1px">
                            <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all" id="check-all">
                        </th>
                        <th>#</th>
                        <th>@lang('admin.title')</th>
                        <th>@lang('articles.sort')</th>
                        <th>@lang('rites.project')</th>
                        <th>@lang('rites.image')</th>
                        <th>@lang('admin.created_at')</th>
                        <th>@lang('admin.updated_at')</th>
                        <th>@lang('articles.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $key => $item)
                    <tr>
                        <td>
                            <input form="update-pages" class="checkbox-check" type="checkbox" name="record[{{$item->id}}]" value={{ $item->id }}>
                        </td>
                        <td>{{ $items->firstItem() + $key  }}</td>
                        <td>
                            {{ @$item->trans->where('locale',$current_lang)->first()->title}}
                        </td>
                        <td>{{ $item->sort }}</td>
                        <td>{{ @ $item->project ? $item->project->trans->where('locale',$current_lang)->first()->title : ""}}</td>
                        <td>
                            @if($item->image != null)
                            <img src="{{ getImageThumb($item->image) }}" alt="" width="60">
                            @else
                            <span class="text-danger">@lang('rites.not_found_ image')</span>
                            @endif
                        </td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                @if($item->status == 1)
                                <a href="{{ route('admin.badal.rites.update-status', $item->id )}}" data-hover="@lang('admin.active')" class="btn btn-neutral text-success btn-sm m-1"><i class="bx bxs-check-square"></i></a>
                                @else
                                <a href="{{ route('admin.badal.rites.update-status', $item->id )}}" data-hover="@lang('admin.dis_active')" class="btn btn-neutral text-secondary btn-sm m-1"><i class="bx bx-no-entry"></i></a>
                                @endif
                                <a href="{{ route('admin.badal.rites.show', $item->id) }}" data-hover="@lang('admin.show')" class="btn btn-neutral text-info btn-sm m-1"><i class="bx bxs-show"></i></a>
                                <a href="{{ route('admin.badal.rites.edit',$item->id) }}" data-hover="@lang('admin.edit')" class="btn btn-neutral text-primary btn-sm m-1"><i class="bx bxs-edit"></i></a>
                                <a class="btn btn-neutral text-danger btn-sm m-1" data-hover="@lang('admin.delete')" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
                                    <i class="bx bxs-trash"> </i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @include('admin.layouts.delete', ['route'=> 'admin.badal.rites.destroy'])
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-12 text-center">
            {{ $items->links('pagination::bootstrap-5') }}
        </div>
        </form>
    </div>
</div>
@endsection
