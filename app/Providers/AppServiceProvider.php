<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
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
        // Create own validator
        // --------------------------------------------------
        // For select option element, 0 is a first option to guid or text and it's invalid
        Validator::extend('choose', function($attribute, $value, $parameters, $validator){
            return $value > 0;
        });
        // For tag with format 1,2,3,4....
        Validator::extend('mintag', function($attribute, $value, $parameters, $validator){
            $t = explode(',', $value);
            if (count($t) < 1) {
                return false;
            }
            return true;
        });


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
