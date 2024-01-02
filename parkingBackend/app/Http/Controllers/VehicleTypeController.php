<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Catalogs\VehicleType;

class VehicleTypeController extends Controller
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
        $vehicleTypes = VehicleType::all();

        return response()->json($vehicleTypes);
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
                'name' => 'unique:vehicle_types',

            ]);

            $vehicleSave = VehicleType::create($request->all());


            return response()->json([
                'code' => 200,
                'message' => "Vehicle type data has saved",
                'vehicleType' => $vehicleSave
            ]);
        } catch (\Throwable $error) {
            return response()->json($error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleType $vehicleType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleType $vehicleType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleType $vehicleType)
    {
        try {
            $request->validate([
                'name' => 'unique:vehicle_types,name,' . $vehicleType->id,

            ]);

            $vehicleType->update($request->all());


            return response()->json([
                'code' => 200,
                'message' => "Vehicle type data has updated",
                'vehicleType' => $vehicleType
            ]);
        } catch (\Throwable $error) {
            return response()->json($error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleType $vehicleType)
    {
        $vehicleType->delete();
        return response()->json([
            'code' => 200,
            'message' => "Vehicle type data has deleted",
            'vehicleType' => $vehicleType
        ]);
    }
}
