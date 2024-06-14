@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $review->title }}</h1>
            <img src="{{ $review->thumbnail }}" alt="{{ $review->title }}" class="img-thumbnail" style="max-height: 300px;">

            <p><strong>Authors:</strong> {{ $review->authors ?? 'Not available' }}</p>
            <p><strong>Categories:</strong> {{ $review->categories ?? 'Not available' }}</p>

            <p>{{ $review->description }}</p>

            <p><strong>Review:</strong></p>
            <p>{{ $review->review }}</p>

            <a href="{{ route('books.companyLibrary') }}" class="btn btn-success">Home</a>
            <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
