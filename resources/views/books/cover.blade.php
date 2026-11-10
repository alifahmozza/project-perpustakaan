{{-- Pemakaian: @include('books._cover', ['book' => $book]) --}}
<div class="cover">
    @if (!empty($book->sampul))
        <img src="{{ asset('storage/' . $book->sampul) }}" alt="Sampul {{ $book->judul }}" loading="lazy">
    @else
        <div class="cover-fallback" style="--h: {{ abs(crc32($book->judul)) % 360 }}">
            <span class="t">{{ $book->judul }}</span>
            <span class="a">{{ $book->penulis }}</span>
        </div>
    @endif
</div>