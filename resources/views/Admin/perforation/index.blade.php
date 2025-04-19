@extends('admin_temp')
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
                                <li class="breadcrumb-item active">سعر التخريم</li>
                            </ol>
                        </div>
                        <h4 class="page-title">سعر التخريم</h4>
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
                                <h4 class="card-title">سعر التخريم</h4>
                                <button class="btn p-0">
                                    <i class="ti ti-pencil"></i>
                                </button>
                            </div>
                            <form action="{{route('perforation.updatePrice')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="mb-3 row">
                                            <label for="example-number-input"
                                                   class="col-sm-4 col-form-label text-end">اختيار السمك</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select  class="form-select" onchange="getDiameter();getPrice();"  id="thickness" name="size">
                                                    
                                             
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="mb-3 row">
                                            <label for="example-number-input"
                                                   class="col-sm-4 col-form-label text-end">اختيار قطر البنطة</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select class="form-select" id="diameter" onchange="getPrice();"  name="diameter">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="mb-3 row">
                                            <label for="example-number-input"
                                                   class="col-sm-4 col-form-label text-end"> السعر</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <input class="form-control" id="price" name="price">
                                                    
                                                </input>
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
                    </div>
                </div>
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

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">عملية البيع</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="mb-3 row">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td><label for="example-number-input"
                                               class="col-12 col-form-label d-flex">المبلغ المستحق
                                            :</label></td>
                                    <td>
                                        <!-- <p class="mb-0">2300 جنيه</p> -->
                                        <input class="form-control" type="text" placeholder="2300 جنيه" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="example-number-input"
                                               class="col-12 col-form-label d-flex">المبلغ المدفوع
                                            :</label></td>
                                    <td>
                                        <!-- <p class="mb-0">2400 جنيه</p> -->
                                        <input class="form-control bg-transparent" type="text"
                                               placeholder="2400 جنيه">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="example-number-input"
                                               class="col-12 col-form-label d-flex">الباقي:</label>
                                    </td>
                                    <td>
                                        <!-- <p class="mb-0">100 جنيه</p> -->
                                        <input class="form-control" type="text" placeholder="100 جنيه" disabled>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="executeExample('successPayment')">
                    <i class="mdi mdi-gesture-double-tap me-1"></i> تأكيد</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> <i
                        class="mdi mdi-cancel me-1"></i> إلغاء</button>

                <div class="btn-group ms-auto">
                    <a type="submit" class="btn btn-info" href="apps-invoice.html"> <i
                            class="mdi mdi-printer me-1"></i> طباعة
                        الإيصال</a>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
@section('scripts')

<script src="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/pages/sweet-alert.init.js')}}"></script>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/weight.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    getThickness();
    getDiameter() ;
    getPrice();
         function getThickness() {
             debugger;
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
            
            };
            $.ajax({
               type:'POST',
               url:'/HwaProgram/public/getThickness',
               data:formData,
               success:function(data) {
                debugger;
                jQuery('#thickness').append('<option value="select">select</select>');
                   var value=data;
                   for (var i=0;i<value.length;i++) {
                        var option='<option  value="'+value[i].value+'">' +value[i].name+'</option>';
                        jQuery('#thickness').append(option);
                    }
                   
                 // $("#thickness").html(data.msg);
               }
            });
         }
         function getDiameter() {
             debugger;
             var x = document.getElementById("diameter");  
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
            size: jQuery('#thickness').val()
            };
            $.ajax({
               type:'POST',
               url:'/HwaProgram/public/getDiameter',
               data:formData,
               success:function(data) {
                jQuery('#diameter').append('<option value="select">select</select>');
                   var value=data;
                   for (var i=0;i<value.length;i++) {
                        var option='<option  value="'+value[i].diameter+'">' +value[i].diameter+'</option>';
                        jQuery('#diameter').append(option);
                    }
                   
                 // $("#thickness").html(data.msg);
               }
            });
         }
         function getPrice() {
             debugger;
             var x = document.getElementById("price");  
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
            size: jQuery('#thickness').val(),
            diameter: jQuery('#diameter').val()

            };
            $.ajax({
               type:'POST',
               url:'/HwaProgram/public/getPrice',
               data:formData,
               success:function(data) {
                jQuery('#price').val("");
                   var value=data;
                   for (var i=0;i<value.length;i++) {
                        var option=value[i].price;
                        jQuery('#price').val(option);
                    }
                   
                 // $("#thickness").html(data.msg);
               }
            });
         }
      </script>
@endsection
