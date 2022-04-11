<?php

namespace App\Providers;


use App\Models\Setting;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Repositories\Contracts\BlogRepositoryInterface;
use App\Repositories\Contracts\BuildingRepositoryInterface;
use App\Repositories\Contracts\ImageRepositoryInterface;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Contracts\CityRepositoryInterface;
use App\Repositories\Contracts\RoomRepositoryInterface;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\Contracts\ContractRepositoryInterface;
use App\Repositories\Contracts\RentalRepositoryInterface;
use App\Repositories\Contracts\WaterRepositoryInterface;
use App\Repositories\Contracts\ElectricRepositoryInterface;
use App\Repositories\Contracts\BillRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Repository\BaseRepository;
use Repository\AuthRepository;

use Repository\BlogRepository;
use Repository\CityRepository;
use Repository\ClientRepository;
use Repository\ImageRepository;
use Repository\RoleRepository;
use Laravel\Dusk\DuskServiceProvider;
use Repository\BuildingRepository;
use Repository\RoomRepository;
use Repository\ContractRepository;
use Repository\SettingRepository;
use Repository\RentalRepository;
use Repository\WaterRepository;
use Repository\ElectricRepository;
use Repository\BillRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);
        $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
        $this->app->bind(BuildingRepositoryInterface::class, BuildingRepository::class);
        $this->app->bind(RoomRepositoryInterface::class, RoomRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(ContractRepositoryInterface::class, ContractRepository::class);
        $this->app->bind(RentalRepositoryInterface::class, RentalRepository::class);
        $this->app->bind(RentalRepositoryInterface::class, RentalRepository::class);
        $this->app->bind(WaterRepositoryInterface::class, WaterRepository::class);
        $this->app->bind(ElectricRepositoryInterface::class, ElectricRepository::class);
        $this->app->bind(BillRepositoryInterface::class, BillRepository::class);
        //Customer
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
//        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
