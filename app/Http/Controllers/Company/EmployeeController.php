<?php

namespace App\Http\Controllers\Company;

use App\Employee;
use App\Employer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\EmployeeRequest;
use App\Http\Resources\Company\EmployeeResource;
use App\Mail\EmployerMail;
use App\Service\CheckUser;
use App\Service\Fileupload;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    use ApiResponser;

    private $checkUser;

    public function __construct(CheckUser $checkUser)
    {
        $this->middleware('auth:api');
        $this->middleware('role:Employer');
        $this->checkUser = $checkUser;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Employee::Where('employer_id',auth()->user()->employer[0]->id)->latest()->get();
        return $this->showAll(EmployeeResource::collection($user));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {

        $user = new User();
        $user->email = $request->email;
        $user->role_id = 6;
        $user->password = Hash::make('qwerty12345');
        $user->save();
        $data =  $request->all();
        $data['slug'] =  Str::slug($request->firstname).'-'.Str::slug($request->lastname).'-'.$user->id;
        $data['user_id'] = $user->id;
        $data['employer_id'] = auth()->user()->employer[0]->id;
        $response = Employee::create($data);
        Mail::to($user->email)->send(new EmployerMail($user));
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
        $user = Employee::where('slug',$id)->first();
        return new EmployeeResource($user);
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
        $data = $request->all();
        $user = User::find($id);
        $user->email = $request->email;
        $user->save();
        $employee = Employee::where('user_id',$id)->first();
        $data['employer_id'] = auth()->user()->employer[0]->id;

        $data['slug'] = Str::slug($request->firstname).'-'.Str::slug($request->lastname).'-'.$user->id;
        $employee->update($data);
        return $this->successResponse($employee,200);
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
        return $this->showMessage("Employee deleted successfully");
    }
}
