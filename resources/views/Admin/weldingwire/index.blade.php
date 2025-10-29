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
                                <li class="breadcrumb-item"><a href="#">قائمة الأسعار</a></li>
                                <li class="breadcrumb-item active">سلك اللحام</li>
                            </ol>
                        </div>
                        <h4 class="page-title">سلك اللحام</h4>
                    </div>
                    <!--end page-title-box-->
                </div>
                <!--end col-->
            </div>
            <!-- end page title end breadcrumb -->
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">أسعار سلك اللحام</h4>
                            <button class="btn p-0">
                                <i class="ti ti-pencil"></i>
                            </button>
                        </div>
                        <!--end card-header-->
                        <div class="card-body">
                            <form action="{{route('weldingwires.update',0)}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3 g-3">
                                    <div class="col-12">
                                        <label for="example-number-input" class="col-form-label">أسعار سلك اللحام بالجنيه:</label>
                                    </div>
                                    @foreach ($weldingwires as $weldingwire)
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="input-group align-items-center">
                                            <label for="example-number-input" class="col-form-label me-2">{{$weldingwire->name}} مم:</label>
                                            <input class="form-control" name="price[]" type="text" placeholder="مثال : 10 جنيه"
                                                id="example-number-input" value="{{$weldingwire->price}}">
                                            <input type="hidden" name="id[]" value="{{$weldingwire->id}}">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <div class="btn-group ms-auto">
                                            <button type="submit" class="btn btn-primary">تأكيد</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
        </div><!-- container -->
    </div>
    <!-- end page content -->
</div>

@endsection
@section('scripts')
<script src="{{asset('assets/js/alerts.js')}}"></script>
@endsection
