<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Invoice
 *
 * @property $id
 * @property $invoice_number
 * @property $invoice_Date
 * @property $Due_date
 * @property $product
 * @property $section_id
 * @property $Amount_collection
 * @property $Amount_Commission
 * @property $Discount
 * @property $Value_VAT
 * @property $Rate_VAT
 * @property $Total
 * @property $Status
 * @property $Value_Status
 * @property $note
 * @property $Payment_Date
 * @property $deleted_at
 * @property $created_at
 * @property $updated_at
 *
 * @property Section $section
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Invoice extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['invoice_number', 'invoice_Date', 'Due_date', 'product', 'section_id', 'Amount_collection', 'Amount_Commission', 'Discount', 'Value_VAT', 'Rate_VAT', 'Total', 'Status', 'Value_Status', 'note', 'Payment_Date'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(\App\Models\Section::class, 'section_id', 'id');
    }
    
}
