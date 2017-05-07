<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use Validator;
use App\SchoolUser;

class SchoolUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return SchoolUser::with('school')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:191|unique:school_users,username',
            'password' => 'required|string|min:6',
            'email' => 'sometimes|nullable|email|unique:school_users,email',
            'chinese_name' => 'required|string',
            'english_name' => 'required|string',
            'school_code' => 'required|exists:school_data,id',
            'organization' => 'required|string',
            'phone' => 'required',
        ]);

        if($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json(compact('messages'), 400);
        }

        $newUser = SchoolUser::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'chinese_name' => $request->chinese_name,
            'english_name' => $request->english_name,
            'school_code' => $request->school_code,
            'organization' => $request->organization,
            'phone' => $request->phone,
        ]);

        return response()->json($newUser, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (SchoolUser::where('username', '=', $id)->exists()) {
            return SchoolUser::where('username', '=', $id)->with('school')->first();
        }

        $messages = array('User Data Not Found!');

        return response()->json(compact('messages'), 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (SchoolUser::where('username', '=', $id)->exists()) {
            // 這裡開始做色色的事情
        }

        $messages = array('User Data Not Found!');

        return response()->json(compact('messages'), 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (SchoolUser::where('username', '=', $id)->exists()) {
            // 這裡開始做色色的事情
        }

        $messages = array('User Data Not Found!');

        return response()->json(compact('messages'), 404);
    }
}
