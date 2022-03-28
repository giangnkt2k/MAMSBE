<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-03-26
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientController extends Controller
{

     /**
     * var Repository
     */
    protected $repository;

    public function __construct(ClientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *   path="/api/client",
     *   tags={"Client"},
     *   summary="List client",
     *   operationId="client_index",
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{{"id": 1,"name": "..........."}}}
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="page",
     *     in="query",
     *     @OA\Schema(
     *      type="integer",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="per_page",
     *     in="query",
     *     @OA\Schema(
     *      type="integer",
     *     ),
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
    public function index(ClientRequest $request)
    {
        $data = $this->repository->getAll($request);
        return $this->responseJson(200, BaseResource::collection($data));
    }

    /**
     * @OA\Post(
     *   path="/api/client",
     *   tags={"Client"},
     *   summary="Add new client",
     *   operationId="client_create",
     *   @OA\Parameter(name="name", in="query", required=true,
     *     @OA\Schema(type="string"),
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"name": "......"}}
     *     )
     *   ),
     *   security={},
     * )
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(ClientRequest $request)
    {
        try {
            $req = $request->all();
            if(isset($req['avatar'])) {
            $req['avatar'] = json_encode($request->avatar);
            }
            $req['images'] = json_encode($request->images);
            $data = $this->repository->create($req);
            return $this->responseJson(200, new ClientResource($data));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function import(ClientRequest $request)
    {
        try {
            $image = $this->repository->import($request);
            return $this->responseJson(Response::HTTP_OK, $image, 'upload success');
        } catch (\Exception $e) {
            return $this->responseJsonEx($e);
        }
    }

    public function deleteImg(ClientRequest $request)
    {
        try {
            $image = $this->repository->deleteImg($request);
            return $this->responseJson(Response::HTTP_OK, $image, 'upload success');
        } catch (\Exception $e) {
            return $this->responseJsonEx($e);
        }
    }

    public function importAva(ClientRequest $request)
    {
        try {
            $image = $this->repository->importAva($request);
            return $this->responseJson(Response::HTTP_OK, $image, 'upload success');
        } catch (\Exception $e) {
            return $this->responseJsonEx($e);
        }
    }

    public function deleteImgAva(ClientRequest $request)
    {
        try {
            $image = $this->repository->deleteImgAva($request);
            return $this->responseJson(Response::HTTP_OK, $image, 'upload success');
        } catch (\Exception $e) {
            return $this->responseJsonEx($e);
        }
    }
    /**
     * @OA\Get(
     *   path="/api/client/{id}",
     *   tags={"Client"},
     *   summary="Detail Client",
     *   operationId="client_show",
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
     *      example={"code":200,"data":{"id": 1,"name":"......"}}
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
            $department = $this->repository->find($id);
            return $this->responseJson(200, new BaseResource($department));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Post(
     *   path="/api/client/{id}",
     *   tags={"Client"},
     *   summary="Update Client",
     *   operationId="client_update",
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
     *          example={"name":"string"},
     *          @OA\Schema(
     *            required={"name"},
     *            @OA\Property(
     *              property="name",
     *              format="string",
     *            ),
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"name":  "............."}}
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
    public function update(ClientRequest $request, $id)
    {
        $attributes = $request->except([]);
        $data = $this->repository->update($attributes, $id);
        return $this->responseJson(200, new BaseResource($data));
    }

    /**
     * @OA\Delete(
     *   path="/api/client/{id}",
     *   tags={"Client"},
     *   summary="Delete ..............",
     *   operationId="client_delete",
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
        $this->repository->delete($id);
        return $this->responseJson(200, null, trans('messages.mes.delete_success'));
    }
}
