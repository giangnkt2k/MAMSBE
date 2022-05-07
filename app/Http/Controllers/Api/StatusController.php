<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-05-07
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusRequest;
use App\Repositories\Contracts\StatusRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bill;
use App\Models\Rental;
use App\Models\Room;
use App\Models\Water;
use App\Models\Electric;
use App\Mail\ReportToAdmin;
use Illuminate\Support\Facades\Mail;


class StatusController extends Controller
{

     /**
     * var Repository
     */
    protected $repository;

    // public function __construct(StatusRepositoryInterface $repository)
    // {
    //     $this->repository = $repository;
    // }

    /**
     * @OA\Get(
     *   path="/api/status",
     *   tags={"Status"},
     *   summary="List status",
     *   operationId="status_index",
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
    public function index(Request $request)
    {
        $req = $request->all();
        $user_id = $req['user_id'];
        $room_id = Rental::where('user_id', $user_id)->value('room_id');
        $room = Room::with(['building'])->where('id', $room_id)->get();
        $water = Water::where('room_id', $room_id)->latest()->value('new_number');
        $electric = Electric::where('room_id', $room_id)->latest()->value('new_number');

        $data = [
            'room' => $room,
            'water' => $water,
            'electric' => $electric,
        ];
        return $this->responseJson(200, ($data));
    }

    /**
     * @OA\Post(
     *   path="/api/status",
     *   tags={"Status"},
     *   summary="Add new status",
     *   operationId="status_create",
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
    public function store(StatusRequest $request)
    {
        try {
            $data = $this->repository->create($request->all());
            return $this->responseJson(200, new StatusResource($data));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function sendtoAdmin(Request $request) {
        Mail::to('thanhgiangss2@gmail.com', $request->client)->send(new ReportToAdmin($request));

        return $this->responseJson(200, null, "Gửi yêu cầu thành công.");
        echo "HTML Email Sent. Check your inbox.";
    }

    /**
     * @OA\Get(
     *   path="/api/status/{id}",
     *   tags={"Status"},
     *   summary="Detail Status",
     *   operationId="status_show",
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
     *   path="/api/status/{id}",
     *   tags={"Status"},
     *   summary="Update Status",
     *   operationId="status_update",
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
    public function update(StatusRequest $request, $id)
    {
        $attributes = $request->except([]);
        $data = $this->repository->update($attributes, $id);
        return $this->responseJson(200, new BaseResource($data));
    }

    /**
     * @OA\Delete(
     *   path="/api/status/{id}",
     *   tags={"Status"},
     *   summary="Delete ..............",
     *   operationId="status_delete",
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
