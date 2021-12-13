<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-06-09
 */

namespace Repository;

use App\Models\Blog;
use App\Repositories\Contracts\BlogRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Blog $model
       */

    public function model()
    {
        return Blog::class;
    }


}
