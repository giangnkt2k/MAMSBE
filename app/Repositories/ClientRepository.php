<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-03-26
 */

namespace Repository;

use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Helper\Common;
use Illuminate\Http\Response;
use Helper\ResponseService;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientRepository extends BaseRepository implements ClientRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Client $model
       */

    public function model()
    {
        return Client::class;
    }

    public function getAll ($request)
    {
        if(isset($request->key_search)) {
            $clients = $this->model->select('clients.*')->search($request->key_search);
        }
        else
        {
            $clients = $this->model->select('clients.*');
        }
        error_log($request);
        return  Common::pagination($request, $clients);
    }

    public function import($request)
    {
        DB::beginTransaction();
        if(isset($request['file'])){
            $image = Common::uploadFile($request['file'], '');
        }
        return $image;
    }

    public function deleteImg($request)
    {
        DB::beginTransaction();
        if(isset($request['file'])){
            Storage::delete($request['file']);
        }
        return 'deleted';
    }

    public function importAva($request)
    {
        DB::beginTransaction();
        if(isset($request['avatar'])){
            $image = Common::uploadFile($request['avatar'], '');
        }
        return $image;
    }

    public function deleteImgAva($request)
    {
        DB::beginTransaction();
        if(isset($request['avatar'])){
            Storage::delete($request['avatar']);
        }
        return 'deleted';
    }

    public function destroy($request)
    {
        try {
            DB::beginTransaction();
            $clients = $this->model->whereIn('id', $request->id)->get();
            $clients->delete();
            return ResponseService::responseJson(Response::HTTP_OK, null, 'success');
        }
        catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


}
