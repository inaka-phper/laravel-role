<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostCommentController extends Controller
{
    /**
     * ユーザー認証情報
     * @var Auth
     */
    private $user;

    /**
     * Post EloquentModel
     * @var Post
     */
    private $post;

    /**
     * Comment EloquentModel
     * @var Comment
     */
    private $comment;

    /**
     * @param Route $route
     * @param Post $post
     * @param Comment $comment
     */
    public function __construct(Route $route, Post $post, Comment $comment)
    {
        $this->post = $post->findOrFail($route->parameter('post'));
        $this->comment = $comment;
        $this->user = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', $this->comment)) {
            return redirect('/auth/login')->with('message', 'コメントするにはログインしてください。');
        }

        $this->comment->fill($request->all());
        $this->comment->user_id = $this->user->id;
        $this->comment->post_id = $this->post->id;
        $this->comment->save();

        return redirect('/post/' . $this->post->id)->with('message', 'コメントを投稿しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Route $route
     * @return Response
     */
    public function edit(Route $route)
    {
        $id = $route->parameter('comment');
        $this->comment = $this->comment->findOrFail($id);

        if (Gate::denies('update', $this->comment)) {
            return redirect('/post/' . $this->post->id)->with('message', '編集できるのは投稿者と管理者のみです。');
        }

        return view('post.comment.edit', ['comment' => $this->comment]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param Route $route
     * @return Response
     */
    public function update(Request $request, Route $route)
    {
        $id = $route->parameter('comment');
        $this->comment = $this->comment->findOrFail($id);

        if (Gate::denies('update', $this->comment)) {
            return redirect('/post/' . $this->post->id)->with('message', '編集できるのは投稿者と管理者のみです。');
        }

        $this->comment->fill($request->all());
        $this->comment->save();

        return redirect('/post/' . $this->post->id)->with('message', 'コメントを編集しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Route $route
     * @return Response
     */
    public function destroy(Route $route)
    {
        $id = $route->parameter('comment');
        $this->comment = $this->comment->findOrFail($id);

        if (Gate::denies('delete', [$this->comment, $this->post])) {
            return redirect('/post/' . $this->post->id)->with('message', '削除できるのは投稿者と記事の投稿者、管理者のみです。');
        }

        $this->comment->delete();

        return redirect('/post/' . $this->post->id)->with('message', 'コメントを削除しました。');
    }
}
