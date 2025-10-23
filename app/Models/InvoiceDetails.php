<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    protected $table = 'invoices_details';
    protected $fillable = ['invoice_number', 'invoice_id', 'invoice_date', 'due_date', 'amount_collection', 'amount_commission', 'discount', 'value_vat', 'rate_vat', 'total', 'status', 'note', 'payment_date'];

    public function invoice(){
        return $this->belongsTo(\App\Models\Invoice::class, 'invoice_id', 'id');
    }
}
