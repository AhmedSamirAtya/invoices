<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if ($id == 'home') {
            $invoices = Invoice::all();
            $invoicesCount = Invoice::count();
            $unpaidCount = $invoices
                ->filter(function ($invoice) {
                    // Here, $invoice is a single model instance, so isPaid() works.
                    return $invoice->status == 'unpaid';
                })
                ->count();

            $partialyPaidCount = $invoices
                ->filter(function ($invoice) {
                    // Here, $invoice is a single model instance, so isPaid() works.
                    return $invoice->totalPaid < $invoice->details?->amount_collection && $invoice->totalPaid > 0;
                })
                ->count();
            $paidCount = $invoices
                ->filter(function ($invoice) {
                    // Here, $invoice is a single model instance, so isPaid() works.
                    return $invoice->status === 'paid';
                })
                ->count();

            $chart = Chartjs::build()
                ->name('pieChartTest')
                ->type('pie')
                ->labels([trans('app.paid_invoices_percentage'), trans('app.partialy_paid_invoices_percentage'), trans('app.unpaid_invoices_percentage')])
                ->datasets([
                    [
                        'backgroundColor' => ['#0bff34ff', '#eeea11ff', '#db0b0bff'],
                        'hoverBackgroundColor' => ['#FF6384', '#36A2EB', '#36A2EB'],
                        'data' => [$paidCount, $partialyPaidCount, $unpaidCount]
                    ]
                ])
                ->options([]);


            $bar = Chartjs::build()
                ->name('barChartTest')
                ->type('bar')
                ->labels([trans('app.paid_invoices_percentage'), trans('app.partialy_paid_invoices_percentage'), trans('app.unpaid_invoices_percentage')])
                ->datasets(
                    [
                        [
                            "label" => trans('app.paid_invoices_percentage'),
                            'backgroundColor' => ['rgba(31, 236, 59, 0.93)'],
                            'data' => [round(($paidCount / $invoicesCount) * 100,1)]
                        ],
                        [
                            "label" => trans('app.partialy_paid_invoices_percentage'),
                            'backgroundColor' => ['rgba(235, 217, 54, 0.7)'],
                            'data' => [round(($partialyPaidCount / $invoicesCount) * 100,1)]
                        ],
                        [
                            "label" => trans('app.unpaid_invoices_percentage'),
                            'backgroundColor' => ['rgba(250, 3, 3, 0.3)'],
                            'data' => [round(($unpaidCount / $invoicesCount) *100, 1)]
                        ],
                    ],

                )
                ->options([
                    "scales" => [
                        "y" => [
                            "beginAtZero" => true,
                            // Ensure the Y-axis (percentage) goes up to 100%
                            "max" => 100,
                            "title" => ["display" => true, "text" => trans('app.percentage')]
                        ],
                        "x" => [
                            "beginAtZero" => true,
                            "title" => ["display" => true, "text" => trans('app.invoice_status')]
                        ]
                    ]
                ]);


            return view($id, compact('chart', 'bar'));
        } else if (view()->exists($id)) {
            return view($id);
        } else {
            return view('404');
        }

        //   return view($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
