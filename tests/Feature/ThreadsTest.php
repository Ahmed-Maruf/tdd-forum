<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
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
    
    public function test_a_user_can_view_threads()
    {
        
        $this->get('/threads')
             ->assertStatus(200)
             ->assertSee($this->thread->title);
    }
    
    public function test_a_user_can_view_single_thread()
    {
        $this->get("{$this->thread->path()}")
             ->assertStatus(200)->assertSee($this->thread->title);
    }
    
    public function test_a_user_can_read_replies_associated_with_a_thread()
    {
        $reply = factory(Reply::class)
            ->create(['thread_id' => $this->thread->id]);
        
        $this->get("{$this->thread->path()}")
             ->assertStatus(200)
             ->assertSee($reply->body);
    }
    
    public function test_an_auth_user_can_create_thread()
    {
        $this->withoutExceptionHandling();
        //Given a signed in user
        $this->signIn();
        
        
        //Create a thread
        $thread = make('App\Thread', ['user_id' => auth()->id()]);
        $this->post('/threads', $thread->toArray());
        //Visible in the thread page
        $this->get('/threads')
             ->assertSee($thread->title)
             ->assertSee($thread->body);
    }
    
    public function test_guest_may_not_create_thread()
    {
        $thread = make(Thread::class);
        $this->get('/threads/create')->assertRedirect('login');
        $this->post('/threads', $thread->toArray())
             ->assertRedirect(route('login'));
    }
    
    /**
     * @test
     */
    public function a_thread_requires_data()
    {
        
        $user   = $this->be(factory(User::class)->create());
        $thread = make('App\Thread',
            ['title' => null, 'body' => null, 'channel_id' => 9999]);
        $this->post('/threads', $thread->toArray())
             ->assertSessionHasErrors(['title', 'body', 'channel_id']);
    }
    
    /**
     * @test
     */
    
    public function a_user_can_filter_threads_via_channel()
    {
        $this->withoutExceptionHandling();
        $channel = factory(Channel::class)->create();
        
        $threadInChannel
                            = factory(Thread::class)->create(['channel_id' => $channel->id]);
        $threadNotInChannel = factory(Thread::class)->create();
        
        $this->get('threads/'.$channel->slug)
             ->assertSee($threadInChannel->title)
             ->assertDontSee($threadNotInChannel->title);
    }
    
    public function test_a_user_can_filter_threads_via_user()
    {
        $this->withoutExceptionHandling();
        
        $this->signIn(create(User::class, ['name' => 'Ahmed']));
        
        $channel       = create(Channel::class);
        $threadByAhmed = factory(Thread::class)->create([
            'user_id' => auth()->id(),
            'channel_id' => $channel->id,
        ]);
        
        $threadByOther = factory(Thread::class)->create([
            'channel_id' => $channel->id,
        ]);
        $this->get('/threads?by=Ahmed')
             ->assertSee($threadByAhmed->title)
             ->assertDontSee($threadByOther->title);
    }
    
}
