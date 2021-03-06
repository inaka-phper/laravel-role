<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
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
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->user = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = $this->post->paginate();

        return view('post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (Gate::denies('create', $this->post)) {
            return redirect('/auth/login')->with('message', '投稿するにはログインしてください。');
        }
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', $this->post)) {
            return redirect('/auth/login')->with('message', '投稿するにはログインしてください。');
        }

        $this->post->fill($request->all());
        $this->post->user_id = $this->user->id;
        $this->post->save();

        return redirect('/post')->with('message', '投稿を保存しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $this->post = $this->post->findOrFail($id);

        return view('post.show', ['post' => $this->post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $this->post = $this->post->findOrFail($id);

        if (Gate::denies('update', $this->post)) {
            return redirect('/post')->with('message', '編集できるのは投稿者と管理者のみです。');
        }

        return view('post.edit', ['post' => $this->post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->post = $this->post->findOrFail($id);

        if (Gate::denies('update', $this->post)) {
            return redirect('/post')->with('message', '編集できるのは投稿者と管理者のみです。');
        }

        $this->post->fill($request->all());
        $this->post->save();

        return redirect('/post/' . $this->post->id)->with('message', '投稿を編集しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->post = $this->post->findOrFail($id);

        if (Gate::denies('delete', $this->post)) {
            return redirect('/post')->with('message', '削除できるのは投稿者と管理者のみです。');
        }

        $this->post->delete();

        return redirect('/post')->with('message', '投稿を削除しました。');
    }
}
