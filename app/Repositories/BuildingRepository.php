<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-02-17
 */

namespace Repository;

use App\Models\Building;
use App\Repositories\Contracts\BuildingRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Helper\Common;
use Helper\ResponseService;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;


class BuildingRepository extends BaseRepository implements BuildingRepositoryInterface
{
    use SoftDeletes;

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Building $model
       */

    public function model()
    {
        return Building::class;
    }

    // public function create($request)
    // {
    //     return $request;
    // }

    public function getAll ($request)
    {
        if(isset($request->key_search)) {
            $buildings = $this->model->select('buildings.*')->search($request->key_search);
        }
        else
        {
            $buildings = $this->model->select('buildings.*');
        }
        error_log($request);
        return  Common::pagination($request, $buildings);
    }

    public function import($request)
    {
        DB::beginTransaction();
        if(isset($request['file'])){
            $image = Common::uploadFile($request['file'], '');
        }
        return $image;
    }

    public function deleteImg($request)
    {
        DB::beginTransaction();
        if(isset($request['file'])){
            Storage::delete($request['file']);
        }
        return 'deleted';
    }

    public function destroy($request)
    {
        try {
            DB::beginTransaction();
            $buildings = $this->model->whereIn('id', $request->id)->get();
            $buildings->delete();
            return ResponseService::responseJson(Response::HTTP_OK, null, 'success');
        }
        catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
