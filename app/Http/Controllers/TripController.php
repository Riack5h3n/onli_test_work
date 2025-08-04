<?php

namespace App\Http\Controllers;

use App\Models\Trips;
use App\Models\Car;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TripController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:cars,id',
            'staff_id' => 'required|exists:staffs,id',
            'start_time' => 'required|date|after_or_equal:now',
            'end_time' => 'required|date|after:start_time',
            'destination' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $staff = Staff::with('position.carComfortClasses')->find($request->input('staff_id'));

        if (!$staff || !$staff->position) {
            return response()->json([
                'error' => 'Пользователь не найдено или не назначена должность.'
            ], 400);
        }

        $carId = $request->input('car_id');
        $start = Carbon::parse($request->input('start_time'));
        $end = Carbon::parse($request->input('end_time'));

        $car = Car::with('comfortClass')->find($carId);
        if (!$car) {
            return response()->json(['error' => 'Машина не найдено.'], 404);
        }

        $onWorked = Trips::where('car_id', $carId)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                  ->orWhereBetween('end_time', [$start, $end])
                  ->orWhere(function ($q2) use ($start, $end) {
                      $q2->where('start_time', '<=', $start)
                         ->where('end_time', '>=', $end);
                  });
            })
            ->exists();

        if ($onWorked) {
            return response()->json([
                'error' => 'Выбранное транспортное средство бронируется для другой поездки в течение этого периода времени.'
            ], 409);
        }

        $allowedComfortClassIds = $staff->position->carComfortClasses->pluck('id')->toArray();

        if (!in_array($car->car_comfort_class_id, $allowedComfortClassIds)) {
            return response()->json([
                'error' => 'Вам не разрешено использовать данное транспортное средство.'
            ], 403);
        }

        $trip = Trips::create([
            'staff_id' => $staff->id,
            'car_id' => $carId,
            'start_time' => $start,
            'end_time' => $end,
            'destination' => $request->input('destination'),
        ]);

        return response()->json([
            'message' => 'Служебная поездка успешно создана.',
            'trip' => $trip
        ], 201);
    }
}
