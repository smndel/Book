<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Author; //importe pour la page author
use App\Genre;
use Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $books = Book::withoutGlobalScopes()->paginate(10);
        return view('back.book.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::pluck('name', 'id')->all();
        $genres = Genre::pluck('name', 'id')->all();

        return view('back.book.create', ['authors'=>$authors, 'genres'=>$genres]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Vérification des données envoyées
         $this->validate($request,
        [
            'title' => 'required',
            'description' => 'required|string',
            'genre_id' => 'integer',
            'authors' => 'array',
            'authors.*' => 'int',
            'status' => 'in:published,unpublished',
            'picture' => 'image|mimes:jpg,png,jpeg',
        ]);

        //hydratation des données du livre enregistré en base de données
        $book = Book::create($request->all());
        $book->authors()->attach($request->authors);

        $img = $request->file('picture');
        if(!empty($img)){

        //Méthode store retourne un link hash sécurisé
        $link = $request->file('picture')->store('./');
        //Mettre à jour la table picture pour le lien vers l'image dans la base de donnée
        $book->picture()->create([
        'link' => $link,
        // 'title' => $request->title_image?? $request->title
        ]);
        }
      


        return redirect()->route('book.index')->with('message', 'success');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        return view('back.book.show' ,['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        //hydratation des données du livre enregistré en base de données
        $book = Book::find($id);
        $authors = Author::pluck('name', 'id')->all();
        $genres = Genre::pluck('name', 'id')->all();

        return view('back.book.edit', ['authors'=>$authors, 'genres'=>$genres, 'book'=>$book]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,
        [
            'title' => 'required',
            'description' => 'required|string',
            'genre_id' => 'integer',
            'authors' => 'array',
            'authors.*' => 'int',
            'status' => 'in:published,unpublished',
            'picture' => 'image|mimes:jpg,png,jpeg',
        ]);


        $book = Book::find($id); //Récupérer l'id du livre à modifier
        $book->update($request->all()); //Mettre à jour les données du livre
        $book->authors()->sync($request->authors); //Synchronise les données dans la table de liaison
    
    $image = $request->file('picture');    

    if(!empty($image)){
        //Suppression de l'image si elle existe
        if(count($book->picture)>0){
            Storage::disk('local')->delete($book->picture->link);//Supprime physiquemnt l'image
            $book->picture()->delete();//Supprime l'information en base de données
        }

        $link = $request->file('picture')->store('./');
        //Mettre à jour la table picture pour le lien vers l'image dans la base de donnée
        $book->picture()->create(['link' => $link]);
    }
       
        return redirect()->route('book.index')->with('message', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('book.index')->with('message', 'success');

    }
}
