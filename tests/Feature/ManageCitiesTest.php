<?php

namespace Tests\Feature;

use App\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageCitiesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function all_cities_can_be_read()
    {
        $cities = factory(City::class, 10)->create();

        $this->get(route('cities.index'))
            ->assertSuccessful()
            ->assertJson($cities->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function a_single_city_can_be_accessed()
    {
        $city = factory(City::class)->create();

        $this->get(route('cities.show', $city))
            ->assertSuccessful()
            ->assertJson($city->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function a_city_can_be_created()
    {
        $data = [
            'name' => 'New York',
        ];

        $this->post(route('cities.store'), $data)
            ->assertCreated()
            ->assertJson($data);

        $this->assertDatabaseHas('cities', $data);
    }

    /**
     * @test
     * @return void
     */
    public function a_name_must_be_provided_when_creating_city()
    {
        $data = [];

        $this->json('POST', route('cities.store'), $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

        $this->assertDatabaseMissing('cities', $data);
    }

    /**
     * @test
     * @return void
     */
    public function a_city_can_be_updated()
    {
        $city = factory(City::class)->create();

        $data = [
            'name' => 'foo',
        ];

        $this->put(route('cities.update', $city), $data)
            ->assertSuccessful()
            ->assertJson($data);

        $this->assertDatabaseHas('cities', [
            'id' => $city->id,
            'name' => 'foo',
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function a_city_can_be_deleted()
    {
        $city = factory(City::class)->create();

        $this->delete(route('cities.destroy', $city))
            ->assertSuccessful()
            ->assertJson([
                'status' => 'deleted'
            ]);

        $this->assertDatabaseMissing('cities', $city->toArray());
    }
}
