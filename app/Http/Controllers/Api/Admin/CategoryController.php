<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Traits\ApiResponses;
use App\Models\Category;
use App\Services\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CategoryResource::collection(Category::latest()->paginate(10));
        return $this->data([$categories],'all categories',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $file_name = $this->saveImage($request->photo,'images\category');
        $categories = new Category();
        $categories['name']=$request->name;
        $categories['photo']= $this->$file_name;
        $categories->save();
        return $this->data([$categories],'category stored successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = new CategoryResource(Category::find($id));
        if(!$categories){
            return $this->error(['no category is founded']);
        }
        return $this->data([$categories],200);
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
        $categories = new CategoryResource(Category::find($id));
        if(!$categories){
            return $this->error(['no category is founded']);
        }
        $file_name = $this->saveImage($request->photo,'images\category');
        $categories = new Category();
        $categories['name']=$request->name;
        $categories['photo']= $this->$file_name;
        $categories->save();
        return $this->data([$categories],'category stored successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $categories = new CategoryResource(Category::where('id',$id)->withTrashed()->restore());

        if(!$categories){
            return $this->error(['the category not found']);
        }

        return $this->success('the carergory is restored successfully');
    }
    public function forceDelete($id){


        $categories = new CategoryResource(Category::where('id',$id)->withTrashed()->forceDelete());
        $categories = $this->removeImage(public_path('images\product\\'.$categories->image));

        return $this->success('the category is deleted');



    }
    public function restoreAll(){
        $categories = CategoryResource::collection(Category::all());

        $categories::onlyTrashed()->restore();
        return $this->success('the trashed categories are restored');

    }
}
