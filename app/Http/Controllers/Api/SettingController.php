<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-06-04
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    /**
     * var Repository
     */
    protected $repository;

    public function __construct(SettingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *   path="/api/setting",
     *   tags={"Setting"},
     *   summary="Danh sách ................",
     *   operationId="setting_index",
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"label":  ".............","key":  ".............","value":  ".............","type":  "............."}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Đăng nhập thất bại",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Sai tài khoản hoặc mật khẩu"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->repository->paginate();
        return $this->responseJson(CODE_SUCCESS, BaseResource::collection($data));
    }


    /**
     * @OA\Get(
     *   path="/api/setting/{id}",
     *   tags={"Setting"},
     *   summary="Chi tiết ............",
     *   operationId="setting_show",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"label":  ".............","key":  ".............","value":  ".............","type":  "............."}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Đăng nhập thất bại",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Sai tài khoản hoặc mật khẩu"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $setting = $this->repository->find($id);
            return $this->responseJson(CODE_SUCCESS, new BaseResource($setting));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Post(
     *   path="/api/setting",
     *   tags={"Setting"},
     *   summary="Thêm mới ..................",
     *   operationId="setting_create",
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={"label":"string","key":"string","value":"string", "type": "string"},
     *          @OA\Schema(
     *            required={"label"},
     *            required={"key"},
     *            required={"value"},
     *            required={"type"},
     *            @OA\Property(
     *              property="label",
     *              format="string",
     *            ),
     *            @OA\Property(
     *              property="key",
     *              format="string",
     *            ),
     *           @OA\Property(
     *              property="value",
     *              format="string",
     *            ),
     *           @OA\Property(
     *              property="type",
     *              format="string",
     *            ),
     *         )
     *      )
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"label":  ".............","key":  ".............","value":  ".............","type":  "............."}}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(SettingRequest $request)
    {
        $setting = $this->repository->create($request->all());
        return $this->responseJson(CODE_SUCCESS, new BaseResource($setting));
    }

    /**
     * @OA\Put(
     *   path="/api/setting/{id}",
     *   tags={"Setting"},
     *   summary="Cập nhật thông tin ",
     *   operationId="setting_update",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={"label":"string","key":"string","value":"string","type":"string"},
     *          @OA\Schema(
     *            required={"key"},
     *            @OA\Property(
     *              property="key",
     *              format="string",
     *            ),
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"label":  ".............","key":  ".............","value":  ".............","type":  "............."}}
     *     ),
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Từ chối quyền truy cập",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":403,"message":"Từ chối quyền truy cập"}
     *     ),
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SettingRequest $request, $id)
    {
        $attributes = $request->except([]);
        $data = $this->repository->update($attributes, $id);
        return $this->responseJson(CODE_SUCCESS, new BaseResource($data));
    }

    /**
     * @OA\Delete(
     *   path="/api/setting/{id}",
     *   tags={"Setting"},
     *   summary="Xóa ..............",
     *   operationId="setting_delete",
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":"Gửi yêu cầu thành công"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $result = $this->repository->delete($id);
        if($result){
            return $this->responseJson(CODE_SUCCESS, null, trans('messages.mes.delete_success'));
        }
        return $this->responseJsonError(CODE_DELETE_FAILED, null, trans('messages.mes.delete_error'));
    }
}



