<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-11
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardRequest;
use App\Repositories\Contracts\DashboardRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\DashboardResource;
use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Room;
use App\Models\Water;
use App\Models\Client;
use App\Models\Electric;
use App\Models\Contract;
use App\Models\Rental;
use App\Models\Utilities;
class DashboardController extends Controller
{

     /**
     * var Repository
     */
    protected $repository;

    // public function __construct(DashboardRepositoryInterface $repository)
    // {
    //     $this->repository = $repository;
    // }

    /**
     * @OA\Get(
     *   path="/api/dashboard",
     *   tags={"Dashboard"},
     *   summary="List dashboard",
     *   operationId="dashboard_index",
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
    public function index()
    {
        $buildings = count(Building::get());
        $rooms = count(Room::get());
        $users = count(Client::get());
        $data = [
            'buildings' => $buildings,
            'rooms' => $rooms,
            'users' => $users
        ];
        return $this->responseJson(200, $data);
    }

    public function clientsInBuilding()
    {
        $data = [];
        $labels = [];
        $arr_clients = [];
        $roomInBuilding = Building::with(['room'=> function($query) {
            $query->where('rent', 1);
        }])->get();

        for ($i = 0; $i < count($roomInBuilding); $i++) {
            $clients = count($roomInBuilding[$i]->room);
            array_push($labels,$roomInBuilding[$i]->name);
            array_push($arr_clients, $clients);
        }
        array_push($data, (object)[
            'labels' => $labels,
            'clients' => $arr_clients
        ]);

        return $this->responseJson(200, $data);
    }

    public function roomStatus ()
    {
        $data = [];
        $empty = 0;
        $fill = 0;
        $listRooms = Room::get();
        for ($i = 0; $i < count($listRooms); $i++) {
            if ($listRooms[$i]->rent === 1) {
                $fill++;
            }
            else {
                $empty++;
            }
        }
       $data = [
           'fill' => $fill,
           'empty' => $empty
       ];
        return $this->responseJson(200, $data);
    }

    /**
     * @OA\Post(
     *   path="/api/dashboard",
     *   tags={"Dashboard"},
     *   summary="Add new dashboard",
     *   operationId="dashboard_create",
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
    public function store(DashboardRequest $request)
    {
        try {
            $data = $this->repository->create($request->all());
            return $this->responseJson(200, new DashboardResource($data));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Get(
     *   path="/api/dashboard/{id}",
     *   tags={"Dashboard"},
     *   summary="Detail Dashboard",
     *   operationId="dashboard_show",
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
     *   path="/api/dashboard/{id}",
     *   tags={"Dashboard"},
     *   summary="Update Dashboard",
     *   operationId="dashboard_update",
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
    public function update(DashboardRequest $request, $id)
    {
        $attributes = $request->except([]);
        $data = $this->repository->update($attributes, $id);
        return $this->responseJson(200, new BaseResource($data));
    }

    /**
     * @OA\Delete(
     *   path="/api/dashboard/{id}",
     *   tags={"Dashboard"},
     *   summary="Delete ..............",
     *   operationId="dashboard_delete",
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
