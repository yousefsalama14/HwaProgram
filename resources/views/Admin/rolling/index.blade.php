@extends('admin_temp')
@section('content')

{{--start modal--}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">تعديل سعر مصنعيه كيلو الدرفله</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h2 id="rollingkind"></h2>
            <div class="modal-body">
                       <form method="post" action="{{route('rollings.update',0)}}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id" value="">
                            <div class="input-group align-items-center">
                                <span class="input-group-text">السعر في حالة
                                    الوزن أقل من
                                    <span id="span_less_price"></span>
                                </span>
                                <input type="number" name="smallweight" id="lessweight" class="form-control" aria-label=""
                                    value="" >
                                    <p class="mb-0 fw-semibold input-group-text d-none">25</p>
                                <span class="input-group-text">كجم :</span>
                                <input type="text" name="lesspriceweight" id="less" class="form-control" aria-label=""
                                value="" >

                                    {{-- <p class="mb-0 fw-semibold input-group-text d-none">25</p> --}}
                                <span class="input-group-text">سعر مصنعيه الكيلو</span>
                                <input type="text" name="price" id="more" class="form-control" aria-label="" value=""
                                    placeholder="مثال : 10 جنيه">
                                    <p class="mb-0 fw-semibold ms-2 d-none">10 جنيه</p>
                            </div>
                        </div>

                         <input  class="btn btn-primary" type="submit" value="update">

                       </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{--end modal--}}



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
                                <li class="breadcrumb-item"><a href="#">قائمة الأسعار</a></li>
                                <li class="breadcrumb-item active">الدرفلة</li>
                            </ol>
                        </div>
                        <h4 class="page-title">الدرفلة</h4>
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
                            <h4 class="card-title">إضافة سعر</h4>

                        </div>
                      @foreach ($rolleingnames as $rollingname)
                                    <!--end card-header-->
                        <div class="card-body">
                            <div class="row mb-3 g-3">
                                <div class="col-12">
                                    <label for="example-number-input" class="col-form-label fw-bold">في حالة {{$rollingname->name}} :</label>
                                </div>

                                <div class="col-sm-6 col-lg-4">
                                    <div class="input-group align-items-center">
                                        <span for="example-number-input" class="input-group-text">سعر مصنعية
                                            الكيلو
                                            :</span>
                                        <input class="form-control" disabled value="{{$rollingname->price}}" type="number"
                                            placeholder="مثال : 10 جنيه" id="example-number-input">

                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-8">
                                    <div class="input-group align-items-center">
                                        <span class="input-group-text">السعر في حالة
                                            الوزن أقل من </span>
                                        <input type="text" class="form-control" aria-label=""
                                            value="{{$rollingname->smallweight}}" disabled>
                                            <p class="mb-0 fw-semibold input-group-text d-none">25</p>
                                        <span class="input-group-text">كجم :</span>
                                        <input type="text" class="form-control" aria-label=""
                                        value="{{$rollingname->lesspriceweight}}" disabled>

                                    </div>
                                </div>


                                {{-- <div class="col-sm-6 col-lg-4">
                                    <div class="input-group align-items-center">
                                        <span for="example-number-input" class="input-group-text">سعر مصنعية
                                            الكيلو
                                            :</span>
                                        <input class="form-control" type="number"
                                            placeholder="مثال : 10 جنيه" id="example-number-input" disabled value="{{$rollingname->rolleingdetailes->first()->price}}">
                                        <p class="mb-0 fw-semibold ms-2"> جنيه</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-8">
                                    <div class="input-group align-items-center">
                                        <span class="input-group-text">   السعر في حالة الوزن أقل من  25 السعر الكلي</span>
                                        <input type="text" class="form-control" aria-label="" disabled
                                            placeholder="مثال : 25 كجم" value="{{$rollingname->rolleingdetailes->last()->price}}">
                                            <p class="mb-0 fw-semibold input-group-text d-none">25</p>
                                            <span class="input-group-text">   السعر في حالة الوزن اكثر من  25</span>
                                        <input type="text" class="form-control" aria-label="" value="{{$rollingname->rolleingdetailes->first()->price}}" disabled
                                            placeholder="مثال : 10 جنيه">
                                            <p class="mb-0 fw-semibold ms-2 d-none">10 جنيه</p>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <div class="btn-group ms-auto">
                                        {{-- <button type="submit" class="btn btn-primary">تأكيد</button> --}}
                                        <button type="submit"  data-bs-toggle="modal"
                                        data-bs-target="#paymentModal" class="btn btn-secondary ms-1"  onclick="rollingdata({{$rollingname->id}},'{{$rollingname->name}}',{{$rollingname->lesspriceweight}},{{$rollingname->price}},{{$rollingname->smallweight}});">تعديل</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                      @endforeach
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
<script>
let rollingdata =(id,name,less,more,lessweight)=>{
    document.getElementById('id').value=id;
    document.getElementById('rollingkind').innerHTML=name;
    document.getElementById('span_less_price').innerHTML=lessweight;
    document.getElementById('more').value=more;
    document.getElementById('less').value=less;
    document.getElementById('lessweight').value=lessweight;
}
</script>
@endsection
