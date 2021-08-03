<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\users;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->request->get('page') <> '')
        {
            $page = $request->get('page');
            $user = users::orderBy('users.UserID')->skip(($page-1)*15)->take(15)->get();
        }
        else
        {
            $user = users::orderBy('users.UserID')->take(15)->get();
        }
        if ($user->count() > 0)
        {
            return response()->json($user, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function GetUserByID($UserID)
    {
        $user = users::where('UserID', $UserID)->get();
        if ($user->count() > 0)
        {
            return response()->json($user, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }

    public function GetUserByUserName($UserName)
    {
        $user = users::where('UserName', $UserName)->get();
        if ($user->count() > 0)
        {
            return response()->json($user, 200);
        }
        else
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }
    }
}
