<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function auth()
    {
    	if (auth()->user()) {
    		$r = true;
    	}
    	else{
    		$r = false;
    	}
    	return response()->json($r);
    }

    public function getUsers()
    {
        $addresses = [];
        $users = User::all();

        foreach ($users as $user) {
            $addresses[$user->email] = $user;
        }
        return response()->json(['users' => $users, 'addresses' => $addresses]);
    }
}
