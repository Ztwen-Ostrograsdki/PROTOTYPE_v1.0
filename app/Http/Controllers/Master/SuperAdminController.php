<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Tools\Tools;
use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Horaire;
use App\Models\Pupil;
use App\Models\Subject;
use App\Models\Teacher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('onlySuperAdmin');
    }


    /**
     * To approve an inserting of a data 
     * @param  [type] $request [description]
     * @param  [type] $user    [description]
     * @return [type]          [description]
     */
    public static function getAuthorization($user)
    {
        if (in_array('superAdmin', $user->getRoles())) {
            return true;
        }
        return false;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('directors.index');
    }


    public function dashboarder()
    {
        // dd(Horaire::where('year', $year)->get());
        // Horaire::create(['subject_id' => 18, 'classe_id' => 10, 'day' => 'Vendredi', 'year' => '2020', 'start' => '10', 'end' => '13']);
        // Horaire::create(['subject_id' => 10, 'classe_id' => 10, 'day' => 'Jeudi', 'year' => '2020', 'start' => '10', 'end' => '12']);
        return view('directors.dashboards.index');
    }

    public function getHoraires(int $year)
    {
        $horairesTables = [];
        $classes = Classe::whereLevel('secondary')->get();

        foreach ($classes as $c) {
            $h = Horaire::where('year', $year)->where('classe_id', $c->id)->with('subject')->get();
            if (count($h) > 0) {
                $horairesTables[$c->id] = $h;
            }
            else{
                $horairesTables[$c->id] = null;
            }
        }
        return response()->json($horairesTables);
    }


    public function dataSender()
    {

        $user = auth()->user();
        $admin = false;
        $roles = $user->getRoles();
        
        if (in_array('admin', $roles) || in_array('superAdmin', $roles)) {
            $admin = true;
        }

        $u = User::all()->count();

        $t = Teacher::all()->count();
        $ts = Teacher::whereLevel('secondary')->count();
        $tp = Teacher::whereLevel('primary')->count();

        $classes = Classe::withTrashed('deleted_at')->orderBy('level', 'asc')->get();
        $classesSecondary = Classe::whereLevel('secondary')->orderBy('name', 'asc')->get();
        $classesPrimary = Classe::whereLevel('primary')->orderBy('name', 'asc')->get();

        $classesBlockeds = [];
        $classesPrimaryBlockeds = [];
        $classesSecondaryBlockeds = [];

        $classesB = Classe::withTrashed('deleted_at')->where('deleted_at', '!=', null)->get();
        foreach ($classesB as $cl) {
            $classesBlockeds[$cl->id] = $cl;
        }

        $p = Pupil::all()->count();
        $ps = Pupil::whereLevel('secondary')->count();
        $pp = Pupil::whereLevel('primary')->count();
        $pupilsBlockedsLength = count(Pupil::getBlockeds());
        $PBSLength = count(Pupil::getBlockeds('secondary'));
        $PBPLength = count(Pupil::getBlockeds('primary'));

        $data = [
            'user' => $user,
            'admin' => $admin,
            'tl' => $t, 
            'tsl' => $ts, 
            'tpl' => $tp, 
            'pl' => $p, 
            'psl' => $ps, 
            'ppl' => $pp, 
            'ul' => $u, 
            'classes' => $classes,
            'classesPrimary' => $classesPrimary,
            'classesSecondary' => $classesSecondary,
            'classesBlockeds' => $classesBlockeds,
            'classesSecondaryBlockeds' => $classesSecondaryBlockeds,
            'classesPrimaryBlockeds' => $classesPrimaryBlockeds,
            'pupilsblockedLength' => $pupilsBlockedsLength, 
            'PBSLength' => $PBSLength, 
            'PBPLength' => $PBPLength
        ];
        
        return response()->json($data);
    }

    /**
     * Use to get data and sebd then to a vue
     * @return a json response
    */
    public function getTOOLS()
    {   
        $secondaryClassesFormatted = [];

        $token = csrf_token();
        $secondarySubjects = Subject::whereLevel('secondary')->get();
        $primarySubjects = Subject::whereLevel('primary')->get();
        $primaryClasses = Classe::whereLevel('primary')->get();
        $secondaryClasses = Classe::whereLevel('secondary')->get();
        $months = Tools::months();
        $roles = Tools::roles();

        if (count($secondaryClasses) > 0) {
           foreach ($secondaryClasses as $classe) {
                $secondaryClassesFormatted[$classe->id] = $classe->getFormattedClasseName();
           }
        }
        $data = [
            'secondaryClasses' => $secondaryClasses, 
            'secondaryClassesFormatted' => $secondaryClassesFormatted, 
            'primaryClasses' => $primaryClasses, 
            'primarySubjects' => $primarySubjects, 
            'secondarySubjects' => $secondarySubjects,
            'subjects' => $secondarySubjects,
            'months' => $months,
            'roles' => $roles,
            'token' => $token
        ];

        return response()->json($data);
        
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * To update the data of the teacher and related user in database
     * @param  [type] $teacher [description]
     * @param  [type] $user    [description]
     * @param  [type] $data    [description]
     * @return [type]          [description]
     */
    public static function updateTeacherAndUser($teacher, $user, $data)
    {
        $teacher->update($data->all());
        // $user->update($data->only(['name', 'email', 'authorized']));
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['msg' => "deconnection réussie"]);
    }



}
