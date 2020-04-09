<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
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
    
    public function test_an_authenticated_user_may_participate_in_forum_threads(){
        $this->withoutExceptionHandling();
        //Given we have authenticate user
        $user = factory('App\User')->create();
        $this->be($user);
        //And an existing thread
        $thread = factory('App\Thread')->create();
        
        //When the user adds a reply to the thread
        $reply = factory('App\Reply')->create(['thread_id' => $thread->id]);
        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());
        
        //Then their reply should be visible to the page
        
        $this->get($thread->path())->assertSee($reply->body);
    }
}
