<?php 

namespace App\Http\ValidatorsSpaces;

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

        


}



