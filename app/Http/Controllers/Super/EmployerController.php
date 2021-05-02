<?php

namespace App\Http\Controllers\Super;

use App\User;
use Exception;
use App\Employer;
use App\Mail\EmployerMail;
use Illuminate\Support\Str;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\EmployerResources;
use App\Http\Requests\SuperAdmin\EmployerRequest;

class EmployerController extends Controller
{
    use ApiResponser;

    public function __construct() {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Employer::latest()->get();
        return $this->showAll(EmployerResources::collection($user));
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
    public function store(EmployerRequest $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->role_id = 5;
        $user->password = Hash::make('qwerty12345');
        $user->save();
        $data =  $request->all();
        $data['slug'] = Str::slug($request->name).'-'.md5(uniqid(rand(), true));
        $data['user_id'] = $user->id;
        $response = Employer::create($data);
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
        $user = Employer::where('slug',$id)->first();
        return new EmployerResources($user);
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
    public function update(EmployerRequest $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);
        $user->email = $request->email;
        $user->save();
        $employer = Employer::where('user_id',$id)->first();
        $data['slug'] = Str::slug($request->name).'-'.md5(uniqid(rand(), true));
        $employer->update($data);
        return $this->successResponse($employer,200);
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
        return $this->showMessage("Company deleted successfully");
    }
}
