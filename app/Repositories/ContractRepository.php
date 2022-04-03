<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-03-29
 */

namespace Repository;

use App\Models\Contract;
use App\Repositories\Contracts\ContractRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Helper\Common;

class ContractRepository extends BaseRepository implements ContractRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Contract $model
       */

    public function model()
    {
        return Contract::class;
    }

    public function getAll ($request)
    {
        if(isset($request->key_search)) {
            $contracts = $this->model->select('contracts.*')->search($request->key_search);
        }
        else
        {
            $contracts = $this->model->select('contracts.*');
        }
        error_log($request);
        return  Common::pagination($request, $contracts);
    }


}
