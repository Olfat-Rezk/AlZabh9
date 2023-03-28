<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponses;
use App\Models\packing;

class PackingController extends Controller
{
    use ApiResponses;
    public function index(){
        $packing = packing::all();
        return $this->data([$packing],200);
    }
    public function show($id)
    {
        $packing = packing::find($id);
        if(!$packing){
            return $this->error(['error'],'not found');
        }
        return $this->data([$packing],200);

    }

}
