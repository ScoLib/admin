<?php

namespace Sco\Admin\Console;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Sco Admin Package(publish/migrate).';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('');
        $this->line('************************');
        $this->line('  Welcome to Sco Admin  ');
        $this->line('************************');

        $this->publish();
        $this->migrate();

        $this->info('Successfully Installed Sco Admin!');
    }

    protected function publish()
    {
        $this->line('Publish Resources');
        $this->line('');
        $this->call('vendor:publish', [
            '--provider' => 'Sco\Admin\Providers\AdminServiceProvider',
            '--force'    => true,
        ]);
    }

    protected function migrate()
    {
        $this->line('Running Database Migrations');
        $this->line('');
        $this->call('migrate', ['--force' => true]);
        $this->line('');

        $this->line('Seeding database');
        $this->line('');
        $this->call('db:seed', [
            '--force' => true,
            '--class' => \AdminTableSeeder::class,
        ]);
        $this->line('');

    }
}
