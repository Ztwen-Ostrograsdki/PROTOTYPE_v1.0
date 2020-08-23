<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\ValidatorsSpaces\MarksValidator;
use App\Models\Mark;
use App\Models\Pupil;
use Illuminate\Http\Request;

class MarksController extends Controller
{
    use MarksValidator;
    public function getAPupilMarks(int $p, int $classe, int $trimestre)
    {
    	$pupil = Pupil::find((int)$p);

    	$marks = Mark::where('pupil_id', $p)->where('classe_id', $classe)->where('trimestre', $trimestre)->get();
        $marksArray = ['epe' => [], 'devoirs' => []];
        $marksArrayByType = [];

        if ($marks->toArray() === []) {
            $marksArrayByType = null;
        }
        else{
            foreach ($marks as $mark) {
                if (in_array($mark->type, ['epe', 'interrogation']) ) {
                    $marksArray['epe'][] = $mark;
                    $marksArrayByType[$mark->subject_id] = $marksArray;
                }
                elseif (in_array($mark->type, ['devoir', 'dev'])) {
                    $marksArray['devoirs'][] = $mark;
                    $marksArrayByType[$mark->subject_id] = $marksArray;
                }
                
            }

        }

        return response()->json('marks' => $marksArrayByType);
    }

    public static function createMarkOrEdit($default = null, $newValue, $pupil, $classe, $subject, $trimestre, $id, $type = 'epe')
    {
        $user = auth()->user();
        $authorized = false;
        $roles = $user->getRoles();

        if (in_array('admin', $roles) || in_array('superAdmin', $roles)) {
            $authorized = true;
        }

        $markDefault = ['pupil_id' => $pupil, 'subject_id' => $subject, 'classe_id' => $classe, 'trimestre' => $trimestre, 'year' => date('Y'), 'creator' => $user->name, 'authorized' => $authorized];

        if ($default !== null) {
            if ($newValue !== null && $newValue !== 0) {
                $default = $newValue;
                $mark = (Mark::where('pupil_id', $pupil)->where('classe_id', $classe)->where('subject_id', $subject)->where('trimestre', $trimestre)->get());
                return response()->json('marks' => $mark);
                // $mark->value = $default;
                // $mark->save();
            }
        }
        else{
            $markDefault['type'] = $type;
            if ($newValue !== null && $newValue !== 0) {
                $markDefault['value'] = $newValue;
                $mark = Mark::create($markDefault);
            }
        }
    }


}
