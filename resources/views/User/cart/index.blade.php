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
                @if ($order && $order->orderdetailes->count() > 0)
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="selectAll" class="form-check-input">
                                            </th>
                                            <th>العملية</th>
                                            <th>العدد الكلي</th>
                                            <th>الوزن</th>
                                            <th>السعر</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderdetailes as $d)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input item-checkbox" value="{{$d->id}}">
                                                </td>
                                                <td>
                                                    <h5 class="m-0 font-14">
                                                        @if($d->opreationname === 'خامات' || $d->opreationname === 'خامات استاندرد')
                                                            {{$d->material_name ?? $d->opreationname}}
                                                        @else
                                                            {{$d->opreationname}}
                                                        @endif
                                                    </h5>
                                                </td>
                                                @php
                                                    // Always display the entered quantity only; do not multiply by passes
                                                    $baseQty = (int)($d->operationdetailes->quantity ?? 0);
                                                    $totalQty = $baseQty;
                                                @endphp
                                                <td class="font-14">{{$totalQty}}</td>
                                                <td class="font-14">{{number_format($d->weight ?? 0, 3)}} كجم</td>
                                                <td class="font-14">{{$d->price}} جنيه</td>
                                                <td>
                                                    <a href="{{route('user.deleteOrderDetailes',$d->id)}}" class="text-danger delete-single-item" title="حذف" data-id="{{$d->id}}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
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
                                                    <td class="text-dark border-bottom-0"><strong>
                                                            {{$totalprcie}} جنيه</strong></td>
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
                                        <button type="button" id="deleteSelectedBtn" class="btn btn-danger" disabled>
                                            <i class="fas fa-trash-alt me-1"></i> حذف المحدد
                                        </button>
                                        <a href="{{route('user.checkout', $order->id)}}" class="btn btn-primary">
                                            <i class="fas fa-check me-1"></i> إتمام الطلب
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!--end row-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end card-body-->
                </div>
                <!--end col-->
            </div>
              @else
              <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center py-5">
                            <h4 class="text-muted">السلة فارغة</h4>
                            <p class="text-muted">لا توجد عناصر في السلة</p>
                        </div>
                    </div>
                </div>
              </div>
                @endif

            <!--end row-->

        </div><!-- container -->

        <!--Start Footer-->


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

<style>
.btn.disabled {
    opacity: 0.6;
    cursor: not-allowed;
    pointer-events: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if cart is empty
    const orderExists = @json($order ? true : false);
    const hasItems = @json($order && $order->orderdetailes->count() > 0 ? true : false);
    const totalPrice = @json($totalprcie ?? 0);

    if (!orderExists || !hasItems || totalPrice <= 0) {
        // Disable checkout button
        const checkoutButton = document.querySelector('a[href*="checkout"]');
        if (checkoutButton) {
            checkoutButton.classList.add('disabled');
            checkoutButton.style.pointerEvents = 'none';
        }

        // Hide print button
        const printButton = document.querySelector('a[href*="print"]');
        if (printButton) {
            printButton.style.display = 'none';
        }
    }

    // Bulk delete functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');

    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateDeleteButton();
    });

    // Individual checkbox change
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllState();
            updateDeleteButton();
        });
    });

    function updateSelectAllState() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        selectAllCheckbox.checked = checkedCount === itemCheckboxes.length;
        selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < itemCheckboxes.length;
    }

    function updateDeleteButton() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        deleteSelectedBtn.disabled = checkedCount === 0;
    }

    // Delete selected items
    deleteSelectedBtn.addEventListener('click', function() {
        const checkedItems = document.querySelectorAll('.item-checkbox:checked');
        if (checkedItems.length === 0) return;

        const confirmMessage = `هل أنت متأكد من حذف ${checkedItems.length} عنصر؟`;

        Swal.fire({
            title: 'تأكيد الحذف',
            text: confirmMessage,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const selectedIds = Array.from(checkedItems).map(checkbox => checkbox.value);

                fetch('{{ route("user.bulkDeleteOrderDetailes") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        ids: selectedIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        Swal.fire({
                            title: 'تم الحذف!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'حسناً'
                        }).then(() => {
                            // Check if cart is now empty
                            if (data.count === 0) {
                                // Redirect to show empty cart
                                window.location.href = '{{ route("user.cart") }}';
                            } else {
                                // Reload the page to reflect changes
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'خطأ!',
                            text: data.message || 'حدث خطأ أثناء حذف العناصر',
                            icon: 'error',
                            confirmButtonText: 'حسناً'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error deleting items:', error);
                    Swal.fire({
                        title: 'خطأ!',
                        text: 'حدث خطأ أثناء حذف العناصر',
                        icon: 'error',
                        confirmButtonText: 'حسناً'
                    });
                });
            }
        });
    });

    // Single item delete functionality
    const deleteLinks = document.querySelectorAll('.delete-single-item');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const deleteUrl = this.getAttribute('href');

            Swal.fire({
                title: 'تأكيد الحذف',
                text: 'هل أنت متأكد من حذف هذا العنصر؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete route
                    window.location.href = deleteUrl;
                }
            });
        });
    });
});
</script>
