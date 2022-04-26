<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-02-17
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Repositories\Contracts\RoomRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\RoomResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Utilities;
use App\Models\Rental;
use App\Models\Bill;
use Illuminate\Support\Facades\Mail;
use App\Mail\BillEmail;
use Nexmo\Laravel\Facade\Nexmo;



class RoomController extends Controller
{

     /**
     * var Repository
     */
    protected $repository;

    public function __construct(RoomRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *   path="/api/room",
     *   tags={"Room"},
     *   summary="List room",
     *   operationId="room_index",
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
        $data = $this->repository->getAll($request);

        return $this->responseJson(200, BaseResource::collection($data));
    }

    public function indexForBill(Request $request)
    {
        $data = $this->repository->getAllForBIll($request);

        for ($i = 0; $i < count($data); $i++) {
            if($data[$i]['rent'] == 1) {
                $unlities = Utilities::find(json_decode($data[$i]->utilities));
                $data[$i]['utilities'] = $unlities;
                $rental = Rental::where('room_id', $data[$i]['id'])->with('user')->first();
                if(isset($rental->user)) {
                    $data[$i]['user'] = $rental->user;
                }
                else {
                    $data[$i]['user'] = null;
                }
            }
       }
        return $this->responseJson(200, BaseResource::collection($data));
    }

    public function indexCollectWater(Request $request)
    {
        $data = $this->repository->getListToCollectWater($request);
        return $this->responseJson(200, BaseResource::collection($data));
    }

    public function indexCollectElectric(Request $request)
    {
        $data = $this->repository->getListToCollectElectric($request);
        return $this->responseJson(200, BaseResource::collection($data));
    }

    /**
     * @OA\Post(
     *   path="/api/room",
     *   tags={"Room"},
     *   summary="Add new room",
     *   operationId="room_create",
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
    public function store(RoomRequest $request)
    {
        try {
            $req = $request->all();
            $req['utilities'] = json_encode($request->utilities);
            $req['rules'] = json_encode($request->rules);
            $req['images'] = json_encode($request->images);
            $data = $this->repository->create($req);
            $utilities = Utilities::find(json_decode($request->utilities));
            $data->utilities()->attach($utilities);

            return $this->responseJson(200, new RoomResource($data));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function sendBillEmail(Request $request) {
        $data = $this->repository->getAllForBIll($request);
        for ($i = 0; $i < count($data); $i++) {
            $unlities = Utilities::find(json_decode($data[$i]->utilities));
            $data[$i]['utilities'] = $unlities;
            $rental = Rental::where('room_id', $data[$i]['id'])->with('user')->first();
            $bill = Bill::where('room_id', $data[$i]['id'])->first();
            if(isset($bill)) {
                $data[$i]['bill'] = $bill;
            }
            // $user = $rental[0]->user;
            $data[$i]['date'] = $request->date;
            if(isset($rental->user)) {
                $data[$i]['user'] = $rental->user;
                Mail::to($data[$i]['user']->email, $data[$i]['user']->name)->send(new BillEmail($data[$i]));
            }
            else {
                $data[$i]['user'] = null;
            }

       }

        return $this->responseJson(200, null, "Gửi yêu cầu thành công.");
        echo "HTML Email Sent. Check your inbox.";
    }

    public function sendBillSMS(Request $request) {
        $data = $this->repository->getAllForBIll($request);
        for ($i = 0; $i < count($data); $i++) {
            $unlities = Utilities::find(json_decode($data[$i]->utilities));
            $data[$i]['utilities'] = $unlities;
            $rental = Rental::where('room_id', $data[$i]['id'])->with('user')->first();
            $bill = Bill::where('room_id', $data[$i]['id'])->first();
            if(isset($bill)) {
                $data[$i]['bill'] = $bill;
            }
            // $user = $rental[0]->user;
            $data[$i]['date'] = $request->date;
            if(isset($rental->user)) {
                $data[$i]['user'] = $rental->user;
                $invoice_component = json_decode($data[$i]->bill->invoice_component);
                Nexmo::message()->send([
                    'to' => '84903463046',
                    'from' => 'MAMS'.$data[$i]->building->name,
                    'text' => 'Your bill '. $data[$i]['date'].': '.
                    'Client: ' .$data[$i]['user']['name'].
                    ' .Total: ' .$invoice_component->totalPrice.' VND',
                ]);
            }
            else {
                $data[$i]['user'] = null;
            }

       }

        return $this->responseJson(200, null, "Gửi yêu cầu thành công.");
    }

    /**
     * @OA\Get(
     *   path="/api/room/{id}",
     *   tags={"Room"},
     *   summary="Detail Room",
     *   operationId="room_show",
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
     *   path="/api/room/{id}",
     *   tags={"Room"},
     *   summary="Update Room",
     *   operationId="room_update",
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
    public function update(RoomRequest $request, $id)
    {
        $attributes = $request->except([]);
        $data = $this->repository->update($attributes, $id);
        return $this->responseJson(200, new BaseResource($data));
    }

    /**
     * @OA\Delete(
     *   path="/api/room/{id}",
     *   tags={"Room"},
     *   summary="Delete ..............",
     *   operationId="room_delete",
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

    public function import(RoomRequest $request)
    {
        try {
            $image = $this->repository->import($request);
            return $this->responseJson(Response::HTTP_OK, $image, 'upload success');
        } catch (\Exception $e) {
            return $this->responseJsonEx($e);
        }
    }
}
