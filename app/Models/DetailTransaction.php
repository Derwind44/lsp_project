<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    protected $table = 'detail_transactions';
    protected $fillable = ['transaction_id', 'item_id', 'quantity', 'subtotal'];
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function item()
    {
        return $this->belongsTo(MasterItems::class);
    }
}
