<?php

namespace Tests\Unit;

use App\Thread;
use App\User;
use App\Channel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Collection;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    private $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }
    
    /** @test */
    public function a_thread_can_make_a_string_path() : void
    {
        $this->assertEquals('/threads/' . $this->thread->channel->slug . '/' . $this->thread->id,
                            $this->thread->path()
        );
    }

    /** @test */
    public function a_thread_has_creator() : void
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }
    
    /** @test */
    public function a_thread_has_replies() : void
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    public function a_thread_can_add_a_reply() : void
    {
        $this->thread->addReply([
            'body' => 'foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }
    
    /** @test */
    public function a_thread_belongs_to_a_channel() : void
    {
        $this->assertInstanceOf(Channel::class, $this->thread->channel);
    }
}
