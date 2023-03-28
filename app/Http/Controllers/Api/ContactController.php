<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Traits\ApiResponses;
use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    use ApiResponses;
    public function index(){
        $contact = Contact::all();
        return $this->data([$contact],200);
    }
    public function show($id)
    {
        $contact = Contact::find($id);
        if(!$contact){
            return $this->error(['error'],'not found');
        }
        return $this->data([$contact],200);

    }

}
