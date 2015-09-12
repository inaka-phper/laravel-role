<?php

namespace App\Policies;

use App\Comment;
use App\Post;
use App\User;

class CommentPolicy
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
     * 4. 登録ユーザーは「記事」対して「コメント」を書き込める。
     * @return bool
     */
    public function create()
    {
        return true;
    }

    /**
     * 5. 自分が投稿した「コメント」は編集が可能。
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id == $comment->user_id;
    }

    /**
     * 6. 自分が投稿した「コメント」は削除が可能。
     * 7. 投稿された「記事」と「コメント」は非ログインユーザーでも閲覧は可能。
     * @param User $user
     * @param Post $post
     * @param Comment $comment
     * @return bool
     */
    public function delete(User $user, Comment $comment, Post $post)
    {
        return $user->id == $post->user_id || $user->id == $comment->user_id;
    }
}
