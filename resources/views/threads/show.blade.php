@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{$thread->title}}</a> by {{ $thread->creator->name }}
                    </div>
                    <div class="panel-body">
                        {{$thread->body}}
                    </div>
                </div>

                <?php $replies = $thread->replies()->paginate(1); ?>
                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }}

                @if( auth()->check() )
                    <form action="{{ $thread->path() }}/replies" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body"
                                      id="reply_body"
                                      class="form-control"
                                      placeholder="Have somthing to say?">
                            </textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-default">Post</button>
                        </div>
                    </form>
                @else
                    <p class="text-center">please <a href="{{ route('login') }}">sign in</a> to participate in this discussion</p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Meta
                    </div>
                    <div class="panel-body">
                        This thread was published {{ $thread->created_at->DiffForHumans() }} by <a href="#">{{ $thread->creator->name }}</a> and currently has {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                    </div>
                </div>

            </div>
        </div>


    </div>
@endsection
