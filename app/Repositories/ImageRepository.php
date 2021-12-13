<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-06-08
 */

namespace Repository;

use App\Http\Controllers\Api\ImageController;
use App\Http\Requests\ImageRequest;
use App\Http\Resources\BaseResource;
use App\Models\Image;
use App\Repositories\Contracts\ImageRepositoryInterface;
use Helper\Common;
use Illuminate\Support\Facades\Storage;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use function Illuminate\Http\Request;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);
     }

    /**
       * Instantiate model
       *
       * @param Image $model
       */

    public function model()
    {
        return Image::class;
    }

    public function create(array $attributes)
    {
        if(isset($attributes['file'])){
            $dir = $this->uploadImage($this->model, 'file', IMAGE . '/' . Auth::id());
            $attributes['url'] = $dir;
            $attributes['created_by'] = Auth::id();
            return parent::create($attributes);
        }
        return false;
    }

    public function update(array $attributes, $id)
    {
        if(isset($attributes['file'])) {
            $dir = $this->uploadImage($this->model, 'file', IMAGE . '/' . Auth::id());
            $image = $this->find($id);
            Storage::delete($image->url);
            $attributes['url'] = $dir;
        }
        $attributes['updated_by'] = Auth::id();
        return parent::update($attributes, $id);
    }

    public function delete($id)
    {
        $dir = $this->uploadImage($this->model, 'file', IMAGE . '/' . Auth::id());
        $image = $this->find($id);
        Storage::delete($image->url);
        $attributes['url'] = $dir;
        $attributes['deleted_by'] = Auth::id();
        return parent::delete($id);
    }
}
