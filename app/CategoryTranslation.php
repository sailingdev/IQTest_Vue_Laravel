<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    //
    protected $table = 'category_translations';
    protected $fillable = ['category_id', 'locale', 'title', 'description','question','short_desc'];
    
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
