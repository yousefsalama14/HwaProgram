<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>


    <meta charset="utf-8" />
    <title>POS System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="POS System By Jcloud" name="description" />
    <meta content="Jcloud" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{asset('assets/css/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style-rtl.css')}}" rel="stylesheet" type="text/css" />

</head>

<body id="body" class="auth-page"
    style="background-image: url('assets/images/p-1.png'); background-size: cover; background-position: center center;">
    <!-- Log In page -->
    <div class="container-md">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mx-auto">
                            <div class="card">
                                <div class="card-body p-0 auth-header-box">
                                    <div class="text-center p-3">
                                        <a href="index.html" class="logo logo-admin">
                                            <img src="{{asset('assets/images/logos/logo.png')}}" height="50" alt="logo"
                                                class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold text-white font-18">تسجيل الدخول</h4>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    {{--validation error--}}
                                    {{Session::get('error')}}
                                    <form class="my-4" action="{{route('user.login')}}" method="post">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="username">اسم المستخدم</label>
                                            <input type="text" class="form-control" id="username" name="email"
                                                placeholder="أدخل اسم المستخدم">
                                        </div>
                                        <!--end form-group-->

                                        <div class="form-group mb-2">
                                            <label class="form-label" for="userpassword">كلمة المرور</label>
                                            <input type="password" class="form-control" name="password"
                                                id="userpassword" placeholder="أدخل كلمة المرور">
                                        </div>
                                        <!--end form-group-->

                                        {{-- <div class="form-group">
                                            <label class="form-label" for="exampleFormControlSelect1">تسجيل دخول
                                                ك</label>
                                            <select class="form-select" id="exampleFormControlSelect1">
                                                <option>أدمن</option>
                                                <option>مستخدم</option>
                                            </select>
                                        </div> --}}
                                        <!--end form-group-->

                                        <div class="form-group row mt-3">
                                            <div class="col-sm-6">
                                                <div class="form-check form-switch form-switch-success">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="customSwitchSuccess">
                                                    <label class="form-check-label"
                                                        for="customSwitchSuccess">تذكرني</label>
                                                </div>
                                            </div>
                                            <!--end col-->

                                        </div>
                                        <!--end form-group-->

                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">

                                                     <button type="submit" class="btn btn-primary"> <li  class="fas fa-sign-in-alt ms-1" >  تسجيل الدخول</li></button>
                                                    {{-- <input type="submit" class="btn btn-primary" value="تسجيل الدخول">

                                                    <a href="index.html" class="btn btn-primary" type="submit">تسجيل الدخول <i
                                                            class="fas fa-sign-in-alt ms-1"
                                                            style="transform: rotate(180deg);"></i></a> --}}
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end form-group-->
                                    </form>
                                    <!--end form-->
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end card-body-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->

    <!-- Javascript  -->
    <!-- App js -->
    <script src="{{asset('assets/js/app.js')}}"></script>
</body>

</html>
