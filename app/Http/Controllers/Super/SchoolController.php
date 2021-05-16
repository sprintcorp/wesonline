<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\InstitutionRequest;
use App\Http\Resources\InstitutionResource;
use App\Http\Resources\InstitutionStudentResources;
use App\Http\Resources\StudentResource;
use App\Institution;
use App\Mail\InstitutionMail;
use App\Student;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SchoolController extends Controller
{
    use ApiResponser;

    public function __construct() {
        $this->middleware('auth:api');
//        $this->middleware('permission:Create student',['except' => ['create','update','delete','index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Institution::latest()->get();
        return $this->showAll(InstitutionResource::collection($user));
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
    public function store(InstitutionRequest $request)
    {

        $user = new User();
        $user->email = $request->email;
        $user->role_id = 1;
        $user->password = Hash::make('qwerty12345');
        $user->save();
        $data =  $request->all();
        $data['slug'] = Str::slug($request->name).'-'.$user->id;
        $data['user_id'] = $user->id;
        $response = Institution::create($data);
        Mail::to($user->email)->send(new InstitutionMail($user));
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
        $user = Institution::where('slug',$id)->first();
        if($user) {
            return new InstitutionStudentResources($user);
        }else{
            throw new NotFoundHttpException();
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InstitutionRequest $request, $id)
    {
//        dd($request->all());
        $data = $request->all();
        $user = User::find($id);
        $user->email = $request->email;
        $user->save();
        $institution = Institution::where('user_id',$id)->first();
        $data['slug'] = Str::slug($request->name).'-'.$user->id;
        $institution->update($data);
        return $this->successResponse($institution,200);
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
        return $this->showMessage("Institution deleted successfully");
    }
}
