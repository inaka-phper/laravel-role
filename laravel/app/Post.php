<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'content'];

    /**
     * ブログポストのコメントを取得
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * このコメントを書き込んだUserを取得
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
