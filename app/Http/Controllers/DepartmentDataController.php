<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SchoolData;

class DepartmentDataController extends Controller
{
    /** @collect system_id_collection */
    private $system_id_collection;

    /** @var SchoolData */
    private $SchoolDataModel;

    /**
     * DepartmentDataController constructor.
     *
     * @param SchoolData $SchoolDataModel
     */
    public function __construct(SchoolData $SchoolDataModel)
    {
        $this->system_id_collection = collect([
            'bachelor' => 1,
            1 => 1,
            'two-year' => 2,
            'twoYear' => 2,
            2 => 2,
            'master' => 3,
            3 => 3,
            'phd' => 4,
            4 => 4,
        ]);

        $this->SchoolDataModel = $SchoolDataModel;
    }

    /**
     * @param $school_id
     * @param $system_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($school_id, $system_id)
    {
        // mapping 學制 id
        $system_id = $this->system_id_collection->get($system_id, 0);

        if ($system_id == 0) {
            $messages = ['System id not found.'];

            return response()->json(compact('messages'), 404);
        }

        if ($this->SchoolDataModel->where('id', '=', $school_id)->whereHas('systems', function ($query) use ($system_id) {
            $query->where('type_id', '=', $system_id);
        })->exists()) {
            switch ($system_id) {
                case 1:
                    return $this->SchoolDataModel->where('id', '=', $school_id)->with([
                        'systems' => function ($query) use ($system_id) {
                            $query->where('type_id', '=', $system_id);
                        },
                        'departments',
                        'departments.evaluation_level',
                        'departments.main_group_data',
                        'departments.sub_group_data',
                        'departments.admission_placement_step_quota'
                    ])->first();

                    break;

                case 2:
                    return $this->SchoolDataModel->where('id', '=', $school_id)->with([
                        'systems' => function ($query) use ($system_id) {
                            $query->where('type_id', '=', $system_id);
                        },
                        'two_year_tech_departments',
                        'two_year_tech_departments.evaluation_level',
                        'two_year_tech_departments.main_group_data',
                        'two_year_tech_departments.sub_group_data'
                    ])->first();

                    break;

                default:
                    return $this->SchoolDataModel->where('id', '=', $school_id)->with([
                        'systems' => function ($query) use ($system_id) {
                            $query->where('type_id', '=', $system_id);
                        },
                        'graduate_departments' => function ($query) use ($system_id) {
                            $query->where('system_id', '=', $system_id);
                        },
                        'graduate_departments.evaluation_level',
                        'graduate_departments.main_group_data',
                        'graduate_departments.sub_group_data'
                    ])->first();

                    break;
            }
        }

        $messages = ['System data not found.'];

        return response()->json(compact('messages'), 404);
    }
}
