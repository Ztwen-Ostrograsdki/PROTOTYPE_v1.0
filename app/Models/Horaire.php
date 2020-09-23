<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{
    protected $fillable = ['subject_id', 'classe_id', 'year', 'day', 'start', 'end', 'creator', 'editor', ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
