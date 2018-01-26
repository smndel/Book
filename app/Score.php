<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
	protected $fillable = [
	'ip', 'book_id', 'vote'
	]; //Pour récupérer les données post du formulaire, et les injecter dans la table SCORES

    public function book(){
   	return $this->belongsTo(Book::class);
   }
}
