 <div class="div">
     <div class="profile-content" id="orders-content">
         <div class="profile-header mb-4">
             <h2 class="section-title">سجل الطلبات</h2>
         </div>

         <!-- Statistics Summary -->
         {{-- <div class="statistics-cards mb-4">
             <div class="row">
                 <div class="col-md-6 mb-4">
                     <div class="stat-card">
                         <div class="stat-value text-white">{{ $ordersCount }}</div>
                         <div class="stat-label"> @lang('Number of donates') </div>
                     </div>
                 </div>

                 <div class="col-md-6 mb-4">
                     <div class="stat-card">
                         <div class="stat-value text-white"> {{ $totalOrders }} </div>
                         <div class="stat-label"> @lang('Total Amount') </div>
                     </div>
                 </div>
             </div>
         </div> --}}
         <!-- STATISTICS -->
         <div class="statistics-container mb-3">


             <div class="statistic">
                 <div class="statistic-title"> @lang('Total Amount') </div>

                 <div class="statistic-value">{{ $totalOrders }}</div>
                 <div class="statistic-currency">ر.س</div>
             </div>

             <div class="statistic">
                 <div class="statistic-title">@lang('Number of donates')</div>

                 <div class="statistic-value">{{ $ordersCount }}</div>

             </div>
         </div>

         <!-- Filter Options -->
         <div class="orders-filter mb-4">
             <div class="filter-buttons">
                 <button class="filter-btn {{ '' == $selectedStatus ? 'active' : '' }}" wire:model="selectedStatus"
                     wire:click="updateSelectStatus('All')">الكل </button>
                 <button class="filter-btn {{ '0' == $selectedStatus ? 'active' : '' }}" wire:model="selectedStatus"
                     wire:click="updateSelectStatus(0)">@lang('Pending') </button>
                 <button class="filter-btn {{ '1' == $selectedStatus ? 'active' : '' }}" wire:model="selectedStatus"
                     wire:click="updateSelectStatus(1)">@lang('Confirmed')</button>
                 <button class="filter-btn {{ '3' == $selectedStatus ? 'active' : '' }}" wire:model="selectedStatus"
                     wire:click="updateSelectStatus(3)">@lang('Waiting')</button>
                 <button class="filter-btn {{ '4' == $selectedStatus ? 'active' : '' }}" wire:model="selectedStatus"
                     wire:click="updateSelectStatus(4)">@lang('Canceled')</button>
             </div>
         </div>

         <!-- Orders Table -->
         <div class="orders-table-container">
             <div class="table-responsive">
                 <table class="table orders-table">
                     <thead>
                         <tr>
                             <th scope="col " dir="rtl"> @lang('Identifier') </th>
                             <th scope="col" dir="rtl"> @lang('Quantity') </th>
                             <th scope="col" dir="rtl"> @lang('Total') </th>
                             <th scope="col" dir="rtl"> @lang('Payment Method') </th>
                             <th scope="col" dir="rtl"> @lang('Donation date') </th>
                             <th scope="col" dir="rtl"> @lang('Order Status') </th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             @forelse ($orderCarousels as $key => $carousel)
                                 @forelse ($carousel as $key => $order)
                         <tr>
                             <th scope="row">{{ $order['identifier'] }}</th>
                             <td>{{ $order['quantity'] }}</td>
                             <td>{{ number_format($order['total']) }} <small>ر.س</small></td>
                             {{-- <td>test1</td> --}}
                             <td>{{ $order['payment_method_' . app()->getLocale()] }}</td>
                             <td><span dir="ltr">{{ date('Y/m/d', strtotime($order['created_at'])) }}</span></td>
                             <td dir="rtl" class="ek-orders__status-cell">
                                 @php
                                     $rowStatus = ['0' => ['Pending', 'wait'], '1' => ['Confirmed', 'ok'], '3' => ['Waiting', 'info'], '4' => ['Canceled', 'bad']][(string) $order['status']] ?? null;
                                 @endphp
                                 @if ($rowStatus)
                                     <span class="ek-od__status ek-od__status--{{ $rowStatus[1] }}">@lang($rowStatus[0])</span>
                                 @endif
                                 @livewire('site.profile.order-items', ['order_id' => $order['id']], key($order['id']))

                             </td>

                         </tr>
                     @empty
                         @endforelse
                     @empty
                         @endforelse
                         </tr>
                     </tbody>
                 </table>
             </div>
         </div>
         @if ($ordersCount - count($orderCarousels) * $pageCount > 0)
             <div class="text-center my-2">
                 <button wire:click="showMore" class="btn btn-primary px-5">
                     @lang('More')
                 </button>
             </div>
         @endif
     </div>
 </div>
