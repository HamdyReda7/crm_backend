<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeadSourceResource;
use App\Http\Resources\ServiceResource;
use App\Models\LeadSource;
use App\Models\Service;

class SalesController extends Controller
{
    /**
     * عرض جميع الخدمات المتاحة للـSales
     */
    public function services()
    {
        $services = Service::where('status', true)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'تم جلب الخدمات بنجاح.',
            'data' => ServiceResource::collection($services),
        ]);
    }

    /**
     * عرض جميع مصادر العملاء المتاحة للـSales
     */
    public function leadSources()
    {
        $leadSources = LeadSource::where('status', true)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'تم جلب مصادر العملاء بنجاح.',
            'data' => LeadSourceResource::collection($leadSources),
        ]);
    }
}
