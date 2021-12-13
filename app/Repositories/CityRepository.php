<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-06-02
 */

namespace Repository;

use App\Models\City;
use App\Repositories\Contracts\CityRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param City $model
       */

    public function model()
    {
        return City::class;
    }


}
