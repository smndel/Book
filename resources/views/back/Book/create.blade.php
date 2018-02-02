@extends('layouts.master')

@section('content')

<h1>Create Book :</h1>
<form action="{{route('book.store')}}" method="post" enctype="multipart/form-data">
    <!-- Token de sécurité : -->
    {{csrf_field()}}

<div class="col-md-6">

    <div class="form-group">
    <label for="inputPassword2">Titre :</label>
      <input type="text" class="form-control" placeholder="Titre du livre" id="title" name="title" value="{{old('title')}}">
      @if($errors->has('title'))
      <span class="error" style="color : red;">
        {{$errors->first('title')}}
      </span>
      @endif
    </div>

    <div class="form-group">
    <label for="inputPassword3">Description :</label>
      <textarea type="textarea" class="form-control" id="description" name="description" value="{{old('description')}}"></textarea>
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
        <option value="{{$id}}" @if(old('genre_id') == $id) {{'selected'}} @endif>{{$genre}}</option>
        @empty
        @endforelse
    </select>
    </div>

<h2>Choisissez un/des auteurs :</h2>

        <div class="form-group">
        @forelse($authors as $id =>$name)
        <label class="control-label" >{{$name}}</label>
        <input 
        name="authors[]" 
        type="checkbox" 
        value="{{$id}}" 
        id="author{{$id}}" 
        {{ ( !empty(old('authors')) and in_array($id, old('authors')) )? 'checked' : ''  }}>

        @empty
        @endforelse
        </div>
</div>

<div class="col-md-6">

<button type="submit" href="{{route('book.store')}}" class="col-md-6">Ajouter un livre</button></br>
        
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
    </div>

</div>

</form>
  


@endsection