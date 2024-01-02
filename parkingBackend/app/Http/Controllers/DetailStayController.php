<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\ReportExport;
use App\Models\Catalogs\Vehicle;
use Illuminate\Support\Facades\DB;
use App\Models\Catalogs\VehicleType;
use Maatwebsite\Excel\Excel as EXLSX;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Transactions\PayRecord;
use App\Models\Transactions\DetailStay;
use Illuminate\Support\Facades\Storage;



class DetailStayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function checkInRegister(Request $request)
    {
        try {

            $request->validate([

                'license_plate'  => 'required',
                'check_in_time' => 'required'

            ]);

            $searchPreviousInWithoutOut = DetailStay::select('check_out_time')
                ->where('license_plate', $request->license_plate)
                ->whereNull('check_out_time')
                ->get();



            if ($searchPreviousInWithoutOut->count() > 0) {
                $data = [
                    'code'          => 200,
                    'message'       => 'Can\'t create new register couse, not register check-out time',
                    'detailStay'    => $searchPreviousInWithoutOut
                ];
            }

            if ($searchPreviousInWithoutOut->count() < 1) {

                $getVehicleId = Vehicle::select('id')->where('license_plate', $request->license_plate)->get();

                $saveDetail = new DetailStay();
                $saveDetail->vehicle_id = ($getVehicleId->count() > 0) ? $getVehicleId[0]->id : null;
                $saveDetail->license_plate = $request->license_plate;
                $saveDetail->check_in_time = $request->check_in_time;
                $saveDetail->save();

                $data = [
                    'code'          => 200,
                    'message'       => 'Vehicle register check-in time',
                    'detailStay'    => $searchPreviousInWithoutOut
                ];
            }

            return response()->json($data);
        } catch (\Throwable $error) {
            return response()->json($error->getMessage());
        }
    }


    public function checkOutRegister(Request $request)
    {

        try {
            $request->validate([

                'license_plate'  => 'required',
                'check_out_time' => 'required'

            ]);

            $searchCheckIn = DetailStay::where('license_plate', $request->license_plate)
                ->whereNull('check_out_time')
                ->first();

            $timeIn = Carbon::createFromFormat("H:i:s", $searchCheckIn->check_in_time);
            $timeOut = Carbon::createFromFormat("H:i:s", $request->check_out_time);

            $totalTime = $timeIn->diffInMinutes($timeOut);

            $getVehicleSelect = Vehicle::select('vehicles.id', 'vehicle_types.fee', 'vehicles.vehicle_type_id')
                ->join('vehicle_types', 'vehicle_types.id', 'vehicles.vehicle_type_id')
                ->where('vehicles.license_plate', $request->license_plate)
                ->get();


            if ($getVehicleSelect->count() > 0) {
                $getFeeValue = VehicleType::select('fee', 'recurrent', 'name')
                    ->where('id', $getVehicleSelect[0]->vehicle_type_id)
                    ->get();
                $paymentAmount = $totalTime * $getVehicleSelect[0]->fee;
            }


            if ($getVehicleSelect->count() < 1) {
                $getFeeValue = VehicleType::select('fee', 'recurrent', 'name')->where('recurrent', 0)->get();

                $paymentAmount = $totalTime * $getFeeValue[0]->fee;
            }


            // Update Detail
            $searchCheckIn->check_out_time       = $request->check_out_time;
            $searchCheckIn->payment_amount       = $paymentAmount;
            $searchCheckIn->total_stay_minutes   = $totalTime;
            $searchCheckIn->save();

            // Pay Recod Register
            if ($getFeeValue[0]->name === "standar") {
                PayRecord::create([
                    'vehicle_id'            => null,
                    'license_plate'         => $request->license_plate,
                    'total_stay_minutes'    => $totalTime,
                    'total_stay_payment'    => $paymentAmount,
                    'date_time_payment'     => date('Y-m-d H:i:s'),
                    'period_start'          => date('Y-m-d H:i:s'),
                    'period_end'            => date('Y-m-d H:i:s')

                ]);
            }

            $data = [
                'code'             => 200,
                'vehicle_type'     => $getFeeValue[0]->name,
                'payment_register' => $paymentAmount,
                'pay_now'          => ($getFeeValue[0]->name === "standar") ? $paymentAmount : "0.00"

            ];



            return response()->json($data);
        } catch (\Throwable $error) {
            return response()->json($error->getMessage());
        }
    }


    public function residentReport(Request $request)
    {

        try {

            $request->validate([
                'fileName' => 'required'
            ]);

            $registeReport = DetailStay::select(
                'detail_stays.vehicle_id',
                'detail_stays.license_plate',
                DB::raw("SUM(detail_stays.total_stay_minutes) as total_minutes"),
                DB::raw("SUM(detail_stays.payment_amount) as total_amount")
            )
                ->join('vehicles', 'vehicles.id', 'detail_stays.vehicle_id')
                ->join('vehicle_types', 'vehicle_types.id', 'vehicles.vehicle_type_id')
                ->where('vehicles.vehicle_type_id', 2)
                ->groupBy(['detail_stays.license_plate', 'detail_stays.vehicle_id'])
                ->get();

            $matrixReport = [['Núm. Placa', 'Tiempo Estacionado (min.)', 'Cantidad a pagar']];

            foreach ($registeReport as $register) {
                $matrixReport[] = [
                    Str::upper($register->license_plate),
                    $register->total_minutes,
                    $register->total_amount,

                ];
            }

            $extension = '.xlsx';
            $fileName = $request->fileName . '_';
            $export = new ReportExport($matrixReport);
            $excelFile = 'public/temp/' . $fileName . uniqid() . $extension;
            Excel::store($export, $excelFile, 'public',  EXLSX::XLSX);

            $base64Content = base64_encode($excelFile);

            //Storage::delete($excelFile);


            return response()->json(['fileDownloadReport' => $base64Content]);
        } catch (\Throwable $error) {

            return response()->json($error->getMessage());
        }
    }

    public function startMonth()
    {
        try {

            //Delete oficial and resident start month
            $deleteData = DetailStay::whereNotNull('vehicle_id')->get();
            $deleteData->delete();

            $data = [
                'code' => 200,
                'message' => 'Restart Month to resident and official customers'
            ];
            return response()->json();
        } catch (\Throwable $error) {
            return response()->json($error->getMessage());
        }
    }
}
