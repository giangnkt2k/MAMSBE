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

    public function CreateBuilding($request)
    {

    }


}
