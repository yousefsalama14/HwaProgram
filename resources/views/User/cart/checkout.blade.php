@extends('user_temp')
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
                                <li class="breadcrumb-item"><a href="{{route('user.home')}}">الرئيسية</a></li>
                                <li class="breadcrumb-item"><a href="{{route('user.cart')}}">سلة المشتريات</a></li>
                                <li class="breadcrumb-item active">إتمام الطلب</li>
                            </ol>
                        </div>
                        <h4 class="page-title">إتمام الطلب</h4>
                    </div>
                </div>
            </div>
            <!-- end page title end breadcrumb -->

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">تفاصيل الطلب</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>العملية</th>
                                            <th>الكمية</th>
                                            <th>الوزن</th>
                                            <th>السعر</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderdetailes as $d)
                                            <tr>
                                                <td><strong>
                                                    @if($d->opreationname === 'خامات' || $d->opreationname === 'خامات استاندرد')
                                                        {{$d->material_name ?? $d->opreationname}}
                                                    @else
                                                        {{$d->opreationname}}
                                                    @endif
                                                </strong></td>
                                                <td>{{$d->operationdetailes->quantity ?? 0}}</td>
                                                <td>{{number_format($d->weight ?? 0, 3)}} كجم</td>
                                                <td><strong>{{$d->price}} جنيه</strong></td>
                                            </tr>
                                        @endforeach
                                        <tr class="table-active">
                                            <td colspan="3" class="text-end"><strong>المجموع الكلي:</strong></td>
                                            <td><strong class="text-success">{{$totalprcie}} جنيه</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="card-title text-white mb-0">ملخص الطلب</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <p class="mb-2"><strong>رقم الطلب:</strong> #{{$order->id}}</p>
                                <p class="mb-2"><strong>عدد العناصر:</strong> {{$order->orderdetailes->count()}}</p>
                                <p class="mb-2"><strong>التاريخ:</strong> {{$order->created_at->format('Y-m-d')}}</p>
                            </div>

                            <hr>

                            <form action="{{route('user.pay', $order->id)}}" method="post">
                                @csrf

                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">اسم العميل</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="أدخل اسم العميل">
                                </div>

                                <div class="mb-3">
                                    <label for="customer_phone" class="form-label">رقم الهاتف</label>
                                    <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="أدخل رقم الهاتف">
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">ملاحظات إضافية</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="أي ملاحظات أو تعليمات خاصة"></textarea>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="mdi mdi-check-circle me-1"></i>
                                        تأكيد الدفع ({{$totalprcie}} جنيه)
                                    </button>
                                    <a href="{{route('user.cart')}}" class="btn btn-outline-secondary">
                                        <i class="mdi mdi-arrow-right me-1"></i>
                                        العودة للسلة
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center text-muted">
                                <i class="mdi mdi-shield-check-outline font-24 me-2"></i>
                                <small>جميع المعلومات محمية وآمنة</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- container -->

        <!-- Footer Start -->
        <footer class="footer text-center text-sm-start">
            &copy;
            <script>
                document.write(new Date().getFullYear())
            </script> JCloud Co
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->

@endsection

