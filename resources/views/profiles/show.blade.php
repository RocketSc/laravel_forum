@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">
                    <h1>{{ $profileUser->name }}</h1>
                    <small>since {{ $profileUser->created_at->diffForHumans() }}</small>
                </div>

                @foreach($threads as $thread)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                        <span>
                            <a href="{{ $thread->path() }}">{{$thread->title}}</a> by
                            <a href="{{ route('user_profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
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
        </div>
    </div>
@endsection