<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Services\CreateServiceRequest;
use App\Http\Requests\Services\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * إضافة خدمة جديدة
     */
    public function store(CreateServiceRequest $request)
    {
        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة الخدمة بنجاح.',
            'data' => new ServiceResource($service),
        ], 201);
    }

    public function index()
    {
        $services = Service::latest()->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'تم جلب الخدمات بنجاح.',
            'data' => ServiceResource::collection($services),
            'pagination' => [
                'current_page' => $services->currentPage(),
                'last_page' => $services->lastPage(),
                'per_page' => $services->perPage(),
                'total' => $services->total(),
            ],
        ]);
    }

    public function show($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'الخدمة غير موجودة.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم جلب بيانات الخدمة بنجاح.',
            'data' => new ServiceResource($service),
        ]);
    }

    public function update(UpdateServiceRequest $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'الخدمة غير موجودة.',
            ], 404);
        }

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الخدمة بنجاح.',
            'data' => new ServiceResource($service->fresh()),
        ]);
    }

    public function destroy($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'الخدمة غير موجودة.',
            ], 404);
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الخدمة بنجاح.',
        ]);
    }
}
