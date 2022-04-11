<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-11
 */

namespace Repository;

use App\Models\Dashboard;
use App\Repositories\Contracts\DashboardRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class DashboardRepository extends BaseRepository implements DashboardRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Dashboard $model
       */

    public function model()
    {
        return Dashboard::class;
    }


}
