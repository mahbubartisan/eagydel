<?php

namespace App\Models;

use App\Models\Type;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category as ModelsCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function parents(){

        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function types(){

        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function products(){

        return $this->hasMany(Product::class);
    }

}
