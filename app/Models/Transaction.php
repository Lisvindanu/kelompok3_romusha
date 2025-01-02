<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions'; // Pastikan nama tabel sesuai dengan database
    protected $fillable = [
        'order_id', 'amount', 'status', 'created_at', 'updated_at',
    ];

    protected $casts = [
        'status' => TransactionStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
