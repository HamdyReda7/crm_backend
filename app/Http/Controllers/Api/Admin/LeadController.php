<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeadResource;
use App\Models\Lead;

class LeadController extends Controller
{
    /**
     * عرض جميع العملاء المحتملين
     */
    public function index()
    {
        $leads = Lead::with([
            'leadSource',
            'sales',
            'services',
        ])
            ->latest()
            ->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'تم جلب العملاء المحتملين بنجاح.',
            'data' => LeadResource::collection($leads),
            'pagination' => [
                'current_page' => $leads->currentPage(),
                'last_page' => $leads->lastPage(),
                'per_page' => $leads->perPage(),
                'total' => $leads->total(),
            ],
        ]);
    }

    /**
     * عرض تفاصيل عميل محتمل
     */
    public function show($id)
    {
        $lead = Lead::with([
            'leadSource',
            'sales',
            'services',
            'activities',
        ])->find($id);

        if (!$lead) {
            return response()->json([
                'success' => false,
                'message' => 'العميل المحتمل غير موجود.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم جلب بيانات العميل المحتمل بنجاح.',
            'data' => new LeadResource($lead),
        ]);
    }
}
