<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SchoolData;

class SchoolDataController extends Controller
{
    /** @var SchoolData */
    private $SchoolDataModel;

    /**
     * SchoolDataController constructor.
     *
     * @param SchoolData $SchoolDataModel
     */
    public function __construct(SchoolData $SchoolDataModel)
    {
        //$this->middleware('auth', ['except' => ['getActivate', 'anotherMethod']]);

        $this->SchoolDataModel = $SchoolDataModel;
    }

    public function index()
    {
        return $this->SchoolDataModel->get();
    }

    /**
     * 取得學校資訊（校名、介紹等）與所有系所資訊
     *
     * @param  string $school_id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $school_id)
    {
        if ($this->SchoolDataModel->where('id', '=', $school_id)->exists()) {
            return $this->SchoolDataModel->where('id', '=', $school_id)->with('departments')->first();
        }

        $messages = array('School Data Not Found!');

        return response()->json(compact('messages'), 404);
    }
}
