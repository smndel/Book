<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book; //importe l'alias de la classe
use App\Author; //importe pour la page author
use App\Genre;
use App\Score;
use Cache;

class FrontController extends Controller
{

    public function __construct(){
    	//Méthode pour injecter des données à une vue partielle
    	view()->composer('partials.menu', function($view){
    		$genres = Genre::pluck('name','id')->all(); //on récupère un tableau associatif ['id'=>1]
    		$view->with('genres', $genres);// on passe les données à la vue
       	});
    }

    public function index(){
    	// return Book::all(); //retourne tous les livres de l'application
    	$prefix=request()->page?? 'home';
        $path='book'.$prefix;

        $books = Cache::remember($path, 60*24, function(){
            return Book::published()->with('picture', 'authors', 'scores')->paginate(5);
        });

        return view('front.index', ['books'=>$books]);
    }

    public function show(int $id){

    	$book = Book::find($id);

    	return view('front.show', ['book' => $book]);
    }

    public function showBookByAuthor(int $id){
    	$books = Author::find($id)->books()->published()->paginate(5);//on récupère tout les livres d'un auteur
    	$author = Author::find($id);

    	//Que nous passons à la vue
    	return view('front.author', ['books' => $books, 'author' => $author]);
    }


     public function showBookByGenre(int $id){
     	$genre = Genre::find($id);
    	$books = $genre->books()->published()->paginate(5);//on récupère tout les livres d'un auteur
    	//Que nous passons à la vue
    	return view('front.genre', ['books' => $books, 'genre' => $genre]);
    }

    public function create(Request $request){
    	// dump($request->all());

    	//Pour la vérif des données recupérer sur le formulaire
    	$this->validate($request, [
    	'vote' => "in:0,1,2,3,4,5",
    	'ip' => 'ipv4|required',
    	'book_id' => "integer|required|uniqueVoteIp:{$request->ip}",//renvoi pour la vérification sur la page AppserviceProvider
    	]);

    	//On créer une variable pour sauvegarder les données du formulaire
    	$score = Score::create($request->all()); //assignation de masse
    
    	//Message retourné sur la page après 
    	return back()->with('message', 'Merci pour votre vote');

    }
}
