<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\PupilsController;
use App\Http\ValidatorsSpaces\ParentsValidators;
use App\Models\Parentable;
use App\Models\Parentor;
use App\Models\Pupil;
use Illuminate\Http\Request;

class ParentsController extends Controller
{
    use ParentsValidators;
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
        //
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
            // return $this->pupilsDataSender([], null, ['status' => true, 'type' => '419']);
        }

        $validator = $this->parentPersoValidator($request->all());

        if ($validator->fails()) {
            return response()->json(['invalidInputs' => $validator->errors()]);
        }

        $parent = Parentor::create($request->all());
        if ($parent) {
            $creator = auth()->user();
            $parent->creator = $creator->name;

            if (in_array('admin', $creator->getRoles()) || in_array('superAdmin', $creator->getRoles())) {
                $parent->authorized = true;
            }
            $parent->save();
        }

        return $this->getAllParents();
    }

    public function joinedParentToPupil(Request $request, $pupil)
    {
        $parentEmail = $request->identify;
        $p = Pupil::find((int)$pupil);

        $parentExisted = Parentor::where('email', $parentEmail)->first();

        if ($parentExisted !== null) {
            if (count(Parentable::all()) > 0) {
                $wasLied = Parentable::where('parentor_id', $parentExisted->id)->where('pupil_id', $p->id)->get();
                if(!wasLied){
                   Parentable::create(['parentor_id' => $parentExisted->id, 'pupil_id' => $p->id, 'relation' => $request->relation]);

                   $controller = (new PupilsController())->getAPupilData($p->id);
                   return $controller;
                }
            }
            else{
                // Parentable::create(['parentor_id' => $parentExisted->id, 'pupil_id' => $p->id, 'relation' => $request->relation]);

               // $controller = (new PupilsController())->getAPupilData($p->id);
               // return $controller;
            }
        }
        return response()->json(['req' => $parentExisted, 'pupil' => $p->parentors()]);
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


    public function getAllParents()
    {
        $parents = Parentor::withTrashed('deleted_at')->get();
        return response()->json($parents);
    }

    public function getAllParentsBySearch($search)
    {
        $parents = Parentor::where('email', 'like', '%'. $search . '%')->orwhere('contact', 'like', '%'. $search . '%')->get();
        return response()->json($parents);
    }
}
