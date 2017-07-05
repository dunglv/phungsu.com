<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Category;
use App\Article;
use App\Tag;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $c = Category::all()->where('active', 1);
        $t = Tag::take(10)->get();
        $a = Article::whereHas('stat', function($q){$q->orderBy('view', 'desc');})->take(5)->get();
        view()->share(['__CATEGORY'=> $c, '__TAG' => $t, '__ARTICLE' => $a]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
