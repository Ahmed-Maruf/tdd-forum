@php
    /** @var TYPE_NAME $thread */
$replies = $thread->replies()->paginate(1);
@endphp

@foreach($replies as $reply)
    <div class="card-header">
        <a href="">{{ $reply->user->name }}</a> said {{ $reply->created_at->diffForHumans() }}
    </div>

    <div class="card-body">
        <div class="body">{{ $reply->body }}</div>
    </div>

    <hr>
@endforeach

{{$replies->links()}}
