<?php 

namespace App\Http\ValidatorsSpaces;

use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;

trait TeachersValidators {


	    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return array|bool
     */
    
    public function teacherValidateClasses(array $data, $id)
    {

        $classesConfirmed = [];
        $classables = [];

        $teacher = Teacher::withTrashed('deleted_at')->whereId($id)->firstOrFail();
        
        if ($teacher->level == "secondary") {
            $classesConcerned = $teacher->classesConcernedByThisTeacher(); //Classes pouvant recevoir les cours de l'enseignant
            $classesRefused = $teacher->classesConcernedByThisTeacherButNot();
            $classes = [$data['classe1'], $data['classe2'], $data['classe3'], $data['classe4'], $data['classe5']];

            foreach ($classesConcerned as $c) {
                $classables[] = $c->id;
            }

            foreach ($classes as $classe) {
                if ($classe !== null && in_array($classe, $classables) && !array_key_exists($classe, $classesRefused)) {
                    $classesConfirmed[] = $classe;
                }
            }


            if (count(array_flip($classesConfirmed)) <= 0) {
               return false;
            }

            $classesConfirmedNotDuplicate = [];
            $teachersOldClassesOnID = [];
            $teachersOldClasses = $teacher->classes;

            if (count($teachersOldClasses) > 0) {
                foreach ($teachersOldClasses as $teachersOldClasse) {
                   $teachersOldClassesOnID[] = $teachersOldClasse->id;
                }
            }

            foreach (array_flip(array_flip($classesConfirmed)) as $cv) {
                //Suppression des duplicata
                if (!in_array($cv, $teachersOldClassesOnID)) {
                    // On selectionne uniquement parmi les classes envoyées celles que le prof ne gardait pas
                    $classesConfirmedNotDuplicate[] = $cv;
                }
            }

            return $classesConfirmedNotDuplicate == [] ? false : $classesConfirmedNotDuplicate;
        }
        else{
            $classes = $data['classe'];
            return [$classes];
        }

    
    }


    public function validateNewTeachersInputs($data)
    {
        $level = $data['level'];

        $validator = [
            'name' => ['required', 'string', 'min:2', 'max:50', 'bail', 'unique:teachers'],
            'email' => ['required', 'email', 'min:8', 'max:50', 'bail', 'unique:teachers'],
            'contact' => ['required', 'string', 'min:8', 'max:250', 'bail', 'unique:teachers'],
            'residence' => ['required', 'string', 'min:5', 'max:250', 'bail'],
            'sexe' => ['required', 'string', 'bail'],
            'month' => ['required', 'string', 'bail'],
            'level' => ['required', 'string', 'bail'],
            'birth' => ['required', 'date', 'bail'],
            'year' => ['required', 'numeric', 'bail', 'max:'.date('Y')],
        ];

        if ($level == 'secondary') {
            $validator = [
                'name' => ['required', 'string', 'min:2', 'max:50', 'bail', 'unique:teachers'],
                'email' => ['required', 'email', 'min:8', 'max:50', 'bail', 'unique:teachers'],
                'contact' => ['required', 'string', 'min:8', 'max:250', 'bail', 'unique:teachers'],
                'residence' => ['required', 'string', 'min:5', 'max:250', 'bail'],
                'sexe' => ['required', 'string', 'bail'],
                'month' => ['required', 'string', 'bail'],
                'level' => ['required', 'string', 'bail'],
                'birth' => ['required', 'date', 'bail'],
                'subject_id' => ['required', 'numeric', 'bail'],
                'year' => ['required', 'numeric', 'bail', 'max:'.date('Y')],
            ];
        }

        return Validator::make($data, $validator);

    }




}



