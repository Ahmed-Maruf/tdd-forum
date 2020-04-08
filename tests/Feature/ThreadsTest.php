<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    
    use DatabaseMigrations;
    
    public $thread;
    
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        
        $this->thread = factory(Thread::class)->create();
        
    }
    
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
        
        $this->get('/threads')
             ->assertStatus(200)
             ->assertSee($this->thread->title);
    }
    
    public function test_a_user_can_view_single_thread()
    {
        
        $this->get('/threads/'.$this->thread->id)
             ->assertStatus(200)->assertSee($this->thread->title);
    }
    
    public function test_a_user_can_read_replies_associated_with_a_thread()
    {
        $reply = factory(Reply::class)
            ->create(['thread_id' => $this->thread->id]);
        
        $this->get('/threads/'.$this->thread->id)
             ->assertSee($reply->body);
    }
    
}
