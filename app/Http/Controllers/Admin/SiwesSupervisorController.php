<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SiwesSupervisorRequest;
use App\Http\Resources\Admin\SiwesSupervisorResource;
use App\Mail\SiwesRegistrationMail;
use App\Service\CheckUser;
use App\Service\Fileupload;
use App\SiwesSupervisor;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SiwesSupervisorController extends Controller
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
        $user = SiwesSupervisor::Where('institution_id',auth()->user()->institution[0]->id)->latest()->get();
        return $this->showAll(SiwesSupervisorResource::collection($user));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiwesSupervisorRequest $request)
    {
        $check = $this->checkUser->checkUserMail($request->email);
        if($check){
            return $this->showMessage("User email address already exist as ".$check->role->name,200);
        }else{
            $user = new User();
            $user->email = $request->email;
            $user->role_id = 3;
            $user->password = Hash::make('qwerty12345');
            $user->save();
        }


        $data =  $request->all();
        $data['slug'] =  Str::slug($request->firstname).'-'.Str::slug($request->lastname).'-'.$user->id;
        $data['user_id'] = $user->id;
        $data['institution_id'] = auth()->user()->institution[0]->id;
        $response = SiwesSupervisor::create($data);

        Mail::to($user->email)->send(new SiwesRegistrationMail($user));
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
        $user = SiwesSupervisor::where('slug',$id)->first();
        return new SiwesSupervisorResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SiwesSupervisorRequest $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);
        $user->email = $request->email;
        $user->save();
        $siwes = SiwesSupervisor::where('user_id',$id)->first();
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
        return $this->showMessage("Supervisor deleted successfully");
    }
}
