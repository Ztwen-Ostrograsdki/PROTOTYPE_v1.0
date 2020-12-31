<?php 

namespace App\Http\ValidatorsSpaces;

use App\Models\Mark;
use Illuminate\Support\Facades\Validator;

trait MarksValidator {


	    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    
    public function validateMarks(array $data)
    {
        return Validator::make($data, [
            'epe1' => ['numeric','max:20', 'min:0', 'bail'],
            'epe2' => ['numeric','max:20', 'min:0', 'bail'],
            'epe3' => ['numeric','max:20', 'min:0', 'bail'],
            'epe4' => ['numeric','max:20', 'min:0', 'bail'],
            'epe5' => ['numeric','max:20', 'min:0', 'bail'],
            'dev1' => ['numeric','max:20', 'min:0', 'bail'],
            'dev2' => ['numeric','max:20', 'min:0', 'bail']
        ]);
    	
    }


    public function validateModality(array $data)
    {
        return Validator::make($data, [
            'value' => ['numeric','max:5', 'min:1', 'bail', 'required'],
            'year' => ['numeric', 'bail', 'required'],
            'classe_id' => ['numeric', 'bail'],
            'subject_id' => ['numeric', 'bail'],
            'trimestre' => ['bail', 'required']
        ]);
    }




}



