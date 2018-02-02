@extends('layouts.master')

@section('content')

<div class='row' style='margin-left: auto;'>
<a href="{{route('book.create')}}"><button>Ajouter un livre</button></a>
</div>

{{$books->links()}}

<!-- Affichage d'un message de succès -->
@include('back.Book.partials.flash')

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Title</th>
      <th scope="col">Authors</th>
      <th scope="col">Genre</th>
      <th scope="col">Date de publication</th>
      <th scope="col">Status</th>
      <th scope="col">Edition</th>
      <th scope="col">Show</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>


    @forelse($books as $book)
    <tr>
      <td>{{$book->title}}</td>

      <td>
      @forelse($book->authors as $author)
      {{$author->name}}
      @empty
      @endforelse
      </td>
      
      @if(isset($book->genre->name))
      <td>{{$book->genre->name}}</td>
      @else
      <td>{{$book->genre_id}}</td>
      @endif
      <td>{{$book->created_at}}</td>
      
        @if($book->status== 'published')
        <td style="color:green">
        {{$book->status}}
        </td>
        @else
        <td style="color:red">
        {{$book->status}}
        </td>
        @endif




      
      <td><a href="{{route('book.show', $book->id)}}">voir</a></td>
      <td><a href="{{route('book.edit', $book->id)}}">Editer</a></td>
      <td>
        <form class="delete" action="{{route('book.destroy', $book->id)}}" method="POST">
          <input type="hidden" name="_method" value="DELETE">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <input type="submit" value="Delete" style="background-color: #B35935; color: white;">
        </form>
      </td>
    </tr>
    @empty
    @endforelse

  </tbody>
</table>
{{$books->links()}}

<!-- Pour affichage du message de confirmation de suppression d'un livre -->
@section('scripts')
    @parent
    <script src="{{asset('js/confirm.js')}}"></script>
@endsection
@endsection