<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * このコメントを書き込んだUserを取得
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * このコメントを書き込んだブログを取得
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
