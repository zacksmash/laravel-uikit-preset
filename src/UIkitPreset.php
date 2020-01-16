<?php

namespace Zacksmash\LaravelPreset;

use Artisan;
use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset as BasePreset;

class UIkitPreset extends BasePreset
{
    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install($withAuth = false)
    {
        static::ensureComponentDirectoryExists();
        static::updatePackages();
        static::updateSass();
        static::updateWebpackConfiguration();
        static::updateJavaScript();
        static::updateTemplates();
        static::removeNodeModules();
        static::updateGitignore();
        static::updateEditorConfig();
    }

    protected static function updateWebpackConfiguration()
    {
        copy(__DIR__ . '/stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    protected static function updateGitignore()
    {
        copy(__DIR__ . '/stubs/gitignore', base_path('.gitignore'));
    }

    protected static function updateEditorConfig()
    {
        copy(__DIR__ . '/stubs/editorconfig', base_path('.editorconfig'));
    }

    protected static function updatePackageArray(array $packages)
    {
        return array_merge([
            'browser-sync' => '^2.26.7',
            'browser-sync-webpack-plugin' => '^2.2.2',
            'laravel-mix-auto-extract' => '^1.0.1',
            'laravel-mix' => '^3.0',
            'cross-env' => '^5.2',
            'uikit' => '^3.2.7'
        ], Arr::except($packages, [
            'bootstrap',
            'bootstrap-sass',
            'popper.js',
            'axios',
            'lodash',
            'resolve-url-loader',
            'sass',
            'sass-loader'
        ]));
    }

    protected static function updateSass()
    {
        copy(__DIR__ . '/stubs/sass', resource_path('sass'));
    }

    protected static function updateJavaScript()
    {
        copy(__DIR__ . '/stubs/js', resource_path('js'));
    }

    protected static function updateTemplates()
    {
        copy(__DIR__ . '/stubs/views', resource_path('views'));
    }
}
