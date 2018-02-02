@extends('layouts.master')

@section('content')
 <h1>{{$book->title}}</h1>
       
        <div class="col-md-12 img-thumbnail" style="margin-left: 5px">

            <div class="text-center">
            @if(count($book->picture)>0)
            <img src="{{url('images', $book->picture->link)}}">
            @endif
            </div>

        </div>

        <h2>Description :</h2>
        <p>{{$book->description}}</p>

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

        <h3>Voter pour ce livre</h3>

        <!-- POur afficher un message d'error sur n'importe quelles erreurs du formulaire -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        <!-- Relation avec la route defini dans wep.php -->
        <form action="{{route('vote')}}" method="post">
        <!-- Token de vérification -->
        {{csrf_field()}}
        <select class="custom-select" name="vote" style='height: 33px' >
          <option selected value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="2">4</option>
          <option value="3">5</option>
        </select>
        <!-- On défini des input invisible pour récupérer vaec le formulaire les book_id et l'ip -->
        <input name="book_id" type="hidden" value="{{$book->id}}">
        <input name="ip" type="hidden" value="{{request()->ip()}}">
        <button type="submit" class="btn btn-default">Ok</button>
        </form>

        <!-- Pour afficher le message de bonne prise en compte du vote, définie dans le controller -->
        @if(Session::has('message'))
            <div class="alert">
                <p>{{Session::get('message')}}</p>
            </div>
        @endif

</div> 
@endsection