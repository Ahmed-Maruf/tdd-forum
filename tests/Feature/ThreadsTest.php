<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase
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
    
    public function test_a_user_can_view_threads()
    {
        $thread = factory(Thread::class)->create();
        $this->get('/threads')
             ->assertStatus(200)
             ->assertSee($thread->title);
    }
    
    public function test_a_user_can_view_single_thread()
    {
        $thread = factory(Thread::class)->create();
        
        $this->get('/threads/'.$thread->id)
             ->assertStatus(200)->assertSee($thread->title);
    }
    
}
