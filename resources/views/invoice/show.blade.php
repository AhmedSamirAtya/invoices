@extends('layouts.master')

@section('template_title')
    {{ $invoice->name ?? __('Show') . " " . __('Invoice') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Invoice</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('invoices.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Invoice Number:</strong>
                                    {{ $invoice->invoice_number }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Invoice Date:</strong>
                                    {{ $invoice->invoice_Date }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Due Date:</strong>
                                    {{ $invoice->Due_date }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Product:</strong>
                                    {{ $invoice->product }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Section Id:</strong>
                                    {{ $invoice->section_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Amount Collection:</strong>
                                    {{ $invoice->Amount_collection }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Amount Commission:</strong>
                                    {{ $invoice->Amount_Commission }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Discount:</strong>
                                    {{ $invoice->Discount }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Value Vat:</strong>
                                    {{ $invoice->Value_VAT }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Rate Vat:</strong>
                                    {{ $invoice->Rate_VAT }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Total:</strong>
                                    {{ $invoice->Total }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Status:</strong>
                                    {{ $invoice->Status }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Value Status:</strong>
                                    {{ $invoice->Value_Status }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Note:</strong>
                                    {{ $invoice->note }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Payment Date:</strong>
                                    {{ $invoice->Payment_Date }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
