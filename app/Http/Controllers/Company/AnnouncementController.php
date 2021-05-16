<?php

namespace App\Http\Controllers\Company;

use App\Announcement;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\AnnouncementRequest;
use App\Http\Resources\Company\AnnouncementResource;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('role:Employer');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Announcement::Where('employer_id',auth()->user()->employer[0]->id)->latest()->get();
        return $this->showAll(AnnouncementResource::collection($user));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnouncementRequest $request)
    {
        $data =  $request->all();
        $data['slug'] =  Str::slug($request->title).'-'.auth()->user()->employer[0]->id.'-'.auth()->user()->id;
        $data['employer_id'] = auth()->user()->employer[0]->id;
        $response = Announcement::create($data);
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
        $announcement = Announcement::where('slug',$id)->first();
        return new AnnouncementResource($announcement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnnouncementRequest $request, $id)
    {
        $data =  $request->all();
        $announcement = Announcement::findorFail($id);
        if($announcement->employer_id === auth()->user()->employer[0]->id) {
            $data['slug'] = Str::slug($request->title) . '-' . auth()->user()->employer[0]->id . '-' . auth()->user()->id;
            $data['employer_id'] = auth()->user()->employer[0]->id;
            $announcement->update($data);
            return $this->showOne($announcement, 201);
        }else{
            return $this->errorResponse("User is not authorize to modify content", 401);
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
        Announcement::findorFail($id)->delete();
        return $this->showMessage("Announcement deleted successfully");
    }
}
