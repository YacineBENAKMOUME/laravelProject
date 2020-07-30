<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator,Redirect,Response;
use App\Post;

class NotificationController extends Controller
{  

    public function index()
    {  
       return Mission::all();
    }

}