<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Hash;
use Validator;
use App\User;

class SchoolUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return User::all();
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
            'username' => 'required|string|max:191|unique:school_editors,username',
            'password' => 'required|string|min:6',
            'email' => 'sometimes|nullable|email|unique:school_editors,email',
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

        $newUser = User::create([
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
        if (User::where('username', '=', $id)->exists()) {
            return User::where('username', '=', $id)->with('school')->first();
        }

        $messages = array('User Data Not Found!');

        return response()->json(compact('messages'), 404);
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
        if (User::where('username', '=', $id)->exists()) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:6',
                'email' => ['sometimes', 'nullable', 'email', Rule::unique('school_users', 'email')->ignore($id, 'username')],
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

            User::where('username', '=', $id)->update([
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'chinese_name' => $request->chinese_name,
                'english_name' => $request->english_name,
                'school_code' => $request->school_code,
                'organization' => $request->organization,
                'phone' => $request->phone,
            ]);

            return User::where('username', '=', $id)->first();
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
        if (User::where('username', '=', $id)->exists()) {
            User::where('username', '=', $id)->delete();

            return User::withTrashed()->where('username', '=', $id)->first();
        }

        $messages = array('User Data Not Found!');

        return response()->json(compact('messages'), 404);
    }
}
