<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\InvoiceRequest;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetails;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class InvoiceDetailsController extends Controller
{
    public function index(Request $request)
    {

    }


    public function create()
    {

    }

    public function invoiceDetailsById(InvoiceDetails $invoiceDetails){
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceDetails $invoiceDetails)
    {
        dd($invoiceDetails);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceDetails $invoiceDetails)
    {
        $attachments  = InvoiceAttachment::where('invoice_id',$invoiceDetails->invoice_id)->get();

        return view('invoice.invoice_details',compact('invoiceDetails','attachments'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {

    }

    public function destroy($id)
    {

    }

    public function getproducts($id)
    {

    }
}
