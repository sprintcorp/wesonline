<?php

namespace App\Http\Controllers\Super;

use App\Http\Resources\SectionResource;
use App\Section;
use App\Training;
use App\Traits\ApiResponser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\SectionRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class SectionController extends Controller
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
//        $training = Training::where('slug',$_GET['slug'])->latest()->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request)
    {
        $data = $request->all();
        $training = Training::where('slug',$request->training_id)->first();
        if($training){
            $data['user_id'] = auth()->user()->id;
            $data['training_id'] = $training->id;
            $data['user_type'] = 'admin';
            $data['slug'] = Str::slug($request->name).'-'.md5(uniqid(rand(), true));
            Section::create($data);
            return $this->showMessage("Section created successfully",201);
        }else{
             throw new NotFoundHttpException('not found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $section = Section::where('slug',$id)->first();
        if($section){
            return new SectionResource($section);
        }else{
            throw new RouteNotFoundException('Section not found',404);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param SectionRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $request, $id)
    {
        $section = Section::findorFail($id);
        $data = $request->all();
        if($section->user_id == auth()->user()->id){
            $data['slug'] = Str::slug($request->name).'-'.md5(uniqid(rand(), true));
            $section->update($data);
            return $this->showMessage("Section updated successfully",200);
        }else{
            throw new HttpException(422,'The user is not the creator of this section');
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
        Section::findorFail($id)->delete();
        return $this->showMessage("Section successfully deleted");
    }
}
