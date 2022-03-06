<?php


namespace Helper;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Events\EvenInput;
use App\Models\Relation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class Common
{
    /**
     * @param UploadedFile $file
     * @param $path
     * @param null $shopId
     * @return mixed
     */
//    public static function uploadFile(UploadedFile $file, $path = '', $shopId = null)
//    {
//        $shopId = $shopId ?? data_get(Auth::user(), 'shop.id');
//        $fileName = now()->format('d-m-Y--H-i-s') . "_" . $file->getClientOriginalName();
//        return $file->storeAs("shops/{$shopId}/{$path}", $fileName);
//    }

    public static function uploadFile(UploadedFile $file, $path = '', $userId = null)
    {
        $userId = $userId ?? Auth::id();
        $fileName = time().'.'.$file->getClientOriginalExtension();
        return $file->storeAs($path, $fileName);
    }

    public static function checkTokenFB($token){
        try{
            $client = new \GuzzleHttp\Client();
            $url    = 'https://graph.facebook.com/me?access_token=' . $token;
            $res    = $client->request('GET', $url);
            if ($res->getStatusCode() == 200) {
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }

    public static function pagination($request, $data)
    {
        if ($request->per_page < 0) {
            $object = $data->get()->count();
            return $data->paginate($object);
        } else {
            $limit = is_null(request('per_page')) ? 15 : request('per_page');
            return $data->paginate($limit);
        }
    }

}
