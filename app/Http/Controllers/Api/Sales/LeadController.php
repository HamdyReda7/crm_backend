<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leads\CreateLeadRequest;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LeadController extends Controller
{
    /**
     * إضافة عميل محتمل جديد
     */
    public function store(CreateLeadRequest $request)
    {
        DB::beginTransaction();

        try {

            $lead = Lead::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'whatsapp' => $request->whatsapp,
                'business_type' => $request->business_type,
                'city' => $request->city,
                'address' => $request->address,
                'lead_source_id' => $request->lead_source_id,

                // الـSales الحالي تلقائيًا
                'assigned_to' => $request->user()->id,

                // الحالة الافتراضية
                'status' => Lead::NEW,

                'notes' => $request->notes,
                'next_follow_up_at' => $request->next_follow_up_at,
            ]);

            if ($request->filled('services')) {
                $lead->services()->sync($request->services);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم إضافة العميل المحتمل بنجاح.',
                'data' => new LeadResource(
                    $lead->load([
                        'leadSource',
                        'sales',
                        'services',
                    ])
                ),
            ], 201);
        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إضافة العميل المحتمل.',
            ], 500);
        }
    }

    /**
     * عرض العملاء المحتملين الخاصين بالـSales الحالي
     */
    public function index(Request $request)
    {
        $leads = Lead::where('assigned_to', $request->user()->id)
            ->with([
                'leadSource',
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
    public function show(Request $request, $id)
    {
        $lead = Lead::where('id', $id)
            ->where('assigned_to', $request->user()->id)
            ->with([
                'leadSource',
                'sales',
                'services',
            ])
            ->first();

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

    /**
     * تعديل حالة وملاحظات العميل المحتمل
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => [
                'required',
                Rule::in([
                    Lead::NEW,
                    Lead::CONTACTED,
                    Lead::INTERESTED,
                    Lead::FOLLOW_UP,
                    Lead::NO_ANSWER,
                    Lead::PHONE_CLOSED,
                    Lead::WRONG_NUMBER,
                    Lead::NOT_INTERESTED,
                    Lead::CONVERTED,
                    Lead::LOST,
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'last_contact_at' => [
                'nullable',
                'date',
            ],
        ], [
            'status.required' => 'حالة العميل مطلوبة.',
            'status.in' => 'حالة العميل المحددة غير صحيحة.',

            'notes.string' => 'الملاحظات يجب أن تكون نصًا.',

            'last_contact_at.date' => 'تاريخ آخر تواصل غير صحيح.',
        ]);
        $lead = Lead::where('id', $id)
            ->where('assigned_to', $request->user()->id)
            ->first();

        if (!$lead) {
            return response()->json([
                'success' => false,
                'message' => 'العميل المحتمل غير موجود.',
            ], 404);
        }

        $lead->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'last_contact_at' => $request->last_contact_at,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث بيانات العميل المحتمل بنجاح.',
            'data' => new LeadResource(
                $lead->fresh()->load([
                    'leadSource',
                    'sales',
                    'services',
                ])
            ),
        ]);
    }
}
