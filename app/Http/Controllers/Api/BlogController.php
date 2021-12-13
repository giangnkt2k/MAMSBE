<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-06-09
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Repositories\Contracts\BlogRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\BlogResource;
use Illuminate\Http\Request;

class BlogController extends Controller
{

     /**
     * var Repository
     */
    protected $repository;

    public function __construct(BlogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *   path="/api/blog/",
     *   tags={"Blog"},
     *   summary="Danh sách ................",
     *   operationId="blog_index",
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"name":  ".............","parent_id": 1,"type": 1,"sub_type": 1,"content":  "............."}}
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
    public function index(BlogRequest $request)
    {
        $data = $this->repository->paginate();
        return $this->responseJson(CODE_SUCCESS, BaseResource::collection($data));
    }

    /**
     * @OA\Post(
     *   path="/api/blog",
     *   tags={"Blog"},
     *   summary="Thêm mới ..................",
     *   operationId="blog_create",
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={"name":"string","parent_id": "integer", "type": {1,2}, "sub_type": {1,2}, "content": "longText"},
     *          @OA\Schema(
     *           @OA\Property(
     *              property="name",
     *              format="string",
     *            ),
     *           @OA\Property(
     *              property="parent_id",
     *              format="integer",
     *            ),
     *           @OA\Property(
     *              property="type",
     *              format="array",
     *              description="Mảng Type"
     *            ),
     *           @OA\Property(
     *              property="sub_type",
     *              format="array",
     *              description="Mảng Sub_type"
     *            ),
     *           @OA\Property(
     *              property="content",
     *              format="longText",
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
     *      example={"code":200,"data":{"id": 1,"name":  ".............","parent_id": 1,"type": "......","sub_type": "......","content":  "............."}}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(BlogRequest $request)
    {
        try {
            $data = $this->repository->create($request->all());
            return $this->responseJson(CODE_SUCCESS, new BlogResource($data));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Get(
     *   path="/api/blog/{id}",
     *   tags={"Blog"},
     *   summary="Chi tiết ............",
     *   operationId="blog_show",
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
     *      example={"code":200,"data":{"id": 1,"name":  ".............","parent_id": ".....","type": ".....","sub_type": ".....","content":  "............."}}
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
            $blog = $this->repository->find($id);
            return $this->responseJson(CODE_SUCCESS, new BaseResource($blog));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Put(
     *   path="/api/blog/{id}",
     *   tags={"Blog"},
     *   summary="Cập nhật thông tin ",
     *   operationId="blog_update",
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
     *          example={"name":"string","parent_id": "integer", "type":{1,2}, "sub_type": {1,2}, "content": "longText"},
     *          @OA\Schema(
     *            required={"name"},
     *           @OA\Property(
     *              property="name",
     *              format="string",
     *            ),
     *           @OA\Property(
     *              property="parent_id",
     *              format="integer",
     *            ),
     *           @OA\Property(
     *              property="type",
     *              format="array",
     *            ),
     *           @OA\Property(
     *              property="sub_type",
     *              format="array",
     *            ),
     *           @OA\Property(
     *              property="content",
     *              format="longText",
     *            ),
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"name":  ".....","parent_id": 1,"type": "....","sub_type": "....","content":  "............."}}
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
    public function update(BlogRequest $request, $id)
    {
        $attributes = $request->except([]);
        $data = $this->repository->update($attributes, $id);
        return $this->responseJson(CODE_SUCCESS, new BaseResource($data));
    }

    /**
     * @OA\Delete(
     *   path="/api/blog/{id}",
     *   tags={"Blog"},
     *   summary="Xóa ..............",
     *   operationId="blog_delete",
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
        $this->repository->delete($id);
        return $this->responseJson(CODE_SUCCESS, null, _('mes.delete_success'));
    }
}
