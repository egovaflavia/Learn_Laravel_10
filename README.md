
# Tutorial Laravel 10 itsolutionstuff.com

I am still learning



## CH 2 : Laravel 10 Daily Weekly Monthly Automatic Database Backup

#### Create Middleware

```http
php artisan make:command DatabaseBackUp
```

#### app/Console/Commands/DatabaseBackUp.php

```http
<?php
namespace App\Console\Commands;
  
use Illuminate\Console\Command;
  
class DatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
  
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $filename = "backup-" . now()->format('Y-m-d') . ".gz";
    
        $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . storage_path() . "/app/backup/" . $filename;
    
        $returnVar = NULL;
        $output  = NULL;
    
        exec($command, $output, $returnVar);
    }
}
```

### In this step, we need to create "backup" folder in your storage folder. you must have to create "backup" on following path: storage/app/backup

### app/Console/Kernel.php

```http 
<?php
  
namespace App\Console;
  
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
  
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('database:backup')
                 ->daily();
    }
  
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    
        require base_path('routes/console.php');
    }
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

```http
php artisan database:backup
```

### Run following command:
```http
crontab -e
```
## Authors

- [@egovaflavia](https://www.github.com/egovaflavia)


## Source

 - [itsolutionstuff.com](https://www.itsolutionstuff.com/)
