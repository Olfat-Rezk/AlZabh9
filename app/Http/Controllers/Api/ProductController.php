<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponses;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponses;
    public function index(){
        $product = Products::latest()->paginate(10);
        return $this->data([$product],200);
    }

    public function show($id){
        $product = Products::find($id);
        if(!$product){
            return $this->error('there is no product');
        }
        return $this->data([$product]);
    }
}
