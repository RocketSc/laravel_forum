<div class="panel panel-default">
    <div class="level">
        <div class="panel-heading">
            <a href="{{ route('user_profile', $reply->owner) }}">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}...
        </div>
        <div>
            <form method="post" action="{{ route('favorite_reply', $reply->id) }}">
                {{ csrf_field() }}
                <button class="btn btn-default" {{ $reply->isFavored() ? 'disabled' : ''}}>
                    {{ $reply->favorites_count }}
                    {{ str_plural('Favorite', $reply->favorites_count) }}
                </button>
            </form>
        </div>
    </div>

    <div class="panel-body">
        {{$reply->body}}
    </div>
</div>

