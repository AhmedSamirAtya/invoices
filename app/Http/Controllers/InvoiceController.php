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
use App\Exports\InvoicesExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Rap2hpoutre\FastExcel\FastExcel;

class InvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $invoices = Invoice::with(['details', 'product', 'payments'])->get();

        return view('invoice.index', compact('invoices'));
    }

     public function export()
    {

       // Fetch the data you want to export
        $invoiceDetails = InvoiceDetails::all();

        // The keys of the collection items will become the column headers in the Excel file.
        return (new FastExcel($invoiceDetails))->download('invoiceDetails.xlsx');

    }

    // public function import(Request $request)
    // {
    //     // Validate the uploaded file
    //     $request->validate(['excel_file' => 'required|file|mimes:xlsx,xls,csv']);

    //     $filePath = $request->file('excel_file');

    //     // Read the spreadsheet into a collection
    //     $sections = (new FastExcel)->import($filePath, function ($line) {
    //         // $line is an array where keys are the column headers (e.g., 'name', 'email')
    //         return Section::create([
    //             'name' => $line['name'], // Ensure these keys match your Excel headers
    //             'email' => $line['email'],
    //             // ... other fields
    //         ]);
    //     });

    //     return back()->with('success', 'Data imported successfully!');
    // }



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
        $invoice = Invoice::create([
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
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'note' => $request->note,
        ]);

        if ($request->hasFile('pic')) {
            $invoice_number = $request->invoice_number;

            $attachments = new InvoiceAttachment();
            $attachments->invoice_id = $invoice->id;
            $imageName = uniqid() . '.' . $request->pic->getClientOriginalExtension();
            $attachments->file_name = $imageName;
            $attachments->save();

            // move pic
            //$imageName = $request->pic->getClientOriginalName();

            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        // $user = User::first();
        // Notification::send($user, new AddInvoice($invoice_id));

        $invoice = Invoice::latest()->first();
        $section = $invoice->section;

        Notification::send($section, new \App\Notifications\InvoiceAdded($invoice->id));

        // event(new MyEventClass('hello world'));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }

    public function pay(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount'     => 'required|numeric|min:0.01',
            'paid_at'    => 'required|date',
        ]);

        $invoice = Invoice::with('details')->findOrFail($request->invoice_id);

        $balance = $invoice->details?->amount_collection - $invoice->totalPaid;

        if ($request->amount > $balance) {
            return back()->withErrors([
                'amount' => 'المبلغ المدخل يتجاوز المبلغ المتبقي للدفع.'
            ]);
        }
        $invoice->payments()->create([
            'amount'  => $request->amount,
            'paid_at' => $request->paid_at,
            'method'  => $request->method ?? 'cash',
        ]);
        session()->flash('Add', 'تم الدفع الفاتورة بنجاح');
        return back();
    }

    public function show($id): View
    {
        $invoice = Invoice::find($id);

        return view('invoice.show', compact('invoice'));
    }

    public function edit(int $id): View
    {
        $invoice = Invoice::with(['details', 'section', 'product'])->findOrFail($id);
        $sections = Section::all();
        return view('invoice.edit', compact('invoice', 'sections'));
    }

    public function update(Request $request, Invoice $invoice): RedirectResponse
    {
         $invoice->update([
            'product_id' => $request->product,
            'section_id' => $request->section,
            'user_id' => Auth::id(),
        ]);

        $invoice->details()->update([
            'invoice_id' => $invoice->id,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'note' => $request->note,
        ]);

        return Redirect::route('invoices.index')
            ->with('success', 'Invoice updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $invoice = Invoice::findOrFail($id);

        $folderPath = public_path('Attachments/' . $invoice->details?->invoice_number);

        if (is_dir($folderPath)) {
            File::deleteDirectory($folderPath);
        }

        $invoice->delete();

        return Redirect::route('invoices.index')->with('success', 'تم حذف الفاتورة ومرفقاتها بنجاح.');
    }

    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("name", "id");
        return json_encode($products);
    }

    public function printInvoice($id): View
    {
        $invoice = Invoice::with(['details', 'product', 'section'])->findOrFail($id);
        return view('invoice.print_invoice', compact('invoice'));
    }
}
