<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\Sousmenu;
use App\Models\Menu;
use App\Models\RolePermission;
use App\Observers\RoleObserver;
use App\Observers\SousmenuObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS URLs on production or when behind Render/Cloudflare HTTPS reverse proxy
        if ($this->app->environment('production') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
            URL::forceScheme('https');
        }

        // Register observers
        Role::observe(RoleObserver::class);
        Sousmenu::observe(SousmenuObserver::class);

        // Share main menus with all views based on user role permissions
        View::composer('*', function ($view) {
            $user = Auth::user();

            $menus = [];
            if ($user) {
                $roleId = $user->role_id;
                $accessibleSousMenus = RolePermission::where('role_id', $roleId)
                                            ->where('is_granted', true)
                                            ->where('actif', 'OUI')
                                            ->pluck('sous_menu_id')->toArray();

                $menus = Menu::with(['sousmenus' => function ($query) use ($accessibleSousMenus) {
                    $query->whereIn('id', $accessibleSousMenus)
                          ->where('actif', 'OUI')
                          ->orderBy('libelle', 'asc');
                }])->whereHas('sousmenus', function ($query) use ($accessibleSousMenus) {
                    $query->whereIn('id', $accessibleSousMenus)
                          ->where('actif', 'OUI');
                })->where('actif', 'OUI')
                  ->orderBy('libelle', 'asc')
                  ->get();
            }

            $view->with('mainmenus', $menus);
        });
    }
}
