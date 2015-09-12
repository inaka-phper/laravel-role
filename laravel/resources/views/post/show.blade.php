@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->created_at->toDateString() }} {{ $post->user->name }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>{!! nl2br(e($post->content)) !!}</p>
                        @can('update', $post)
                        <a href="/post/{{ $post->id }}/edit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 編集
                        </a>
                        @endcan
                        @can('delete', $post)
                        <button class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-whatever="/post/{{ $post->id }}">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 削除
                        </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h3>コメント</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @can('create', $post)
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/post/' . $post->id . '/comment') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="POST">

                        <div class="form-group">
                            <div class="col-md-5">
                                <textarea name="content" class="form-control">{{ old('content') }}</textarea>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">
                                    投稿
                                </button>
                            </div>
                        </div>

                    </form>
                @else
                    <p>コメントを投稿するには <a href="/auth/login">ログイン</a>してください。</p>
                @endcan
            </div>
        </div>

        @forelse ($post->comments as $comment)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>{{ $comment->id }}. {{ $comment->user->name }} {{ $comment->created_at->toDateString() }}</p>
                            <p>{!! nl2br(e($comment->content)) !!}</p>
                            @can('update', $comment)
                                <a href="/post/{{ $post->id }}/comment/{{ $comment->id }}/edit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 編集
                                </a>
                            @endcan
                            @can('delete', [$comment, $post])
                                <button class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-whatever="/post/{{ $post->id }}/comment/{{ $comment->id }}">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 削除
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>コメントはまだないよ</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">削除確認</h4>
                </div>
                <div class="modal-body">
                    <p>削除してもよいですか？</p>
                    <form class="form-horizontal" role="form" method="POST" action="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-primary">削除する</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var action = button.data('whatever');
                var modal = $(this);
                $('.modal-body form').attr('action', action);
            });
            $('.modal-footer button.btn-primary').on('click', function () {
                $('.modal-body form').submit();
            });
        });

    </script>

@endsection