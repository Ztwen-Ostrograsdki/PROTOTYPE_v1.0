<?php

namespace App\Models;

use App\Models\Parentor;
use App\Models\Pupil;
use Illuminate\Database\Eloquent\Model;

class Parentable extends Model
{
    protected $fillable = ['relation', 'creator', 'editor', 'authorized', 'ability'];

    public function relationner(Pupil $pupil, Parentor $parent)
    {

    }



}
