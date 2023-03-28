<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponses;
use App\Models\Shreeder;
use Illuminate\Http\Request;

class ShreederController extends Controller
{ use ApiResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $shreeder = Shreeder::all();
        return $this->data([$shreeder]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $shreeder = Shreeder::find($id);
        if(!$shreeder){
            return $this->error(['error'],'not found');
        }
        return $this->data([$shreeder],200);

    }


}
