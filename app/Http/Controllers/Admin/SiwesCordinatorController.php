<?php

namespace App\Http\Controllers\Admin;

use App\Employer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SiwesCordinatorRequest;
use App\Http\Resources\Admin\SiwesCordinatorResource;
use App\Mail\CordinatorRegistrationMail;
use App\Mail\EmployerMail;
//use App\Mail\SiwesRegistrationMail;
use App\SiwesCordinator;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SiwesCordinatorController extends Controller
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
        $user = SiwesCordinator::Where('institution_id',auth()->user()->institution[0]->id)->latest()->get();
        return $this->showAll(SiwesCordinatorResource::collection($user));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiwesCordinatorRequest $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->role_id = 2;
        $user->password = Hash::make('qwerty12345');
        $user->save();
        $data =  $request->all();
        $data['slug'] =  Str::slug($request->firstname).'-'.Str::slug($request->lastname).'-'.$user->id;
        $data['user_id'] = $user->id;
        $data['institution_id'] = auth()->user()->institution[0]->id;
        $response = SiwesCordinator::create($data);

        Mail::to($user->email)->send(new CordinatorRegistrationMail($user));
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
        $user = SiwesCordinator::where('slug',$id)->first();
        return new SiwesCordinatorResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SiwesCordinatorRequest $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);
//        return $user;
        $user->email = $request->email;
        $user->save();
        $siwes = SiwesCordinator::where('user_id',$id)->first();
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
        return $this->showMessage("Coordinator deleted successfully");
    }
}
