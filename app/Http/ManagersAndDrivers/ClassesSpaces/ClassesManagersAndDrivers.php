<?php

namespace App\Http\ManagersAndDrivers\ClassesSpaces;

use App\Http\Controllers\Master\ClassesController;
use App\Http\ValidatorsSpaces\ClassesValidators;
use App\Models\Classe;
use App\Models\ComputedMarksModalities;
use App\Models\Pupil;
use App\Models\Teacher;
use Illuminate\Http\Request;

//__DRM => DRIVERS and MANAGERS

class ClassesManagersAndDrivers{

	use ClassesValidators;

	private $classe;

	public function __construct(Classe $classe){
		$this->classe = $classe;
	}


    public static function __DRM_TO_EDIT_CLASSE_MODALITY(Request $request)
    {

        $user = auth()->user();
        $authorized = false;
        $roles = $user->getRoles();

        if (in_array('admin', $roles) || in_array('superAdmin', $roles)) {
            $authorized = true;
        }

        $subject = $request->subject_id;
        $classe = $request->classe_id;
        $year = $request->year;
        $trimestre = 'trimestre '.$request->trimestre;

        $oldModality = ComputedMarksModalities::withTrashed('deleted_at')->where('trimestre', $trimestre)->where('subject_id', $subject)->where('classe_id', $classe)->where('year', $year)->first();
        if ($oldModality !== null) {
            $oldModality->update(['value' => $request->value]);
            return true;
        }
        else{
            $data = [
                'subject_id' => $subject, 
                'classe_id' => $classe, 
                'trimestre' => $trimestre,
                'year' => $year, 
                'creator' => $user->name, 
                'authorized' => $authorized, 
                'value' => $request->value
            ];

            $modality = ComputedMarksModalities::create($data);
        }
        
        if ($modality) {
            return true;
        }
        else{
            return false;
        }
    }


    /**
     * [__FORMAT_CLASSE_NAME_BEFORE description]
     * @param  Request $request [description]
     * @return Request $request [description]
     */
    public static function __FORMAT_CLASSE_NAME_BEFORE(Request $request)
    {
        preg_match(('/aa/'), $request->name);
        return $request;
    }


