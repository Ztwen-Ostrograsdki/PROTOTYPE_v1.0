<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\SuperAdminController;
use App\Http\ManagersAndDrivers\Authenticator;
use App\Http\ValidatorsSpaces\TeachersValidators;
use App\ModelHelper;
use App\Models\Classe;
use App\Models\Pupil;
use App\Models\Teacher;
use App\User;
use Illuminate\Http\Request;

class TeachersController extends Controller
{
    use TeachersValidators;

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

        return view('directors.teachers.index');
    }

    /**
     * Use to get a data of a pupil
     * @param  int    $id [description]
     * @return a json response to a view
     */
    public function getATeacherData(int $id)
    {
        $token = csrf_token();
        $teacher = Teacher::withTrashed('deleted_at')->whereId($id)->firstOrFail();
        $birthday = ModelHelper::birthFormattor($teacher, 0);
        $allClasses = Classe::whereLevel('secondary')->get();

        $classes = []; //Les classes de l'enseignant
        
        
        if ($teacher->classes->count() > 0) {
            foreach ($teacher->classes as $classe) {
                $classes[] = $classe->id;
            }
        }

        $classesFMT = $teacher->getFormattedclasses();

        $isAE = $teacher->isAE();

        $helper = (new ModelHelper($teacher))->setLastNameAndFirstName();
        $lastName = $helper->getLastName();
        $firstName = $helper->getFirstName();

        if ($teacher->level == "secondary") {
            $classesConcerned = $teacher->classesConcernedByThisTeacher(); //Classes pouvant recevoir les cours de l'enseignant
            $classesRefused = $teacher->classesConcernedByThisTeacherButNot();
        }
        else{
            $classesC = Classe::whereLevel('primary')->get();
            $classesConcerned = [];
            foreach ($classesC as $cc) {
                $classesConcerned[$cc->id] = $cc;
            }
            $classesRefused = $teacher->classesConcernedByThisTeacherButNot('primary');
        }

        $data = [
            'teacher' => $teacher,
            'token' => $token,
            'classes' => $classes,
            'targetedTeacherClassesFMT' => $classesFMT,
            'targetedTeacherLastName' => $lastName,
            'targetedTeacherFirstName' => $firstName,
            'classesConcerned' => $classesConcerned,
            'classesRefused' => $classesRefused,
            'isAE' => $isAE
        ];

        return response()->json($data);


    }



     /**
     * Use to send a data to a view in ajax
     * @return a json response 
     */
    public function teachersDataSender($teacherEdited = null, array $errors = [])
    {
        $user = auth()->user();
        $admin = false;
        $roles = $user->getRoles();

        if (in_array('admin', $roles) || in_array('superAdmin', $roles)) {
            $admin = true;
        }

        $AllTeachersWithClasses = [];
        $AllTeachersWithSubject = [];
        $TSBlockeds = [];
        $TPBlockeds = [];
        $teachers = Teacher::withTrashed('deleted_at')->orderBy('name', 'asc')->get();
        $userLength = User::all()->count();
        $p = Pupil::all()->count();
        $ts = Teacher::whereLevel('secondary')->count();
        $tp = Teacher::whereLevel('primary')->count();
        $TBSLength = count(Teacher::getBlockeds('secondary'));
        $TBPLength = count(Teacher::getBlockeds('primary'));
        $blockeds = Teacher::getBlockeds();

        if (count($blockeds) > 0) {
            foreach ($blockeds as $tb) {
               if ($tb->level == "secondary") {
                   $TSBlockeds[] = $tb;
               }
               elseif ($tb->level == "primary") {
                   $TPBlockeds[] = $tb;
               }
            }
        }


        foreach ($teachers as $teacher) {
            if ($teacher->level == 'secondary') {
                $AllTeachersWithSubject[$teacher->id] = $teacher->subject;
                if ($teacher->classes->count() > 0) {
                    $classes = [];
                    foreach ($teacher->classes as $classe) {
                        $classes[] = $classe->getFormattedClasseName();
                        $AllTeachersWithClasses[$teacher->id] = $classes;
                    }
                }
                else{
                    $AllTeachersWithClasses[$teacher->id] = 'Aucune';
                }
                
            }
            else{
                $AllTeachersWithSubject[$teacher->id] = "Maitre";
                $classes = $teacher->classes;
                if ($classes->toArray() !== []) {
                    $AllTeachersWithClasses[$teacher->id] = [$classes[0]->getFormattedClasseName()];
                }
                else{
                    $AllTeachersWithClasses[$teacher->id] = "Aucune";
                }
            }
        }

        $teachersSecondary = Teacher::whereLevel('secondary')->orderBy('name', 'asc')->get();
        $teachersPrimary = Teacher::whereLevel('primary')->orderBy('name', 'asc')->get();

        $data = [
            'user' => $user,
            'admin' => $admin,
            't' => $teachers,
            'tSec' => $teachersSecondary, 
            'tPrim' => $teachersPrimary, 
            'allTWC' => $AllTeachersWithClasses, 
            'allTWS' => $AllTeachersWithSubject, 
            'userLength' => $userLength, 
            'p' => $p, 
            'ts' => $ts, 
            'tp' => $tp, 
            'tblockeds' => $blockeds, 
            'TSBlockeds' => $TSBlockeds, 
            'TPBlockeds' => $TPBlockeds, 
            'TBSLength' => $TBSLength, 
            'TBPLength' => $TBPLength
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function joinedTeacherToClasses(Request $request, int $id)
    {
        if ((!$request->filled('token') || $request->token == "") || ($request->filled('token') && $request->token !== csrf_token())) {
            return $this->teachersDataSender(null, ['status' => true, 'type' => '419']);
        }


        $teacher = Teacher::withTrashed('deleted_at')->whereId((int)$id)->firstOrFail();

        $validator = $this->teacherValidateClasses($request->all(), $id);

        if ($validator === false) {
            return response()->json(['invalidInputs' => "Veuillez choisir au moins une classe valide"]);
        }

        if ($validator !== []) {
            if ($teacher->level == "secondary") {
                foreach ($validator as $classe) {
                    $teacher->classes()->attach($classe);
                }
            }
            elseif ($teacher->level == "primary") {

                $oldClasse = Classe::find($teacher->classes);

                if (count($oldClasse) > 0) {
                    $teacher->classes()->detach($oldClasse[0]->id);
                    $oldClasse[0]->teacher_id = null;
                    $oldClasse[0]->save();
                    
                }
                
                $teacher->classes()->attach($validator[0]);
                $newClasse = Classe::find($validator[0]);
                $newClasse->teacher_id = $teacher->id;
                $newClasse->save();
            }

            $updater = auth()->user();
            $teacher->editor = $updater->name;
            if (in_array('admin', $updater->getRoles()) || in_array('superAdmin', $updater->getRoles())) {
                $teacher->authorized = true;
            }
            $teacher->save();
        }

        return $this->teachersDataSender($teacher, []);
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
     * Store a new teacher if withuser === true store also user with the same data of the related teacher.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createTeacher(Request $request, $withUser = false)
    {
        $level = $request->level;
        $request->creator = auth()->user()->name;
        $validator = $this->teachersValidator($request->all(), $level);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => 12345,
            'role' => $request->role,
            'authorized' => $request->authorized
            ];

        if ($level === 'primary') {
            $request->subject_id = null;
            $input = $request->except(['classe', 'role']);

            $teacher = Teacher::create($input);
            
            if ($withUser) {
                AdminController::createUser($teacher, $data);
            }

            if ($request->filled('classe')) {
                $classe = Classe::find((int)$request->classe);
                $classe->teacher_id = $teacher->id;
                $classe->save();
                $teacher->classes()->attach($classe->id);
                return response()->json(['success'=> 'Vous '.$teacher->name, 'classe' => $classe->name, 'level' => $level]);
            }
            return response()->json(['success'=> 'Vous '.$teacher->name, 'level' => $level]);
        }
        elseif ($level === 'secondary') {
            $input = $request->except('role');
            $teacher = Teacher::create($input);
            
            if ($withUser) {
                AdminController::createUser($teacher, $data);
            }
            return response()->json(['success'=> 'Vous '.$teacher->name, 'level' => $level]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token_auth = Authenticator::__AUTH_TOKEN($request->token);
        if ($token_auth !== []) {
            return response()->json($token_auth);
        }
        else{
            $validator = $this->validateNewTeachersInputs($request->all());
            if ($validator->fails()) {
                return response()->json(['invalidInputs' => $validator->errors()]);
            }
            else{
                $user = Authenticator::__GET_MODELS_IF_EXISTS_BY_NAME_OR_EMAIL(User::class, $request->name, $request->email);
                if ($user !== null) {
                    if ($user->name == $request->name && $user->email == $request->email) {
                        $teacher = Teacher::create($request->all());
                        if ($teacher) {
                            $user->teachers()->attach($teacher->id);
                        }
                    }
                    else{
                        return response()->json(['invalidInputs' => ['user' => ["Nous avons détecter un utilisateur utilisant déjà des données similaires, consulter l'administrateur pour avoir plus de détails!"]]]);
                    }
                }
                else{
                    $teacher = Teacher::create($request->all());
                    if ($teacher) {
                        $data = [
                            'name' => $request->name,
                            'email' => $request->email,
                            'password' => 12345,
                            'role' => 'teacher',
                            'authorized' => $request->authorized
                        ];
                        $user = AdminController::createUser($teacher, $data, 'teacher');
                    }
                }
            }
        }

        return $this->teachersDataSender();

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return view('directors.teachers.profil');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $teacher = Teacher::find((int)$id);
        if ($teacher->level === "primary") {
            if ($teacher->classes->count() > 0) {
                $classe = $teacher->classes[0]->id;
            }
            else{
                $classe = null;
            }
        }
        else{
            $classe = null;
        }

        $role = $teacher->user()->role;
        return response()->json(['teacher'=> $teacher, 'role' => $role, 'classe' => $classe]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePersonalTeacherData(Request $request, int $id, $withuser = true)
    {
        $id = $request->teacher_id;
        $teacher = Teacher::find((int)$id);
        $level = $teacher->level;

        $validator = $this->teachersValidator($request->all(), $level, $id);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        if ($level === 'primary') {
            $request->subject_id = null;
            $input = $request->except(['classe', 'id']);

            if ($request->filled('classe')) {
                $classe = Classe::find((int)$request->classe);
                $classe->teacher_id = $teacher->id;
                $classe->save();
                $teacher->classes()->attach($classe->id);
            }

            $teacher->update($input);
            ($teacher->user())->update($request->only(['name', 'email', 'authorized', 'editor', 'role']));
            $teacher = Teacher::find($id);
            return response()->json(['success'=> $teacher]);
        }

        elseif ($level === "secondary") {
            $input = $request->except(['id', 'classe']);
            $teacher->update($input);
            ($teacher->user())->update($request->only(['name', 'email', 'authorized', 'editor', 'role']));

            $teacher = Teacher::find($id);
            $subject = $teacher->subject->name;
            return response()->json(['success'=> $teacher, 'subject' => $subject]);
        }
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
     * Detach teacher to a specific classe
     * @param  int $teacher 
     * @param  int    $classe  
     * @return [type]          
     */
    public function detachTeacherAndClasse(int $teacher, $classe)
    {
        $teacher = Teacher::find((int)$teacher);
        $classeID = (int)$classe;

        if ($classe !== 'fresh' && is_int($classeID)) {

            $classes = [];

            $teacherClasses = $teacher->classes;

            if ($teacher->level == 'secondary' || $teacher->level == 'primary') {
                if ($teacher->classes->count() > 0) {
                    foreach ($teacher->classes as $classe) {
                        $classes[] = $classe->id;
                    }
                }
            }

            if ($classes == [] || ($classes !== [] && !in_array($classeID, $classes))) {
                return response()->json(["failed" => "La requête est inconnue"]);
            }
            else{
                $c = Classe::find($classeID);
                $teacher->classes()->detach($classeID);
                if ($c->teacher_id == $teacher->id) {
                    $c->teacher_id = null;
                    $c->save();
                }
                return response()->json(["success" => "Le prof " .$teacher->name. " ne garde plus la classe de ". $c->name]);
            }
            
        }
        elseif($classe == 'fresh') {
            $classes = $teacher->classes;
            foreach ($classes as $classe) {
                $teacherIsPrincipal = $teacher->classe;
                if ($teacherIsPrincipal !== null) {
                    $classe->teacher_id = null;
                    $classe->save();
                }
                $teacher->classes()->detach($classe->id);
            }
            
        }

        return response()->json(["success" => "Le prof " .$teacher->name. " ne garde plus de classe!"]);

        // return $this->teachersDataSender($teacher, []);
        
    }

        
  
    
}
