<?php

namespace Tests\Feature;

use \App\Reply;
use \App\Thread;
use \App\User;
use \Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @var  Thread */
    private $thread;

    /** @var  Reply */
    private $reply;

    public function setUp() : void
    {
        parent::setUp();
        $this->thread = create(Thread::class);
        $this->reply = make(Reply::class);
    }

    /** @test */
    public function an_authenticated_user_may_add_replies() : void
    {
        $this->signIn();

        $this->post($this->thread->path() . '/replies', $this->reply->toArray());

        $this->get($this->thread->path())
             ->assertSee($this->reply->body);
    }

    /** @test */
    public function unauthenticated_user_may_not_add_replies() : void
    {
        $this->withExceptionHandling()
             ->post('/threads/some-slug/1/replies', [])
             ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_reply_requires_a_body() : void
    {
        $this->signIn();

        $emptyReply = make(Reply::class, ['body' => null]);

        $this->withExceptionHandling()
             ->post($this->thread->path() . '/replies', $emptyReply->toArray())
             ->assertSessionHasErrors('body');
    }
}
