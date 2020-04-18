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
     * @test
     */
    
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->withoutExceptionHandling();
        //Given we have authenticate user
        $user = factory('App\User')->create();
        $this->be($user);
        //And an existing thread
        $thread = factory('App\Thread')->create();
        
        //When the user adds a reply to the thread
        $reply = factory('App\Reply')->make();
        $this->post("{$thread->path()}/replies", $reply->toArray());
        
        //Then their reply should be visible to the page
        
        $this->get($thread->path())->assertSee($reply->body);
    }
    
    /**
     * @test
     */
    
    public function a_reply_requires_a_body()
    {
        //Given we have authenticate user
        $user = factory('App\User')->create();
        $this->be($user);
        //And an existing thread
        $thread = factory('App\Thread')->create();
        
        //When the user adds a reply to the thread
        $reply = factory('App\Reply')->make([
            'body' => null,
        ]);
        $this->post("{$thread->path()}/replies", $reply->toArray())
             ->assertSessionHasErrors('body');
    }
    
}
