<?php

namespace Tests\Feature;

use App\Activity;
use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    private $thread;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
        $this->thread = create(Thread::class);
    }

    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $this->thread->id,
            'subject_type' => Thread::class
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $this->thread->id);
    }
    
    /** @test */
    public function it_records_activity_when_a_reply_is_created() : void
    {
       $reply = create(Reply::class, ['thread_id' => $this->thread->id]);

       $this->assertEquals(2, Activity::count());
    }
}