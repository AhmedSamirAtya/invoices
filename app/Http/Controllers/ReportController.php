<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sections;
use App\invoices;
use App\Models\Invoice;
use App\Models\Section;

class ReportController extends Controller
{
    public function customersReport()
    {
        $sections = Section::all();
        return view('reports.customers_report', compact('sections'));
    }


    public function searchCustomers(Request $request)
    {
        // حالة البحث بدون التاريخ
        $section_id = $request->section_id;
        $product_id = $request->product_id;
        if ($request->section_id && $request->product_id && $request->start_at == '' && $request->end_at == '') {
            $invoices = Invoice::select('*')->where('section_id', '=', $request->section_id)->where('product_id', '=', $request->product_id)->get();
            $sections = Section::all();

            return view('reports.customers_report', compact('sections', 'section_id', 'product_id'))->withDetails($invoices);
        }
        // في حالة البحث بتاريخ
        else {
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

            $invoices = Invoice::query()
                ->where('section_id', $request->section_id)
                ->where('product_id', $request->product_id)
                ->whereHas('details', function ($query) use ($start_at, $end_at) {
                    $query->whereBetween('invoice_date', [$start_at, $end_at]);
                })
                ->get();
            $sections = Section::all();
            return view('reports.customers_report', compact('sections','section_id', 'product_id', 'start_at', 'end_at'))->withDetails($invoices);
        }
    }

    public function invoicesReport()
    {

        return view('reports.invoices_report');
    }

    public function searchInvoices(Request $request)
    {

        $rdio = $request->rdio;


        // في حالة البحث بنوع الفاتورةphp

        if ($rdio == 1) {
            // في حالة عدم تحديد تاريخ
            if ($request->type && $request->start_at == '' && $request->end_at == '') {
                $invoices = Invoice::select('*')->where('Status', '=', $request->type)->get();
                $type = $request->type;
                return view('reports.invoices_report', compact('type'))->withDetails($invoices);
            }
            // في حالة تحديد تاريخ استحقاق
            else {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;
                $invoices = Invoice::whereBetween('invoice_Date', [$start_at, $end_at])->where('Status', '=', $request->type)->get();
                return view('reports.invoices_report', compact('type', 'start_at', 'end_at'))->withDetails($invoices);
            }
        }
        // في البحث برقم الفاتورة
        else {
            $invoices = Invoice::select('*')->where('invoice_number', '=', $request->invoice_number)->get();
            return view('reports.invoices_report')->withDetails($invoices);
        }
    }
}
