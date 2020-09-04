<?php

namespace App\Http\Controllers\Master;

use App\ClasseAndSubjectJoiner;
use App\Helpers\Tools\Tools;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\MarksController;
use App\Http\ValidatorsSpaces\PupilsValidators;
use App\ModelHelper;
use App\Models\Classe;
use App\Models\Mark;
use App\Models\Parentable;
use App\Models\Pupil;
use App\Models\Subject;
use App\Models\Teacher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PupilsController extends Controller
{
    use PupilsValidators;

    public function __construct()
    {
        $this->middleware('onlySuperAdmin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('directors.pupils.index');
    }


    /**
     * Use to send a data to a view in ajax
     * @return a json response 
     */
    public function pupilsDataSender($pupilSearch = [], $pupilEdited = null, array $errors = [])
    {
        $user = auth()->user();
        $admin = false;
        $roles = $user->getRoles();

        if (in_array('admin', $roles) || in_array('superAdmin', $roles)) {
            $admin = true;
        }
        $AllpupilsWithClasses = [];
        $PSBlockeds = [];
        $PPBlockeds = [];
        $pupils = Pupil::withTrashed(!'deleted_at')->orderBy('name', 'asc')->get();
        $u = User::all()->count();
        $t = Teacher::all()->count();
        $ts = Teacher::whereLevel('secondary')->count();
        $tp = Teacher::whereLevel('primary')->count();
        $PBSLength = count(Pupil::getBlockeds('secondary'));
        $PBPLength = count(Pupil::getBlockeds('primary'));
        $blockeds = Pupil::getBlockeds();

        foreach ($blockeds as $pb) {
           if ($pb->level == "secondary") {
               $PSBlockeds[] = $pb;
           }
           elseif ($pb->level == "primary") {
               $PPBlockeds[] = $pb;
           }
        }


        foreach (Pupil::withTrashed('deleted_at')->get() as $pupil) {
            $AllpupilsWithClasses[$pupil->id] = $pupil->classe->getFormattedClasseName();
        }

        $pupilsSecondary = Pupil::whereLevel('secondary')->orderBy('name', 'asc')->get();
        $pupilsPrimary = Pupil::whereLevel('primary')->orderBy('name', 'asc')->get();


        $data = [
            'user' => $user,
            'admin' => $admin,
            'p' => $pupils,
            'pSec' => $pupilsSecondary, 
            'pPrim' => $pupilsPrimary, 
            'all' => $AllpupilsWithClasses, 
            'u' => $u, 
            't' => $t, 
            'ts' => $ts, 
            'tp' => $tp, 
            'pblockeds' => $blockeds, 
            'PSBlockeds' => $PSBlockeds, 
            'PPBlockeds' => $PPBlockeds, 
            'PBSLength' => $PBSLength, 
            'PBPLength' => $PBPLength,
        ];
        
        if ($errors !== []) {
            $data['errors'] = $errors;
        }
        else{
            $data['errors'] = ['status' => false, 'type' => ''];
        }
        if ($pupilEdited !== null) {
            $classeFMT = $pupilEdited->classe->getFormattedClasseName();
            $birthday = ModelHelper::birthFormattor($pupilEdited, 0);

            $helper = new ModelHelper($pupilEdited);
            $surname = $helper->setLastNameAndFirstName();

            $lastName = $helper->getLastName();
            $firstName = $helper->getFirstName();
            
            $data['pupilEdited'] = $pupilEdited; 
            $data['classeFMT'] = $classeFMT; 
            $data['birthFMT'] = $birthday; 
            $data['firstName'] = $firstName; 
            $data['lastName'] = $lastName; 
        }

        if ($pupilSearch !== []) {
            $data['p'] = $pupilSearch;
        }
        
        return response()->json($data);
    }

    public function getPupilsBySearch($q)
    {
        $search = $q;
        if (is_numeric($search)) {
            $pupils = Pupil::where('classe_id', $search)->get();
        }
        else{
            if (in_array($search, ['prim', 'primary', 'sec', 'secondary', 'second'])) {
                $pupils = Pupil::where('level', 'like', '%'. $search . '%')->get();
            }
            else{
                $pupils = Pupil::where('name', 'like', '%'. $search . '%')->orwhere('sexe', 'like', '%'. $search . '%')->get();
            }
        }
        return $this->pupilsDataSender($pupils);
    }

    /**
     * Use to get a data of a pupil
     * @param  int    $id [description]
     * @return a json response to a view
     */
    public function getAPupilData(int $id)
    {
        $token = csrf_token();
        $pupil = Pupil::withTrashed('deleted_at')->whereId($id)->firstOrFail();

        $subjects = $pupil->classe->subjects;
        if ($pupil->level === "primary") {
           $subjects = Subject::whereLevel('primary')->get();
        }

        $coefTables = [];
        $joiner = new ClasseAndSubjectJoiner($pupil->classe);
        foreach ($subjects as $subject) {
            $coef = $joiner->getCoefiscientOfSubject($subject);
            $coefTables[$subject->id] = $coef;
        }

        $classeFMT = $pupil->classe->getFormattedClasseName();
        $birthday = ModelHelper::birthFormattor($pupil, 0);

        $helper = new ModelHelper($pupil);
        $surname = $helper->setLastNameAndFirstName();

        $lastName = $helper->getLastName();
        $firstName = $helper->getFirstName();

        $classeName = $pupil->classe->name;

        $parents = $pupil->parentors();

        return response()->json(['p' => $pupil, 'subjects' => $subjects, 'coefTables' => $coefTables, 'token' => $token, 'classeFMT' => $classeFMT, 'birthFMT' => $birthday, 'classeName' => $classeName, 'firstName' => $firstName, 'lastName' => $lastName, 'pupilParents' => $parents]);
    }

    public function sendPupilMarks(Request $request, int $id, int $trimestre)
    {
        $pupil = Pupil::withTrashed('deleted_at')->whereId($id)->firstOrFail();
        $marks = Mark::where('pupil_id', $id)->where('trimestre', 'trimestre '.$trimestre)->get();
        $lastMark = Mark::where('pupil_id', $id)->where('trimestre', 'trimestre '.$trimestre)->where('value', '>', 0)->orderBy('id', 'desc')->first();
        $bestMark = Mark::where('pupil_id', $id)->where('trimestre', 'trimestre '.$trimestre)->where('value', '>', 0)->orderBy('value', 'desc')->first();
        $weakMark = Mark::where('pupil_id', $id)->where('trimestre', 'trimestre '.$trimestre)->where('value', '>', 0)->orderBy('value', 'asc')->first();
        $allMarks = Mark::where('pupil_id', $id)->where('trimestre', 'trimestre '.$trimestre)->where('value', '>', 0)->count();
        $passMarks = Mark::where('pupil_id', $id)->where('trimestre', 'trimestre '.$trimestre)->where('value', '>=', 10)->count();
        


        
        $marksArrayByType = [];

        if ($marks->toArray() === []) {
            $marksArrayByType = null;
        }

        else{
            $percentage = number_format(($passMarks / $allMarks) * 100, 2, '.', ' ');
            $lastSubject = (Subject::find($lastMark->subject_id))->name;
            $bestSubject = (Subject::find($bestMark->subject_id))->name;
            $weakSubject = (Subject::find($weakMark->subject_id))->name;
            if ($pupil->level === "secondary") {
                foreach ($pupil->classe->subjects as $subject) {
                    $classe = $pupil->classe->id;
                    $tr = 'trimestre '.$trimestre;
                    $marksArray = ['epe' => [], 'devoirs' => []];
                    $marks = Mark::where('pupil_id', $id)->where('classe_id', $classe)->where('trimestre', $tr)->where('subject_id', $subject->id)->get();
                    if (count($marks) > 0) {
                        $marksEPE = Mark::where('pupil_id', $id)->where('classe_id', $classe)->where('trimestre', $tr)->where('subject_id', $subject->id)->where('type', 'epe')->where('value', '>', 0)->get();
                        $marksDEV = Mark::where('pupil_id', $id)->where('classe_id', $classe)->where('trimestre', $tr)->where('subject_id', $subject->id)->where('type', 'devoir')->where('value', '>', 0)->get();
                        $marksArrayByType[$subject->id] = ['epe' => $marksEPE, 'devoirs' => $marksDEV];
                    }
                }
            }
            elseif ($pupil->level == "primary") {
                foreach (Subject::whereLevel('primary')->get() as $subject) {
                    $classe = $pupil->classe->id;
                    $tr = 'trimestre '.$trimestre;
                    $marksArray = ['epe' => [], 'devoirs' => []];
                    $marks = Mark::where('pupil_id', $id)->where('classe_id', $classe)->where('trimestre', $tr)->where('subject_id', $subject->id)->get();
                    if (count($marks) > 0) {
                        $marksEPE = Mark::where('pupil_id', $id)->where('classe_id', $classe)->where('trimestre', $tr)->where('subject_id', $subject->id)->where('type', 'epe')->where('value', '>', 0)->get();
                        $marksDEV = Mark::where('pupil_id', $id)->where('classe_id', $classe)->where('trimestre', $tr)->where('subject_id', $subject->id)->where('type', 'devoir')->where('value', '>', 0)->get();
                        $marksArrayByType[$subject->id] = ['epe' => $marksEPE, 'devoirs' => $marksDEV];
                    }
                }
            }
            return response()->json(['marks' => $marksArrayByType, 'tr' =>$trimestre, 'last' => ['mark' => $lastMark, 'subject' => $lastSubject], 'best' => ['mark' => $bestMark, 'subject' => $bestSubject], 'weak' => ['mark' => $weakMark, 'subject' => $weakSubject], 'percentage' => $percentage]);

        }

        return response()->json(['marks' => $marksArrayByType, 'tr' =>$trimestre, 'last' => ['mark' => null, 'subject' => null], 'best' => ['mark' => null, 'subject' => null], 'weak' => ['mark' => null, 'subject' => null], 'percentage' => null]);
    }


    /**
     * Use to get a data of a pupil
     * @param  int    $id [description]
     * @return a json response to a view
     */
    public function showPupilMarks(int $id)
    {
        return view('directors.pupils.marks.index');
    }


    /**
     * Use to get a classe formatted of a pupil
     * @param  int    $id [description]
     * @return a json response to a view 
     */
    public function pupilClasse(int $id)
    {
        $p = Pupil::find((int)$id);
        $classe = $p->classe->getFormattedClasseName();
        return response()->json($classe);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ((!$request->filled('token') || $request->token == "") || ($request->filled('token') && $request->token !== csrf_token())) {
            return $this->pupilsDataSender([], null, ['status' => true, 'type' => '419']);
        }

        $validator = $this->pupilsPersoValidator($request->all());

        if ($validator->fails()) {
            return response()->json(['invalidInputs' => $validator->errors()]);
        }

        $pupil = Pupil::create($request->all());
        if ($pupil) {
            $creator = auth()->user();
            $pupil->creator = $creator->name;

            if (in_array('admin', $creator->getRoles()) || in_array('superAdmin', $creator->getRoles())) {
                $pupil->authorized = true;
            }
            $pupil->save();
        }


        
        return $this->pupilsDataSender();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('directors.pupils.profil');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function persoUpdate(Request $request, int $id)
    {

        if ((!$request->filled('token') || $request->token == "") || ($request->filled('token') && $request->token !== csrf_token())) {
            return $this->pupilsDataSender([], null, ['status' => true, 'type' => '419']);
        }

        $pupil = Pupil::withTrashed('deleted_at')->whereId((int)$id)->firstOrFail();

        $validator = $this->pupilsPersoValidator($request->all(), $id);

        if ($validator->fails()) {
            return response()->json(['invalidInputs' => $validator->errors()]);
        }

        if ($pupil->update($request->all())) {
            $updater = auth()->user();
            $pupil->editor = $updater->name;
            

            if (in_array('admin', $updater->getRoles()) || in_array('superAdmin', $updater->getRoles())) {
                $pupil->authorized = true;
            }
            $pupil->save();
        }

        return $this->pupilsDataSender([], $pupil, []);

    }

    public function updateAPupilMarks(Request $request, int $p, int $s, int $c)
    {

        $user = auth()->user();
        $authorized = false;
        $roles = $user->getRoles();

        if (in_array('admin', $roles) || in_array('superAdmin', $roles)) {
            $authorized = true;
        }

        $pupil = Pupil::find((int)$p);
        $notes = $request->all();
        $trimestre = 'trimestre '.$notes['trimestre'];

        $oldMarks = $pupil->marks->toArray();
        $marksOfCurrentClasse = [];
        $devoirs = [];
        $interrogations = [];

        $markDefault = ['pupil_id' => $p, 'subject_id' => $s, 'classe_id' => $c, 'trimestre' => $trimestre, 'year' => date('Y'), 'creator' => $user->name, 'authorized' => $authorized];

        $int1 = null; $int2 = null; $int3 = null; $int4 = null; $int5 = null;

        $dev1 = null; $dev2 = null;

        if ($oldMarks !== []) {
            foreach ($pupil->marks as $m) {
                if ($m->classe_id == $c && $m->trimestre == $trimestre) {
                    $marksOfCurrentClasse[$m->id] = $m;
                }
            }
        }

        if ($marksOfCurrentClasse !== []) {

            $marksOfCurrentSubject = Mark::where('pupil_id', $p)->where('classe_id', $c)->where('subject_id', $s)->where('trimestre', $trimestre)->get();
            foreach ($marksOfCurrentSubject as $m) {
                if (in_array($m->type, ['epe', 'interrogations', 'interrogation'])) {
                    $interrogations[] = $m;
                }
                elseif (in_array($m->type, ['epe', 'devoirs', 'devoir'])) {
                    $devoirs[] = $m;
                }
            }

            if ($interrogations !== []) {
                $int1  = $interrogations[0];
                if (count($interrogations) > 1) {
                    $int2 = $interrogations[1];
                    if (count($interrogations) > 2) {
                        $int3 = $interrogations[2];
                        if (count($interrogations) > 3) {
                            $int4 = $interrogations[3];
                            if (count($interrogations) > 4) {
                                $int5 = $interrogations[4];
                            }
                        }
                    }
                }
            }
            if ($devoirs !== []) {
                $dev1 = $devoirs[0];
                if (count($devoirs) > 1) {
                    $dev2 = $devoirs[1];
                }
            }

           $validator =  $this->validateMarks($request->all());

            if ($validator->fails()) {
                return response()->json(['invalidInputs' => $validator->errors()]);
            }
            else{
                $this->createMarkOrEdit($int1, $notes['epe1'], $p, $c, $s, $trimestre, 0, 'epe');
                $this->createMarkOrEdit($int2, $notes['epe2'], $p, $c, $s, $trimestre, 1, 'epe');
                $this->createMarkOrEdit($int3, $notes['epe3'], $p, $c, $s, $trimestre, 2, 'epe');
                $this->createMarkOrEdit($int4, $notes['epe4'], $p, $c, $s, $trimestre, 3, 'epe');
                $this->createMarkOrEdit($int5, $notes['epe5'], $p, $c, $s, $trimestre, 4, 'epe');
                $this->createMarkOrEdit($dev1, $notes['dev1'], $p, $c, $s, $trimestre, 0, 'devoir');
                $this->createMarkOrEdit($dev2, $notes['dev2'], $p, $c, $s, $trimestre, 1, 'devoir');
            }

            
        }
        else{
            $this->createMarkOrEdit(null, $notes['epe1'], $p, $c, $s, $trimestre, 0, 'epe');
            $this->createMarkOrEdit(null, $notes['epe2'], $p, $c, $s, $trimestre, 1, 'epe');
            $this->createMarkOrEdit(null, $notes['epe3'], $p, $c, $s, $trimestre, 2, 'epe');
            $this->createMarkOrEdit(null, $notes['epe4'], $p, $c, $s, $trimestre, 3, 'epe');
            $this->createMarkOrEdit(null, $notes['epe5'], $p, $c, $s, $trimestre, 4, 'epe');
            $this->createMarkOrEdit(null, $notes['dev1'], $p, $c, $s, $trimestre, 0, 'devoir');
            $this->createMarkOrEdit(null, $notes['dev2'], $p, $c, $s, $trimestre, 1, 'devoir');
        }
        return response()->json([]);
    }

    public function createMarkOrEdit($default = null, $newValue, $pupil, $classe, $subject, $trimestre, $id, $type = 'epe')
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
                $mark = (Mark::where('pupil_id', $pupil)->where('classe_id', $classe)->where('subject_id', $subject)->where('trimestre', $trimestre)->where('type', $type)->get())[$id];
                $mark->value = $default;
                $mark->save();
            }
        }
        else{
            $markDefault['type'] = $type;
            if ($newValue !== null && $newValue !== 0) {
                $markDefault['value'] =  $newValue;
                $mark = Mark::create($markDefault);
            }
        }
    }

    public function buildBulletin(Request $request, int $id, int $trimestre)
    {
        return view('directors.pupils.marks.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $pupil = Pupil::find((int)$id);
        if ($pupil->delete()) {
            return $this->pupilsDataSender();
        }

    }

    public function restore(int $id) 
    {   
        Pupil::withTrashed()->whereId((int)$id)->firstOrFail()->restore();
        return $this->pupilsDataSender();
    }

    

}
