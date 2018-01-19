<?php

namespace Sco\Admin\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:install
                    {--force : Overwrite existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Sco-Admin Package.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('');
        $this->line('************************');
        $this->line('  Welcome to Sco-Admin  ');
        $this->line('************************');

        $this->publish();
        $this->routes();

        $this->info('Successfully Installed Sco-Admin!');
    }

    protected function publish()
    {
        $this->line('Publish Resources');
        $this->call('vendor:publish', [
            '--provider' => 'Sco\Admin\Providers\ResourcesServiceProvider',
            '--force'    => true,
        ]);
    }

    protected function routes()
    {
        file_put_contents(
            base_path('routes/web.php'),
            "\nAdmin::routes();",
            FILE_APPEND
        );

        $this->info('Routes generated successfully.');
    }
}
