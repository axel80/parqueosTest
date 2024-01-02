<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::all();

        return response()->json($vehicles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'vehicle_type_id'   => 'required',
                'license_plate'     => 'required|unique:vehicles',
                'owner_name'        => 'required|max:80'

            ]);

            $vehicleSave = Vehicle::create($request->all());


            return response()->json([
                'code' => 200,
                'message' => "Vehicle data has saved",
                'vehicleType' => $vehicleSave
            ]);
        } catch (\Throwable $error) {
            return response()->json($error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        try {
            $request->validate([
                'license_plate'     => 'unique:vehicles,license_plate,' . $vehicle->id,

            ]);

            $vehicle->update($request->all());


            return response()->json([
                'code' => 200,
                'message' => "Vehicle data has updated",
                'vehicleType' => $vehicle
            ]);
        } catch (\Throwable $error) {
            return response()->json($error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return response()->json([
            'code' => 200,
            'message' => "Vehicle data has deleted",
            'vehicleType' => $vehicle
        ]);
    }
}
