<?php

namespace App\Models;

use App\ClasseAndSubjectJoiner;
use App\Models\Classe;
use App\Models\ComputedMarksModalities;
use App\Models\Pupil;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classe extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'level', 'year', 'month', 'respo1', 'respo2', 'teacher_id', 'creator', 'editor', 'authorized'];

    /**
     * To get all pupils of this classe
     * @return [type] [description]
     */
    public function pupils()
    {
    	return $this->hasMany(Pupil::class);
    }


    /**
     * To get all subject of this classe
     * @return [type] [description]
     */
    public function subjects()
    {
    	return $this->morphedByMany(Subject::class, 'classable');
    }

    /**
     * To get all teachers of this classe
     * @return [type] [description]
     */
    public function teachers()
    {
    	return $this->morphedByMany(Teacher::class, 'classable');
    }

    /**
     * To get the principal
     * @return [type] [description]
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }


    public function respo1()
    {
        return Pupil::find($this->respo1);
    }

    public function respo2()
    {
        return Pupil::find($this->respo2);
    }

    /**
     * Pour avoir le format numerique des classes
     * @return array [description]
     */
    public function getFormattedClasseName()
    {
        $classe = new ClasseAndSubjectJoiner($this);
        $name = $this->name;
        $serie = $classe->getSerie();


        if ($this->level === "secondary") {
            $card = [];
            $card['id'] = $this->id;
            if ($serie == "serie-65" || $serie == "serie-43") {
                $card['sup'] = "ème";
                if (preg_match_all('/-/', $name)) {
                    $card['idc'] = explode('-', $name)[1];
                }
                else{
                    $card['idc'] = "";
                }

                if (preg_match_all('/Sixième/', $name)) {
                    $card['name'] = "6";
                }
                elseif (preg_match_all('/Cinqui/', $name)) {
                    $card['name'] = "5";
                }
                elseif (preg_match_all('/Quatri/', $name)) {
                    $card['name'] = "4";
                }
                else{
                    $card['name'] = "3";
                }

                return $card;
            }

            elseif (preg_match_all('/Seconde/', $name)) {
                $card['sup'] = "nde";
                $card['name'] = "2";

                if (preg_match_all('/-/', $name)) {
                    $card['idc'] = explode('-', $name)[1];
                }
                
                return $card;
            }
            elseif (preg_match_all('/Premi/', $name)) {
                $card['sup'] = "ère";
                $card['name'] = "1";
                
                if (preg_match_all('/-/', $name)) {
                    $card['idc'] = explode('-', $name)[1];
                }
                
                return $card;
            }
            elseif (preg_match_all('/Terminale/', $name)) {
                $card['sup'] = "le";
                $card['name'] = "T";
                
                if (preg_match_all('/-/', $name)) {
                    $card['idc'] = explode('-', $name)[1];
                }
                
                return $card;
            }
            else{
                return ['name' => $name, 'sup' => "", 'idc' => "", 'id' => $this->id];
            }
        }
        else{
            return ['name' => $name, 'sup' => "", 'idc' => "", 'id' => $this->id];
        }
    }



    /**
     * To get the name of the teacher of a specific subject
     * @param  int    $subject [description]
     * @return [type]          [description]
     */
    public function teacherOf(int $subject)
    {
        $teachers = $this->teachers;
        if ($teachers->count() > 0) {
            
            foreach ($teachers as $teacher) {
                if ($teacher->subject->id == $subject) {
                    return $teacher;
                }
            }
        }

    }

    public static function getBlockeds()
    {
        $classes = Classe::withTrashed('deleted_at')->get();

        $blockeds = [];

        foreach ($classes as $classe) {
            if ($classe->deleted_at !== null) {
                $blockeds[] = $classe;
            }
        }

        return $blockeds;
    }

    public function getModalities():?array
    {
        $subjects = $this->subjects;
        $id = $this->id;
        $classeModality = [];

        foreach ($subjects as $subject) {
            $id_s = $subject->id;
            $modality = ComputedMarksModalities::withTrashed('deleted_at')->where('classe_id', $id)->where('subject_id', $id_s)->first();
            $classeModality[$id_s] = $modality;
        }

        return $classeModality;
    }

    /**
     * Use to get for a classe they modalities joined to the specific subject
     * @param  string $trimestre [description]
     * @param  int $year      [description]
     * @return array           [description]
     */
    public function getMarksOnModalities($trimestre, $year = null)
    {
        if ($year == null) {
            $year = date('Y');
        }

        $subjectWithModalities = [];
        $modalities = ComputedMarksModalities::withTrashed('deleted_at')->where('trimestre', $trimestre)->where('classe_id', $this->id)->where('year', $year)->get();

        if (count($modalities) > 0) {
            foreach ($this->subjects as $subject) 
            {
                foreach ($modalities as $modality) {
                    if ($subject->id == $modality->subject_id) {
                        $subjectWithModalities[$subject->id] = $modality->value;
                    }
                }
            }
        }

        return $subjectWithModalities;

    }

}
