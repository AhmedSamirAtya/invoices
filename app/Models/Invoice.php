<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;

class Invoice extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['product_id', 'section_id', 'user_id'];

    public function section()
    {
        return $this->belongsTo(\App\Models\Section::class, 'section_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function details()
    {
        return $this->hasOne(\App\Models\InvoiceDetails::class, 'invoice_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Computed total paid
    public function totalPaid(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->payments->sum('amount')
        );
    }

    // Computed status
    public function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                $paid = $this->totalPaid;

                if ($paid == 0) {
                    return 'unpaid';
                } elseif ($paid < $this->details?->amount_collection ?? 0) {
                    return 'partially_paid';
                } elseif ($paid == $this->details?->amount_collection) {
                    return 'paid';
                } else {
                    return 'overpaid';
                }
            }
        );
    }

    // Helper: is fully paid?
    public function isPaid(): bool
    {
        return $this->status === 'paid' || $this->status === 'overpaid';
    }

    public function attachments()
    {
        return $this->hasMany(InvoiceAttachment::class, 'invoice_id');
    }

    public static function getTotalFullyUnpaidAmount(): float
    {
        $paymentsTable = (new \App\Models\Payment())->getTable();
        $detailsTable = (new \App\Models\InvoiceDetails())->getTable();
        //$paiedInvoices = self::isPaid()->get();
        // The sub-query logic (required for filtering)
        $fullyUnpaidFilter = '
        IFNULL((SELECT SUM(amount) FROM ' . $paymentsTable . ' WHERE ' . $paymentsTable . '.invoice_id = invoices.id), 0) = 0
    ';

        // Build the query
        return (float) self::query()
            // 1. Join InvoiceDetails to access the amount_collection column
            ->join($detailsTable, 'invoices.id', '=', $detailsTable . '.invoice_id')

            // 2. Filter: Only include invoices with zero payments
            ->whereRaw($fullyUnpaidFilter)

            // 3. Filter: Only include invoices with a charge amount
            ->where($detailsTable . '.amount_collection', '>', 0)

            // 4. Perform the sum on the column from the joined table
            ->sum($detailsTable . '.amount_collection');
    }

   public static function getTotalPaidAmount(): float
{
    $paymentsTable = (new \App\Models\Payment())->getTable();
    $detailsTable = (new \App\Models\InvoiceDetails())->getTable();

    // SQL condition for 'paid' status:
    // IFNULL(SUM of payments) must equal amount_collection.
    $fullyPaidFilter = '
        IFNULL((SELECT SUM(amount) FROM ' . $paymentsTable . ' WHERE ' . $paymentsTable . '.invoice_id = invoices.id), 0) = ' . $detailsTable . '.amount_collection
    ';

    return (float) self::query()
        // 1. Join InvoiceDetails to access the amount_collection column
        ->join($detailsTable, 'invoices.id', '=', $detailsTable . '.invoice_id')

        // 2. Filter: Only include invoices where total payments equals the amount collected
        ->whereRaw($fullyPaidFilter)

        // 3. Optional: Filter out invoices with zero collection amount (though payment filter should cover this)
        ->where($detailsTable . '.amount_collection', '>', 0)

        // 4. Perform the sum on the column from the joined table
        ->sum($detailsTable . '.amount_collection');
}
}
