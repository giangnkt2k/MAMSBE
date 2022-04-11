<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-02-17
 */

namespace Repository;

use App\Models\Room;
use App\Repositories\Contracts\RoomRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Helper\Common;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Room $model
       */

    public function model()
    {
        return Room::class;
    }

    public function getAll ($request)
    {
        if(isset($request->key_search)) {
            $rooms = $this->model->with(['building'])->where(['building_id'=> $request->building_id])->select('rooms.*')->search($request->key_search);
        }
        else
        {
            $rooms = $this->model->with(['building'])->where(['building_id'=> $request->building_id]);
        }
        return  Common::pagination($request, $rooms);
    }

    public function getAllForBIll ($request)
    {
        $rooms = $this->model->where(['rent' => 1])->with(['building'])
        ->where(
            ['building_id'=> $request->building_id,
             'floor_id' =>$request->floor_id,])
        ->with('water', function($query) use($request) {
            $query->where('date', $request->date);
        })
        ->with('electric', function($query) use($request) {
            $query->where('date', $request->date);
        });
        return  Common::pagination($request, $rooms);
    }

    public function getListToCollectWater ($request)
    {

            $rooms = $this->model->with(['building'])
            ->with('water', function($query) use($request) {
                $query->whereIn('date', [$request->date, $request->date('date')->subMonth()->format('Y-m-d')]);
            })
            ->where(['building_id'=> $request->building_id])
            ->where(['floor_id' => $request->floor_id]);

        return  Common::pagination($request, $rooms);
    }

    public function getListToCollectElectric ($request)
    {

            $rooms = $this->model->with(['building'])
            ->with('electric', function($query) use($request) {
                $query->whereIn('date', [$request->date, $request->date('date')->subMonth()->format('Y-m-d')]);
            })
            ->where(['building_id'=> $request->building_id])
            ->where(['floor_id' => $request->floor_id]);

        return  Common::pagination($request, $rooms);
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
}
