@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>📌 마이 리뷰 리스트</h1>
            <br>
            <button class="btn btn-success" id="toggleReviewModalButton">글쓰기</button>

            <div class="modal" id="reviewModal" style="display: none;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        @include('reviews.create')
                    </div>
                </div>
            </div>

            <div id="selectedBookInfo" class="mt-3" style="display: none;">
                <h5>Selected Book:</h5>
                <img id="selectedBookInfoThumbnail" class="img-thumbnail" style="max-height: 100px;">
                <h5 id="selectedBookInfoTitle"></h5>
                <h5 id="selectedBookInfoAuthors"></h5>
                <h5 id="selectedBookInfoCategories"></h5>
            </div>

            <div class="row mt-3">
                @foreach ($my_books as $book)
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

<script>
    document.getElementById('toggleReviewModalButton').addEventListener('click', function() {
        const reviewModal = document.getElementById('reviewModal');
        reviewModal.style.display = 'block';
    });

    document.getElementById('closeReviewModalButton').addEventListener('click', function() {
        document.getElementById('reviewModal').style.display = 'none';
    });

    document.getElementById('closeSearchModalButton').addEventListener('click', function() {
        document.getElementById('searchModal').style.display = 'none';
    });

    function searchBook() {
        const keyword = document.getElementById('keyword').value;
        axios.get(`/api/books?keyword=${encodeURIComponent(keyword)}`)
            .then(response => {
                const books = response.data.data;
                const resultsDiv = document.getElementById('searchResults');
                resultsDiv.innerHTML = '';

                books.forEach(book => {
                    const bookDiv = document.createElement('div');
                    bookDiv.classList.add('book-result');
                    bookDiv.innerHTML = `
                        <img src="${book.thumbnail}" alt="${book.title}" class="img-thumbnail" style="max-height: 100px;">
                        <h5>${book.title}</h5>
                        <p>${book.description}</p>
                        <p><strong>Authors:</strong> ${book.authors.join(', ')}</p>
                        <p><strong>Categories:</strong> ${book.categories.join(', ')}</p>
                        <button class="btn btn-primary" onclick="selectBook('${book.id}', '${encodeURIComponent(book.title)}', '${book.thumbnail}', '${encodeURIComponent(book.description)}', '${encodeURIComponent(book.authors.join(', '))}', '${encodeURIComponent(book.categories.join(', '))}')">Select</button>
                    `;
                    resultsDiv.appendChild(bookDiv);
                });
            });
    }

    function selectBook(id, title, thumbnail, description, authors, categories) {
        document.getElementById('book_id').value = id;
        document.getElementById('title').value = decodeURIComponent(title);
        document.getElementById('thumbnail').value = thumbnail;
        document.getElementById('description').value = decodeURIComponent(description);
        document.getElementById('authors').value = decodeURIComponent(authors);
        document.getElementById('categories').value = decodeURIComponent(categories);

        // Display selected book information in the modal
        document.getElementById('selectedBook').style.display = 'block';
        document.getElementById('selectedBookThumbnail').src = thumbnail;
        document.getElementById('selectedBookTitle').innerText = decodeURIComponent(title);
        document.getElementById('selectedBookAuthors').innerText = decodeURIComponent(authors);
        document.getElementById('selectedBookCategories').innerText = decodeURIComponent(categories);

        // Hide search results
        document.getElementById('searchResults').innerHTML = '';
    }

    function displaySelectedBookInfo() {
        // Display selected book information outside the modal
        document.getElementById('selectedBookInfo').style.display = 'block';
        document.getElementById('selectedBookInfoThumbnail').src = document.getElementById('thumbnail').value;
        document.getElementById('selectedBookInfoTitle').innerText = document.getElementById('title').value;
        document.getElementById('selectedBookInfoAuthors').innerText = document.getElementById('authors').value;
        document.getElementById('selectedBookInfoCategories').innerText = document.getElementById('categories').value;
    }
</script>
@endsection
