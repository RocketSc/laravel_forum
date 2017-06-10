<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @var  Thread*/
    private $thread;

    /** @var Reply */
    private $reply;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create(Thread::class);

        $this->reply = create(Reply::class, ['thread_id' => $this->thread->id]);
    }

    /** @test  */
   public function a_user_can_browse_all_threads() : void
    {
        $this->get('/threads')
             ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread() : void
    {
        $this->get( $this->thread->path() )
            ->assertSee($this->thread->body);
    }
    
    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread() : void
    {
        $this->get( $this->thread->path() )
             ->assertSee($this->reply->body);
    }

    /** @test */
    public function a_user_can_see_author_of_reply() : void
    {
        $this->get( $this->thread->path() )
             ->assertSee($this->reply->owner->name);
    }

    /** @test */
    public function a_user_can_see_author_of_thread() : void
    {
        $this->get( $this->thread->path() )
             ->assertSee($this->thread->creator->name);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel() : void
    {
        $channel = create(Channel::class);

        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(Thread::class);

        $this->get('/threads/' . $channel->slug)
             ->assertSee($threadInChannel->title)
             ->assertDontSee($threadNotInChannel->title);
    }
    
    /** @test */
    public function a_user_can_filter_threads_by_any_username() : void
    {
        $this->signIn(create(User::class, ['name' => 'JohnDoe']));

        $threadByJohn = create(Thread::class, ['user_id' => auth()->id()]);
        $threadNotByJohn = create(Thread::class);

        $this->get('/threads?by=JohnDoe')
             ->assertSee($threadByJohn->title)
             ->assertDontSee($threadNotByJohn->title);
    }
}
