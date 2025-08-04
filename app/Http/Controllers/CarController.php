<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    public function getCars(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required|date|after_or_equal:now',
            'end_time' => 'required|date|after:start_time',
            'staff_id' => 'required|exists:staffs,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $start = Carbon::parse($request->input('start_time'));
        $end = Carbon::parse($request->input('end_time'));
        $staffId = $request->input('staff_id');

        $staff = Staff::with('position.carComfortClasses')->find($staffId);

        if (!$staff || !$staff->position) {
            return response()->json([
                'error' => 'Пользователь не найдено или не назначена должность.'
            ], 404);
        }

        $allowedComfortClassIds = $staff->position->carComfortClasses->pluck('id')->toArray();

        if (
            $request->filled('car_comfort_class_id') &&
            !in_array($request->input('car_comfort_class_id'), $allowedComfortClassIds)
        ) {
            return response()->json([
                'error' => 'Вам не разрешено использовать данное комфорт класса.'
            ], 403);
        }

        $availableCars = Car::with('driver', 'comfortClass')
            ->whereIn('car_comfort_class_id', $allowedComfortClassIds)
            ->whereDoesntHave('trips', function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->whereBetween('start_time', [$start, $end])
                      ->orWhereBetween('end_time', [$start, $end])
                      ->orWhere(function ($q2) use ($start, $end) {
                          $q2->where('start_time', '<=', $start)
                             ->where('end_time', '>=', $end);
                      });
                });
            })
            ->when($request->filled('model'), function ($q) use ($request) {
                $q->where('model', 'like', '%' . $request->input('model') . '%');
            })
            ->when($request->filled('car_comfort_class_id'), function ($q) use ($request) {
                $q->where('car_comfort_class_id', $request->input('car_comfort_class_id'));
            })
            ->get();

        return response()->json($availableCars);
    }
}