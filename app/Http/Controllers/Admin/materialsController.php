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
        $materials_normal = $materials->where('category', 'normal');
        $materials_standard = $materials->where('category', 'standard');
        if ($materials_normal->count() === 0 && $materials_standard->count() === 0) {
            // Fallback split by ID ranges when category is not populated yet
            $materials_normal = $materials->filter(function ($m) {
                return ($m->id >= 1 && $m->id <= 35) || ($m->id >= 92 && $m->id <= 122);
            });
            $materials_standard = $materials->filter(function ($m) {
                return ($m->id >= 36 && $m->id <= 91);
            });
        }
        $materials_type = materials::select('name')->groupBy('name')->get();
        $materials_size = materials::select('size')->groupBy('size')->get();
        $order = null;

        return view('Admin.materials.index', compact('materials', 'materials_normal', 'materials_standard', 'materials_type', 'materials_size', 'order'));
    }

    public function normalMaterials() {
        $materials_normal = materials::where('category', 'normal')->orderBy('id', 'asc')->paginate(20);
        if ($materials_normal->isEmpty()) {
            $materials_normal = materials::whereBetween('id', [1, 35])->orWhereBetween('id', [92, 122])->orderBy('id', 'asc')->paginate(20);
        }

        $materials_type = materials::select('name')->where('category', 'normal')->groupBy('name')->get();
        $materials_size = materials::select('size')->where('category', 'normal')->groupBy('size')->get();
        $order = null;

        return view('Admin.materials.normal', compact('materials_normal', 'materials_type', 'materials_size', 'order'));
    }

    public function standardMaterials() {
        $materials_standard = materials::where('category', 'standard')->orderBy('id', 'asc')->paginate(20);
        if ($materials_standard->isEmpty()) {
            $materials_standard = materials::whereBetween('id', [36, 91])->orderBy('id', 'asc')->paginate(20);
        }

        $materials_type = materials::select('name')->where('category', 'standard')->groupBy('name')->get();
        $materials_size = materials::select('size')->where('category', 'standard')->groupBy('size')->get();
        $order = null;

        return view('Admin.materials.standard', compact('materials_standard', 'materials_type', 'materials_size', 'order'));
    }

    public function getSize() {
        $materials_size = materials::select('size')->groupBy('size')->get();
    }

    public function createForm() {
        return view('file-upload');
    }

    public function fileUpload(Request $req) {
        $req->validate([
            'file' => 'nullable|mimes:xlsx,xls,csv|max:4048',
            'files.*' => 'nullable|mimes:xlsx,xls,csv|max:4048'
        ]);

        // Determine category based on route
        $category = null;
        if (request()->routeIs('materials.normal.upload')) {
            $category = 'normal';
        } elseif (request()->routeIs('materials.standard.upload')) {
            $category = 'standard';
        }

        if ($req->file() || $req->hasFile('files')) {
            try {
                // Clear only materials of the specific category
                if ($category) {
                    materials::where('category', $category)->delete();
                } else {
                    materials::truncate(); // Fallback for general upload
                }

                $filesToProcess = [];
                if ($req->hasFile('files')) {
                    $filesToProcess = $req->file('files');
                } elseif ($req->file('file')) {
                    $filesToProcess = [$req->file('file')];
                }

                foreach ($filesToProcess as $file) {
                    $extension = $file->getClientOriginalExtension();
                    \Log::info('Processing file: ' . $file->getClientOriginalName() . ', Extension: ' . $extension);

                    if ($extension === 'csv') {
                        $path = $file->getRealPath();
                        $originalName = strtolower($file->getClientOriginalName());
                        $inferredCategory = null;
                        if (strpos($originalName, 'normal') !== false) {
                            $inferredCategory = 'normal';
                        } elseif (strpos($originalName, 'standard') !== false) {
                            $inferredCategory = 'standard';
                        }

                        $handle = fopen($path, 'r');
                        if ($handle === false) {
                            \Log::error('Could not open CSV file: ' . $path);
                            continue;
                        }

                        \Log::info('CSV file opened successfully');

                        // Detect delimiter from first line
                        $firstLine = fgets($handle);
                        $delimiter = ',';
                        if ($firstLine !== false) {
                            if (substr_count($firstLine, ';') > substr_count($firstLine, ',')) {
                                $delimiter = ';';
                            } elseif (substr_count($firstLine, "\t") > max(substr_count($firstLine, ','), substr_count($firstLine, ';'))) {
                                $delimiter = "\t";
                            }
                        }
                        \Log::info('Detected delimiter: ' . ($delimiter === "\t" ? 'TAB' : $delimiter) . ', First line: ' . substr($firstLine, 0, 100));
                        // Rewind and parse
                        rewind($handle);

                        $rowIndex = 0;
                        $createdCount = 0;
                        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                            $rowIndex++;
                            \Log::info('Processing row ' . $rowIndex . ': ' . json_encode($row));
                            if ($rowIndex === 1) {
                                // Assume header exists; skip first row
                                \Log::info('Skipping header row');
                                continue;
                            }
                            if (count($row) === 1 && trim($row[0]) === '') {
                                continue; // skip empty lines
                            }

                            // Remove UTF-8 BOM from first cell if present
                            if (isset($row[0])) {
                                $row[0] = preg_replace('/^\xEF\xBB\xBF/', '', $row[0]);
                            }

                            // Handle CSV format based on category (without ID column)
                            if ($category === 'standard') {
                                // For standard materials: name,wholesale_price,retail_price (no ID, no size column)
                                $name = $row[0] ?? null;
                                $size = 'ثابت'; // Fixed size for standard materials
                                $wholesale = isset($row[1]) && $row[1] !== '' ? (float)str_replace([','], [''], $row[1]) : null;
                                $retail = isset($row[2]) && $row[2] !== '' ? (float)str_replace([','], [''], $row[2]) : null;
                            } else {
                                // For normal materials: name,size,wholesale_price,retail_price,category (no ID)
                                $name = $row[0] ?? null;
                                $size = $row[1] ?? null;
                                $wholesale = isset($row[2]) && $row[2] !== '' ? (float)str_replace([','], [''], $row[2]) : null;
                                $retail = isset($row[3]) && $row[3] !== '' ? (float)str_replace([','], [''], $row[3]) : null;
                            }

                            // Parse thickness range from size text
                            $thicknessRange = $this->parseThicknessRange($size);

                              // Use category from route/filename inference (no category column in CSV)
                              $csvCategory = $category ?: $inferredCategory;

                            if ($name === null && $size === null) {
                                \Log::info('Skipping row - empty name and size');
                                continue;
                            }

                            if ($category === 'standard') {
                                // For standard materials, create single entry without thickness parsing
                                try {
                                    materials::create([
                                        'name' => $name,
                                        'size' => $size,
                                        'min_thickness' => null,
                                        'max_thickness' => null,
                                        'category' => $csvCategory,
                                        'wholesale_price' => $wholesale,
                                        'retail_price' => $retail,
                                        'updated_by' => 'Admin Upload',
                                    ]);
                                    $createdCount++;
                                    \Log::info('Created standard material: ' . $name);
                                } catch (\Exception $e) {
                                    \Log::error('Failed to create standard material: ' . $e->getMessage());
                                }
                            } else {
                                // For normal materials, parse thickness range
                                if (empty($thicknessRange)) {
                                    \Log::warning('No thickness range found for: ' . $size);
                                    continue;
                                }

                                \Log::info('Creating materials for range: ' . $size . ' -> ' . implode(', ', $thicknessRange));

                                // Create a material record for each thickness in the range
                                foreach ($thicknessRange as $thickness) {
                                    try {
                                        materials::create([
                                            'name' => $name,
                                            'size' => $thickness . 'مم', // Store individual thickness
                                            'min_thickness' => $thickness,
                                            'max_thickness' => $thickness,
                                            'category' => $csvCategory,
                                            'wholesale_price' => $wholesale,
                                            'retail_price' => $retail,
                                            'updated_by' => 'Admin Upload',
                                        ]);
                                        $createdCount++;
                                    } catch (\Exception $e) {
                                        \Log::error('Failed to create material for thickness ' . $thickness . ': ' . $e->getMessage());
                                    }
                                }
                            }

                            if ($category === 'standard') {
                                \Log::info('Successfully created standard material: ' . $name);
                            } else {
                                \Log::info('Successfully created ' . count($thicknessRange) . ' materials for range: ' . $size);
                            }
                        }
                        fclose($handle);

                        \Log::info('CSV import completed. Created ' . $createdCount . ' rows for file: ' . $file->getClientOriginalName() . ', Category: ' . $inferredCategory);
                        Session::flash('success', 'تم استيراد ' . $createdCount . ' صف من الملف: ' . $file->getClientOriginalName());
                    } else {
                        // Excel file may contain multiple sheets (normal/standard)
                        Excel::import(new SteelPricesImport, $file);
                    }
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

    private function parseThicknessRange($sizeText) {
        // Remove common Arabic text and extract numbers
        $text = preg_replace('/[سمك\s]/u', '', $sizeText);
        $text = preg_replace('/مم/u', '', $text);

        // Extract all numbers
        preg_match_all('/\d+\.?\d*/', $text, $matches);
        $numbers = array_map('floatval', $matches[0]);

        if (empty($numbers)) {
            return [];
        }

        $min = min($numbers);
        $max = max($numbers);

        // Generate range with 0.1 step increments
        $range = [];
        $current = $min;

        while ($current <= $max) {
            $range[] = round($current, 1); // Round to 1 decimal place
            $current += 0.1;
        }

        // Ensure max value is included
        if (!in_array($max, $range)) {
            $range[] = $max;
        }

        // Sort and remove duplicates
        $range = array_unique($range);
        sort($range);

        return $range;
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
