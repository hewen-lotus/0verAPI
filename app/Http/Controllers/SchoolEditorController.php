<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Auth;
use DB;

use App\User;
use App\SchoolEditor;
use App\SchoolData;

class SchoolEditorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $school_code
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $school_code)
    {
        if (SchoolData::where('id', '=', $school_code)->exists()) {
            return User::whereHas('school_editor', function ($query) use ($school_code) {
                $query->where('school_code', '=', $school_code);
            })->with('school_editor')->get();
        }

        $messages = array('This School is NOT exist!');

        return response()->json(compact('messages'), 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $school_code
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $school_code)
    {
        if (!SchoolData::where('id', '=', $school_code)->exists()) {
            $messages = array('This School is NOT exist!');

            return response()->json(compact('messages'), 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:191|unique:school_editors,username|unique:users,username',
            'password' => 'required|string|min:6',
            'email' => 'sometimes|nullable|email',
            'name' => 'required|string',
            'eng_name' => 'required|string',
            'phone' => 'required|string',
            'organization' => 'required|string',
            'has_admin' => 'sometimes|required|boolean'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json(compact('messages'), 400);
        }

        return DB::transaction(function () use ($request, $school_code) {
            User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'name' => $request->name,
                'eng_name' => $request->eng_name,
                'phone' => $request->phone,
            ]);

            SchoolEditor::create([
                'username' => $request->username,
                'school_code' => $school_code,
                'organization' => $request->organization,
                'has_admin' => $request->input('has_admin', 0),
            ]);

            return User::where('username', '=', $request->username)->with('school_editor')->first();
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $school_code
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $school_code, $id)
    {
        if (!SchoolData::where('id', '=', $school_code)->exists()) {
            $messages = array('This School is NOT exist!');

            return response()->json(compact('messages'), 404);
        }

        if (User::where('username', '=', $id)->has('school_editor')->exists()) {
            return User::where('username', '=', $id)->with('school_editor')->first();
        }

        $messages = array('User Data Not Found!');

        return response()->json(compact('messages'), 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $school_code
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $school_code, $id)
    {
        if (!SchoolData::where('id', '=', $school_code)->exists()) {
            $messages = array('This School is NOT exist!');

            return response()->json(compact('messages'), 404);
        }

        if (SchoolEditor::where('username', '=', $id)->exists()) {
            $validator = Validator::make($request->all(), [
                'password' => 'sometimes|string|min:6',
                'email' => 'sometimes|nullable|email',
                'chinese_name' => 'sometimes|required|string',
                'english_name' => 'sometimes|required|string',
                'phone' => 'sometimes|required|string',
                //'school_code' => 'required|exists:school_data,id',
                'organization' => 'sometimes|required|string',
                'admin' => 'sometimes|required|boolean'
            ]);

            if ($validator->fails()) {
                $messages = $validator->errors()->all();
                return response()->json(compact('messages'), 400);
            }

            return DB::transaction(function () use ($request, $id) {
                $UserUpdateData = array();

                $EditorUpdateData = array();

                if ($request->has('password')) {
                    $UserUpdateData += array(
                        'password' => Hash::make($request->password)
                    );
                }

                if ($request->has('email')) {
                    $UserUpdateData += array(
                        'email' => $request->email
                    );
                }

                if ($request->has('chinese_name')) {
                    $UserUpdateData += array(
                        'chinese_name' => $request->chinese_name
                    );
                }

                if ($request->has('english_name')) {
                    $UserUpdateData += array(
                        'english_name' => $request->english_name
                    );
                }

                if ($request->has('phone')) {
                    $UserUpdateData += array(
                        'phone' => $request->phone
                    );
                }

                if ($request->has('organization')) {
                    $EditorUpdateData += array(
                        'organization' => $request->organization
                    );
                }

                if ($request->has('admin')) {
                    $EditorUpdateData += array(
                        'admin' => $request->admin
                    );
                }

                User::where('username', '=', $id)->update($UserUpdateData);

                SchoolEditor::where('username', '=', $id)->update($EditorUpdateData);

                return User::where('username', '=', $id)->with('school_editor')->first();
            });
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
        //
    }
}
