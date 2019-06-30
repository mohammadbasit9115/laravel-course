@extends('layout')

@section('content')
<div class="row">
    <div class="col-8">
        @if($post->image)
        <div
            style="background-image: url('{{ $post->image->url() }}'); min-height: 500px; color: white; text-align: center; background-attachment: fixed;">
            <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
                @else
                <h1>
                    @endif
                    {{ $post->title }}
                    @badge(['show' => now()->diffInMinutes($post->created_at) < 30]) {{ __('Brand new Post!') }}
                        @endbadge @if($post->image)
                </h1>
        </div>
        @else
        </h1>
        @endif

        <p>{{ $post->content }}</p>

        @updated(['date' => $post->created_at, 'name' => $post->user->name])
        @endupdated
        @updated(['date' => $post->updated_at])
        {{ __('Updated') }}
        @endupdated

        @tags(['tags' => $post->tags])@endtags

        <p>{{ trans_choice('messages.people.reading', $counter) }}</p>

        <h4>{{ __('Comments') }}</h4>

        {{-- @commentForm(['route' => route('posts.comments.store', ['post' => $post->id])])
        @endcommentForm --}}

        @auth
        <comment-form url="{{ route('posts.comments.store', ['post' => $post->id]) }}"
            submit-label="{{ __('Add comment') }}" :user="{{ Auth::user() }}" :post={{ $post->id }}></comment-form>
        @else
        <a href="{{ route('login') }}">{{ __('Sign-in') }}</a> {{ __('to post comments!') }}
        @endauth

        <hr />

        {{-- @commentList(['comments' => $post->comments])
        @endcommentList --}}

        <comment-list :post="{{ $post->id }}"></comment-list>
    </div>
    <div class="col-4">
        @include('posts._activity')
    </div>
    @endsection('content')