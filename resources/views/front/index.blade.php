@extends('layouts.master')

@section('content')
<h1>Tous les livres</h1>
{{$books->links()}}
<ul class="list-group">
    @forelse($books as $book)
    <li class="list-group-item">
        <h2><a href="{{url('book', $book->id)}}">{{$book->title}}</a></h2>
        <div class="row">
            
            <div class="img-thumbnail col-md-4" style="margin-left: 10px">
            
                <a href="{{url('book', $book->id)}}">
                <div class="text-center">
                @if(count($book->picture)>0)
                <img class="" src="{{url('images', $book->picture->link)}}">
                @endif
                </a>
                </div>
            </div>
            <p class="col-md-7" >{{$book->description}}</p>
        </div>

        <p> La note moyenne est de : {{round($book->avgVotes(),2)}}</p>

        <h3>Genre :</h3>
            <ul>
                <li><a href="{{url('genre', $book->genre->id)}}">{{$book->genre->name}}</a></li>
            </ul>

        <h3>Auteurs :</h3>
            <ul>
                @forelse($book->authors as $author)
                <li><a href="{{url('author', $author->id)}}">{{$author->name}}</a></li>
                @empty
                @endforelse
            </ul>
    </li>
@empty
@endforelse
</ul>

@endsection