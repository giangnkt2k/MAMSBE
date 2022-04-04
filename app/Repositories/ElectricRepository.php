<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-04
 */

namespace Repository;

use App\Models\Electric;
use App\Repositories\Contracts\ElectricRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class ElectricRepository extends BaseRepository implements ElectricRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Electric $model
       */

    public function model()
    {
        return Electric::class;
    }


}
