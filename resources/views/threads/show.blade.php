@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->owner->name }}</a> Posted: {{ $thread->title }}</div>

                    <div class="card-body">
                        <div class="body">{{ $thread->body }}</div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @include('threads.replies')
                </div>
            </div>
        </div>
    </div>
@endsection
