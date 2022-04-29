<?php


namespace Repository;

use App\Models\Bill;
use App\Models\Room;
use App\Repositories\Contracts\BillRepositoryInterface;
use Helper\Common;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class BillRepository extends BaseRepository implements BillRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Bill $model
       */

    public function model()
    {
        return Bill::class;
    }

    public function getBillByDate ($request)
    {
        $bills = $this->model->where(['date' => $request->date]);
        return  Common::pagination($request, $bills);
    }

}
