@extends('layouts.master')

@section('content')
<h1>{{$genre->name}}</h1>

<ul class="list-group">
    {{$books->links()}}
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

        <h3>Les autres Auteurs :</h3>
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