<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\User solved the problem 'Undefined type 'App\Http\Controllers\User'.'
use App\Models\User;
use App\Models\Post;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
        public function __construct()
        {
            $this->middleware('auth');
        }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        // use App\Models\User solved the problem
        $user = User::find($user_id);
        //Wtihout the below line , it was not recoginizing posts as a property
        //Routing has changed a lot since then
       // return $user;

        return view('dashboard')->with('posts', $user ->posts);
    }
}
