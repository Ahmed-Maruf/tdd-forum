<?php

namespace Tests\Feature;

use App\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_guest_can_not_favorite_anything(){
        $this->post("/replies/1/favorites")->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_make_a_reply_favorite(){
        $this->withoutExceptionHandling();
        $this->signIn();
        $reply = create(Reply::class);

        $this->post("/replies/{$reply->id}/favorites");

        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_authenticated_user_can_make_a_reply_favorite_only_once(){
        $this->withoutExceptionHandling();
        $this->signIn();
        $reply = create(Reply::class);

        try {
            $this->post("/replies/{$reply->id}/favorites");
            $this->post("/replies/{$reply->id}/favorites");
        }catch (\Exception $e){
            $this->fail('Did not expect to have more then one favorites on the same set');
        }

        $this->assertCount(1, $reply->favorites);
    }


}
