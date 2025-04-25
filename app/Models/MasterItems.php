<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterItems extends Model
{
    protected $table = 'master_items';
    protected $fillable = ['category_id', 'name', 'price', 'stock'];

    public function category()
    {
        return $this->belongsTo(MasterCategory::class, 'category_id');
    }

    public function transactions()
    {
        return $this->hasMany(DetailTransaction::class, 'item_id');
    }
}
