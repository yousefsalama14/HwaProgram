<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Orderdetailes;
use App\Models\Operation;
use App\Models\Operationdetailes;
use App\Models\materials;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Auth;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SteelPricesImport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class materialsController extends Controller {

    //
    function weight($thickness, $length, $width, $qty) {
        $weight = (7.85 / 10000) * ($thickness * $length * $width);
        return $weight * $qty;
    }

    public function index() {
        $materials = materials::orderBy('id', 'asc')->get();
        $materials_type = materials::select('name')->groupBy('name')->get();
        $materials_size = materials::select('size')->groupBy('size')->get();
        $order = null;

        return view('Admin.materials.index', compact('materials', 'materials_type', 'materials_size', 'order'));
    }

    public function getSize() {
        $materials_size = materials::select('size')->groupBy('size')->get();
    }

    public function createForm() {
        return view('file-upload');
    }

    public function fileUpload(Request $req) {
        $req->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:4048'
        ]);

        if ($req->file()) {
            try {
                // Clear existing data
                materials::truncate();

                $file = $req->file('file');
                $extension = $file->getClientOriginalExtension();

                if ($extension === 'csv') {
                    // Handle CSV file
                    $path = $file->getRealPath();
                    $data = array_map('str_getcsv', file($path));

                    // Remove header row
                    $headers = array_shift($data);

                    foreach ($data as $row) {
                        materials::create([
                            'name' => $row[0],
                            'size' => $row[1],
                            'wholesale_price' => $row[2],
                            'retail_price' => $row[3]
                        ]);
                    }
                } else {
                    // Handle Excel files (xlsx, xls)
                    Excel::import(new SteelPricesImport, $file);
                }

                return back()
                    ->with('success', 'تم رفع ملف أسعار الخامات بنجاح');
            } catch (\Exception $e) {
                return back()
                    ->with('error', 'حدث خطأ أثناء معالجة الملف: ' . $e->getMessage());
            }
        }
    }

    public function formatSize($size) {
        $newSize = str_replace('مم', '', $size);
        $newSize = str_replace('سمك', '', $newSize);
        return $newSize;
    }

    function csvToArray($filename = '', $delimiter = ',') {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function materialsorder(Request $request) {
        $validated = $request->validate([
            'item' => 'required',
            'size' => 'required',
            'priceType' => 'required',
            'weight' => 'required',
        ]);
// if($request->thickness>12){
//   return redirect()->back();
// }

        $price = materials::where('name', $request->item)->where('size', $request->size)->get();
        $material_id = $price[0]->id;
        if ($request->priceType == '0') {
            $price = $price[0]->cost_price;
        } else {
            $price = $price[0]->sale_price;
        }
        error_log($price . "");
//     $weight=$this->weight($request->thickness,$request->length,$request->width,$request->quantity);
        $order = Order::with('orderdetailes')->where('user_id', Auth::user()->id)->where('status', '=', 'unpaid')->first();
        if ($order != null) {
            $order->update([
                'quantity' => $order->quantity + 1,
            ]);
        }
        if ($order == null) {
            $order = Order::create([
                        'status' => 'unpaid',
                        'user_id' => Auth::user()->id,
                        'quantity' => 1,
            ]);
        }
        Session::put('orderqnty', $order->quantity);
        $Operationdetailes = Operationdetailes::create([
                    'operation_id' => 5,
                    //'thickness'=>$request->size,
                    'weight' => $request->weight,
                    'quantity' => 1,
        ]);
        $Orderdetailes = Orderdetailes::create([
                    'order_id' => $order->id,
                    'operation_id' => 5,
                    'quantity' => 1,
                    'operationdetailes_id' => $Operationdetailes->id,
                    'price' => $price,
                    'weight' => $request->weight,
                    'opreationname' => 'خامات',
                    'material_id' => $material_id
        ]);
        return redirect()->back();
    }

    public function deleteOrderDetailes($id) {
        $Orderdetailes = Orderdetailes::with('operationdetailes')->find($id);
        $Operationdetailes = Operationdetailes::find($Orderdetailes->operationdetailes_id)->delete();
        $order = Order::find($Orderdetailes->order_id);
        $order->update([
            'quantity' => $order->quantity - 1,
        ]);
        Session::put('orderqnty', $order->quantity);
        return redirect()->back();
    }

    public function downloadSample()
    {
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="materials_sample.xlsx"'
        ];

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add headers
        $sheet->setCellValue('A1', 'name');
        $sheet->setCellValue('B1', 'size');
        $sheet->setCellValue('C1', 'wholesale_price');
        $sheet->setCellValue('D1', 'retail_price');

        // Add a sample row
        $sheet->setCellValue('A2', 'حديد مسطح');
        $sheet->setCellValue('B2', '10×100');
        $sheet->setCellValue('C2', '1000');
        $sheet->setCellValue('D2', '1200');

        // Create the Excel file
        $writer = new Xlsx($spreadsheet);

        // Save to a temporary file
        $temp_file = tempnam(sys_get_temp_dir(), 'materials_sample');
        $writer->save($temp_file);

        return response()->download($temp_file, 'materials_sample.xlsx', $headers)->deleteFileAfter();
    }

    public function downloadSampleCSV()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="materials_sample.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for proper Arabic display in Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Add headers
            fputcsv($file, ['name', 'size', 'wholesale_price', 'retail_price']);

            // Add sample data
            fputcsv($file, ['حديد مسطح', '10×100', '1000', '1200']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
