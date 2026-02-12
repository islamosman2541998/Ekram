@extends('admin.app')

@section('title', trans('admin.review'))
@section('title_page', trans('products.show_review'))


@section('style')
    @livewireStyles
@endsection
@section('content')

    <div class="container-fluid">
        <!-- container-fluid -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body search-group">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('admin.projects.index') }}"
                                    class="btn btn-outline-success">@lang('button.cancel')</a>

                            </div>
                        </div>
                        {{-- Start Form search --}}
                        <form action="{{ route('admin.charity.project.reviews', $charity_project->id) }}" method="get">


                            <div class="mb-3 row">
                                <div class="mb-2 col-md-3">
                                    <select class="form-select" name="created_by" aria-label=".form-select-sm example">
                                        <option selected value="">@lang('admin.created_by')</option>
                                        @forelse($reviews as $key => $item)
                                            <option value="{{ $item->created_by }}"
                                                {{ old('created_by', request()->input('created_by')) == $item->created_by ? 'selected' : '' }}>
                                                {{ $item->created_by }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>


                                <div class="mb-2 col-md-3">
                                    <select class="form-select" name="rate">
                                        <option selected value=""> @lang('admin.rate')</option>
                                        @forelse($reviews as $key => $item)
                                            <option value="{{ $item->rate }}">
                                                {{ $item->rate }} @lang('products.stars')
                                            </option>
                                        @empty
                                        @endforelse

                                    </select>
                                </div>
                                <div class="search-input col-md-2">
                                    <button class="btn btn-primary btn-sm" type="submit"
                                        data-hover="{{ trans('pages.search') }}"><i class="bx bx-search-alt"> </i></button>
                                    <a class="btn btn-success btn-sm"
                                        href="{{ route('admin.charity.project.reviews', $charity_project->id) }}"
                                        data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>


                                </div>
                            </div>
                        </form>
                        {{-- End Form search --}}
                    </div>
                    <div class="pt-0 mt-0 card-body">
                        <form id="update-pages" action="{{ route('admin.charity.reviews.actions') }}" method="post">
                            @csrf
                        </form>
                        <div class="table-responsive">
                            <table id="main-datatable"
                                class="table table-bordered dt-responsive nowrap table-striped table-table-success table-hover"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr class="bluck-actions" style="display: none" scope="row">
                                        <td colspan="8">
                                            <div class="mt-0 mb-0 text-center col-md-12">
                                                <button form="update-pages" class="btn btn-success btn-sm" type="submit"
                                                    name="publish" value="1"> <i class="bx bxs-check-square"></i></button>
                                                <button form="update-pages" class="btn btn-warning btn-sm" type="submit"
                                                    name="unpublish" value="1"> <i class="bx bx-no-entry"></i></button>
                                                <button form="update-pages" class="btn btn-danger btn-sm" type="submit"
                                                    name="delete_all" value="1"> <i
                                                        class="bx bxs-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th tyle="width: 1px">
                                            <input form="update-pages" class="checkbox-check flat" type="checkbox"
                                                name="check-all" id="check-all">
                                        </th>
                                        <th>#</th>
                                        <th>@lang('admin.rate')</th>
                                        <th>@lang('admin.description')</th>
                                        <th>@lang('admin.created_by')</th>
                                        <th>@lang('admin.created_at')</th>
                                        <th>@lang('admin.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reviews as $key => $item)
                                        <tr>
                                            <td>
                                                <input form="update-pages" class="checkbox-check" type="checkbox"
                                                    name="record[{{ $item->id }}]" value={{ $item->id }}>
                                            </td>

                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                @for ($i = 0; $i < $item->rate; $i++)
                                                    <i class="bx bxs-star text-warning"></i>
                                                @endfor
                                            </td>
                                            <td>{{ @$item->description }} </td>
                                            <td>{{ @$item->created_by }} </td>
                                            <td>{{ @$item->created_at }} </td>
                                            <td>
                                                <div class=" d-flex justify-content-center">
                                                    @if ($item->status == 1)
                                                        <a href="{{ route('admin.charity.reviews.update-status', $item->id) }}"
                                                            data-hover="@lang('admin.active')"
                                                            class="m-1 btn btn-xs btn-success btn-sm"><i
                                                                class="bx bxs-check-square"></i></a>
                                                    @else
                                                        <a href="{{ route('admin.charity.reviews.update-status', $item->id) }}"
                                                            data-hover="@lang('admin.dis_active')"
                                                            class="m-1 btn btn-xs btn-outline-secondary btn-sm"><i
                                                                class="bx bx-no-entry"></i></a>
                                                    @endif
                                                    <a class="m-1 btn btn-outline-danger btn-sm"
                                                        data-hover="@lang('admin.delete')" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $item->id }}">
                                                        <i class="bx bxs-trash"> </i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @include('admin.layouts.delete', ['route'=> 'admin.charity.reviews.destroy'])

                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
