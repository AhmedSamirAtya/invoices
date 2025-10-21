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

class InvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $invoices = Invoice::paginate();

        return view('invoice.index', compact('invoices'))
            ->with('i', ($request->input('page', 1) - 1) * $invoices->perPage());
    }


    public function create(): View
    {
        $sections = Section::all();
        return view('invoice.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $invoice =Invoice::create([
            'product_id' => $request->product_id,
            'section_id' => $request->section_id,
            'user_id' => Auth::id(),
        ]);

        InvoiceDetails::create([
            'invoice_id' => $invoice->id,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'amount_collection' => $request->amount_collection,
            'amount_Commission' => $request->amount_Commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'status' => 'unpaied',
            'note' => $request->note,
        ]);

        if ($request->hasFile('pic')) {
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new InvoiceAttachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_id = $invoice->id;
            $attachments->save();

            // move pic
            //$imageName = $request->pic->getClientOriginalName();
            $imageName = uniqid() . '.' . $request->pic->getClientOriginalExtension();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


           // $user = User::first();
           // Notification::send($user, new AddInvoice($invoice_id));

        // $user = User::get();
        // $invoices = Invoice::latest()->first();
        // Notification::send($user, new \App\Notifications\Add_invoice_new($invoices));

        // event(new MyEventClass('hello world'));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $invoice = Invoice::find($id);

        return view('invoice.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $invoice = Invoice::find($id);

        return view('invoice.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $request, Invoice $invoice): RedirectResponse
    {
        $invoice->update($request->validated());

        return Redirect::route('invoices.index')
            ->with('success', 'Invoice updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Invoice::find($id)->delete();

        return Redirect::route('invoices.index')
            ->with('success', 'Invoice deleted successfully');
    }

    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("name", "id");
        return json_encode($products);
    }
}
