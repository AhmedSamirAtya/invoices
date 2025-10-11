<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\InvoiceRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $invoices = Invoice::paginate();

        return view('invoice.index', compact('invoices'))
            ->with('i', ($request->input('page', 1) - 1) * $invoices->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $invoice = new Invoice();

        return view('invoice.create', compact('invoice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request): RedirectResponse
    {
        Invoice::create($request->validated());

        return Redirect::route('invoices.index')
            ->with('success', 'Invoice created successfully.');
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
}
