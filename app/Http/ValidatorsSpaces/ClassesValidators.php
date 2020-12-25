<?php 

namespace App\Http\ValidatorsSpaces;

use App\Http\Controllers\Master\ClassesController;
use App\Models\Classe;
use App\Models\Pupil;
use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;

trait ClassesValidators {


	    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    
    public function createClassesValidator(array $data, $except = null)
    {
    	return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:7', 'bail', 'unique:classes'],
            'level' => ['required', 'string', 'bail'],
            'month' => ['required', 'string', 'bail'],
            'year' => ['required', 'numeric', 'bail', 'max:'.date('Y')]
        ]);
    }
    public function validateClasseName(array $data, $except = null)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:2', 'bail', 'unique:classes'],
        ]);
    }

    /**
     * Use to edit a classe step or part by part
     * @param  [type] $tag     the specific target of a classe that will be change or modify
     * @param  [type] $request the data to change the old classe data
     * @param  [type] $id      the classe id
     * @return [type]          a json response with a data to fetch to a client
     */
    public function classeEditor($tag, $request, $id)
    {
        $classe = Classe::withTrashed('deleted_at')->whereId($id)->first();
        if ($tag == 'teacher') {
            $teacher = Teacher::withTrashed('deleted_at')->whereId($request['inputs'])->get()[0];
            $is_pp = Classe::withTrashed('deleted_at')->where('teacher_id', $teacher->id)->get();

            if (count($is_pp) > 0) {
                abort(403, "Requete non autorisée");
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
        if ($tag == 'name') {
            $targets = Classe::withTrashed('deleted_at')->where('name', $request['inputs'])->get();
            if (count($targets) > 0) {
                if ($targets[0]->id == $id) {
                    $classe->name = $request['inputs'];
                    $classe->save();
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
                        return response()->json([$r1, $r2, $pupils]);
                    }
                }
                else{
                    abort(404, "Requete inconnue");
                }
                
            }
            else{
                abort(404, "Requete inconnue");
            }
            
        }
        return (new ClassesController())->classesDataSender();
    }

        


}



