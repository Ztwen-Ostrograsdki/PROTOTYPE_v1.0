<?php

namespace App\Http\Controllers\Master;

use App\ClasseAndSubjectJoiner;
use App\Helpers\Operators\Computator;
use App\Http\Controllers\Controller;
use App\Http\ManagersAndDrivers\Authenticator;
use App\Http\ManagersAndDrivers\ClassesSpaces\ClassesManagersAndDrivers;
use App\Http\ValidatorsSpaces\ClassesValidators;
use App\ModelHelper;
use App\Models\Classe;
use App\Models\ComputedMarksModalities;
use App\Models\Mark;
use App\Models\Pupil;
use App\Models\Subject;
use App\Models\Teacher;
use App\User;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    use ClassesValidators;

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
        return view('directors.classes.index');
    }

    /**
     * Use to send a data to a view in ajax
     * @return a json response 
     */
    public function classesDataSender($pupilEdited = null, array $errors = [])
    {
        $user = auth()->user();
        $admin = false;
        $roles = $user->getRoles();

        if (in_array('admin', $roles) || in_array('superAdmin', $roles)) {
            $admin = true;
        }

        
        $classes = Classe::where('id', '>', 0)->orderBy('level', 'asc')->get();
        $u = User::all()->count();
        $t = Teacher::all()->count();
        $ts = Teacher::whereLevel('secondary')->count();
        $tp = Teacher::whereLevel('primary')->count();

        $teachersAll = [];
        $pupilsAll = [];
        $teachers = Teacher::withTrashed('deleted_at')->get();
        $pupils = Pupil::withTrashed('deleted_at')->get();

        foreach ($teachers as $teacher) {
            $teachersAll[$teacher->id] = $teacher;
        }

        foreach ($pupils as $pupil) {
            $pupilsAll[$pupil->id] = $pupil;
        }

        $classeWithHeads = [];

        $classesSecondary = Classe::whereLevel('secondary')->orderBy('name', 'asc')->get();
        $classesPrimary = Classe::whereLevel('primary')->orderBy('name', 'asc')->get();
        $blockeds = Classe::getBlockeds();

        $data = [
            'user' => $user,
            'admin' => $admin,
            'classes' => $classes,
            'classesAll' => $classes,
            'cSec' => $classesSecondary, 
            'cPrim' => $classesPrimary, 
            'u' => $u,
            'classesBlockeds' => $blockeds,
            'teachers' => $teachersAll,
            'pupils' => $pupilsAll,
        ];
        if ($errors !== []) {
            $data['errors'] = $errors;
        }
        else{
            $data['errors'] = ['status' => false, 'type' => ''];
        }
        
        return response()->json($data);
    }

    /**
     * Use to get a data of a pupil
     * @param  int    $id [description]
     * @return a json response to a view
     */
    public function getAClasseData(int $id, $defaultsPupils = null)
    {
        $token = csrf_token();
        $classe = Classe::withTrashed('deleted_at')->whereId($id)->firstOrFail();

        $pupils = Pupil::whereClasseId($classe->id)->get();

        if ($defaultsPupils !== null) {
            $pupils = $defaultsPupils;
        }
        $teacher = $classe->teacher;
        $respo1 = $classe->respo1();
        $respo2 = $classe->respo2();

        $subjects = $classe->subjects;
        if ($classe->level === "primary") {
           $subjects = Subject::whereLevel('primary')->get();
        }

        $ClasseModality = $classe->getModalities();

        $classeFMT = $classe->getFormattedClasseName();

        $data = [
            'targetedClasse' => [
                'classe' => $classe, 
                'classeFMT' => $classeFMT, 
                'subjects' => $subjects, 
                'pupils' => $pupils, 
                'targetedSubject' => $subjects[0], 
                'heads' => [
                    'teacher' => $teacher, 
                    'respo1' => $respo1, 
                    'respo2' => $respo2
                ],
            ], 
            'token' => $token,
            'ClasseModalities' => $ClasseModality
        ];
        return response()->json($data);
    }

    public function getAClasseTeachersAndPupils(int $id, $year = null)
    {
        $data = [];
        $targetedClasseTeachers = [];
        $targetedClassePupils = [];
        $classe = Classe::find($id);

        if ($classe->level == 'secondary') {
            $teachers = (Classe::find($id))->teachers;
            if ($teachers->toArray() !== []) {
                foreach ($teachers as $t) {
                    $targetedClasseTeachers[$t->id] = $t;
                }
            }
        }
        elseif ($classe->level == 'primary') {
            $teachers = Teacher::whereLevel('primary')->get();

            foreach ($teachers as $t) {
                if (count($t->classes->toArray()) == 0) {
                    $targetedClasseTeachers[$t->id] = $t;
                }
            }
        }

        $pupils = (Classe::find($id))->pupils;
        if ($pupils->toArray() !== []) {
            foreach ($pupils as $p) {
                $targetedClassePupils[$p->id] = $p;
            }
        }

        $data['teachers'] = $targetedClasseTeachers;
        $data['pupils'] = $targetedClassePupils;

        return response()->json($data);
    }

    public function updateClasseModality(Request $request)
    {

        $auth_token = Authenticator::__AUTH_TOKEN($request->token);
        if ($auth_token !== []) {
            return response()->json(['invalidInputs' => ['token' => "La requête est invalide"]]);
        }
        else{
            
            $user = auth()->user();
            $authorized = false;
            $roles = $user->getRoles();

            if (in_array('admin', $roles) || in_array('superAdmin', $roles)) {
                $authorized = true;
            }

            
            $classe = Classe::withTrashed('deleted_at')->whereId($request->classe_id)->first();
            $insertion = ClassesManagersAndDrivers::__DRM_TO_EDIT_CLASSE_MODALITY($request);
            
            if ($insertion) {
                return $this->getAClasseData($classe->id);
            }
            else{
                return response()->json(['invalidInputs' => ['modality' => "Une erreure lors de l'insertion des données; vérifier vos données"]]);
            }

        }
    }


    public function getClasseMarks(int $classe, int $subject, int $trimestre = 1)
    {
        $trim = 'trimestre ' .$trimestre;

        $pupils = Pupil::where('classe_id', $classe)->get();

        $c = Classe::find($classe);
        $marks = [];

        $subjects = $c->subjects;
        if ($c->level === "primary") {
           $subjects = Subject::whereLevel('primary')->get();
        }

        $coefTables = [];
        $joiner = new ClasseAndSubjectJoiner($c);
        foreach ($subjects as $sub) {
            $coef = $joiner->getCoefiscientOfSubject($sub);
            $coefTables[$sub->id] = $coef;
        }

        $subjectWithModalities = $c->getMarksOnModalities($trim);

        foreach ($pupils as $pupil) {
            $pupilMarks = Mark::where('pupil_id', $pupil->id)->where('trimestre', $trim)->where('subject_id', $subject)->where('value', '>', 0)->get();
            if (count($pupilMarks) > 0) {
                $marks[$pupil->id] = $pupilMarks;
            }
            else{
                $marks[$pupil->id] = null;
            }
            
        }


        return response()->json(['classesMarks' => $marks, 'coefTables' => $coefTables, 'subjectWithModalities' => $subjectWithModalities]);
    }


    /**
     * To get a pupil of classe order by average
     * @param  int         $id        [description]
     * @param  int         $classe    [description]
     * @param  int         $subject   [description]
     * @param  int|integer $trimestre [description]
     * @return [type]                 [description]
     */
    public function orderPupilsOfThisClasse(int $classe, int $subject, int $trimestre = 1)
    {
        $classe = Classe::find((int)$classe);
        $pupils = $classe->pupils;
        $pupilsOrdered = [];
        $pupilsMarks = [];

        foreach ($pupils as $pupil) {
            $pupilsMarks[$pupil->id] = (new Computator($pupil->id, $subject , $trimestre))->computor();
        }

        arsort($pupilsMarks);

        foreach ($pupilsMarks as $key => $value) {
            $pupilsOrdered[] = Pupil::find($key);
        }
        return $this->getAClasseData($classe->id, $pupilsOrdered);
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
        $classes = Classe::all();

        $validator = $this->createClassesValidator($request->all());

        if ($validator->fails()) {
            return response()->json(['invalidInputs' => $validator->errors()]);
        }

        $classe = Classe::create($request->all());
        if ($classe) {
            (New ClasseAndSubjectJoiner($classe))->joinedSubjectsNow($classe);
        }
        return $this->classesDataSender();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('directors.classes.profil');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $tag = $request['tag'];
        $tok = $request['token'];
        $token = csrf_token();

        if ($tok !== $token) {
            abort(403, "Requete non autorisée");
        }

        return $this->classeEditor($tag, $request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($target)
    {
        if (preg_match_all('/-/', $target)) {
            $id = (int)(explode('-', $target))[0];
            $forced = (explode('-', $target))[1] == 'true' ? true : false;
        }
        else{
            $id = (int)$target;
            $forced = false;
        }
        $classe = Classe::find($id);

        $pupils = $classe->pupils;
        $teachers = $classe->teachers;
        $subjects = $classe->subjects;

        if ($forced) {
            if (count($pupils) > 0) {
                foreach ($pupils as $pupil) {
                    $pupil->classe_id = null;
                    $pupil->save();
                }
            }

            if (count($teachers) > 0) {
                foreach ($teachers as $teacher) {
                    $teacher->classes->detach($classe->id);
                }
            }

            if (count($subjects) > 0) {
                foreach ($subjects as $subject) {
                    $subject->classes->detach($classe->id);
                }
            }

            $classe->teacher_id = null;
            $classe->forceDelete();

            
        }
        else{
            $classe->delete();
            return $this->classesDataSender();
        }

    }

    public function restore(int $id) 
    {   
        Classe::withTrashed('deleted_at')->whereId((int)$id)->firstOrFail()->restore();
        return $this->classesDataSender();
    }


    /**
     * Use to refresh a classe --- retrieve all pupils out this classe
     * @param  boolean $forced [description]
     * @return json          [description]
     */
    public function refreshOnPupils(Request $request, $id)
    {
        // $id = $request->classe;
        // $forced = $request->forced;

        // $classe = Classe::withTrashed('deleted_at')->whereId($id)->first();
        
        // $done = $classe->refreshOnPupils($forced);
        // if ($done) {
        //     return $this->getAClasseData($id);
        // }
        // else{
        //     return response()->json(['errors' => "Une erreure est survenue"]);
        // }
        return $this->getAClasseData($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id classe
     * @param  int  $p a pupil
     * @return \Illuminate\Http\Response
     */
    public function destroyPupil(int $id, int $p)
    {
        $pupil = Pupil::find((int)$p);
        $classe = Classe::withTrashed('deleted_at')->whereId($id)->first();
        if ($pupil->delete()) {
            return $this->getAClasseData($classe->id);
        }

    }

}
