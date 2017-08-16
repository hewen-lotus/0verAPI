<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SchoolData;

class QuotaInquireController extends Controller
{
    // 毫無反應就是個名額查詢

    /** @var SchoolData */
    private $SchoolDataModel;

    /**
     * QuotaInquireController constructor.
     * @param SchoolData $SchoolDataModel
     */
    public function __construct(SchoolData $SchoolDataModel)
    {
        $this->SchoolDataModel = $SchoolDataModel;
    }

    public function index(Request $request)
    {
        if ( $request->has('school_id') ) {
            $data = $this->SchoolDataModel->where('id', '=', $request->input('school_id'));
        } else {
            $data = $this->SchoolDataModel;
        }

        // system = bachelor, twoyear, master, phd
        if ( $request->has('system') ) {
            if ($request->input('system') == 'bachelor') {
                $data->with('departments');
            } else if ($request->input('system') == 'twoyear') {
                $data->with('two_year_tech_departments');
            } else if ($request->input('system') == 'master') {
                $data->with(['graduate_departments' => function ($query) {
                    $query->where('system_id', '=', 3);
                }]);
            } else if ($request->input('system') == 'phd') {
                $data->with(['graduate_departments' => function ($query) {
                    $query->where('system_id', '=', 4);
                }]);
            }
        }

        return $data->get();
    }
}
