<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadSources\CreateLeadSourceRequest;
use App\Http\Requests\LeadSources\UpdateLeadSourceRequest;
use App\Http\Resources\LeadSourceResource;
use App\Models\LeadSource;
use Illuminate\Http\Request;

class LeadSourceController extends Controller
{
    /**
     * إضافة مصدر عميل جديد
     */
    public function store(CreateLeadSourceRequest $request)
    {
        $leadSource = LeadSource::create([
            'name' => $request->name,
            'status' => $request->status ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة مصدر العميل بنجاح.',
            'data' => new LeadSourceResource($leadSource),
        ], 201);
    }

    public function index()
    {
        $leadSources = LeadSource::latest()->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'تم جلب مصادر العملاء بنجاح.',
            'data' => LeadSourceResource::collection($leadSources),
            'pagination' => [
                'current_page' => $leadSources->currentPage(),
                'last_page' => $leadSources->lastPage(),
                'per_page' => $leadSources->perPage(),
                'total' => $leadSources->total(),
            ],
        ]);
    }

    public function show($id)
    {
        $leadSource = LeadSource::find($id);

        if (!$leadSource) {
            return response()->json([
                'success' => false,
                'message' => 'مصدر العميل غير موجود.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم جلب بيانات مصدر العميل بنجاح.',
            'data' => new LeadSourceResource($leadSource),
        ]);
    }

    public function update(UpdateLeadSourceRequest $request, $id)
    {
        $leadSource = LeadSource::find($id);

        if (!$leadSource) {
            return response()->json([
                'success' => false,
                'message' => 'مصدر العميل غير موجود.',
            ], 404);
        }

        $leadSource->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث مصدر العميل بنجاح.',
            'data' => new LeadSourceResource($leadSource->fresh()),
        ]);
    }
    public function destroy($id)
    {
        $leadSource = LeadSource::find($id);

        if (!$leadSource) {
            return response()->json([
                'success' => false,
                'message' => 'مصدر العميل غير موجود.',
            ], 404);
        }

        $leadSource->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف مصدر العميل بنجاح.',
        ]);
    }
}
