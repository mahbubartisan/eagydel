<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $casts = [

    //     // 'district_id' => 'array',
    //     'state_name' => 'array',
    // ];

    public function district(){

        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
