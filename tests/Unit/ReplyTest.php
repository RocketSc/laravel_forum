<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_an_owner() : void
    {
        $reply = factory(Reply::class)->create();

        $this->assertInstanceOf(User::class, $reply->owner);
    }

}
