<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads() : void
    {
        $this->signIn();

        $thread = make(Thread::class);

        $response = $this->post('/threads', $thread->toArray() );

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function guests_may_not_create_threads() : void
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
             ->assertRedirect(route('login'));

        $this->post('/threads')
             ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_thread_requires_a_title() : void
    {
        $this->publishThread(['title' => null])
             ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel() : void
    {
        factory(Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function a_thread_requires_a_body() : void
    {
        $this->publishThread(['body' => null])
             ->assertSessionHasErrors('body');
    }

    private function publishThread(array $overrides) : TestResponse
    {
        $this->signIn();

        $thread = make(Thread::class, $overrides);

        return $this->withExceptionHandling()
            ->post('/threads', $thread->toArray());
    }
}
