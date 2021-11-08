<?php

namespace Tomeet\Certification\Http\Controllers\APIs;

use Tomeet\Certification\Http\Controllers\Controller;
use Tomeet\Certification\Http\Requests\APIs\OfficialRequest;
use Tomeet\Certification\Http\Resources\APIs\OfficialResource;
use Tomeet\Certification\Models\CertificationOfficial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jiannei\Response\Laravel\Support\Facades\Response;
use Exception;

class OfficialController extends Controller
{
    /**
     * 保存实名认证信息
     */
    public function store(OfficialRequest $request)
    {
        try {
            CertificationOfficial::handleCreate($request, Auth::user());
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
        $official = Auth::user()->official;
        if ($official) {
            return Response::success(new OfficialResource($official));
        }
        Response::fail('还未实名认证！');
    }


    /**
     * 更新实名认证信息
     */
    public function update(OfficialRequest $request)
    {
        try {
            CertificationOfficial::handleUpdate($request, Auth::user());
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
            CertificationOfficial::handleUpload($request);
        } catch (Exception $exception) {
            Response::fail($exception->getMessage());
        }
    }
}
