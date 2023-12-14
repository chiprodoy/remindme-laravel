<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\DBTestCase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    private $user;


    /**
     * @test
     * test if can create user
     *
     */
    public function canCreateUserSeeder()
    {
        // Run user seeder...
        $this->seed(UserSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'alice@mail.com'
        ]);
    }

    /**
     * @test
     * test if can create user
     *
     */
    public function canReadEncryptPassword()
    {
        $this->seed(UserSeeder::class);

        $this->user=User::where('email','alice@mail.com')->first();
        $this->assertTrue(Hash::check('123456',$this->user->password));
    }

    /**
     * @test
     * test if user modal use soft delete
     */
    public function userModelUsingSoftDelete()
    {
        $user=User::factory()->create([
            'name' => 'test',
            'email' => 'test@mail.com',
        ]);
        $user->delete();

        $this->assertSoftDeleted($user);
    }
}
