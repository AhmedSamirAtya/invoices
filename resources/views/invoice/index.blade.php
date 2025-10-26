@extends('layouts.master')
@include('partials.datatable-assets')
@section('template_title')
    {{ trans('app.invoices') }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('delete_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif


    @if (session()->has('Status_Update'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم تحديث حالة الدفع بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif

    @if (session()->has('restore_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم استعادة الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif


    <!-- row -->
    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    {{-- @can('اضافة فاتورة') --}}
                    <a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                            class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>
                    {{-- @endcan --}}

                    {{-- @can('تصدير EXCEL') --}}
                    <a class="modal-effect btn btn-sm btn-primary" href="{{ url('export_invoices') }}"
                        style="color:white"><i class="fas fa-file-download"></i>&nbsp;تصدير اكسيل</a>
                    {{-- @endcan --}}

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap"
                            data-page-length='50'style="text-align: center">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ القاتورة</th>
                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="border-bottom-0">المنتج</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">الخصم</th>
                                    <th class="border-bottom-0">نسبة الضريبة</th>
                                    <th class="border-bottom-0">قيمة الضريبة</th>
                                    <th class="border-bottom-0">المبلغ المطلوب</th>
                                    <th class="border-bottom-0">المدفوع</th>
                                    <th class="border-bottom-0">اجمالى نسبه شركه التحصيل</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($invoices as $invoice)
                                    @php
                                        $i++;

                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $invoice->details?->invoice_number }} </td>
                                        <td>{{ $invoice->details?->invoice_date }}</td>
                                        <td>{{ $invoice->details?->due_date }}</td>
                                        <td>{{ $invoice->product->name }}</td>
                                        <td><a
                                                href="{{ url('InvoicesDetails') }}/{{ $invoice->details?->id }}">{{ $invoice->section->name }}</a>
                                        </td>
                                        <td>{{ $invoice->details?->discount }}</td>
                                        <td>{{ $invoice->details?->rate_vat }}</td>
                                        <td>{{ $invoice->details?->value_vat }}</td>
                                        <td>{{ $invoice->details?->amount_collection }}</td>
                                        <td>{{ $invoice->total_paid }}</td>
                                        <td>{{ $invoice->details?->total }}</td>
                                        <td>{{ $invoice->details?->note }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    {{-- @can('تعديل الفاتورة') --}}
                                                    <a class="dropdown-item"
                                                        href=" {{ url('edit_invoice') }}/{{ $invoice->id }}">تعديل
                                                        الفاتورة</a>
                                                    {{-- @endcan --}}

                                                    {{-- @can('حذف الفاتورة') --}}
                                                    <a class="dropdown-item" href="#"
                                                        data-invoice_id="{{ $invoice->id }}" data-toggle="modal"
                                                        data-target="#delete_invoice"><i
                                                            class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                        الفاتورة</a>

                                                    @if (!$invoice->isPaid())
                                                        <a class="dropdown-item" href="javascript:void(0)"
                                                            data-invoice-id="{{ $invoice->id }}"
                                                            data-amount="{{ $invoice->totalPaid }}"
                                                            data-total="{{ $invoice->details?->amount_collection }}"
                                                            data-toggle="modal" data-target="#pay_invoice">
                                                            <i
                                                                class="text-success fas fa-money-bill-wave"></i>&nbsp;&nbsp;دفع
                                                            الفاتورة
                                                        </a>
                                                    @endif
                                                    {{-- @endcan --}}

                                                    {{-- @can('تغير حالة الدفع') --}}
                                                    {{-- <a class="dropdown-item"
                                                            href="{{ URL::route('Status_show', [$invoice->id]) }}"><i
                                                                class=" text-success fas
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    fa-money-bill"></i>&nbsp;&nbsp;تغير
                                                            حالة
                                                            الدفع</a> --}}
                                                    {{-- @endcan --}}

                                                    {{-- @can('ارشفة الفاتورة') --}}
                                                    {{-- <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                            data-toggle="modal" data-target="#Transfer_invoice"><i
                                                                class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي
                                                            الارشيف</a> --}}
                                                    {{-- @endcan --}}

                                                    {{-- @can('طباعةالفاتورة') --}}
                                                    {{-- <a class="dropdown-item" href="Print_invoice/{{ $invoice->id }}"><i
                                                                class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
                                                            الفاتورة
                                                        </a> --}}
                                                    {{-- @endcan --}}
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>

    <!-- حذف الفاتورة -->
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="" method="POST">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الحذف ؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>




    <div class="modal fade" id="pay_invoice" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">دفع الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="payInvoiceForm" action="{{ route('invoices.pay') }}" method="POST">
                        @csrf
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">

                        <div class="form-group">
                            <label for="payment_amount">المبلغ المطلوب دفعه</label>
                            <input type="number" name="amount" id="payment_amount" class="form-control"
                                step="0.01" min="0.01" required>
                            <small class="text-muted">
                                الحد الأقصى للدفع: <span id="max_amount_display">0.00</span>
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="paid_at">تاريخ الدفع</label>
                            <input type="date" name="paid_at" id="paid_at" class="form-control"
                                value="{{ now()->format('Y-m-d') }}" required>
                        </div>
                         <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">{{ __('app.pay') }}</button>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- ارشيف الفاتورة -->
    <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ارشفة الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الارشفة ؟
                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
                    <input type="hidden" name="id_page" id="id_page" value="2">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-success">تاكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('form').attr('action', '/invoices/' + invoice_id);
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>

    <script>
        $('#Transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#pay_invoice').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal

                var invoice_id = button.data('invoice-id'); // from data-invoice-id
                var totalPaid = parseFloat(button.data('amount')) || 0; // already paid
                var total = parseFloat(button.data('total')) || 0; // full amount

                var maxPayable = Math.max(0, total - totalPaid); // never negative

                var modal = $(this);
                modal.find('.modal-body #invoice_id').val(invoice_id);
                modal.find('.modal-body #payment_amount')
                    .attr('max', maxPayable.toFixed(2))
                    .val(''); // clear previous value

                modal.find('#max_amount_display').text(maxPayable.toFixed(2));
            });
        });
    </script>
@endsection
