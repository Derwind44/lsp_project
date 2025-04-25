<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table ='transactions';
    protected $fillable = ['transaction_code', 'total_price', 'total_items'];
    public function details()
    {
        return $this->hasMany(DetailTransaction::class);
    }
}
