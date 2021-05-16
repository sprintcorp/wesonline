<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentRequest;
use App\Http\Resources\Admin\StudentResource;
use App\Mail\StudentMail;
use App\Service\CheckUser;
use App\Student;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    use ApiResponser;

    private $checkUser;

    public function __construct(CheckUser $checkUser)
    {
        $this->middleware('auth:api');
        $this->middleware('role:Admin');
        $this->checkUser = $checkUser;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Student::Where('institution_id',auth()->user()->institution[0]->id)->latest()->get();
        return $this->showAll(StudentResource::collection($user));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        $check = $this->checkUser->checkUserMail($request->email);
        if($check){
            return $this->showMessage("User with this email already exist ",200);
        }else{
            $user = new User();
            $user->email = $request->email;
            $user->role_id = 4;
            $user->password = Hash::make('qwerty12345');
            $user->save();
        }
        $data = $request->all();
        $data['slug'] =  Str::slug($request->firstname).'-'.Str::slug($request->lastname).'-'.$user->id;
        $data['user_id'] = $user->id;
        $data['institution_id'] = auth()->user()->institution[0]->id;
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
        $siwes = Student::where('user_id',$id)->first();
        $data['institution_id'] = auth()->user()->institution[0]->id;

        $data['slug'] = Str::slug($request->firstname).'-'.Str::slug($request->lastname).'-'.$user->id;
        $siwes->update($data);
        return $this->successResponse($siwes,200);
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
