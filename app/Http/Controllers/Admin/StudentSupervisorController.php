<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentSupervisorRequest;
use App\SiwesSupervisor;
use App\SiwesSupervisorStudent;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class StudentSupervisorController extends Controller
{
    use ApiResponser;

    public function __construct() {
        $this->middleware('auth:api');
        $this->middleware('role:Admin');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentSupervisorRequest $request)
    {
        $check = SiwesSupervisorStudent::where('student_id',$request->student_id)
                ->where('siwes_supervisor_id',$request->siwes_supervisor_id)->first();
        if(!$check) {
            SiwesSupervisorStudent::create($request->all());
            return $this->showMessage('student successfully assigned to supervisor');
        }else{
            return $this->showMessage('student already assigned to supervisor',401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supervisor = SiwesSupervisor::find($id);
        return $supervisor->student;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentSupervisorRequest $request, $id)
    {
        $check = SiwesSupervisorStudent::findorFail($id);
        if($check) {
            $check->update($request->all());
            return $this->showMessage('student successfully assigned to supervisor');
        }else{
            return $this->showMessage('not found',401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SiwesSupervisorStudent::findorFail($id)->delete();
        return $this->showMessage("Action successful");
    }
}
