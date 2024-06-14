@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Edit Review</h1>

            <form method="POST" action="{{ route('reviews.update', $review->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $review->title }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ $review->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="review">Review</label>
                    <textarea class="form-control" id="review" name="review">{{ $review->review }}</textarea>
                </div>
                <div class="form-group">
                    <label>Share with</label>
                    <div>
                        <input type="checkbox" id="sharedWithMyLibrary" name="shared_with[]" value="my_library" {{ in_array('my_library', explode(',', $review->shared_with)) ? 'checked' : '' }}>
                        <label for="sharedWithMyLibrary">My Library</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="sharedWithCompanyLibrary" name="shared_with[]" value="company_library" {{ in_array('company_library', explode(',', $review->shared_with)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="sharedWithCompanyLibrary">Company Library</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
