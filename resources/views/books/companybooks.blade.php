@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>🖌 사내 리뷰 리스트</h1>
            <br>
            <div class="row">
                @foreach ($company_books as $book)
                    <div class="col-md-2 mb-4">
                        <div class="book-card">
                            <img src="{{ $book->thumbnail }}" alt="{{ $book->title }}" class="img-fluid" style="max-height: 100px;">
                            <div class="book-details">
                                <h5 class="book-title">{{ $book->title }}</h5>
                                <p class="book-authors">{{ $book->authors }}</p>
                                <a href="/review/{{ $book->id }}" class="btn btn-success">자세히</a>
                            </div>
                        </div>
                    </div>
                    @if ($loop->iteration % 6 == 0)
                        <div class="w-100"></div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
