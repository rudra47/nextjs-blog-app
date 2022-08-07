<?php

namespace App\Providers;

use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\MoneyReceiverRepositoryInterface;
use App\Interfaces\OfferRepositoryInterface;
use App\Interfaces\PackageProductRepositoryInterface;
use App\Interfaces\PackageRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\PaymentMethodRepositoryInterface;
use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\StoreRepositoryInterface;
use App\Interfaces\TagRepositoryInterface;
use App\Interfaces\SliderRepositoryInterface;
use App\Interfaces\TicketRepositoryInterface;
use App\Interfaces\CouponRepositoryInterface;
use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\ConditionalMoneyReceiverRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\ProfileRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\OrderManagementRepositoryInterface;

use App\Repositories\CategoryRepository;
use App\Repositories\MoneyReceiverRepository;
use App\Repositories\OfferRepository;
use App\Repositories\PackageProductRepository;
use App\Repositories\PackageRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PaymentMethodRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StoreRepository;
use App\Repositories\TagRepository;
use App\Repositories\SliderRepository;
use App\Repositories\TicketRepository;
use App\Repositories\CouponRepository;
use App\Repositories\AuthRepository;
use App\Repositories\CartRepository;
use App\Repositories\ConditionalMoneyReceiverRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use App\Repositories\OrderManagementRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(PackageRepositoryInterface::class, PackageRepository::class);
        $this->app->bind(MoneyReceiverRepositoryInterface::class, MoneyReceiverRepository::class);
        $this->app->bind(PaymentMethodRepositoryInterface::class, PaymentMethodRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(PackageProductRepositoryInterface::class, PackageProductRepository::class);
        $this->app->bind(OfferRepositoryInterface::class, OfferRepository::class);
        $this->app->bind(SliderRepositoryInterface::class, SliderRepository::class);
        $this->app->bind(TicketRepositoryInterface::class, TicketRepository::class);
        $this->app->bind(CouponRepositoryInterface::class, CouponRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderManagementRepositoryInterface::class, OrderManagementRepository::class);
        $this->app->bind(ConditionalMoneyReceiverRepositoryInterface::class, ConditionalMoneyReceiverRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
