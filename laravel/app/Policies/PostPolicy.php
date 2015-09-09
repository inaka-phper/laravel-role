<?php

namespace App\Policies;

use App\Post;
use App\User;

class PostPolicy
{
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 1. 登録ユーザーがログインすることで「記事」を投稿できる。
     * @return bool
     */
    public function create()
    {
        return true;
    }

    /**
     * 2. 自分が投稿した「記事」は編集が可能。
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        return $user->id == $post->user_id;
    }

    /**
     * 3. 自分が投稿した「記事」は削除が可能。
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function delete(User $user, Post $post)
    {
        return $user->id == $post->user_id;
    }
}
