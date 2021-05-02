<?php

namespace App\Http\Controllers\Super;

use App\Training;
use Illuminate\Support\Str;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TrainingResource;
use App\Http\Requests\SuperAdmin\TrainingRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrainingController extends Controller
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
        $training = Training::latest()->get();
        return $this->showAll(TrainingResource::collection($training));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrainingRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $data['user_type'] = 'admin';
        $data['slug'] = Str::slug($request->name).'-'.md5(uniqid(rand(), true));
        Training::create($data);
        return $this->showMessage("Training created successfully",201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $training = Training::where('slug',$id)->first();
        if($training){
            return new TrainingResource($training);
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
    public function update(Request $request, $id)
    {
        $training = Training::findorFail($id);
        $data['user_id'] = auth()->user()->id;
        $data['user_type'] = 'admin';
        $data['slug'] = Str::slug($request->name).'-'.md5(uniqid(rand(), true));
        if(auth()->user()->id == $training->user_id){
            $training->update($data);
            return $this->showMessage("Training updated successfully",200);
        }else{
            throw new HttpException(422,'The user is not the creator of this training');
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
        Training::findorFail($id)->delete();
        return $this->showMessage("Training successfully deleted");
    }
}
