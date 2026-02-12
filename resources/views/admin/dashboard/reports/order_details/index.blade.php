@extends('admin.app')

@section('title', 'تفاصيل الطلبات')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>عدد الطلبات</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $countOrder }}</h4>
                                        <small>طلب</small>
                                    </div>
                                </div>
                                <span class="badge bg-label-primary rounded p-2 text-success">
                                    <i class="fa-light fa-check"></i> </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>مجموع الطلبات</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $totalOrder }}</h4>
                                        <small>ر.س</small>
                                    </div>
                                </div>
                                <span class="badge bg-label-primary rounded p-2 text-success">
                                    <i class="fa fa-check fs-1"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>عدد المنتجات</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $countProductOrder }}</h4>
                                        <small>منتج</small>
                                    </div>
                                </div>
                                <span class="badge bg-label-primary rounded p-2 text-success">
                                    <i class="fa fa-check fs-1"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.order_details.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input type="text" name="order_details_id" class="form-control" placeholder="رقم التبرع"
                            value="{{ request('order_details_id') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" name="search_id" class="form-control" placeholder="رقم الطلب"
                            value="{{ request('search_id') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" name="donor_email" class="form-control" placeholder="بحث بالإيميل"
                            value="{{ request('donor_email') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <input type="text" name="donor_mobile" class="form-control" placeholder="بحث بالموبايل"
                            value="{{ request('donor_mobile') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" name="search_product" class="form-control" placeholder="اسم المنتج"
                            value="{{ request('search_product') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="date" name="search_created_from" class="form-control"
                            value="{{ request('search_created_from') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="date" name="search_created_to" class="form-control"
                            value="{{ request('search_created_to') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        {{-- <label for="search_refer" class="form-label">@lang('admin.refer')</label> --}}
                        <select name="search_refer" id="search_refer" class="form-control">
                            <option value="">{{ 'اختر المسوق' }}</option>
                            @foreach ($refers as $refer)
                                <option value="{{ $refer->id }}"
                                    {{ (string) request('search_refer') === (string) $refer->id ? 'selected' : '' }}>
                                    {{ $refer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <select name="payment_key" id="payment_key" class="form-control">
                            <option value="">{{ 'اختر وسيلة الدفع' }}</option>
                            @foreach ($paymentMethods as $paymentMethod)
                                <option value="{{ $paymentMethod->payment_key }}"
                                    {{ (string) request('payment_key') === (string) $paymentMethod->payment_key ? 'selected' : '' }}>
                                    {{ $paymentMethod->payment_key }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <select name="order_status" id="order_status" class="form-control">
                            <option value="">{{ 'اختر حالة الطلب' }}</option>
                            <option value="1" {{ request('order_status') === '1' ? 'selected' : '' }}>مكتمل</option>
                            <option value="0" {{ request('order_status') === '0' ? 'selected' : '' }}>غير مكتمل
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <select name="item_name" id="item_name" class="form-control">
                            <option value="">{{ 'اختر اسم المشروع' }}</option>
                            @foreach ($items as $name)
                                <option value="{{ $name }}"
                                    {{ (string) request('item_name') === (string) $name ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-end mt-2">
                        <button type="submit" class="btn btn-primary">بحث</button>
                        <a href="{{ route('admin.order_details.index') }}" class="btn btn-danger">مسح</a>
                        <a href="{{ route('admin.order_details.export', request()->all()) }}"
                            class="btn btn-success btn-sm">
                            <i class="bx bx-download"></i> Excel
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>رقم التبرع</th>
                            <th>رقم الطلب</th>
                            <th>اسم العميل</th>
                            <th>البريد الإلكتروني</th>
                            <th>جوال العميل</th>
                            <th>اسم المشروع</th>
                            <th>المسوق </th>
                            <th>وسيلة الدفع</th>
                            <th>الكمية</th>

                            <th>السعر</th>
                            <th>الإجمالي</th>
                            {{-- <th>حالة الشحن</th> --}}
                            <th>التاريخ</th>
                            <th>حالة </th>
                            {{-- <th>البائع</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orderDetails as $detail)
                            <tr>
                                <td>{{ $detail->id }}</td>
                                <td>{{ $detail->order?->id ?? 'غير متوفر' }}</td>
                                <td>{{ $detail->order?->donor?->full_name ?? '—' }}</td>
                                <td>{{ $detail->order?->donor?->account->email ?? '—' }}</td>
                                <td>{{ $detail->order?->donor?->mobile ?? '—' }}</td>
                                <td>{{ $detail->item_name ?? 'غير متوفر' }}</td>
                                <td>{{ $detail->order->refer->name ?? 'غير متوفر' }}</td>
                                <td>{{ $detail->order->paymentMethod->payment_key ?? 'غير متوفر' }}</td>
                                <td>{{ $detail->quantity }}</td>

                                <td>{{ $detail->price }}</td>
                                <td>{{ $detail->total }}</td>
                                {{-- <td>{{ $detail->shipping_status }}</td> --}}
                                <td>{{ $detail->created_at->format('d-m-Y H:i:s') }}</td>
                                {{-- <td>{{ $detail->vendor->name ?? 'غير متوفر' }}</td> --}}

                                <td>
                                    <div class="d-flex justify-content-center bulk-order">
                                        @switch (@$detail->order->status)
                                            @case('0')
                                                <a data-hover="@lang('Pending')"
                                                    class="btn btn-neutral text-warning order-action" data-toggle="tooltip"
                                                    title="" data-original-title="@lang('Pending')">
                                                    <i class="bx bx-no-entry"></i>
                                                </a>
                                            @break

                                            @case(1)
                                                <a data-hover="@lang('Confirmed')"
                                                    class="btn btn-neutral text-success order-action" data-toggle="tooltip"
                                                    title="" data-original-title="@lang('Confirmed')">
                                                    <i class='bx bx-check-circle'></i>
                                                </a>
                                            @break

                                            @case(3)
                                                <a data-hover="@lang('Waiting')" class="btn btn-neutral text-info order-action"
                                                    data-toggle="tooltip" title="" data-original-title="@lang('Waiting')"
                                                    aria-describedby="tooltip358766">
                                                    <i class='bx bx-history'></i>
                                                </a>
                                            @break

                                            @case(4)
                                                <a data-hover="@lang('Canceled')" class="btn btn-neutral text-danger order-action"
                                                    data-toggle="tooltip" title="" data-original-title="@lang('Canceled')"
                                                    aria-describedby="tooltip358766">
                                                    <i class='bx bx-window-close'></i>
                                                </a>
                                            @break
                                        @endswitch


                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">لا توجد بيانات</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="col-md-12 text-center mt-3">
                        {{ $orderDetails->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    @endsection
