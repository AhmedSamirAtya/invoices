<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
}
