<?php

namespace Tests\Feature;

use App\Channel;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChannelTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_consists_of_threads()
    {
        $channel = create(Channel::class);

        $this->assertInstanceOf(Collection::class, $channel->threads);
    }
}