	/**
     * Use to edit a classe step or part by part
     * @param  [type] $tag     the specific target of a classe that will be change or modify
     * @param  [type] $request the data to change the old classe data
     * @return [type]          a json response with a data to fetch to a client
     */
    public function __DRM_TO_EDIT_CLASSE($tag, $request)
    {
        $classe = $this->classe;
        if ($tag == 'teacher') {
            $t = $request['inputs'];
            if ($t !== 'destroy') {
               $teacher = Teacher::withTrashed('deleted_at')->whereId($t)->first();
                $is_pp = Classe::withTrashed('deleted_at')->where('teacher_id', $teacher->id)->get();

                if (count($is_pp) > 0) {
                    return response()->json(['invalidInputs' => ['teacher' => ["Cet(te) enseignant(e) que vous avez renseigneé est déja PP dans l'une de ses classes!"]]]);
                }

                if ($classe->teacher_id !== null) {
                    if ($classe->level == "primary") {
                        $teacher->classes()->detach($classe->id);
                    }
                    $classe->teacher_id = null;
                }

                $classe->teacher_id = $teacher->id;
                $classe->save();

                if ($teacher->level == 'primary') {
                    $teacher->classes()->attach($classe->id);
                }
            }
            else{
                if ($classe->level == 'secondary') {
                    $classe->teacher_id = null;
                    $classe->save();
                }
                elseif ($classe->level == "primary") {
                    $pp = Teacher::withTrashed('deleted_at')->whereId($classe->teacher_id)->first();
                    $classe->teacher_id = null;
                    $classe->save();
                    $pp->classes()->detach($classe->id);
                }
            }
        }
        if ($tag == 'name') {
            $targets = Classe::withTrashed('deleted_at')->where('name', $request['inputs'])->get();
            if (count($targets) > 0) {
                if ($targets[0]->id == $classe->id) {
                    //the user do not change the name of the current classe, so we will haven't apply the inputs
                }
                else{
                    $validator = $this->validateClasseName($request);
                    if ($validator->fails()) {
                        return response()->json(['invalidInputs' => $validator->errors()]);
                    }
                }
            }
            else{
                $classe->name = $request['inputs'];
                $classe->save();
            }
        }
        if ($tag == "respo1") {

            $respo1 = $request['inputs'];
            
            if ($respo1 !== "destroy") {
                $pupil = Pupil::withTrashed('deleted_at')->whereId($respo1)->first();
                $pupils = [];

                foreach ($classe->pupils as $p) {
                    $pupils[] = $p->id;
                }

                if ($pupil) {
                    if (in_array($pupil->id, $pupils)) {
                        $r1 = $classe->respo1;
                        $r2 = $classe->respo2;
                        if ($r1 == null && $r2 == null) {
                            $classe->respo1 = $pupil->id;
                            $classe->save();
                        }
                        else{
                            if ($r1 !== null && $r2 == null) {
                                if ($r1 == $pupil->id) {
                                    # code...
                                }
                                else{
                                    $classe->respo1 = $pupil->id;
                                    $classe->save();
                                }
                            }
                            elseif ($r1 == null && $r2 !== null) {
                                if ($r2 !== $pupil->id) {
                                    $classe->respo1 = $pupil->id;
                                    $classe->save();
                                }
                                else{
                                    $classe->respo2 = null;
                                    $classe->respo1 = $pupil->id;
                                    $classe->save();
                                }
                            }
                            elseif ($r1 !== null && $r2 !== null) {
                                if ($r1 !== $pupil->id && $r2 !== $pupil->id) {
                                    $classe->respo1 = $pupil->id;
                                    $classe->save();
                                }
                                elseif ($r1 !== $pupil->id && $r2 == $pupil->id) {
                                    $classe->respo2 = null;
                                    $classe->respo1 = $pupil->id;
                                    $classe->save();
                                }
                                else{

                                }
                            }
                        }
                    }
                    else{
                        return response()->json(['invalidInputs' => ['respo1' => ["Les données que vous avez renseigneés ne correspondent pas!"]]]);
                    }
                    
                }
                else{
                    return response()->json(['invalidInputs' => ['respo1' => ["Les données que vous avez renseigneés ne correspondent pas!"]]]);
                }
            }
            elseif ($respo1 == "destroy") {
                $classe->respo1 = null;
                $classe->save();
            }
            
        }
        if ($tag == "respo2") {

            $respo2 = $request['inputs'];

            if ($respo2 !== "destroy") {
                $pupil = Pupil::withTrashed('deleted_at')->whereId($respo2)->first();
                $pupils = [];

                foreach ($classe->pupils as $p) {
                    $pupils[] = $p->id;
                }

                if ($pupil) {
                    if (in_array($pupil->id, $pupils)) {
                        $r1 = $classe->respo1;
                        $r2 = $classe->respo2;
                        if ($r1 == null && $r2 == null) {
                            $classe->respo2 = $pupil->id;
                            $classe->save();
                        }
                        else{
                            if ($r2 !== null && $r1 == null) {
                                if ($r2 == $pupil->id) {
                                    # code...
                                }
                                else{
                                    $classe->respo2 = $pupil->id;
                                    $classe->save();
                                }
                            }
                            elseif ($r2 == null && $r1 !== null) {
                                if ($r1 !== $pupil->id) {
                                    $classe->respo2 = $pupil->id;
                                    $classe->save();
                                }
                                else{
                                    $classe->respo1 = null;
                                    $classe->respo2 = $pupil->id;
                                    $classe->save();
                                }
                            }
                            elseif ($r1 !== null && $r2 !== null) {
                                if ($r2 !== $pupil->id && $r1 !== $pupil->id) {
                                    $classe->respo2 = $pupil->id;
                                    $classe->save();
                                }
                                elseif ($r2 !== $pupil->id && $r1 == $pupil->id) {
                                    $classe->respo1 = null;
                                    $classe->respo2 = $pupil->id;
                                    $classe->save();
                                }
                                else{
                                    
                                }
                            }
                        }
                    }
                    else{
                        return response()->json(['invalidInputs' => ['respo2' => ["Les données que vous avez renseigneés ne correspondent pas!"]]]);
                    }
                    
                }
                else{
                    return response()->json(['invalidInputs' => ['respo2' => ["Les données que vous avez renseigneés ne correspondent pas!"]]]);
                }
            }
            elseif ($respo2 == "destroy") {
                $classe->respo2 = null;
                $classe->save();
            }
        }
        return (new ClassesController())->classesDataSender();
    }









}