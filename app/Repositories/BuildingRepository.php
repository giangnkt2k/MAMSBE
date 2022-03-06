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

class BuildingRepository extends BaseRepository implements BuildingRepositoryInterface
{

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

    // public function CreateBuilding($request)
    // {

    // }

    public function getAll ($request)
    {
        if(isset($request->key_search)) {
            $buildings = $this->model->select('buildings.*')->with(['name', 'address', 'detail'])->search($request->key_search);
        }
        else
        {
            $buildings = $this->model->select('buildings.*')->get();
        }
        error_log($request);
        return  $buildings;
    }
}
