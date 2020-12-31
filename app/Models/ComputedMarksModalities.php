<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComputedMarksModalities extends Model
{
   use SoftDeletes;

    protected $fillable = ['value', 'teacher_id', 'subject_id', 'classe_id', 'trimestre', 'year', 'creator', 'editor', 'authorized'];


    
}
