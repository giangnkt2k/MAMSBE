<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-04
 */

namespace Repository;

use App\Models\water;
use App\Repositories\Contracts\waterRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class waterRepository extends BaseRepository implements waterRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param water $model
       */

    public function model()
    {
        return water::class;
    }


}
