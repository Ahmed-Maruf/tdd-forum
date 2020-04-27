@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a new thread</div>

                    <div class="card-body">
                        <form action="/threads" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="channel_id">Select a channel</label>
                                <select class="form-control" name="channel_id" id="channel_id">
                                    <option value="">Choose one...</option>
                                    @foreach($channels as $channel)
                                        <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected' : ''}}>
                                            {{$channel->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Thread Title</label>
                                <input type="text" class="form-control" id="title" placeholder="Enter title" name="title" value="{{old('title')}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Body</label>
                                <textarea name="body" class="form-control" id="exampleFormControlTextarea1" rows="3">{{old('body')}}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Publish</button>
                        </form>
                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
