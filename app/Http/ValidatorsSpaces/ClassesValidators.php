<?php 

namespace App\Http\ValidatorsSpaces;

use App\Http\Controllers\Master\ClassesController;
use App\Http\ManagersAndDrivers\ClassesSpaces\ClassesManagersAndDrivers;
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
            'name' => ['required', 'string', 'max:255', 'min:2', 'bail', 'unique:classes'],
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
        return (new ClassesManagersAndDrivers($classe))-> __DRM_TO_EDIT_CLASSE($tag, $request);
    }


}



