<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

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
    //public function boot(): void
    //{
        //
    //}

    public function boot()
    {
        // 获取菜单数据
        $menus = DB::table('menu')->orderBy('pid')->get();

        // 构建菜单树（可选，根据需要）
        $menuTree = $this->buildMenu($menus);

        // 共享变量到所有视图
        View::share('menus', $menuTree);
    }

    // 构建多层级菜单的递归方法（可选）
    private function buildMenu($menus, $parentId = 0)
    {
        $result = [];
        foreach ($menus as $menu) {
            if ($menu->pid == $parentId) {
                $menu->children = $this->buildMenu($menus, $menu->id);
                $result[] = $menu;
            }
        }
        return $result;
    }
}
