<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\CreateSalesRequest;
use App\Http\Requests\Sales\UpdateSalesStatusRequest;
use App\Http\Resources\LeadResource;
use App\Http\Resources\SalesResource;
use App\Http\Resources\UserResource;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SalesController extends Controller
{
    public function store(CreateSalesRequest $request)
    {
        $imageName = null;

        /*
    |--------------------------------------------------------------------------
    | Upload Image
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $randomNumber = random_int(100000, 999999);

            $imageName = 'user_' . $randomNumber . '.' .
                $image->getClientOriginalExtension();

            $image->move(
                public_path('img/users'),
                $imageName
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Create Sales
    |--------------------------------------------------------------------------
    */

        $sales = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => User::SALES,
            'status' => $request->status ?? User::ACTIVE,
            'image' => $imageName,
        ]);

        /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة موظف المبيعات بنجاح.',
            'data' => new SalesResource($sales),
        ], 201);
    }

    public function index()
    {
        $sales = User::where('role', User::SALES)
            ->withCount('leads')
            ->latest()
            ->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'تم جلب موظفي المبيعات بنجاح.',
            'data' => SalesResource::collection($sales),
            'pagination' => [
                'current_page' => $sales->currentPage(),
                'last_page' => $sales->lastPage(),
                'per_page' => $sales->perPage(),
                'total' => $sales->total(),
            ],
        ]);
    }

    /**
     * عرض بيانات الـ Sales والعملاء التابعين له
     */
    public function show($id)
    {
        $sales = User::where('id', $id)
            ->where('role', User::SALES)
            ->first();

        if (!$sales) {
            return response()->json([
                'success' => false,
                'message' => 'موظف المبيعات غير موجود.',
            ], 404);
        }

        $leads = Lead::where('assigned_to', $sales->id)
            ->with([
                'leadSource',
                'services',
            ])
            ->latest()
            ->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'تم جلب بيانات موظف المبيعات والعملاء التابعين له بنجاح.',

            'data' => [
                /*
            |--------------------------------------------------------------------------
            | Sales Information
            |--------------------------------------------------------------------------
            */

                'sales' => [
                    'id' => $sales->id,
                    'name' => $sales->name,
                    'email' => $sales->email,
                    'phone' => $sales->phone,
                    'image' => $sales->image
                        ? asset('storage/' . $sales->image)
                        : null,
                    'status' => $sales->status,
                    'created_at' => $sales->created_at,
                ],

                /*
            |--------------------------------------------------------------------------
            | Leads
            |--------------------------------------------------------------------------
            */

                'leads_count' => $leads->total(),

                'leads' => LeadResource::collection($leads),

                'pagination' => [
                    'current_page' => $leads->currentPage(),
                    'last_page' => $leads->lastPage(),
                    'per_page' => $leads->perPage(),
                    'total' => $leads->total(),
                ],
            ],
        ]);
    }

    public function updateStatus(UpdateSalesStatusRequest $request, $id)
    {
        $sales = User::where('role', User::SALES)
            ->find($id);

        if (!$sales) {
            return response()->json([
                'success' => false,
                'message' => 'موظف المبيعات غير موجود.',
            ], 404);
        }

        $sales->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث حالة موظف المبيعات بنجاح.',
            'data' => new SalesResource($sales->fresh()->loadCount('leads')),
        ]);
    }

    public function destroy($id)
    {
        $sales = User::where('role', User::SALES)
            ->find($id);

        if (!$sales) {
            return response()->json([
                'success' => false,
                'message' => 'موظف المبيعات غير موجود.',
            ], 404);
        }

        if ($sales->image) {

            $imagePath = public_path('img/users/' . $sales->image);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $sales->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف موظف المبيعات بنجاح.',
        ]);
    }
}
