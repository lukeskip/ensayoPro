<?php

namespace App\Http\Controllers;

use App\Role as Role;
use App\Company as Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\User as User;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
