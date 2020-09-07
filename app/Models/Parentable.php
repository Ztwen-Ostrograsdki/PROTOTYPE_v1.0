<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parentable extends Model
{

    protected $fillable = ['relation', 'creator', 'editor', 'authorized', 'ability', 'parentor_id', 'pupil_id'];
    



}
