<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterCategory extends Model
{
    protected $table = 'master_categories';
    protected $fillable = ['name'];

    public function items()
    {
        return $this->hasMany(MasterItems::class, 'category_id');
    }
}
