<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = [
      'title',
      'article',
      'slug',
      'formatted_article',
      'published_on'
    ];

	  protected $dates = ['published_on'];

    public function getRouteKeyName() {
        return 'slug';
    }
}
