@extends('admin.app')

@section('title', 'العملاء')

@section('content')
@php
$search =
request('start_date') ||
request('end_date') ||
request('mobile') ||
request('status') ||
request('total_from') ||
request('total_to');
@endphp
<div class="row mb-3">
    <div class="col-12">
        <div class="card card-body border">
            <form action="{{ route('admin.clients') }}" method="GET">
                <div class="row my-3">
                    <div class="col-md-3">
                        <label>رقم الجوال</label>
                        <input type="text" name="mobile" value="{{ request('mobile') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>حاله العميل</label>
                        <select name="status" class="form-control">
                            <option value="">الكل</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>نشط</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>من تاريخ</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>الي تاريخ</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                    </div>
                    <div class="col-md-3 mt-3">
                        <label>الاجمالي من</label>
                        <input type="number" name="total_from" value="{{ request('total_from') }}" class="form-control">
                    </div>
                    <div class="col-md-3 mt-3">
                        <label>الاجمالي الي</label>
                        <input type="number" name="total_to" value="{{ request('total_to') }}" class="form-control">
                    </div>
                    <div class="col-md-3 mt-5">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="bx bx-search-alt"></i>
                        </button>
                        <a href="{{ route('admin.clients') }}" class="btn btn-danger btn-sm">
                            <i class="bx bx-refresh"></i>
                        </a>

                        <a href="{{ route('admin.clients.export', request()->only(['mobile', 'status', 'start_date', 'end_date', 'total_from', 'total_to'])) }}" class="btn btn-success btn-sm">
                            <i class="bx bx-download"></i> Excel
                        </a>

                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


<div class="card radius-10">
    <div class="card-header">
        <h6 class="mb-0">العملاء</h6>
    </div>
    <div class="card-body table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>رقم جوال العميل</th>
                    <th>الإيميل</th>
                    <th>المتجر</th>
                    <th>تاريخ التسجيل</th>
                    <th>التاريخ والوقت لآخر عملية</th>
                    <th>إجمالي التبرع</th>

                    <th style="background-color: #88cda5" colspan="3"> الطلبات (مكتملة - مدفوعة)</th>

                    <th style="background-color: #ff6950e8" colspan="3"> الطلبات (غير مكتملة)</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $index => $client)
                @php
                $lastOrder = $client->orders->first();
                $lastDate = $lastOrder ? $lastOrder->created_at->format('Y-m-d H:i:s') : '-';
                @endphp
                <tr>
                    <td>{{ $clients->firstItem() + $index }}</td>
                    <td>{{ $client->full_name }}</td>
                    <td>{{ $client->mobile }}</td>
                    <td>{{ $client->account->email ?? '-' }}</td>
                    <td>{{ $client->refer?->name }}</td>
                    <td>{{ $client->created_at->format('Y-m-d') }}</td>
                    <td>{{ $lastDate }}</td>
                    <td>{{ $client->orders->sum('total') }}</td>
                    <td>{{ $client->paid_count }} طلبات </td>
                    <td>{{ $client->paid_total }} ريال</td>
                    <td>
                        <a class="btn btn-primary btn-sm" target="_blank" href="{{ route('admin.order_details.index', [
                                        'donor_mobile' => $client->mobile,
                                        'order_status' => '1',
                                    ]) }}">
                            تفاصيل
                        </a>

                    </td>
                    <td>{{ $client->unpaid_count }} طلبات </td>
                    <td>{{ $client->unpaid_total }} ريال</td>
                    <td>
                        <a class="btn btn-danger btn-sm" target="_blank" href="{{ route('admin.order_details.index', [
                                        'donor_mobile' => $client->mobile,
                                        'order_status' => '0',
                                    ]) }}">
                            تفاصيل
                        </a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">{{ $clients->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection
