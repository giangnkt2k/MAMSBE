<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-05-07
 */

namespace Repository;

use App\Models\Status;
use App\Repositories\Contracts\StatusRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class StatusRepository extends BaseRepository implements StatusRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Status $model
       */

    public function model()
    {
        return Status::class;
    }


}
