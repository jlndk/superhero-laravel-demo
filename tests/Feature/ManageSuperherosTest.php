<?php

namespace Tests\Feature;

use App\Superhero;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageSuperherosTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function all_superheroes_can_be_read()
    {
        $superheroes = factory(Superhero::class, 10)->create();

        $this->get(route('superheroes.index'))
            ->assertSuccessful()
            ->assertJson($superheroes->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function a_single_superhero_can_be_accessed()
    {
        $superhero = factory(Superhero::class)->create();

        $this->get(route('superheroes.show', $superhero))
            ->assertSuccessful()
            ->assertJson($superhero->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function a_superhero_can_be_created()
    {
        $data = [
            'name' => 'Batman',
            'alter_ego' => 'Bruce Wayne',
            'first_appeared' => 1500,
        ];

        $this->post(route('superheroes.store'), $data)
            ->assertCreated()
            ->assertJson($data);

        $this->assertDatabaseHas('superheroes', $data);
    }

    /**
     * @test
     * @return void
     */
    public function a_name_must_be_provided_when_creating_superhero()
    {
        $data = [
            'alter_ego' => 'Bruce Wayne',
            'first_appeared' => 1500,
        ];

        $this->json('POST', route('superheroes.store'), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

        $this->assertDatabaseMissing('superheroes', $data);
    }

    /**
     * @test
     * @return void
     */
    public function an_alter_ego_must_be_provided_when_creating_superhero()
    {
        $data = [
            'name' => 'Batman',
            'first_appeared' => 1500,
        ];

        $this->json('POST', route('superheroes.store'), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['alter_ego']);

        $this->assertDatabaseMissing('superheroes', $data);
    }

    /**
     * @test
     * @return void
     */
    public function first_appeared_must_be_provided_when_creating_superhero()
    {
        $data = [
            'name' => 'Batman',
            'alter_ego' => 'Bruce Wayne',
        ];

        $this->json('POST', route('superheroes.store'), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['first_appeared']);

        $this->assertDatabaseMissing('superheroes', $data);
    }

    /**
     * @test
     * @return void
     */
    public function a_superhero_can_be_updated()
    {
        $superhero = factory(Superhero::class)->create();

        $data = [
            'name' => 'foo',
            'alter_ego' => 'bar',
            'first_appeared' => 2000,
        ];

        $this->put(route('superheroes.update', $superhero), $data)
            ->assertSuccessful()
            ->assertJson($data);

        $this->assertDatabaseHas('superheroes', [
            'id' => $superhero->id,
            'name' => 'foo',
            'alter_ego' => 'bar',
            'first_appeared' => 2000,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function a_superhero_can_be_deleted()
    {
        $superhero = factory(Superhero::class)->create();

        $this->delete(route('superheroes.destroy', $superhero))
            ->assertSuccessful()
            ->assertJson([
                'status' => 'deleted'
            ]);

        $this->assertDatabaseMissing('superheroes', $superhero->toArray());
    }
}
