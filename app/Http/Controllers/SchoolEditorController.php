<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Auth;
use DB;
use Illuminate\Validation\Rule;

use App\User;
use App\SchoolEditor;
use App\SchoolData;
use App\DepartmentEditorPermission;
use App\GraduateDepartmentEditorPermission;
use App\TwoYearTechDepartmentEditorPermission;

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
    public function index($school_code)
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
        $user = Auth::user();

        if ($user->can('create_schooleditor', [User::class, $school_code])) {
            if (SchoolData::where('id', '=', $school_code)->exists()) {
                $validator = Validator::make($request->all(), [
                    'username' => 'required|string|max:191|unique:school_editors,username|unique:users,username',
                    'password' => 'required|string|min:6',
                    'email' => 'sometimes|nullable|email',
                    'name' => 'required|string',
                    'eng_name' => 'required|string',
                    'phone' => 'required|string',
                    'organization' => 'required|string',
                    'has_admin' => 'present|boolean',
                    'has_banned' => 'present|boolean',
                    'departments.bachelor' => 'present|array',
                    'departments.master' => 'present|array',
                    'departments.phd' => 'present|array',
                    'departments.two_year' => 'present|array',
                    'departments.bachelor.*' => [
                        'string',
                        Rule::exists('department_data', 'id')->where(function ($query) use ($school_code) {
                            $query->where('school_code', $school_code);
                        })
                    ],
                    'departments.master.*' => [
                        'string',
                        Rule::exists('graduate_department_data', 'id')->where(function ($query) use ($school_code) {
                            $query->where('school_code', $school_code);
                        })
                    ],
                    'departments.phd.*' => [
                        'string',
                        Rule::exists('graduate_department_data', 'id')->where(function ($query) use ($school_code) {
                            $query->where('school_code', $school_code);
                        })
                    ],
                    'departments.two_year.*' => [
                        'string',
                        Rule::exists('two_year_tech_department_data', 'id')->where(function ($query) use ($school_code) {
                            $query->where('school_code', $school_code);
                        })
                    ],
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

                    foreach ($request->input('departments.bachelor') as $bachelor) {
                        DepartmentEditorPermission::create([
                            'username' => $request->username,
                            'dept_id' => $bachelor
                        ]);
                    }

                    foreach ($request->input('departments.master') as $master) {
                        GraduateDepartmentEditorPermission::create([
                            'username' => $request->username,
                            'dept_id' => $master
                        ]);
                    }

                    foreach ($request->input('departments.phd') as $phd) {
                        GraduateDepartmentEditorPermission::create([
                            'username' => $request->username,
                            'dept_id' => $phd
                        ]);
                    }

                    foreach ($request->input('departments.two_year') as $two_year) {
                        TwoYearTechDepartmentEditorPermission::create([
                            'username' => $request->username,
                            'dept_id' => $two_year
                        ]);
                    }

                    if ((bool)$request->input('has_banned') == true) {
                        //User::where('username', '=', $request->username)->delete();

                        SchoolEditor::where('username', '=', $request->username)->delete();

                        DepartmentEditorPermission::where('username', '=', $request->username)->delete();

                        GraduateDepartmentEditorPermission::where('username', '=', $request->username)->delete();

                        TwoYearTechDepartmentEditorPermission::where('username', '=', $request->username)->delete();
                    }

                    return response()->json(
                        User::where('username', '=', $request->username)
                        ->with([
                            'school_editor' => function ($query) {
                                $query->withTrashed();
                            },
                            'school_editor.department_permission' => function ($query) {
                                $query->withTrashed();
                            },
                            'school_editor.graduate_department_permission' => function ($query) {
                                $query->withTrashed();
                            },
                            'school_editor.two_year_tech_department_permission' => function ($query) {
                                $query->withTrashed();
                            }])->first(), 201);
                });
            }

            $messages = array('This School is NOT exist!');

            return response()->json(compact('messages'), 404);
        }

        $messages = array('User don\'t have permission to access');

        return response()->json(compact('messages'), 403);
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
        $user = Auth::user();

        if (User::where('username', '=', $id)
            ->whereHas('school_editor', function ($query) use ($school_code) {
                $query->where('school_code', '=', $school_code);
            })->exists()) {
            $editor = User::where('username', '=', $request->username)
                ->with([
                    'school_editor',
                    'school_editor.department_permission',
                    'school_editor.graduate_department_permission',
                    'school_editor.two_year_tech_department_permission'
                ])->first();

            if ($user->can('view_schooleditor', [$editor, $school_code])) {
                return $editor;
            }

            $messages = array('User don\'t have permission to access');

            return response()->json(compact('messages'), 403);
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
