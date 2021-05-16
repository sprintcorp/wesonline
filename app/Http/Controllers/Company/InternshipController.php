<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\InternshipRequest;
use App\Http\Resources\Company\InternshipResource;
use App\Internship;
use App\Service\Fileupload;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class InternshipController extends Controller
{
    use ApiResponser;
    private $fileupload;
    public function __construct(Fileupload $fileupload)
    {
        $this->middleware('auth:api');
        $this->middleware('role:Employer');
        $this->fileupload = $fileupload;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $internship = Internship::Where('employer_id',auth()->user()->employer[0]->id)->latest()->get();
        return $this->showAll(InternshipResource::collection($internship));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InternshipRequest $request)
    {
        $data = $request->all();
        try {
            if ($request->hasFile('video')) {
                $video = $this->fileupload->video($request->file('video')->getRealPath());
                $data['video'] = $video->getSecurePath();
            }
            if ($request->hasFile('document')) {
                $document = $this->fileupload->document($request->file('document')->getRealPath());
                $data['document'] = $document->getSecurePath();
            }
            if ($request->hasFile('task')) {
                $task = $this->fileupload->document($request->file('task')->getRealPath());
                $data['task'] = $task->getSecurePath();
            }

        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(),500);
        }
        $data['employer_id'] = auth()->user()->employer[0]->id;
        $data['slug'] = Str::slug($request->name).'-'.md5(uniqid(rand(), true));



        $internship = Internship::create($data);
        return $this->successResponse($internship,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $internship = Internship::where('slug',$id)->first();
        if($internship) {
            return new InternshipResource($internship);
        }else{
            throw new ModelNotFoundException();
        }
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
        $internship = Internship::findorFail($id);
        $data = $request->all();
        try {
            if ($request->hasFile('video')) {
                $video = $this->fileupload->video($request->file('video')->getRealPath());
                $data['video'] = $video->getSecurePath();
            }
            if ($request->hasFile('document')) {
                $document = $this->fileupload->document($request->file('document')->getRealPath());
                $data['document'] = $document->getSecurePath();
            }
            if ($request->hasFile('task')) {
                $task = $this->fileupload->document($request->file('task')->getRealPath());
                $data['task'] = $task->getSecurePath();
            }
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(),500);
        }
        $data['employer_id'] = auth()->user()->employer[0]->id;
        $data['slug'] = Str::slug($request->name).'-'.md5(uniqid(rand(), true));
        $internship->update($data);
        return $this->successResponse($internship,201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Internship::findorFail($id)->delete();
        return $this->showMessage("Internship deleted successfully");
    }
}
