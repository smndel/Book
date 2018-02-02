@extends('layouts.master')

@section('content')

<h1>Edit Book :</h1>
<form action="{{route('book.update', $book)}}" method="post" enctype="multipart/form-data">
    {{method_field('PUT')}}
    {{csrf_field()}}


<div class="col-md-6">

    <div class="form-group">
    <label for="title">Titre :</label>
      <input type="text" class="form-control" id="title" name="title" value="{{$book->title}}">
      @if($errors->has('title'))
      <span class="error" style="color : red;">
        {{$errors->first('title')}}
      </span>
      @endif
    </div>



    <div class="form-group">
    <label for="description">Description :</label>
      <textarea type="textarea" class="form-control" id="description" name="description" value="{{$book->description}}">{{$book->description}}</textarea>
      @if($errors->has('description'))
      <span class="error" style="color : red;">
        {{$errors->first('description')}}
      </span>
      @endif
    </div>

    <div class="form-group">
    <label for="exampleFormControlSelect1">Genre :</label>
    <select class="form-control" id="genre_id" name="genre_id">    
        
        <option value="0">No Genre</option>
        @forelse($genres as $id => $genre)  
        <option value="{{$id}}"
            @if(($id)==$book->genre_id)) selected='selected' @endif
        >{{$genre}}</option>
        @empty
        @endforelse
    </select>
    </div>

<h2>Choisissez un/des auteurs :</h2>

        <div class="form-group">
        @forelse($authors as $id =>$name)
        <label class="control-label"></label>
        <input 
        name="authors[]" 
        type="checkbox" 
        value="{{$id}}" 
        id="author{{$id}}" 
        @forelse($book->authors as $author)
        @if(($id) == $author->id) checked @endif
        @empty 
        @endforelse
        >{{$name}}
        @empty
        @endforelse
        </div>
</div>

<div class="col-md-6">

<button type="submit" class="col-md-6">Editer un livre</button></br>
        
    <div class="input-radio">
        <h2>Status</h2>
        <input 
        type="radio" 
        @if(old('status')=='published') checked @endif 
        name="status" 
        value="published" 
        checked> publier<br>
        <input 
        type="radio" 
        @if(old('status')=='unpublished') checked @endif 
        name="status" value="unpublished"> dépublier<br>
    </div>

    <div class="col-md-12">
    <h2>File</h2>
    <input type="file" name="picture">
    @if(count($book->picture)>0)
    <img src="{{url('images', $book->picture->link)}}">
        @if($errors->has('picture'))
      <span class="error" style="color : red;">
        {{$errors->first('picture')}}
      </span>
        @endif
    @endif
    </div>

</div>

</form>
  


@endsection