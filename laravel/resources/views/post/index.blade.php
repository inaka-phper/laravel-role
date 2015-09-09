@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>ブログ一覧</h2>
                <a href="/post/create" type="button" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 新規追加
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table class="table table-striped">
                    <tr>
                        <td>ID</td>
                        <td>タイトル</td>
                        <td>内容</td>
                        <td>投稿日</td>
                        <td>投稿者</td>
                        <td>操作</td>
                    </tr>
                    @forelse ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td><a href="/post/{{ $post->id }}">{{ $post->title }}</a></td>
                            <td>{!! nl2br(e($post->content)) !!}</td>
                            <td>{{ $post->created_at->toDateString() }}</td>
                            <td>{{ $post->user->name }}</td>
                            <td>
                                <a href="/post/{{ $post->id }}" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> 表示
                                </a>
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td rowspan="6">
                                <p>記事がないよ</p>
                                <p><a href="/post/create">こっちから投稿する？</a></p>
                            </td>
                        </tr>
                    @endforelse
                </table>
            </div>

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    {!! $posts->render() !!}
                </div>
            </div>
        </div>
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