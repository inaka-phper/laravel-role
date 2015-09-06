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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection