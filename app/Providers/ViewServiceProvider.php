<?php

namespace App\Providers;

use App\Models\PermissionMenu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('backend.layouts.master', function ($view) {
            $view->with('permissionMenus', PermissionMenu::with('permissions')->get());
        });
    }
}
