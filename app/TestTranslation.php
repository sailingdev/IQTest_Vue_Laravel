<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestTranslation extends Model
{
    //
    protected $table = 'test_translations';
    protected $fillable = ['test_id', 'locale', 'title', 'description','instruction',
            'pre_page_title','pre_page_desc','post_page_title','post_page_desc'];
    
    public function test()
    {
        return $this->belongsTo('App\Test');
    }

}
