@extends('user_temp')
@section('content')

<div class="page-wrapper">
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Page Content-->
    <div class="page-content-tab">

        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-circle me-2"></i>
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-alert-circle me-2"></i>
                    <strong>{{ session('error') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-alert-circle me-2"></i>
                    <strong>يرجى تصحيح الأخطاء التالية:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="float-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                                <li class="breadcrumb-item active">خامات استاندرد</li>
                            </ol>
                        </div>
                        <h4 class="page-title">خامات استاندرد</h4>
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
                            <h4 class="card-title">اضافة فاتورة - خامات الحديد الاستاندرد</h4>
                        </div>
                        <form action="{{route('materials.standard.order')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label text-end">اختيار الصنف</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <select class="form-select" id="std_item" name="item">
                                                    <option value="null"> اختر الصنف</option>
                                                    @if ($materials_type)
                                                    @foreach ( $materials_type as $type)
                                                    <option value="{{$type->name}}"> {{$type->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label text-end">اختيار السعر</label>
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
                                            <label class="col-sm-4 col-form-label text-end">وزن الواحدة</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <input class="form-control" type="number" step="0.01" placeholder="مثال: 12.5" name="unit_weight" id="unit_weight">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label text-end">العدد الكلي</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <input class="form-control" type="number" placeholder="مثال: 100" name="quantity" id="quantity">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-sm-4 col-form-label text-end">الوزن الاجمالي</label>
                                            <div class="col-sm-8 d-flex align-items-center">
                                                <input class="form-control" type="number" step="0.01" placeholder="الوزن الاجمالي" name="weight" id="weight" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <div class="btn-group ms-auto">
                                            <button type="submit" class="btn btn-primary" id="confirmBtn" disabled>تأكيد</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if ($order)
            @foreach ( $order->orderdetailes as $detailes)
            <div class="col-lg-12 " id="orderDetailsCol">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">تفاصيل الطلب</h4>
                    </div>
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="mb-3 row">
                                    <label for="example-number-input"
                                           class="col-sm-4 col-form-label text-end">الوزن الاجمالي
                                         :</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <input class="form-control" name="weghit" type="text"
                                               placeholder="مثال : 1234" id="example-number-input" value="{{$detailes->operationdetailes->weight}} كيلو  " disabled>
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
            </div>
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

<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
$(function() {
    // Store material prices
    var materialPrices = {};

    // Load material prices when page loads
    function loadMaterialPrices() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'GET',
            url: '{{ route("materials.prices") }}',
            success: function(data) {
                materialPrices = data;
                console.log('Material prices loaded:', materialPrices);
            },
            error: function(xhr, status, error) {
                console.error('Error loading material prices:', error);
                console.log('Response:', xhr.responseText);
            }
        });
    }

    function calculatePrice() {
        var unitWeight = parseFloat($('#unit_weight').val()) || 0;
        var quantity = parseInt($('#quantity').val()) || 0;

        var totalWeight = unitWeight * quantity;
        $('#weight').val(totalWeight > 0 ? totalWeight.toFixed(2) : '');
    }

    $('#unit_weight').on('input change', calculatePrice);
    $('#quantity').on('input change', calculatePrice);

    // Load prices on page load
    loadMaterialPrices();
    calculatePrice();
});

// Listen for success alerts and dispatch cartUpdated event
document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        // Dispatch cartUpdated event after a short delay
        setTimeout(() => {
            document.dispatchEvent(new CustomEvent('cartUpdated'));
        }, 500);

        // Auto-hide alert after 3 seconds
        setTimeout(() => {
            successAlert.remove();
        }, 3000);
    }

});
</script>

<script src="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/pages/sweet-alert.init.js')}}"></script>
<script src="{{asset('assets/js/alerts.js')}}"></script>

@endsection
