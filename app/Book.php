<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
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
}

