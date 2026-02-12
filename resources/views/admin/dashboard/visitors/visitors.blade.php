@extends('admin.app')

@section('title', 'الزوار')

@section('content')
    @php
        $search = request('start_date') || request('end_date') || request('mobile') || request('status');
    @endphp
    <div class="row mb-3">
        <div class="accordion accordion-flush" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="accordionFlushExample">
                    <button class="accordion-button @if (!$search) collapsed @endif" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false"
                        aria-controls="collapseFilter">
                        @lang('dashboard.filter')
                    </button>
                </h2>
                <div id="collapseFilter" class="accordion-collapse collapse @if ($search) show @endif"
                    aria-labelledby="headingFilter" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <form action="{{ route('admin.visitors') }}" method="GET">
                            <div class="row my-3">
                                <div class="col-12 col-md-3">
                                    <label for="mobile">رقم الجوال</label>
                                    <input type="text" name="mobile" value="{{ request('mobile') }}"
                                        class="form-control">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label for="email">الايميل </label>
                                    <input type="text" name="email" value="{{ request('email') }}"
                                        class="form-control">
                                </div>

                                <div class="col-12 col-md-3">
                                    <label for="status">حالة العميل</label>
                                    <select name="status" class="form-control">
                                        <option value="">الكل</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>نشط</option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>غير نشط
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label for="start_date">من تاريخ</label>
                                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                                        class="form-control">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label for="end_date">إلى تاريخ</label>
                                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                                        class="form-control">
                                </div>
                                <div class="col-12 col-md-3">
                                    <button class="btn btn-primary mt-4 btn-sm" type="submit"
                                        data-hover="{{ trans('pages.search') }}"><i class="bx bx-search-alt"> </i></button>
                                    <a href="{{ route('admin.visitors') }}" class="btn btn-danger btn-sm mt-4"><i
                                            class="bx bx-refresh"></i></a>
                                    <a href="{{ route('admin.visitors.export', request()->only(['mobile', 'status', 'start_date', 'end_date'])) }}"
                                        class="btn btn-success btn-sm mt-4">
                                        <i class="bx bx-download"></i> Excel
                                    </a>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card radius-10">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">الزوار</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>رقم الجوال</th>
                            <th>الإيميل</th>
                            <th>تاريخ تسجيل الدخول</th>
                            <th>عدد المنتجات في السلة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1;
                        @endphp
                        @forelse($visitors as $visitor)
                            @php
                                $donor = $visitor->donor;
                            @endphp
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>{{ $donor ? $donor->full_name : 'غير معروف' }}</td>
                                <td>{{ $visitor->mobile }}</td>
                                <td>{{ $visitor->email }}</td>
                                <td>{{ $visitor->created_at }}</td>
                                <td>{{ $donor ? $donor->carts_count : 0 }}</td>
                            </tr>
                            @php
                                $counter++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">لا توجد بيانات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">{{ $visitors->links('pagination::bootstrap-5') }}</div>

            </div>
        </div>
    </div>
@endsection
