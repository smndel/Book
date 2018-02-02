<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $fillable = [
        'title', 'description', 'genre_id', 'status', 
    ];

    //Ici le setter va récupérer la valeur à insérer en base de données
    //Nous pourrons alors vérifier sa valeur avant que le modèle n'insère la donnée en base de donnée
    //Cette fonction est utile en cas d'enregistrement d'un nouveau livre sans genre. Vue que l'on n epeux pas ne pas mettre de genre à 0, on lui dit de se définir à null.
    public function setGenreIdAttribute($value){
        if($value == 0){
            $this->attributes['genre_id']= null;
        }else{
            $this->attributes['genre_id'] = $value;
        }
    }

    public function genre(){
    	return $this->belongsTo(Genre::class);
    }

    public function authors(){
    	return $this->belongsToMany(Author::class);
    }

    public function picture(){
    	return $this->hasOne(Picture::class);
    }

    public function scores(){
    	return $this->hasMany(Score::class);
    }

    public function avgVotes(){
        return $this->scores()->avg('vote')?? 0;
    }//Calcul de la moyenne des notes du livre

    public function shuffle($value)
   {
       return str_shuffle($value);
   }

   //Pour afficher seulemnt le livre avec le status "published"
   public function scopePublished($query){
    return $query->where('status', 'published');
   }

}

