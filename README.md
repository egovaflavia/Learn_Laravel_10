
# Tutorial Laravel 10 itsolutionstuff.com

I am still learning



## CH : Laravel 10 Restrict User Access From IP Address Example

#### Create Middleware

```http
  php artisan make:middleware BlockIpMiddleware
```

#### app/Http/Middleware/BlockIpMiddleware.php

```http
<?php
  
namespace App\Http\Middleware;
  
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
  
class BlockIpMiddleware
{
    public $blockIps = ['whitelist-ip-1', 'whitelist-ip-2', '127.0.0.1'];
  
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->ip(), $this->blockIps)) {
            abort(403, "You are restricted to access the site.");
        }
  
        return $next($request);
    }
}
```

### app/Http/Kernel.php

```http 
<?php
  
namespace App\Http;
  
use Illuminate\Foundation\Http\Kernel as HttpKernel;
  
class Kernel extends HttpKernel
{
    ....
  
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        ....
        'blockIP' => \App\Http\Middleware\BlockIpMiddleware::class,
    ];
}
```

### routes/web.php

```http
<?php
  
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\RSSFeedController;
use App\Http\Controllers\UserController;
   
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    
Route::middleware(['blockIP'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('rss', RSSFeedController::class);
});
```


## Authors

- [@egovaflavia](https://www.github.com/egovaflavia)


## Source

 - [itsolutionstuff.com](https://www.itsolutionstuff.com/)
