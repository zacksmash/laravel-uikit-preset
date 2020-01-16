<?php

namespace Zacksmash\LaravelPreset;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\PresetCommand;

class UIkitPresetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        PresetCommand::macro('uikit', function ($command) {
            UIkitPreset::install();
            $command->info('UIkit scaffolding installed successfully.');
            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });

        PresetCommand::macro('uikit-auth', function ($command) {
            UIkitAuthPreset::install();
            $command->info('UIkit auth scaffolding installed successfully.');
            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });
    }
}
