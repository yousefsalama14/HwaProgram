@extends('user_temp')

@section('title', 'Print Reciet')

@section('content')


<div class="page-wrapper">
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
            <div class="row justify-content-center">
                <div class="col-10 mt-4">
                    <div id="Receipt" class="well receipt-container">
                        <div class="row">
                            @if($order->user->id ==11 || $order->user->id ==12)
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <address>
                                    <strong style="margin-right: 78px;">Hwa</strong>
                                    <br>

                                 (العنوان:أميال) <br>
                                 المنطقة الصناعية الاولى - السادات - المنوفية
                                    <br>
                                 رقم الموبايل : ٠١٠٠٠٣٠١٤٧٩ - ٠١٠١١٦٤٥٧٠٠ - ٠٤٨٢٦٥٦٨٧٦
                                </address>
                            </div>
                            @endif
                            @if($order->user->id ==8 || $order->user->id ==9 || $order->user->id ==10)
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <address>
                                    <strong style="margin-right: 78px;">Hwa</strong>
                                    <br>

                                 العنوان: المحمدية ( الفرع الرئيسي) <br>
                                 ش. مجدي حسنين- مركز بدر- البحيرة
                                    <br>
                                 رقم الموبايل : ٠١٠٠٨٥٥٢٦٠٤ - ٠١٠٠٨٥٥٢٦٠٢ - ٠٤٥٣٦٢٦٧٠١
                                </address>
                            </div>
                            @endif
                            @if($order->user->id ==13)
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <address>
                                    <strong style="margin-right: 78px;">Hwa</strong>
                                    <br>

                                 العنوان: المحمدية ( فرع السادات) <br>
                                 منطقة المخازن - المنطقة الصناعية الثانية - السادات - المنوفية
                                    <br>
                                 رقم الموبايل : ٠١٢٨١٤٤٧٣١٣ - ٠١١٠٣٨٨٨١٥٧ - ٠١٠٩٨١٣٠٤٩٨
                                </address>
                            </div>
                            @endif
                            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                <p>
                                    <em>التاريخ: <?php
                                        $now = new DateTime();
                                        echo $now->format('Y/m/d h:i A');
                                    ?></em>
                                </p>
                                <p>
                                    <em>اسم المستخدم: {{$order->user->name}}</em>
                                </p>
                                <p>
                                    <em class="text-success">رقم الفاتورة : <?php echo $order->id; ?></em>
                                </p>


                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                <form action="{{ route('user.customer.update', $order->id) }}" method="post" id="printCustomerForm">
                                    @csrf
                                    <p class="mb-2">
                                        <em>اسم العميل: </em>
                                        <input type="text" name="customer_name" class="form-control d-inline-block w-auto invoice-input" value="{{ old('customer_name', $order->customer_name ?? '') }}" placeholder="أدخل اسم العميل">
                                    </p>
                                    <p class="mb-2">
                                        <em>رقم التليفون: </em>
                                        <input type="text" name="customer_phone" class="form-control d-inline-block w-auto invoice-input" value="{{ old('customer_phone', $order->customer_phone ?? '') }}" placeholder="أدخل رقم التليفون">
                                    </p>
                                    <input type="hidden" name="notes" value="{{ old('notes', request('notes','')) }}">
                                </form>
                                </div>
                        </div>
                        <div class="row">
                            <div class="text-center invoice-title">
                                <h2>فاتورة</h2>
                                <hr class="invoice-sep">
                            </div>
                            <table class="table mb-0 invoice-table">
                                <thead>
                                    <tr>
                                        <th>العملية</th>
                                        <th>الوزن</th>
                                        <th>الكمية</th>
                                        <th class="text-center">السعر</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($order->orderdetailes as $d)
                                    @php
                                        $quantity = $d->operationdetailes->quantity ?? 0;
                                        // Skip items with zero quantity unless they have a price (service fee)
                                        $shouldShow = ($quantity > 0) || ($d->price > 0 && $quantity == 0);
                                    @endphp
                                    @if($shouldShow)
                                    <tr>
                                        <td><h5 class="mt-0 mb-1 font-14">
                                            @if($d->opreationname === 'خامات' || $d->opreationname === 'خامات استاندرد')
                                                {{$d->material_name ?? $d->opreationname}}
                                            @else
                                                {{$d->opreationname}}
                                            @endif
                                        </h5></td>
                                        <td><h5 class="mt-0 mb-1 font-14">{{number_format($d->weight ?? 0, 3)}} كجم</h5></td>
                                        <td class="text-center invoice-qty">{{number_format($quantity, 0)}}</td>
                                        <td class="text-center">{{number_format($d->price, 2)}} جنيه</td>
                                    </tr>
                                    @endif
                                @endforeach

                                    <tr>
                                        <td>   </td>
                                        <td>   </td>
                                        <td class="text-right">
                                            <h4><strong>المجموع الكلي : </strong></h4>
                                        </td>
                                        <td class="text-center text-danger">
                                            <h4><strong>{{number_format($totalprcie, 2)}} جنيه</strong></h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-10 mt-4">
                    <div class="well">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.home') }}" class="btn btn-secondary btn-lg">
                                <i class="mdi mdi-home me-1"></i> العودة للرئيسية
                            </a>
                            <div class="btn-group">
                                @if($order && $order->status === 'unpaid')
                                    <a href="{{ route('user.checkout', $order->id) }}" class="btn btn-warning btn-lg">
                                        <i class="mdi mdi-credit-card me-1"></i> الذهاب للدفع
                                    </a>
                                @endif
                                <button id="updateCustomer" form="printCustomerForm" type="submit" class="btn btn-info btn-lg">
                                    <i class="mdi mdi-content-save me-1"></i> تحديث بيانات العميل
                                </button>
                                <button id="print" onclick="printContent('Receipt');" class="btn btn-success btn-lg">
                                    <i class="mdi mdi-printer me-1"></i> طباعة الفاتورة
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://hwa-eg.com/HwaProgram/public/assets/js/jquery.min.js"></script>
<script>
    async function printContent(el) {
        // Show loading state
        const printBtn = document.getElementById('print');
        const originalText = printBtn.innerHTML;
        printBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i> جاري الطباعة...';
        printBtn.disabled = true;

        // First, persist latest customer fields
        try {
            const form = document.getElementById('printCustomerForm');
            const token = form.querySelector('input[name="_token"]').value;
            const formData = new FormData(form);
            await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token
                },
                body: formData
            });
        } catch (e) {
            // Non-blocking: continue printing even if update fails
            console.error('Customer update before print failed', e);
        }

        // Add a small delay to show the loading state
        setTimeout(() => {
            var restorepage = $('body').html();
            var printcontent = $('#' + el).clone();

            // Add print-specific styles
            printcontent.find('.btn').remove(); // Remove buttons from print
            printcontent.find('.alert').remove(); // Remove alerts from print
            printcontent.find('input[type="text"]').each(function() {
                // Convert input fields to plain text for printing
                var value = $(this).val() || '';
                $(this).replaceWith('<span style="font-weight: 500;">' + value + '</span>');
            });
            // Remove any URLs or links
            printcontent.find('a').each(function() {
                var text = $(this).text();
                $(this).replaceWith(text);
            });

            $('body').empty().html(printcontent);

            // Styles are now in assets/css/invoice.css (no inline styles appended)

            window.print();

            // Restore original page then redirect to home
            $('body').html(restorepage);

            // Redirect to home after printing
            window.location.href = "{{ route('user.home') }}";
        }, 500);
    }

    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            <i class="mdi mdi-${type === 'success' ? 'check-circle' : 'information'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(toast);

        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 3000);
    }

    // Auto-hide success alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert-success');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 5000);
        });
    });
</script>





@endsection
