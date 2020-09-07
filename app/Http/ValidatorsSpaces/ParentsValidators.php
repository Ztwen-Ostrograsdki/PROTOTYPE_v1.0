<?php 

namespace App\Http\ValidatorsSpaces;

use Illuminate\Support\Facades\Validator;

trait ParentsValidators {


	    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    
    public function parentPersoValidator(array $data, $except = null)
    {

    	if ($except == null) {
    	   //NOUVELLE INSERTION
           return Validator::make($data, [
                'name' => ['required', 'string', 'max:255', 'min:8', 'bail', 'unique:parentors'],
                'email' => 'required|email|min:5|max:250|bail|unique:parentors',
                'works' => 'required|string|min:5|max:250|bail',
                'contact' => 'required|string|min:5|max:250|bail|unique:parentors',
                'residence' => 'required|string|min:5|max:250|bail',
                'sexe' => ['required', 'string', 'bail'],
                'birth' => ['required', 'date', 'bail'],
            ]);
    	}
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:8', 'bail', 'unique:parentors'],
            'email' => 'required|email|min:5|max:250|bail|unique:parentors',
            'works' => 'required|string|min:5|max:250|bail',
            'contact' => 'required|string|min:5|max:250|bail|unique:parentors',
            'residence' => 'required|string|min:5|max:250|bail',
            'sexe' => ['required', 'string', 'bail'],
            'birth' => ['required', 'date', 'bail'],
        ]);
    }

    public function validateMarks(array $data)
    {
        
    }





}



