<?php

namespace Zacksmash\UIkitPreset;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Ui\UiCommand;
use Laravel\Ui\AuthCommand;

class UIkitPresetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        UiCommand::macro('uikit', function ($command) {
            UIkitPreset::install();

            $command->info('UIkit CSS scaffolding installed successfully.');

            if ($command->option('auth')) {
                UIkitPreset::installAuth();

                $command->info('UIkit CSS auth scaffolding installed successfully.');
            }

            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });

        Paginator::defaultView('pagination::default');

        Paginator::defaultSimpleView('pagination::simple-default');
    }
}
