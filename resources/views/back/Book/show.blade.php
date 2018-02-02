@extends('layouts.master')

@section('content')

<div class="col-md-6"> 
    <h1>Title : <i>{{$book->title}}</i></h1>

    @if(isset($book->genre->name))
    <p><strong>Genre : </strong>{{$book->genre->name}}</p> 
    @else
    <p><strong>Genre : </strong>No genre</p> 
    @endif

    <p><strong>Date de création : </strong>{{$book->created_at}}</p> 

    <p><strong>Date de mise à jour : </strong>{{$book->updated_at}}</p> 
    
    <p><strong>Status : </strong>{{$book->status}}</p>

    <!--<h3>Description :</h3>
        <p>{{$book->description}}</p>

        <h3> La note moyenne est de :</h3> 
        <p>{{round($book->avgVotes(),2)}}</p> -->

     <h2>Les auteurs :</h2>
        <ul>
            <li><strong>Nombre d'auteur(s) : </strong>{{count($book->authors)}}</li>
            @forelse($book->authors as $author)
            <li>{{$author->name}}</li>
            @empty
            @endforelse
        </ul>


</div>


<div class="col-md-6"> 
    
    <h2>Image :</h2>
        @if(isset($book->picture->link))
        <img src="{{url('images', $book->picture->link)}}">
        @else
        <p>Pas d'image</p>
        @endif
</div>

        


                   
        


@endsection