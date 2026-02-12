<?php

namespace App\Http\Controllers\Api\Management;

use App\Http\Controllers\Controller;
use App\Http\Resources\Management\OrderResource;
use App\Models\OrderView;

class OrderController extends Controller
{

    /**
     * get all porders with relation
     *
     * @return response
     */
    public function index()
    {
        $query = OrderView::with(['paymentMethodTranslationEn'])->orderBy('created_at', 'DESC');

        // filter
        // do filters here otr make order service
        
        $orders = $query->get();

        return $this->apiResponse(OrderResource::collection($orders));
    }
}