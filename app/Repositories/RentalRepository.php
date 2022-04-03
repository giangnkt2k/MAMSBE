<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-01
 */

namespace Repository;

use App\Models\Rental;
use App\Repositories\Contracts\RentalRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Helper\Common;
use Illuminate\Support\Facades\Auth;

class RentalRepository extends BaseRepository implements RentalRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Rental $model
       */

    public function model()
    {
        return Rental::class;
    }

    public function getAll ($request)
    {
        if(isset($request->search)) {
            $rental = $this->model->select('rentals.*')->search($request->search);
        }
        else
        {
            $rental = $this->model->with(['room'])->with(['user'])->with(['contract'])->select('rentals.*');
        }
        return  Common::pagination($request, $rental);
    }
}
