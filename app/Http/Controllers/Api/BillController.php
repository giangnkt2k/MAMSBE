<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-08
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillRequest;
use App\Repositories\Contracts\BillRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\BillResource;
use Illuminate\Http\Request;

class BillController extends Controller
{

     /**
     * var Repository
     */
    protected $repository;

    public function __construct(BillRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *   path="/api/bill",
     *   tags={"Bill"},
     *   summary="List bill",
     *   operationId="bill_index",
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
    public function index(BillRequest $request)
    {
        $data = $this->repository->getAll($request);
        return $this->responseJson(200, BaseResource::collection($data));
    }

    public function indexByDate(BillRequest $request)
    {

        $data = $this->repository->getBillByDate($request);
        return $this->responseJson(200, BaseResource::collection($data));
    }

    public function getBillByRoom(BillRequest $request)
    {

        $data = $this->repository->getBillByRoom($request);
        // $invoice_component = json_decode($bills->invoice_component);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->invoice_component = json_decode($data[$i]->invoice_component);
            }
        return $this->responseJson(200, BaseResource::collection($data));
    }
    /**
     * @OA\Post(
     *   path="/api/bill",
     *   tags={"Bill"},
     *   summary="Add new bill",
     *   operationId="bill_create",
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
    public function store(BillRequest $request)
    {
        try {
            $req = $request->all();
            $req['invoice_component'] = json_encode($request->invoice_component);
            $data = $this->repository->create($req);
            return $this->responseJson(200, new BillResource($data));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function addMany(BillRequest $request)
    {
        try {
            $req = $request->all();
            $bills = $req['bills'];
            // dd(json_encode($bills[0]['invoice_component']));
            for ($i = 0; $i < count($bills); $i++) {
                $bills[$i]['invoice_component'] = json_encode($bills[$i]['invoice_component']);
                $this->repository->create($bills[$i]);
            }
            return $this->responseJson(200);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    /**
     * @OA\Get(
     *   path="/api/bill/{id}",
     *   tags={"Bill"},
     *   summary="Detail Bill",
     *   operationId="bill_show",
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
     *   path="/api/bill/{id}",
     *   tags={"Bill"},
     *   summary="Update Bill",
     *   operationId="bill_update",
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
    public function update(BillRequest $request, $id)
    {
        $attributes = $request->except([]);
        $data = $this->repository->update($attributes, $id);
        return $this->responseJson(200, new BaseResource($data));
    }

    /**
     * @OA\Delete(
     *   path="/api/bill/{id}",
     *   tags={"Bill"},
     *   summary="Delete ..............",
     *   operationId="bill_delete",
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
