@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="page-header">
            <h1>{{ $profileUser->name }}</h1>
            <small>since {{ $profileUser->created_at->diffForHumans() }}</small>
        </div>

        @foreach($threads as $thread)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="level">
                        <span>
                            <a href="#">{{$thread->title}}</a> by {{ $thread->creator->name }}
                        </span>
                        <span>
                            {{ $thread->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                <div class="panel-body">
                    {{$thread->body}}
                </div>
            </div>
        @endforeach
        <div class="text-center">
            {{ $threads->links() }}
        </div>
    </div>
@endsection