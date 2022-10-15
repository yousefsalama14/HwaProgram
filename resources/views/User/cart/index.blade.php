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
                                <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                                <li class="breadcrumb-item active">سلة المشتريات</li>
                            </ol>
                        </div>
                        <h4 class="page-title">سلة المشتريات</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">
                @if ($order)
                <form action="{{route('user.paied')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$order->id}}">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>العملية</th>
                                            <th>الكمية</th>
                                            <th>السعر</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderdetailes as $detailes)
                                            <tr>
                                                <td>
                                                    <h5 class="mt-0 mb-1 font-14">{{$detailes->opreationname}}</h5>
                                                </td>

                                                <td>
                                                    <input class="form-control w-25" type="number" value="{{$detailes->operationdetailes->quantity}}"
                                                        id="example-number-input1">
                                                </td>
                                                <td>EGP {{$detailes->price}}</td>
                                                <td>
                                                    <a href="{{route('user.deleteOrderDetailes',$detailes->id)}}" class="text-dark"><i
                                                            class="mdi mdi-close-circle-outline font-18"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="total-payment p-3 mt-4">
                                        <!-- <h4 class="header-title">السعر الكلي</h4> -->
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="border-bottom-0">المجموع الكلي :</td>
                                                    <td class="text-dark border-bottom-0"><strong>EGP
                                                            {{$totalprcie}}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                            <div class="row mt-3">
                                <div class="col-12 d-flex">
                                    <div class="btn-group ms-auto">
                                        <button type="submit" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="">دفع</button>
                                        {{-- <button type=" submit" class="btn btn-secondary ms-1">اضافة عملية
                                            أخري</button> --}}
                                    </div>
                                </div>
                            </div>
                            <form>
                            <!--end row-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end card-body-->
                </div>
                <!--end col-->
            </div>
              @else
              <div class="row justify-content-center">
                <div class="col-12">
                    <div class="total-payment p-3 mt-4">
                        <!-- <h4 class="header-title">السعر الكلي</h4> -->
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="border-bottom-0">المجموع الكلي :</td>
                                    <td class="text-dark border-bottom-0"><strong>EGP
                                            {{$totalprcie}}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end col-->
            </div>
                @endif

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

@endsection
