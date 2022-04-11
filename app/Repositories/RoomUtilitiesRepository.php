<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-09
 */

namespace Repository;

use App\Models\RoomUtilities;
use App\Repositories\Contracts\RoomUtilitiesRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class RoomUtilitiesRepository extends BaseRepository implements RoomUtilitiesRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param RoomUtilities $model
       */

    public function model()
    {
        return RoomUtilities::class;
    }


}
