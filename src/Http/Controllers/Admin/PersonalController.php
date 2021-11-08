<?php

namespace Tomeet\Certification\Http\Controllers\Admin;

use Tomeet\Certification\Http\Controllers\Controller;
use Tomeet\Certification\Models\CertificationPersonal;
use Illuminate\Http\Request;
use Jiannei\Response\Laravel\Support\Facades\Response;
use Tomeet\Certification\Http\Resources\Admin\PersonalResource as CertificationResource;
use Exception;

class PersonalController extends Controller
{
    /**
     * 获取认证列表
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $personals = CertificationPersonal::filter($request->all())->paginate();
        return Response::success(CertificationResource::collection($personals));
    }


    /**
     * 获取认证信息
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $personal = CertificationPersonal::find($id);
        return Response::success(new CertificationResource($personal));
    }


    /**
     * 更新认证状态并创建审核记录
     *
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * 批量审核
     *
     * @param Request $request
     */
    public function massUpdate(Request $request)
    {
        try {
            $status = $request->input('status', 0);
            $reason = $request->input('reason', '');
            foreach ($request->id as $id) {
                CertificationPersonal::handleReview($id, $status, $reason);
            }
        } catch (Exception $exception) {
            Response::fail($exception->getMessage());
        }
    }


    /**
     * 删除个人认证信息
     *
     * @param $id
     */
    public function destroy($id)
    {
        $personal = CertificationPersonal::find($id);
        if ($personal) {
            $personal->delete();
        }
    }


    /**
     * 批量删除个人认证
     *
     * @param Request $request
     */
    public function masDestroy(Request $request)
    {
        CertificationPersonal::whereIn('id', $request->id)->delete();
    }


    /**
     * 设置审核成功并创建审核记录
     *
     * @param $id
     */
    public function success(Request $request, $id)
    {
        try {
            CertificationPersonal::handleReview($id, 1);
        } catch (Exception $exception) {
            Response::fail($exception->getMessage());
        }
    }


    /**
     * 设置审核失败并创建审核记录
     *
     * @param $id
     */
    public function fail(Request $request, $id)
    {
        try {
            CertificationPersonal::handleReview($id, -1, $request->reason);
        } catch (Exception $exception) {
            Response::fail($exception->getMessage());
        }
    }
}
