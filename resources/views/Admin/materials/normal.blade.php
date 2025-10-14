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
                                <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                                <li class="breadcrumb-item active">خامات عادية</li>
                            </ol>
                        </div>
                        <h4 class="page-title">قائمة أسعار خامات الحديد العادية</h4>
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
                            <h4 class="card-title">رفع ملف أسعار الخامات العادية</h4>
                            <p class="text-muted mb-0">تنسيق الملف المطلوب: اسم الخامة، السمك، السعر التجاري، السعر القطاعي</p>
                        </div>
                        <!--end card-header-->
                        <form action="{{route('materials.normal.upload')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="mb-3 row">
                                            <label for="example-number-input"
                                                   class="col-sm-4 col-form-label text-end">رفع ملف</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <input type="file" name="file" class="custom-file-input border p-3" id="chooseFile">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <div class="btn-group ms-auto">
                                            <button type="submit" class="btn btn-primary"> <i
                                                    class="mdi mdi-gesture-double-tap me-1"></i> رفع الملف</button>
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
            </div>
            <!--end row-->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">قائمة أسعار خامات الحديد العادية</h4>
                            <p class="text-muted mb-0">إجمالي السجلات: {{ $materials_normal->total() }} | عرض {{ $materials_normal->count() }} من {{ $materials_normal->firstItem() ?? 0 }} إلى {{ $materials_normal->lastItem() ?? 0 }} | آخر تحديث: {{ $materials_normal->whereNotNull('updated_at')->max('updated_at') ? $materials_normal->whereNotNull('updated_at')->max('updated_at')->format('Y-m-d H:i') : 'غير محدد' }}</p>
                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>اسم الخامة</th>
                                            <th>السمك</th>
                                            <th>السعر التجاري</th>
                                            <th>السعر القطاعي</th>
                                            <th>آخر تحديث</th>
                                            <th>محدث بواسطة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($materials_normal)
                                        @foreach ( $materials_normal as $material)
                                        <tr>
                                            <td>{{$material->name}}</td>
                                            <td>{{$material->size}}</td>
                                            <td>{{$material->wholesale_price}}</td>
                                            <td>{{$material->retail_price}}</td>
                                            <td>{{$material->updated_at ? $material->updated_at->format('Y-m-d H:i') : 'غير محدد'}}</td>
                                            <td>{{$material->updated_by ?: 'غير محدد'}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!--end table-responsive-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
            <!--end row-->

            <!-- Pagination -->
            <nav aria-label="..." class="py-3 border-top">
                {{ $materials_normal->appends(request()->query())->links('pagination.bootstrap-4-arabic') }}
            </nav>
            <!--end pagination-->

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
