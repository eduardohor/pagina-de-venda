<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'sale_id',
        'installment_number',
        'due_date',
        'amount'
    ];

    public function sale() {
        return $this->belongsTo(Sale::class);
    }

    public function payment() {
        return $this->belongsTo(Payment::class);
    }

}
