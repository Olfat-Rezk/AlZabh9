<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponses;
use App\Models\Account;
use Illuminate\Http\Request;

class AcountController extends Controller
{
    use ApiResponses;
    public function index(){
        $account = Account::all();
        return $this->data([$account]);
    }
}
