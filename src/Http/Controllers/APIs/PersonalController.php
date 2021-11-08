<?php

namespace Tomeet\Certification\Http\Controllers\APIs;

use Tomeet\Certification\Http\Controllers\Controller;
use Tomeet\Certification\Http\Requests\APIs\PersonalRequest;
use Tomeet\Certification\Http\Resources\APIs\PersonalResource;
use Tomeet\Certification\Models\CertificationPersonal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jiannei\Response\Laravel\Support\Facades\Response;
use Exception;

class PersonalController extends Controller
{

    /**
     * 保存实名认证信息
     */
    public function store(PersonalRequest $request)
    {
        try {
            CertificationPersonal::handleCreate($request, Auth::user());
            return Response::noContent();
        } catch (Exception $exception) {
            Response::fail($exception->getMessage());
        }
    }


    /**
     * 获取实名认证信息
     */
    public function show()
    {
        $personal = Auth::user()->personal;
        if ($personal) {
            return Response::success(new PersonalResource($personal));
        }
        Response::fail('未实名认证！');

    }


    /**
     * 更新实名认证信息
     */
    public function update(PersonalRequest $request)
    {
        try {
            CertificationPersonal::handleUpdate($request, Auth::user());
            return Response::noContent();
        } catch (Exception $exception) {
            Response::fail($exception->getMessage());
        }

    }


    /**
     * 上传实名认证文件
     */
    public function upload(Request $request)
    {
        try {
            CertificationPersonal::handleUpload($request);
        } catch (Exception $exception) {
            Response::fail($exception->getMessage());
        }
    }
}
