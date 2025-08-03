@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white">{{ __('My Bookmarks') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($bookmarks->count() > 0)
                        <div class="list-group">
                            @foreach($bookmarks as $bookmark)
                                <a href="{{ $bookmark->url }}" class="list-group-item list-group-item-action" target="_blank">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $bookmark->title }}</h5>
                                        <small>{{ $bookmark->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1">{{ $bookmark->description }}</p>
                                    <small class="text-white">Click to open</small>
                                </a>
                            @endforeach
                        </div>
                        
                        <div class="mt-3">
                            {{ $bookmarks->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-white">
                            {{ __('You have no bookmarks yet.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
