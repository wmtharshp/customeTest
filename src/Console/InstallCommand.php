<?php

namespace Custome\Auth\Console;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use RuntimeException;
use Exception;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;
class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Directories...
        (new Filesystem)->ensureDirectoryExists(app_path('Actions/Contracts'));
        (new Filesystem)->ensureDirectoryExists(app_path('DataTables'));

        copy(__DIR__.'/../Contracts/CreateNewUser.php', app_path('Actions/Contracts/CreateNewUser.php'));
        copy(__DIR__.'/../Contracts/PasswordValidationRules.php', app_path('Actions/Contracts/PasswordValidationRules.php'));
        copy(__DIR__.'/../database/2022_12_12_131652_add_google_id_column.php', base_path('database/migrations/2022_12_12_131652_add_google_id_column.php'));
        copy(__DIR__.'/../DataTables/UsersDataTable.php', app_path('DataTables/UsersDataTable.php'));


        app()->make(\App\Composer::class)->run(['require', 'yajra/laravel-datatables-oracle:^10.0']);
        app()->make(\App\Composer::class)->run(['require', 'yajra/laravel-datatables:^9.0']);
        app()->make(\App\Composer::class)->run(['require', 'laravel/socialite']);
        app()->make(\App\Composer::class)->run(['require', 'mckenziearts/laravel-notify']);

        // Storage...
        $this->callSilent('storage:link');
        $this->callSilent('vendor:publish', ['--tag' => 'datatables', '--force' => true]);
        $this->callSilent('vendor:publish', ['--provider' => 'Mckenziearts\Notify\LaravelNotifyServiceProvider', '--force' => true]);
    }

}
