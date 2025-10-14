@extends('user_temp')
@section('content')

<div class="page-wrapper">
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Page Content-->
    <div class="page-content-tab">

        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="float-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                                <li class="breadcrumb-item active">خامات عادية</li>
                            </ol>
                        </div>
                        <h4 class="page-title">خامات عادية</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">اضافة فاتورة - خامات الحديد العادية</h4>
                        </div>
                        <!--end card-header-->
                        <form action="{{route('materials.order')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="mb-3 row">
                                            <label for="example-number-input"
                                                   class="col-sm-4 col-form-label text-end">اختيار الصنف</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select  class="form-select" onchange="getMessage();" id="item" name="item">
                                                    <option  value="null"> اختر الصنف</option>
                                                    @if ($materials_type)
                                                    @foreach ( $materials_type as $type)

                                                    <option  value="{{$type->name}}"> {{$type->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="mb-3 row">
                                            <label for="example-number-input"
                                                   class="col-sm-4 col-form-label text-end">اختيار السمك</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select class="form-select" id="thickness" name="size">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="mb-3 row">
                                            <label for="example-number-input"
                                                   class="col-sm-4 col-form-label text-end">اختيار السعر</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select class="form-select" name="priceType">
                                                    <option value="0">تجاري</option>
                                                    <option value="1">قطاعي</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                            class="col-sm-4 col-form-label text-end">طول
                                            اللوح بالسنتي:</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="length" id="length" type="text" placeholder="مثال : 1234"
                                                id="length">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                            class="col-sm-4 col-form-label text-end">عرض اللوح بالسنتي:</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="width" id="width" type="text" placeholder="مثال : 1234"
                                                id="example-number-input">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                            class="col-sm-4 col-form-label text-end">العدد
                                            الكلي :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="quantity"  type="number" placeholder="مثال : 1234"
                                                id="quantity">
                                            <p class="mb-0 fw-semibold d-none">120 مم</p>
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="mb-3 row">
                                            <label for="example-number-input"
                                                   class="col-sm-4 col-form-label text-end"> الوزن</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <input class="form-control" type="text" placeholder="1234" id="weight" name="weight">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <div class="btn-group ms-auto">
                                            <button type="submit" class="btn btn-primary" onclick="showCol();"> <i
                                                    class="mdi mdi-gesture-double-tap me-1"></i> تأكيد</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                @if ($order)
                @foreach ( $order->orderdetailes as $detailes)
                <div class="col-lg-12 " id="orderDetailsCol">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">تفاصيل الطلب</h4>

                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                               class="col-sm-4 col-form-label text-end">اسم الخامة
                                             :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="weghit" type="text"
                                                   placeholder="مثال : 1234" id="example-number-input" value="{{$detailes->material_name}}   " disabled>
                                            {{-- <p class="mb-0 fw-semibold">120 مم</p> --}}
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-6 col-lg-4">

                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                               class="col-sm-4 col-form-label text-end">الوزن
                                             :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="weghit" type="text"
                                                   placeholder="مثال : 1234" id="example-number-input" value="{{$detailes->operationdetailes->weight}} كيلو  " disabled>
                                            {{-- <p class="mb-0 fw-semibold">120 مم</p> --}}
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-6 col-lg-4">


                                    <div class="mb-3 row">
                                        <label for="example-number-input"
                                               class="col-sm-4 col-form-label text-end">السمك
                                             :</label>
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <input class="form-control" name="thickness" type="text"
                                                   placeholder="مثال : 1234" id="example-number-input" value="{{$detailes->operationdetailes->thickness}} مم  " disabled>
                                            {{-- <p class="mb-0 fw-semibold">120 مم</p> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    </div>
                                    <div class="mb-3 row">
                                        <table>
                                            <tbody class="table table-primary">
                                                <tr>
                                                    <td><label for="example-number-input"
                                                               class="col-12 col-form-label d-flex">المبلغ
                                                            المستحق:</label>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">{{$detailes->price}} جنيه</p>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>


                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->

                @endforeach
                @endif
            </div>
            <!--end row-->

        </div><!-- container -->



        <!--Start Footer-->
        <!-- Footer Start -->
        <footer class="footer text-center text-sm-start">
            &copy;
            <script>
                document.write(new Date().getFullYear())
            </script> JCloud Co
        </footer>
        <!-- end Footer -->
        <!--end footer-->
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->

@endsection
@section('scripts')
<script>
         function getMessage() {
            //  debugger;
             var x = document.getElementById("thickness");
             var count=x.length;
             while (x.length > 0) {
                    x.remove(0);
            }

             $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
             var formData = {
            name: jQuery('#item').val()
            };
            $.ajax({
               type:'POST',
               url:'/HwaProgram/public/getSize',
               data:formData,
               success:function(data) {
                   var value=data;
                   for (var i=0;i<value.length;i++) {
                        var option='<option  value="'+value[i].size+'">' +value[i].size+'</option>';
                        jQuery('#thickness').append(option);
                    }

                 // $("#thickness").html(data.msg);
               }
            });
         }
      </script>
<script src="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/pages/sweet-alert.init.js')}}"></script>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/weight.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

@endsection
