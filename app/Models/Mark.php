<?php

namespace App\Models;

use App\Models\Pupil;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mark extends Model
{
    use SoftDeletes;

    protected $fillable = ['value', 'pupil_id', 'subject_id', 'classe_id', 'trimestre', 'type', 'year', 'creator', 'editor', 'authorized'];

    public function pupil()
    {
        return $this->belongsTo(Pupil::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function pupilClasse()
    {
        return $this->belongsTo(Classe::class);
    }
}
