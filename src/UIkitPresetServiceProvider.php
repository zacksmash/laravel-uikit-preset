<?php

namespace Zacksmash;

use Illuminate\Support\ServiceProvider;
use Laravel\Ui\UiCommand;

class UIkitPresetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        UiCommand::macro('uikit', function ($command) {
            UIkitPreset::install();
            $command->info('UIkit scaffolding installed successfully.');
            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });

        UiCommand::macro('uikit-auth', function ($command) {
            UIkitAuthPreset::install();
            $command->info('UIkit auth scaffolding installed successfully.');
            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });
    }
}
