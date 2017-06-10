<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Thread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store($channelId, Thread $thread) : RedirectResponse
    {

        $this->validate(request(), [
            'body' => 'required',
        ]);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),

        ]);

        return redirect($thread->path());
    }
}
