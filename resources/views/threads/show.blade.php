@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->owner->name }}</a> Posted: {{ $thread->title }}</div>

                    <div class="card-body">
                        <div class="body">{{ $thread->body }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="body">This thread was published {{$thread->created_at->diffForHumans()}} by {{$thread->owner->name}}
                        and contain {{$thread->replyCount}} {{Str::plural('reply', $thread->replyCount)}}</div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    @include('threads.replies')
                </div>
                <hr>

                @if(auth()->check())

                    <form method="POST" action="{{$thread->path()}}/replies">
                        @csrf
                        <div class="form-group">
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="body"
                                              placeholder="Wanna say something?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">Sign in</a> to participate in this
                        forum</p>
                @endif
            </div>
        </div>
    </div>
@endsection
