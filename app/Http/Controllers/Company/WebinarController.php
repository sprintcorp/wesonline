<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\WebinarRequest;
use App\Http\Resources\Company\AnnouncementResource;
use App\Http\Resources\Company\WebinarResource;
use App\Service\Fileupload;
use App\Traits\ApiResponser;
use App\Webinar;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebinarController extends Controller
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
        $webinar = Webinar::Where('employer_id',auth()->user()->employer[0]->id)->latest()->get();
        return $this->showAll(WebinarResource::collection($webinar));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WebinarRequest $request)
    {
        $data = $request->all();
        try {
            $image = $this->fileupload->image($request->file('image')->getRealPath());
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(),500);
        }
        $data['employer_id'] = auth()->user()->employer[0]->id;
        $data['slug'] = Str::slug($request->title).'-'.md5(uniqid(rand(), true));
        $data['image'] = $image->getSecurePath();
        $data['image_id'] = $image->getPublicId();
        $webinar = Webinar::create($data);
        return $this->successResponse($webinar,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $webinar = Webinar::where('slug',$id)->first();
        if($webinar) {
            return new WebinarResource($webinar);
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
        $webinar = Webinar::findorFail($id);
        $data = $request->all();
        if($webinar->employer_id === auth()->user()->employer[0]->id) {
            if ($request->hasFile('image')) {
                try {
                    $res = $this->fileupload->deleteFile($webinar->image_id);
                    if ($res) {
                        $image = $this->fileupload->image($request->file('image')->getRealPath());
                        $data['image'] = $image->getSecurePath();
                        $data['image_id'] = $image->getPublicId();
                    }
                } catch (\Exception $exception) {
                    return $this->errorResponse($exception->getMessage(), 500);
                }
            }
            $data['employer_id'] = auth()->user()->employer[0]->id;
            $data['slug'] = Str::slug($request->title) . '-' . md5(uniqid(rand(), true));
            $webinar->update($data);
            return $this->successResponse($webinar, 201);
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
        $webinar = Webinar::findorFail($id);
        $res = $this->fileupload->deleteFile($webinar->image_id);
        if($res) {
            $webinar->delete();
            return $this->showMessage("Webinar deleted successfully");
        }
    }
}
