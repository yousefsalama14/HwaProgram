@extends('admin_temp')
@section('content')

<div class="page-wrapper">

    <!-- Page Content-->
    <div class="page-content-tab">

        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="float-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('Admin.dashboard')}}">الرئيسية</a></li>
                                <li class="breadcrumb-item active">سعر الخامات</li>
                            </ol>
                        </div>
                        <h4 class="page-title">سعر الخامات</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">
                <form class="border-top pt-3 mb-3" action="{{route('fileUpload')}}" method="post" enctype="multipart/form-data">
                    <h3 class="text-center mb-3 mt-0">رفع عرض الاسعار</h3>
                    @csrf
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <strong>{{ $message }}</strong>

                    </div>
                    @endif
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="alert alert-info">
                        <strong>ملاحظة:</strong> يمكن رفع ملف Excel واحد يحتوي ورقتين (normal, standard) أو رفع ملفين منفصلين.
                    </div>
                    <div class="custom-file mb-2">
                        <input type="file" name="file" class="custom-file-input border p-3" id="chooseFile">
                    </div>
                    <div class="custom-file">
                        <input type="file" name="files[]" multiple class="custom-file-input border p-3" id="chooseFiles">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                        رفع الملف
                    </button>
                </form>
                <div class="card"></div>
                    <div class="card-header">
                        <h4 class="card-title">قائمة اسعار خامات الحديد العاديه</h4>
                    </div>
                    <div class="card-body" style="height: 300px;overflow: auto;">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>نوع الخامة</th>
                                        <th>المقاس</th>
                                        <th>سعر الجملة</th>
                                        <th>سعر التجزئة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($materials_normal) && count($materials_normal) > 0)
                                        @foreach($materials_normal as $material)
                                        <tr>
                                            <td>{{ $material->name }}</td>
                                            <td>{{ $material->size }}</td>
                                            <td>{{ number_format($material->wholesale_price, 2) }}</td>
                                            <td>{{ number_format($material->retail_price, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">لا توجد بيانات متاحة</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="card-title">قائمة اسعار خامات الحديد الاستاندرد</h4>
                    </div>
                    <div class="card-body" style="height: 300px;overflow: auto;">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>نوع الخامة</th>
                                        <th>المقاس</th>
                                        <th>سعر الجملة</th>
                                        <th>سعر التجزئة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($materials_standard) && count($materials_standard) > 0)
                                        @foreach($materials_standard as $material)
                                        <tr>
                                            <td>{{ $material->name }}</td>
                                            <td>{{ $material->size }}</td>
                                            <td>{{ number_format($material->wholesale_price, 2) }}</td>
                                            <td>{{ number_format($material->retail_price, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">لا توجد بيانات متاحة</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- <div class="mb-3">
                    <div class="btn-group">
                        <a href="{{ route('materials.sample-download.excel') }}" class="btn btn-info">
                            <i class="mdi mdi-download me-1"></i> تحميل نموذج Excel
                        </a>
                        <a href="{{ route('materials.sample-download.csv') }}" class="btn btn-info">
                            <i class="mdi mdi-download me-1"></i> تحميل نموذج CSV
                        </a>
                    </div>
                </div> -->
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

@endsection
