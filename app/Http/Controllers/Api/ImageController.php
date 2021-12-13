<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-06-08
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\SettingRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Repositories\Contracts\ImageRepositoryInterface;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{

     /**
     * var Repository
     */
    protected $repository;

    public function __construct(ImageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *   path="/api/image",
     *   tags={"Image"},
     *   summary="List image",
     *   operationId="image_index",
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"model_id":  ".............","model_name":  ".............","title":  ".............","url":  ".............","created_by":  ".............","updated_by":  "............."}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Login false",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Username or password invalid"}
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
     * @OA\Post(
     *   path="/api/image",
     *   tags={"Image"},
     *   summary="Thêm mới ..................",
     *   operationId="image_create",
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          example={"model_id":"int","model_name":"string","title":"string","url": "string","created_by": "string","updated_by": "string"},
     *          @OA\Schema(
     *            required={"title", "file"},
     *            @OA\Property(
     *              format="int",
     *              property="model_id",
     *            ),
     *            @OA\Property(
     *              property="model_name",
     *              format="string",
     *
     *            ),
     *           @OA\Property(
     *              property="title",
     *              format="string",
     *            ),
     *           @OA\Property(
     *              property="file",
     *              format="file",
     *              type="file"
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
     *      example={"code":200,"data":{"id": 1,"model_id":  ".............","model_name":  ".............","title":  ".............","url":  ".............","created_by":  ".............","updated_by":  "............."}}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(ImageRequest $request)
    {
        $result = $this->repository->create($request->all());
        if(!$result){
            return $this->responseJsonError(CODE_CREATE_FAILED, trans('errors.something_error'));
        }
        return $this->responseJson(CODE_SUCCESS, new ImageResource($result));
    }

    /**
     * @OA\Get(
     *   path="/api/image/{id}",
     *   tags={"Image"},
     *   summary="Detail Image",
     *   operationId="image_show",
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
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"model_id":  ".............","model_name":  ".............","title":  ".............","url":  ".............","created_by":  ".............","updated_by":  "............."}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Login false",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Username or password invalid"}
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
            $image = $this->repository->find($id);
            return $this->responseJson(CODE_SUCCESS, new BaseResource($image));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Post(
     *   path="/api/image/edit/{id}",
     *   tags={"Image"},
     *   summary="Update Image",
     *   operationId="image_update",
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
     *          mediaType="multipart/form-data",
     *          example={"model_id":"int","model_name":"string","title":"string","url": "string","created_by": "string","updated_by": "string"},
     *          @OA\Schema(
     *            required={"title"},
     *            @OA\Property(
     *              format="int",
     *              property="model_id",
     *            ),
     *            @OA\Property(
     *              property="model_name",
     *              format="string",
     *            ),
     *           @OA\Property(
     *              property="title",
     *              format="string",
     *            ),
     *           @OA\Property(
     *              property="file",
     *              format="file",
     *              type="file"
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
     *      example={"code":200,"data":{"id": 1,"model_id":  ".............","model_name":  ".............","title":  ".............","url":  ".............","created_by":  ".............","updated_by":  "............."}}
     *     ),
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Access Deny permission",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":403,"message":"Access Deny permission"}
     *     ),
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ImageRequest $request, $id)
    {
        $attributes = $request->except([]);
        $data = $this->repository->update($attributes, $id);
        return $this->responseJson(CODE_SUCCESS, new BaseResource($data));
    }

    /**
     * @OA\Delete(
     *   path="/api/image/{id}",
     *   tags={"Image"},
     *   summary="Delete ..............",
     *   operationId="image_delete",
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
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":"Send request success"}
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
