<?php

namespace Tests\Feature\Restapi;

use App\Enum\HttpStatus;
use Database\Seeders\UserSeeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private $targetEndpoint='/api/session';

    private $validEmail='alice@mail.com';

    private $validPassword='123456';

    private $inValidEmail='sally@mail.com';

    private $inValidPassword='sally123';


    /**
     * @test
     * */
    public function endPointLoginIsExist(){

        $response = $this->postJson($this->targetEndpoint);

        $this->assertTrue($response->status()!=HttpStatus::NOTFOUND);
    }

         /** @test */
         public function canLoginWithCorrectCredentials()
         {
            $this->seed(UserSeeder::class);

             $response = $this->postJson($this->targetEndpoint,[
                 'email' => $this->validEmail,
                 'password' => $this->validPassword,
             ]);

             $response->assertStatus(HttpStatus::SUCCESS)
            ->assertJsonStructure([
                'ok','data'=>['user','access_token']
            ]);
         }
    /**
    * @test
    *
    */
    public function cannotLoginWithWrongEmail()
    {
        // make request to auth endpoint
        $response = $this->postJson($this->targetEndpoint, [
            'email' => $this->inValidEmail,
            'password'=>$this->validPassword
        ]);

        //assert response from endpoint
        $response->assertStatus(HttpStatus::UNAUTHORIZED)
        ->assertJsonStructure([
            'ok','err','msg'
        ]);

    }

    /**
    * @test
    *
    */

    public function cannotLoginWithWrongPassword()
    {
       // make request to auth endpoint
        $response = $this->postJson($this->targetEndpoint, [
            'email' => $this->validEmail,
            'password'=>$this->inValidPassword
        ]);

        //assert response from endpoint
        $response->assertStatus(HttpStatus::UNAUTHORIZED)
        ->assertJsonStructure([
            'ok','err','msg'
        ]);
    }

    /**
     * @test
     *
     * */
    public function emailCanNotBeEmpty()
    {
       // make request to auth endpoint
        $response = $this->postJson($this->targetEndpoint, [
            'email' => '',
            'password'=>$this->validPassword
        ]);

        //assert response from endpoint
        $response->assertStatus(HttpStatus::VALIDATIONERROR)
        ->assertJsonStructure([
            'ok','err','msg'
        ]);
    }

    /**
    * @test
    */
    public function passwordCanNotBeEmpty()
    {
       // make request to auth endpoint
        $response = $this->postJson($this->targetEndpoint, [
            'email' => $this->validEmail,
            'password'=>''
        ]);

        //assert response from endpoint
        $response->assertStatus(HttpStatus::VALIDATIONERROR)
        ->assertJsonStructure([
            'ok','err','msg'
        ]);
    }

}
