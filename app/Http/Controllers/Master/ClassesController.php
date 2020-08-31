<?php

namespace App\Http\Controllers\Master;

use App\ClasseAndSubjectJoiner;
use App\Http\Controllers\Controller;
use App\ModelHelper;
use App\Models\Classe;
use App\Models\Mark;
use App\Models\Pupil;
use App\Models\Subject;
use App\Models\Teacher;
use App\User;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
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

        
        $classes = Classe::withTrashed('deleted_at')->orderBy('level', 'asc')->get();
        $u = User::all()->count();
        $t = Teacher::all()->count();
        $ts = Teacher::whereLevel('secondary')->count();
        $tp = Teacher::whereLevel('primary')->count();

        $classeWithHeads = [];

        // $blockeds = Classe::getBlockeds();


        $classesSecondary = Classe::whereLevel('secondary')->orderBy('name', 'asc')->get();
        $classesPrimary = Classe::whereLevel('primary')->orderBy('name', 'asc')->get();

        $data = [
            'user' => $user,
            'admin' => $admin,
            'classes' => $classes,
            'classesAll' => $classes,
            'cSec' => $classesSecondary, 
            'cPrim' => $classesPrimary, 
            'u' => $u, 
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
    public function getAClasseData(int $id)
    {
        $token = csrf_token();
        $classe = Classe::withTrashed('deleted_at')->whereId($id)->firstOrFail();

        $pupils = Pupil::whereClasseId($classe->id)->get();
        $teacher = $classe->teacher;
        $respo1 = $classe->respo1();
        $respo2 = $classe->respo2();

        $subjects = $classe->subjects;
        if ($classe->level === "primary") {
           $subjects = Subject::whereLevel('primary')->get();
        }

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
            'token' => $token
        ];
        return response()->json($data);
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

        foreach ($pupils as $pupil) {
            $pupilMarks = Mark::where('pupil_id', $pupil->id)->where('trimestre', $trim)->where('subject_id', $subject)->where('value', '>', 0)->get();
            if (count($pupilMarks) > 0) {
                $marks[$pupil->id] = $pupilMarks;
            }
            else{
                $marks[$pupil->id] = null;
            }
            
        }
        return response()->json(['classesMarks' => $marks, 'coefTables' => $coefTables]);

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

        foreach ($classes as $classe) {
            if ($classe->name == $request['name']) {
                return response()->json(['invalidInputs' => "Le nom de la classe que vous avez erneignez est déjà existante!"]);
            }
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
    public function show(int $id)
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
        //
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
