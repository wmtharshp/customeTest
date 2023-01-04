<?php

namespace Custome\Auth\Console;
use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:name';

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
        $this->callSilent('vendor:publish', ['--tag' => 'datatables', '--force' => true]);
        $this->callSilent('vendor:publish', ['--provider' => 'Mckenziearts\Notify\LaravelNotifyServiceProvider', '--force' => true]);
        $this->callSilent('vendor:publish', [ '--provider' => "Spatie\Permission\PermissionServiceProvider", '--force' => true]);
        $this->callSilent('optimize:clear');
        $this->callSilent('config:clear');

    }

}
