<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\ModuleRequest;
use App\Http\Resources\ModuleResource;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;
use App\Module;
use App\Section;
use App\Service\Fileupload;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ModuleController extends Controller
{
    use ApiResponser;
    private $fileupload;

    public function __construct(Fileupload $fileupload)
    {
        $this->middleware('auth:api');
        $this->fileupload = $fileupload;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(ModuleRequest $request)
    {
        $data = $request->all();
        $module = $this->fileupload->video($request->file('module')->getRealPath());
        $data['user_id'] = auth()->user()->id;
        $data['slug'] = Str::slug($request->name).'-'.md5(uniqid(rand(), true));
        $data['module'] = $module->getSecurePath();
        $data['module_id'] = $module->getPublicId();
        $data['user_type'] = 'admin';
//        $data['section_id'] = 1;
            if ($request->has('assessment')) {
                $assessment = $this->fileupload->document($request->file('assessment')->getRealPath());
                $data['assessment'] = $assessment->getSecurePath();
                $data['assessment_id'] = $assessment->getPublicId();
            }
            if ($request->has('document')) {
                $document = $this->fileupload->document($request->file('document')->getRealPath());
                $data['document'] = $document->getSecurePath();
                $data['document_id'] = $document->getPublicId();
            }

        Module::create($data);
            return $this->showMessage("Module created successfully",201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $module = Module::where('slug',$id)->first();
        if($module){
            return new ModuleResource($module);
        }else{
            throw new NotFoundHttpException('not found');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModuleRequest $request, $id)
    {
        $response = Module::findorFail($id);
        $data = $request->all();
        if($request->has('module')){
            if($response->module) {
                Cloudinary::delete($response->module_id);
            }
            $module = $this->fileupload->video($request->file('module')->getRealPath());
            $data['module'] = $module->getSecurePath();
            $data['module_id'] = $module->getPublicId();
        }
        $data['user_id'] = auth()->user()->id;
        $data['slug'] = Str::slug($request->name).'-'.md5(uniqid(rand(), true));

        $data['user_type'] = 'admin';
//        $data['section_id'] = 1;
        if ($request->has('assessment')) {
            if($response->assessment) {
                Cloudinary::delete($response->assessment_id);
            }
            $assessment = $this->fileupload->document($request->file('assessment')->getRealPath());
            $data['assessment'] = $assessment->getSecurePath();
            $data['assessment_id'] = $assessment->getPublicId();
        }
        if ($request->has('document')) {
            if($response->document) {
                Cloudinary::delete($response->document_id);
            }
            $document = $this->fileupload->document($request->file('document')->getRealPath());
            $data['document'] = $document->getSecurePath();
            $data['document_id'] = $document->getPublicId();
        }

        $response->update($data);
        return $this->showMessage("Module updated successfully",200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $module = Module::findorFail($id);
        $public_id = "cd4fskjmkackjy3p6kxt";
//        if($module->module) {
            Cloudinary::destroy($public_id);
//            Cloudinary::destroy($module->assessment_id,[]);
//            Cloudinary::destroy($module->document_id,[]);
//        }
//        $module->delete();
        return $this->showMessage("Module deleted successfully");
    }
}
