<?php

namespace Tests\Feature;

use App\Repositories\PlayerRepositoryInterface;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class PlayerControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index_displays_players()
    {
    /** @var MockInterface|PlayerRepositoryInterface $mockRepo */
        $mockRepo = Mockery::mock(PlayerRepositoryInterface::class);
        $mockRepo->shouldReceive('all')->andReturn(collect([]));

        // Injeção do mock no container do Laravel
        $this->app->instance(PlayerRepositoryInterface::class, $mockRepo);

        // Chamada do endpoint
        $response = $this->get(route('players.index'));

        // Assertivas
        $response->assertStatus(200);
        $response->assertViewIs('players.index');
        $response->assertViewHas('players');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close(); // Limpar o Mockery após cada teste
    }
}
