<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ApplicationDocumentType;

use Auth;
use Validator;
use Illuminate\Validation\Rule;

class ApplicationDocumentTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'switch']);
    }

    /**
     * @param $system_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index($system_id)
    {
        //$user = Auth::user();

        return ApplicationDocumentType::where('system_id', '=', $system_id)->get();
    }

    /**
     * @param $system_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function show($system_id, $id)
    {
        //$user = Auth::user();

        if (ApplicationDocumentType::where('system_id', '=', $system_id)
            ->where('id', '=', $id)->exists()
        ) {
            return ApplicationDocumentType::where('system_id', '=', $system_id)
                ->where('id', '=', $id)->first();
        } else {
            $messages = array('Data Not Found!');

            return response()->json(compact('messages'), 404);
        }
    }

    /**
     * @param Request $request
     * @param $system_id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $system_id)
    {
        $user = Auth::user();

        if ($user->can('create', [ApplicationDocumentType::class])) {
            \Request::merge(['system_id' => $system_id]);

            $validator = Validator::make($request->all(), [
                'name' => [
                    'required',
                    'string',
                    Rule::unique('application_document_types')->where(function ($query) use ($request) {
                        $query->where('system_id', '=', $request->system_id);
                    }),
                ],
                'eng_name' => [
                    'required',
                    'string',
                    Rule::unique('application_document_types')->where(function ($query) use ($request) {
                        $query->where('system_id', '=', $request->system_id);
                    }),
                ],
                'system_id' => 'required|exists:system_types,id'
            ]);

            if ($validator->fails()) {
                $messages = $validator->errors()->all();
                return response()->json(compact('messages'), 400);
            }

            return ApplicationDocumentType::create([
                'name' => $request->name,
                'eng_name' => $request->eng_name,
                'system_id' => $request->system_id
            ]);
        }

        $messages = array('User don\'t have permission to access');

        return response()->json(compact('messages'), 403);
    }

    /**
     * @param Request $request
     * @param $system_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(Request $request, $system_id, $id)
    {
        $user = Auth::user();

        if ($user->can('update', [ApplicationDocumentType::class])) {
            if (ApplicationDocumentType::where('system_id', '=', $system_id)
                ->where('id', '=', $id)->exists()
            ) {
                \Request::merge(['system_id' => $system_id]);

                $validator = Validator::make($request->all(), [
                    'name' => [
                        'required',
                        'string',
                        Rule::unique('application_document_types')->where(function ($query) use ($request, $id) {
                            $query->where('system_id', '=', $request->system_id)->where('id', '!=', $id);
                        }),
                    ],
                    'eng_name' => [
                        'required',
                        'string',
                        Rule::unique('application_document_types')->where(function ($query) use ($request, $id) {
                            $query->where('system_id', '=', $request->system_id)->where('id', '!=', $id);
                        }),
                    ],
                    'system_id' => 'required|exists:system_types,id'
                ]);

                if ($validator->fails()) {
                    $messages = $validator->errors()->all();
                    return response()->json(compact('messages'), 400);
                }

                ApplicationDocumentType::where('id', '=', $id)
                    ->where('system_id', '=', $request->system_id)
                    ->update([
                        'name' => $request->name,
                        'eng_name' => $request->eng_name,
                    ]);

                return $this->show($system_id, $id);
            } else {
                $messages = array('Data Not Found!');

                return response()->json(compact('messages'), 404);
            }
        }

        $messages = array('User don\'t have permission to access');

        return response()->json(compact('messages'), 403);
    }

    /**
     * @param $system_id
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse|static[]
     */
    public function destroy($system_id, $id)
    {
        $user = Auth::user();

        if ($user->can('delete', [ApplicationDocumentType::class])) {
            if (ApplicationDocumentType::where('system_id', '=', $system_id)
                ->where('id', '=', $id)->exists()
            ) {
                ApplicationDocumentType::where('system_id', '=', $system_id)
                    ->where('id', '=', $id)->forceDelete();;

                return $this->index($system_id);
            } else {
                $messages = array('Data Not Found!');

                return response()->json(compact('messages'), 404);
            }
        }

        $messages = array('User don\'t have permission to access');

        return response()->json(compact('messages'), 403);
    }
}
