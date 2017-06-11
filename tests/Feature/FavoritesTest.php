<?php

namespace Tests\Feature;

use App\Reply;
use Exception;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @var  Reply */
    private $reply;

    public function setUp()
    {
        parent::setUp();

        $this->reply = factory(Reply::class)->create();
    }
    
    /** @test */
    public function guests_can_not_favorite_anything() : void
    {
        $this->withExceptionHandling()
             ->post(route('favorite_reply', $this->reply))
             ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply() : void
    {
        $this->signIn();

        $this->post(route('favorite_reply', $this->reply));

        $this->assertCount(1, $this->reply->favorites);
    }
    
    /** @test */
    public function a_user_can_not_favorite_a_reply_more_than_once() : void
    {
        $this->signIn();

        try {
            $this->post(route('favorite_reply', $this->reply));
            $this->post(route('favorite_reply', $this->reply));
        } catch (Exception $e) {
            $this->fail('Did not expect to insert the same record set twice.');
        }

        $this->assertCount(1, $this->reply->favorites);

    }
}