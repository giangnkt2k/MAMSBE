<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-08
 */

namespace Repository;

use App\Models\Utilities;
use App\Repositories\Contracts\UtilitiesRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class UtilitiesRepository extends BaseRepository implements UtilitiesRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Utilities $model
       */

    public function model()
    {
        return Utilities::class;
    }


}
