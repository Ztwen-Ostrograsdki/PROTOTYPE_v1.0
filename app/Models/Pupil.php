<?php

namespace App\Models;
use App\Helpers\TrashedGet;
use App\Models\Classe;
use App\Models\ComputedMarksModalities;
use App\Models\Mark;
use App\Models\Parentable;
use App\Models\Parentor;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pupil extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'sexe', 'classe_id', 'birth', 'status', 'year','month', 'level', 'creator', 'editor', 'authorized'];

    public static function getBlockeds(string $level = null)
    {
        $blocked = (new TrashedGet(Pupil::class))->getDeleted($level);
        return $blocked;
    }


    public function classe()
    {
    	return $this->belongsTo(Classe::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function getSexe()
    {
    	if ($this->sexe == 'male') {
    		return 'Masculin';
    	}
    	else{
    		return 'Féminin';
    	}
    }

    public function isRespo()
    {
        $c = $this->classe;

        if ($c->respo1() !== null && $c->respo2() !== null) {
            if ($c->respo1()->id == $this->id) {
                return "text-primary";
            }
            elseif ($c->respo2()->id == $this->id) {
                return "text-success";
            }
            else{
                return "";
            }
        }
        else{
            if ($c->respo1() !== null && $c->respo2() == null) {
                if ($c->respo1()->id == $this->id) {
                    return "text-primary";
                }
                else{
                    return "";
                }
            }
            elseif($c->respo2() !== null && $c->respo1() == null){
                if ($c->respo2()->id == $this->id) {
                    return "text-primary";
                }
                else{
                    return "";
                }
            }
            else{
                return "";
            }

        }

    }

    

    public function parents()
    {
        $parents = [];
        $parenters = Parentable::where('pupil_id', $this->id)->get();
        if (count($parenters) > 0) {
            foreach ($parenters as $parenter) {
                $parenters[] = [
                    'parent' => Parentor::withTrashed('deleted_at')->where('id', $parenter->parentor_id)->first(),
                    'relation' => $parenter->relation
                ];
            }
        }
        return $parents;
    }

    /**
     * [getMyClasseModality description]
     * @return [type] [description]
     */
    public function getMyClasseModalities()
    {
        $myModalities = [];

        $subjects = Classe::find($this->classe_id)->subjects;
        if (count($subjects) > 0) {
            foreach ($subjects as $subject) {
                $modality = ComputedMarksModalities::withTrashed('deleted_at')->where('classe_id', $this->classe_id)->where('subject_id', $subject->id)->first();
                if ($modality == null) {
                    $myModalities[$subject->id] = null;
                }
                else{
                    $myModalities[$subject->id] = $modality->value;
                }
            }
        }
        return $myModalities;
    }


}
