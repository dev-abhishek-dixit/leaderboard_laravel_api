<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

/**
 * UserTest
 * 
 * @package    Tests\Feature
 * @subpackage Feature
 * @author     Abhishek Dixit<abhishekdixit342@gmail.com>
 */
class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_list(): void
    {
        $response = $this->getJson('api/user');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'age',
                    'points',
                    'address',
                ]
            ],
            'msg'
        ]);

    }

    public function test_create(): void
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'age' => $this->faker->numberBetween(18, 60),
            'points' => $this->faker->numberBetween(0, 100),
            'address' => $this->faker->address,
        ];
        $response = $this->postJson('api/user', $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'age',
                'points',
                'address',
            ]
        ]);
    }

    public function test_update(): void
    {
        $user = User::factory()->create();
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'age'=> $this->faker->numberBetween(18, 60),
            'points' => $this->faker->numberBetween(0, 100),
            'address' => $this->faker->address,
        ];
        $response = $this->putJson('api/user/' . $user->id, $data);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' =>[
                '*'=> [
                'id',
                'name',
                'email',
                'age',
                'points',
                'address',
            ]
            ]   
        ]);
        unset($data['points']);
        $response2 = $this->putJson('api/user/' . $user->id, $data);
        $response2->assertStatus(200);
        $response2->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'age',
                'points',
                'address',
            ]
        ]);


    }
    public function test_delete(): void
    {
        $user = User::factory()->create();
        $response = $this->deleteJson('api/user/' . $user->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'status'
        ]);
    }

    public function test_group_points(): void
    {
        $response = $this->getJson('api/user/group-points');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'average_age',
                    'names'
                ]
            ],
            'message'
        ]);
    }

    public function test_reset_points_command(): void
    {
        $this->artisan('app:reset-users-point')
            ->expectsOutput('All users points have been reset to 0.')
            ->assertExitCode(0);
    }

}
