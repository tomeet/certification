<?php

namespace Tomeet\Certification\Http\Controllers\Admin;

use Tomeet\Certification\Http\Controllers\Controller;
use Tomeet\Certification\Models\CertificationOfficial;
use Illuminate\Http\Request;
use Jiannei\Response\Laravel\Support\Facades\Response;
use Tomeet\Certification\Http\Resources\Admin\V1\OfficialResource as CertificationResource;
use Exception;

class OfficialController extends Controller
{
    //
    public function index(Request $request)
    {
        $officials = CertificationOfficial::filter($request->all())->paginate();
        return Response::success(CertificationResource::collection($officials));
    }


    public function show($id)
    {
        $official = CertificationOfficial::find($id);
        return Response::success(new CertificationResource($official));
    }


    public function update(Request $request, $id)
    {

    }


    public function massUpdate(Request $request)
    {
        try {
            $status = $request->input('status', 0);
            $reason = $request->input('reason', '');
            foreach ($request->id as $id) {
                CertificationOfficial::handleReview($id, $status, $reason);
            }
        } catch (Exception $exception) {
            Response::fail($exception->getMessage());
        }
    }


    public function destroy($id)
    {
        $official = CertificationOfficial::find($id);
        if ($official) {
            $official->delete();
        }
    }


    public function massDestroy(Request $request)
    {
        CertificationOfficial::whereIn('id', $request->id)->delete();
    }


    public function success(Request $request, $id)
    {
        try {
            CertificationOfficial::handleReview($id, 1);
        } catch (Exception $exception) {
            Response::fail($exception->getMessage());
        }
    }


    public function fail(Request $request, $id)
    {
        try {
            CertificationOfficial::handleReview($id, -1, $request->reason);
        } catch (Exception $exception) {
            Response::fail($exception->getMessage());
        }
    }
}
