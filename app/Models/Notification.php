<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $casts = [
        'read_at' => 'datetime',
        'data' => 'array', // <--- THIS IS THE CRITICAL LINE
    ];
}
