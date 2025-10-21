<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Section
 *
 * @property $id
 * @property $name
 * @property $description
 * @property $user_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Invoice[] $invoices
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Section extends Model
{

    protected $perPage = 20;


    protected $fillable = ['name', 'description', 'user_id'];



    public function invoices()
    {
        return $this->hasMany(\App\Models\Invoice::class, 'id', 'section_id');
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

}
