@extends('user_temp')

@section('title', 'Print Reciet')

@section('content')


<div class="page-wrapper">
    <div class="page-content-tab">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-10 mt-4">
                    <div id="Receipt" class="well">
                        <div class="row">
                            @if($order->user->id ==11 || $order->user->id ==12)
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <address>
                                    <strong style="margin-right: 78px;">Hwa</strong>
                                    <br>
                                    
                                 (العنوان:أميال) <br>
                                 المنطقة الصناعية الاولى - السادات - المنوفية
                                    <br>
                                 رقم الموبايل : ٠١٠٠٠٣٠١٤٧٩ - ٠١٠١١٦٤٥٧٠٠ - ٠٤٨٢٦٥٦٨٧٦
                                </address>
                            </div>
                            @endif
                            @if($order->user->id ==8 || $order->user->id ==9 || $order->user->id ==10)
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <address>
                                    <strong style="margin-right: 78px;">Hwa</strong>
                                    <br>
                                    
                                 العنوان: المحمدية ( الفرع الرئيسي) <br>
                                 ش. مجدي حسنين- مركز بدر- البحيرة
                                    <br>
                                 رقم الموبايل : ٠١٠٠٨٥٥٢٦٠٤ - ٠١٠٠٨٥٥٢٦٠٢ - ٠٤٥٣٦٢٦٧٠١
                                </address>
                            </div>
                            @endif
                            @if($order->user->id ==13)
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <address>
                                    <strong style="margin-right: 78px;">Hwa</strong>
                                    <br>
                                    
                                 العنوان: المحمدية ( فرع السادات) <br>
                                 منطقة المخازن - المنطقة الصناعية الثانية - السادات - المنوفية
                                    <br>
                                 رقم الموبايل : ٠١٢٨١٤٤٧٣١٣ - ٠١١٠٣٨٨٨١٥٧ - ٠١٠٩٨١٣٠٤٩٨
                                </address>
                            </div>
                            @endif
                            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                <p>
                                    <em>التاريخ: <?php echo date('Y/m/d H:i:s', strtotime($order->created_at)); ?></em>
                                </p>
                                <p>
                                    <em>اسم المستخدم: {{$order->user->name}}</em>
                                </p>
                                <p>
                                    <em class="text-success">رقم الفاتورة : <?php echo $order->id; ?></em>
                                </p>
                                
                               
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                     <p >
                                    <em>العميل: </em><input type="text">
                                </p>
                                <p >
                                    <em> رقم التليفون:</em><input type="text">
                                </p>
                                </div>
                        </div>
                        <div class="row">
                            <div class="text-center">
                                <h2>فاتورة </h2>
                            </div>
                        
                            </span>
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>العملية</th>
                                        <th>الوزن</th>
                                        <th>الكمية</th>
                                        <th class="text-center">السعر</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($order->orderdetailes as $detailes)
                                    <tr>
                                    <td>
                                        <h5 class="mt-0 mb-1 font-14">{{$detailes->opreationname}}</h5>
                                    </td>
                                    <td>
                                        <h5 class="mt-0 mb-1 font-14">{{$detailes->weight}} كجم</h5>
                                    </td>
                                        <td class="form-control w-25" style="text-align: center"> {{$detailes->operationdetailes->quantity}}</td>
                                        <td >EGP {{$detailes->price}}</td>
                                    </tr>
                                    @endforeach
                
                                    <tr>
                                        <td>   </td>
                                        <td>   </td>
                                        <td class="text-right">
                                            <h4><strong>المجموع الكلي : </strong></h4>
                                        </td>
                                        <td class="text-center text-danger">
                                            <h4><strong>{{$totalprcie}}</strong></h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-10 mt-4">
                    <div class="well">
                        <button id="print" onclick="printContent('Receipt');" class="btn btn-success btn-lg text-justify btn-block">
                            Print <span class="fas fa-print"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://hwa-eg.com/HwaProgram/public/assets/js/jquery.min.js"></script>
        <script>
            function printContent(el) {
                 var restorepage = $('body').html();
                var printcontent = $('#' + el).clone();
                $('body').empty().html(printcontent);
                window.print();
                $('body').html(restorepage);
            }
        </script>





@endsection
