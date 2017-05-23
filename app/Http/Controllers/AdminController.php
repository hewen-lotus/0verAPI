<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Auth;
use DB;

use App\User;
use App\Admin;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->can('list_admin', User::class)) {
            return User::has('admin')->with('admin')->get();
        }

        $messages = array('User don\'t have permission to access');

        return response()->json(compact('messages'), 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (User::where('username', '=', $id)->has('admin')->exists()) {
            $data = User::where('username', '=', $id)->with('admin')->first();

            $user = Auth::user();

            if ($user->can('view_admin', $data)) {
                return $data;
            }

            $messages = array('User don\'t have permission to access');

            return response()->json(compact('messages'), 403);
        }

        $messages = array('User Data Not Found!');

        return response()->json(compact('messages'), 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->can('create_admin', User::class)) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:191|unique:admins,username|unique:users,username',
                'password' => 'required|string|min:6',
                'email' => 'present|email',
                'name' => 'required|string',
                'eng_name' => 'required|string',
                'phone' => 'required|string',
                'has_admin' => 'present|boolean',
                'has_banned' => 'present|boolean',
            ]);

            if ($validator->fails()) {
                $messages = $validator->errors()->all();
                return response()->json(compact('messages'), 400);
            }

            return DB::transaction(function () use ($request) {
                User::create([
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'email' => $request->email,
                    'name' => $request->name,
                    'eng_name' => $request->eng_name,
                    'phone' => $request->phone,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);

                Admin::create([
                    'username' => $request->username,
                    'has_admin' => $request->input('has_admin', 0),
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);

                if ((bool)$request->input('has_banned')) {
                    //User::where('username', '=', $request->username)->delete();

                    Admin::where('username', '=', $request->username)->update([
                        'deleted_by' => Auth::id(),
                    ]);

                    Admin::where('username', '=', $request->username)->delete();
                }

                return response()->json(User::where('username', '=', $request->username)
                    ->with([
                        'admin' => function ($query) {
                            $query->withTrashed();
                        }
                    ])->first(), 201);
            });
        }

        $messages = array('User don\'t have permission to access');

        return response()->json(compact('messages'), 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Admin::where('username', '=', $id)->exists()) {
            $data = User::where('username', '=', $id)->first();

            $user = Auth::user();

            if ($user->can('update_admin', $data)) {
                $validator = Validator::make($request->all(), [
                    'password' => 'present|string|min:6',
                    'email' => 'present|email',
                    'name' => 'required|string',
                    'eng_name' => 'required|string',
                    'phone' => 'required|string',
                    'has_admin' => 'present|boolean',
                    'has_banned' => 'present|boolean',
                ]);

                if ($validator->fails()) {
                    $messages = $validator->errors()->all();
                    return response()->json(compact('messages'), 400);
                }

                return DB::transaction(function () use ($request, $user, $id) {
                    $updateData = array(
                        'name' => $request->name,
                        'eng_name' => $request->eng_name,
                        'phone' => $request->phone,
                        'updated_by' => Auth::id(),
                    );

                    if ($request->has('password')) {
                        $updateData += array(
                            'password' => Hash::make($request->password)
                        );
                    }

                    if ($request->has('email')) {
                        $updateData += array(
                            'email' => $request->email
                        );
                    }

                    User::where('username', '=', $id)->update($updateData);

                    if ((bool)$user->admin->has_admin && $user->username != $id) {
                        if ($request->has('has_admin')) {
                            Admin::where('username', '=', $id)->update([
                                'has_admin' => $request->input('has_admin', 0),
                                'updated_by' => Auth::id(),
                            ]);
                        }

                        if ((bool)$request->input('has_banned')) {
                            Admin::where('username', '=', $id)->update([
                                'deleted_by' => Auth::id(),
                            ]);

                            Admin::where('username', '=', $id)->delete();
                        } else {
                            Admin::where('username', '=', $id)->update([
                                'deleted_by' => NULL,
                            ]);

                            Admin::where('username', '=', $id)->restore();
                        }
                    }

                    return User::where('username', '=', $id)->with([
                        'admin' => function ($query) {
                            $query->withTrashed();
                        }
                    ])->first();
                });
            }

            $messages = array('User don\'t have permission to access');

            return response()->json(compact('messages'), 403);
        }

        $messages = array('User Data Not Found!');

        return response()->json(compact('messages'), 404);
    }

}
