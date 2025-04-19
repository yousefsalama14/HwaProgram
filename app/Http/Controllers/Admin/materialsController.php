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

class materialsController extends Controller {

    //
    function weight($thickness, $length, $width, $qty) {
        $weight = (7.85 / 10000) * ($thickness * $length * $width);
        return $weight * $qty;
    }

    public function index() {
        $materials_type = materials::select('name')->groupBy('name')->get();
        $materials_size = materials::select('size')->groupBy('size')->get();
        $order = null;
        error_log($order);
        return view('Admin.materials.index', compact('materials_type', 'materials_size', 'order'));
    }

    public function getSize() {
        $materials_size = materials::select('size')->groupBy('size')->get();
    }

    public function createForm() {
        return view('file-upload');
    }

    public function fileUpload(Request $req) {
        $req->validate([
            'file' => 'required|mimes:csv|max:4048'
        ]);

//        $fileModel = new File;
        if ($req->file()) {
            $fileName = $req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');
            $path = Storage::disk('public')->path($filePath);

            if (($open = fopen($path, "r")) !== FALSE) {

                while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                    $users[] = $data;
                }

                // error_log($users[0]);
                fclose($open);
            }
            materials::truncate();
            $materialsArr = $this->csvToArray($path);
            $index = 0;
            foreach ($materialsArr as $obj) {
                $object = $this->formatSize($obj['size']);
                if (str_contains($object, ':')) {
                    $start = strtok($object, ':');
                    $end = str_replace($start . ':', '', $object);
                    
                    $start=floatval($start);
                    $end=floatval($end);
                    while ($start <= $end) {
                        
                        materials::Create([
                            'id' => (int) ($obj['id']) + $index,
                            'name' => $obj['name'],
                            'size' => floatval($start) ,
                            'wholesale_price' => $obj['wholesale_price'],
                            'retail_price' => $obj['retail_price'],
                        ]);
                        if($start<$end){
                            $index++;
                            
                        }
                        $start = $start + 0.10;
                        
                    }
                    if(floatval($end)==20.00){
                            // 
                            materials::Create([
                            'id' => (int) ($obj['id']) + $index,
                            'name' => $obj['name'],
                            'size' => floatval($end) ,
                            'wholesale_price' => $obj['wholesale_price'],
                            'retail_price' => $obj['retail_price'],
                        ]);
                       // $index++;
                        }
                        if(floatval($end)==30.00){
                            // 
                            materials::Create([
                            'id' => (int) ($obj['id']) + $index,
                            'name' => $obj['name'],
                            'size' => floatval($end) ,
                            'wholesale_price' => $obj['wholesale_price'],
                            'retail_price' => $obj['retail_price'],
                        ]);
                       // $index++;
                        }
                } else {
                    error_log($index);
                    materials::Create([
                            'id' => (int)($obj['id']) + $index,
                            'name' => $obj['name'],
                            'size' => $object ,
                            'wholesale_price' => $obj['wholesale_price'],
                            'retail_price' => $obj['retail_price'],
                        ]);
                        $index++;
                }
                error_log($index);
            }
            // error_log(array_get($materialsArr[0], 'id'));
            return back()
                            ->with('success', 'تم رفع الملف بنجاح')
                            ->with('file', $materialsArr);
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

}
