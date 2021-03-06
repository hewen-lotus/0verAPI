<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
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
    /** @var SchoolData */
    private $SchoolDataModel;

    /** @var User */
    private $UserModel;

    /** @var SchoolEditor */
    private $SchoolEditorModel;

    /** @var DepartmentEditorPermission */
    private $DepartmentEditorPermissionModel;

    /** @var GraduateDepartmentEditorPermission */
    private $GraduateDepartmentEditorPermissionModel;

    /** @var TwoYearTechDepartmentEditorPermission */
    private $TwoYearTechDepartmentEditorPermissionModel;

    /**
     * SchoolEditorController constructor.
     *
     * @param SchoolData $SchoolDataModel
     * @param User $UserModel
     * @param SchoolEditor $SchoolEditorModel
     * @param DepartmentEditorPermission $DepartmentEditorPermissionModel
     * @param GraduateDepartmentEditorPermission $GraduateDepartmentEditorPermissionModel
     * @param TwoYearTechDepartmentEditorPermission $TwoYearTechDepartmentEditorPermissionModel
     */
    public function __construct(User $UserModel, SchoolData $SchoolDataModel, SchoolEditor $SchoolEditorModel, DepartmentEditorPermission $DepartmentEditorPermissionModel, GraduateDepartmentEditorPermission $GraduateDepartmentEditorPermissionModel, TwoYearTechDepartmentEditorPermission $TwoYearTechDepartmentEditorPermissionModel)
    {
        $this->middleware(['auth', 'switch']);

        $this->UserModel = $UserModel;

        $this->SchoolDataModel = $SchoolDataModel;

        $this->SchoolEditorModel = $SchoolEditorModel;

        $this->DepartmentEditorPermissionModel = $DepartmentEditorPermissionModel;

        $this->GraduateDepartmentEditorPermissionModel = $GraduateDepartmentEditorPermissionModel;

        $this->TwoYearTechDepartmentEditorPermissionModel = $TwoYearTechDepartmentEditorPermissionModel;
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
        $user = Auth::user();

        if ($user->can('list_schooleditor', [User::class, $school_code])) {
            if ($school_code == 'me') {
                $school_code = $user->school_editor->school_code;
            }

            if ($this->SchoolDataModel->where('id', '=', $school_code)->exists()) {
                return $this->UserModel->whereHas('school_editor', function ($query) use ($school_code) {
                    $query->where('school_code', '=', $school_code);
                })->with('school_editor')->get();
            }

            $messages = array('This School is NOT exist!');

            return response()->json(compact('messages'), 404);
        }

        $messages = array('User don\'t have permission to access');

        return response()->json(compact('messages'), 403);
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

            if ($school_code == 'me') {
                $school_code = $user->school_editor->school_code;
            }

            if ($this->SchoolDataModel->where('id', '=', $school_code)->exists()) {
                $validator = Validator::make($request->all(), [
                    'username' => 'required|string|max:191|unique:school_editors,username|unique:users,username',
                    'password' => 'required|string|min:6',
                    'email' => 'present|email',
                    'name' => 'required|string',
                    'job_title' => 'required|string',
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
                    $this->UserModel->create([
                        'username' => $request->username,
                        'password' => Hash::make($request->password),
                        'email' => $request->email,
                        'name' => $request->name,
                        'job_title' => $request->job_title,
                        'phone' => $request->phone,
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id()
                    ]);

                    $this->SchoolEditorModel->create([
                        'username' => $request->username,
                        'school_code' => $school_code,
                        'organization' => $request->organization,
                        'has_admin' => $request->input('has_admin', 0),
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id()
                    ]);

                    foreach ($request->input('departments.bachelor') as $bachelor) {
                        $this->DepartmentEditorPermissionModel->create([
                            'username' => $request->username,
                            'dept_id' => $bachelor
                        ]);
                    }

                    foreach ($request->input('departments.master') as $master) {
                        $this->GraduateDepartmentEditorPermissionModel->create([
                            'username' => $request->username,
                            'dept_id' => $master
                        ]);
                    }

                    foreach ($request->input('departments.phd') as $phd) {
                        $this->GraduateDepartmentEditorPermissionModel->create([
                            'username' => $request->username,
                            'dept_id' => $phd
                        ]);
                    }

                    foreach ($request->input('departments.two_year') as $two_year) {
                        $this->TwoYearTechDepartmentEditorPermissionModel->create([
                            'username' => $request->username,
                            'dept_id' => $two_year
                        ]);
                    }

                    if ((bool)$request->input('has_banned')) {
                        //User::where('username', '=', $request->username)->delete();

                        $this->SchoolEditorModel->where('username', '=', $request->username)->update([
                            'deleted_by' => Auth::id(),
                        ]);

                        $this->SchoolEditorModel->where('username', '=', $request->username)->delete();

                        $this->DepartmentEditorPermissionModel->where('username', '=', $request->username)->delete();

                        $this->GraduateDepartmentEditorPermissionModel->where('username', '=', $request->username)->delete();

                        $this->TwoYearTechDepartmentEditorPermissionModel->where('username', '=', $request->username)->delete();
                    }

                    return response()->json(
                        $this->UserModel->where('username', '=', $request->username)
                        ->with([
                            'school_editor' => function ($query) {
                                $query->withTrashed();
                            },
                            'school_editor.department_permissions' => function ($query) {
                                $query->withTrashed();
                            },
                            'school_editor.graduate_department_permissions' => function ($query) {
                                $query->withTrashed();
                            },
                            'school_editor.two_year_tech_department_permissions' => function ($query) {
                                $query->withTrashed();
                            }
                        ])->first(), 201);
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

        if ($user->can('view_schooleditor', [User::class, $school_code, $id])) {
            if ($school_code == 'me') {
                $school_code = $user->school_editor->school_code;
            }

            if ($id == 'me') {
                $id = $user->school_editor->username;
            }

            if ($this->UserModel->where('username', '=', $id)
                ->whereHas('school_editor', function ($query) use ($school_code) {
                    $query->where('school_code', '=', $school_code);
                })->exists()) {
                return $this->UserModel->where('username', '=', $id)
                    ->with([
                        'school_editor.school',
                        'school_editor.department_permissions',
                        'school_editor.graduate_department_permissions',
                        'school_editor.two_year_tech_department_permissions'
                    ])->first();
            }

            $messages = array('User Data Not Found!');

            return response()->json(compact('messages'), 404);
        }

        $messages = array('User don\'t have permission to access');

        return response()->json(compact('messages'), 403);
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
        $user = Auth::user();

        if ($user->can('update_schooleditor', [User::class, $school_code, $id])) {
            if ($school_code == 'me') {
                $school_code = $user->school_editor->school_code;
            }

            if ($id == 'me') {
                $id = $user->school_editor->username;
            }

            if ($this->UserModel->where('username', '=', $id)
                ->whereHas('school_editor', function ($query) use ($school_code) {
                    $query->where('school_code', '=', $school_code);
                })->exists()
            ) {
                $validator = Validator::make($request->all(), [
                    'password' => 'present|nullable|string|min:6',
                    'email' => 'present|email',
                    'name' => 'required|string',
                    'job_title' => 'required|string',
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

                $result = DB::transaction(function () use ($request, $user, $school_code, $id) {
                    $this->DepartmentEditorPermissionModel->where('username', '=', $id)->forceDelete();

                    $this->GraduateDepartmentEditorPermissionModel->where('username', '=', $id)->forceDelete();

                    $this->TwoYearTechDepartmentEditorPermissionModel->where('username', '=', $id)->forceDelete();

                    $UserUpdateData = array(
                        'email' => $request->email,
                        'name' => $request->name,
                        'job_title' => $request->job_title,
                        'phone' => $request->phone,
                        'updated_by' => Auth::id()
                    );

                    $EditorUpdateData = array(
                        'organization' => $request->organization,
                        'has_admin' => $request->input('has_admin', 0),
                        'updated_by' => Auth::id()
                    );

                    if ($request->has('password')) {
                        if (!Hash::check($request->password, $user->password)) {
                            $new_password = Hash::make($request->password);

                            $UserUpdateData += array(
                                'password' => $new_password
                            );
                        }
                    }

                    $this->UserModel->where('username', '=', $id)->update($UserUpdateData);

                    $this->SchoolEditorModel->where('username', '=', $id)->update($EditorUpdateData);

                    foreach ($request->input('departments.bachelor') as $bachelor) {
                        $this->DepartmentEditorPermissionModel->create([
                            'username' => $id,
                            'dept_id' => $bachelor
                        ]);
                    }

                    foreach ($request->input('departments.master') as $master) {
                        $this->GraduateDepartmentEditorPermissionModel->create([
                            'username' => $id,
                            'dept_id' => $master
                        ]);
                    }

                    foreach ($request->input('departments.phd') as $phd) {
                        $this->GraduateDepartmentEditorPermissionModel->create([
                            'username' => $id,
                            'dept_id' => $phd
                        ]);
                    }

                    foreach ($request->input('departments.two_year') as $two_year) {
                        $this->TwoYearTechDepartmentEditorPermissionModel->create([
                            'username' => $id,
                            'dept_id' => $two_year
                        ]);
                    }

                    if (($user->admin != NULL || (bool)$user->school_editor->has_admin) && $user->username != $id) {
                        if ((bool)$request->input('has_banned')) {
                            //User::where('username', '=', $request->username)->delete();

                            $this->SchoolEditorModel->where('username', '=', $id)->update([
                                'deleted_by' => Auth::id(),
                            ]);

                            $this->SchoolEditorModel->where('username', '=', $id)->delete();

                            $this->DepartmentEditorPermissionModel->where('username', '=', $id)->delete();

                            $this->GraduateDepartmentEditorPermissionModel->where('username', '=', $id)->delete();

                            $this->TwoYearTechDepartmentEditorPermissionModel->where('username', '=', $id)->delete();
                        } else {
                            $this->SchoolEditorModel->where('username', '=', $id)->update([
                                'deleted_by' => NULL,
                            ]);

                            $this->SchoolEditorModel->where('username', '=', $id)->restore();

                            $this->DepartmentEditorPermissionModel->where('username', '=', $id)->restore();

                            $this->GraduateDepartmentEditorPermissionModel->where('username', '=', $id)->restore();

                            $this->TwoYearTechDepartmentEditorPermissionModel->where('username', '=', $id)->restore();
                        }
                    }

                    return response()->json(
                        $this->UserModel->where('username', '=', $id)
                            ->with([
                                'school_editor.school' => function ($query) {
                                    $query->withTrashed();
                                },
                                'school_editor.department_permissions' => function ($query) {
                                    $query->withTrashed();
                                },
                                'school_editor.graduate_department_permissions' => function ($query) {
                                    $query->withTrashed();
                                },
                                'school_editor.two_year_tech_department_permissions' => function ($query) {
                                    $query->withTrashed();
                                }
                            ])->first());
                });

                if ($user->username == $id && !Hash::check($request->password, $user->password) && !(bool)$request->input('has_banned')) {
                    Auth::attempt(['username' => $user->username, 'password' => $request->password, 'deleted_at' => NULL]);
                }

                return $result;
            }

            $messages = array('User Data Not Found!');

            return response()->json(compact('messages'), 404);
        }

        $messages = array('User don\'t have permission to access');

        return response()->json(compact('messages'), 403);
    }

}
