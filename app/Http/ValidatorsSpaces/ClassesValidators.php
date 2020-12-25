<?php 

namespace App\Http\ValidatorsSpaces;

use App\Http\Controllers\Master\ClassesController;
use App\Models\Classe;
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
    public function valiadteClasseName(array $data, $except = null)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:7', 'bail', 'unique:classes'],
        ]);
    }


    public function classeEditor($tag, $request, $id)
    {
        if ($tag == 'teacher') {
            $teacher = Teacher::withTrashed('deleted_at')->whereId($request['inputs'])->get()[0];
            $is_pp = Classe::withTrashed('deleted_at')->where('teacher_id', $teacher->id)->get();

            if (count($is_pp) > 0) {
                abort(403, "Requete non autorisée");
            }

            $classe = Classe::withTrashed('deleted_at')->whereId($id)->first();

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
                    $classe = Classe::withTrashed('deleted_at')->whereId($id)->first();
                    $classe->name = $request['inputs'];
                    $classe->save();
                }
                else{
                    $validator = $this->valiadteClasseName($request);
                    if ($validator->fails()) {
                        return response()->json(['invalidInputs' => $validator->errors()]);
                    }
                }
            }
            else{
                $classe = Classe::withTrashed('deleted_at')->whereId($id)->first();
                $classe->name = $request['inputs'];
                $classe->save();
            }
        }
        return (new ClassesController())->classesDataSender();
    }

        


}



