<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
  protected $hidden = ['post_id', 'deleted_at'];


  public function user()
  {
      return $this->belongsTo(User::class,'user_id', 'id');
  }

  public function post()
  {
      return $this->belongsTo(Post::class,'post_id', 'id');
  }
}
