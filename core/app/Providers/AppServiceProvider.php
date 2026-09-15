<?php

namespace App\Providers;

use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\Hiring;
use App\Models\Influencer;
use App\Models\Language;
use App\Models\Order;
use App\Models\Service;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $activeTemplate = activeTemplate();
        $general = gs();

        $activeTemplate                  = activeTemplate();
        $viewShare['general']            = $general;
        $viewShare['activeTemplate']     = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language']           = Language::all();
        $viewShare['emptyMessage']       = 'Data not found';
        $viewShare['categories']         = Category::active()->select('id', 'name', 'image')->get();
        view()->share($viewShare);

        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'bannedUsersCount'                 => User::banned()->count(),
                'emailUnverifiedUsersCount'        => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'       => User::mobileUnverified()->count(),
                'kycUnverifiedUsersCount'          => User::kycUnverified()->count(),
                'kycPendingUsersCount'             => User::kycPending()->count(),
                'bannedInfluencersCount'           => Influencer::banned()->count(),
                'emailUnverifiedInfluencersCount'  => Influencer::emailUnverified()->count(),
                'mobileUnverifiedInfluencersCount' => Influencer::mobileUnverified()->count(),
                'kycUnverifiedInfluencersCount'    => Influencer::kycUnverified()->count(),
                'kycPendingInfluencersCount'       => Influencer::kycPending()->count(),
                'pendingTicketCount'               => SupportTicket::where('user_id', '!=', 0)->whereIN('status', [0, 2])->count(),
                'influencerPendingTicketCount'     => SupportTicket::where('influencer_id', '!=', 0)->whereIN('status', [0, 2])->count(),
                'pendingDepositsCount'             => Deposit::pending()->count(),
                'pendingWithdrawCount'             => Withdrawal::pending()->count(),
                'pendingServiceCount'              => Service::pending()->count(),
                'pendingHiringCount'               => Hiring::pending()->count(),
                'reportedHiringCount'              => Hiring::reported()->count(),
                'pendingOrderCount'                => Order::pending()->count(),
                'reportedOrderCount'               => Order::reported()->count(),
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications'     => AdminNotification::where('read_status', 0)->with('user')->orderBy('id', 'desc')->take(10)->get(),
                'adminNotificationCount' => AdminNotification::where('read_status', 0)->count(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        if ($general->force_ssl) {
            \URL::forceScheme('https');
        }

        Paginator::useBootstrapFour();
    }

}
