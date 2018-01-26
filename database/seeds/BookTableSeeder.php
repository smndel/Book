<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // private $faker;
  
    // // injection de dépendance 
    // public function __construct(Faker $faker){
    
    // $this->faker = $faker; // Laravel qui injectera le composant Faker directement 
    // }

    public function run()
    {
    	//Création des genres
    	App\Genre::create([
    		'name' => 'science'
    	]);
    	App\Genre::create([
    		'name' => 'maths'
    	]);
    	App\Genre::create([
    		'name' => 'cookbook'
    	]);

    Storage::disk('local')->delete(Storage::AllFiles());

    	//Création de 30 livres à partir de la factory
        factory(App\Book::class, 30)->create()->each(function($book){
        	//Associations un genre à un livre que nous venons de créer
        	$genre = App\Genre::find(rand(1,3));

        	//Pour chaque $book on lui associe un genre en particulier
        	$book->genre()->associate($genre);
        	$book->save(); //il faut sauvegarder l'association pour faire persister en base de données.

			//Ajout des images
		    //On utilise futurama sur le lorempicsum pour récupérer des images aléatoirement
		    //Attention il n'y a que 9 images en tout différentes
		    $link = str_random(12).'.jpg';//hash de lien pour la sécurité(injection de sscripts de protection)
		    $file = file_get_contents('http://lorempicsum.com/futurama/250/250/'.rand(1, 9));
		    Storage::disk('local')->put($link, $file);

		    $book->picture()->create([
		    	'title' =>'Default', //valeur par défaut
		    	'link'	=> $link
		    ]);

		    //Récupération des id des auteurs à partir de la péthode pluck d'Eloquent
		    //les méthodes du pluck shuffle et slice permettent de mélanger et récupérer certain
		    //nombre 3 à partir de l'indice 0, comme ils sont mélangés à chaque fois qu'un livre est créé
		    //On aura des id à chaque fois aléatoires.
		    //La méthode all permet de faire la requête et de récupérer le résultat sous fomr d'un tableau
		    $authors = App\Author::pluck('id')->shuffle()->slice(0,rand(1,3))->all();

		    //Il faut se mettre maintenant en relation avec les auteurs(relation ManyToMany) et attacher les id des auteurs dans la table de liaison.
		    $book->authors()->attach($authors);

    	});

		
	}
}
