@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>ブログ投稿</h2>
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/post') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="POST">

                            <div class="form-group">
                                <label class="col-md-4 control-label">タイトル</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">内容</label>
                                <div class="col-md-6">
                                    <textarea name="content" class="form-control">{{ old('content') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        投稿
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection