<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\StudentRequest;
use App\Http\Resources\StudentResource;
use App\Mail\StudentMail;
use App\Student;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    use ApiResponser;

    public function __construct() {
        $this->middleware('auth:api');
        $this->middleware('role:System');
        $this->middleware('permission:Create student',['only' => ['store','update','delete','index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Student::latest()->get();
        return $this->showAll(StudentResource::collection($user));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StudentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
//        return "hello";
        $user = new User();
        $user->email = $request->email;
        $user->role_id = 4;
        $user->password = Hash::make('qwerty12345');
        $user->save();
        $data =  $request->all();
        $data['slug'] =  Str::slug($request->firstname).'-'.Str::slug($request->lastname).'-'.$user->id;
        $data['user_id'] = $user->id;
        $response = Student::create($data);
        Mail::to($user->email)->send(new StudentMail($user));
        return $this->successResponse($response,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Student::where('slug',$id)->first();
        return new StudentResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);
        $user->email = $request->email;
        $user->save();
        $student = Student::where('user_id',$id)->first();
        $data['slug'] = Str::slug($request->firstname).'-'.Str::slug($request->lastname).'-'.$user->id;
        $student->update($data);
        return $this->successResponse($student,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findorFail($id)->delete();
        return $this->showMessage("Student deleted successfully");
    }
}
