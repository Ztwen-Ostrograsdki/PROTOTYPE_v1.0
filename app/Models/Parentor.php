<?php

namespace App\Models;

use App\Models\Pupil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Parentor extends Model
{
    use Notifiable;
	use SoftDeletes;

    protected $fillable = ['name', 'email', 'contact', 'sexe', 'residence', 'birth', 'year','month', 'firstName', 'surname', 'creator', 'editor', 'authorized', 'works'
		];


}
