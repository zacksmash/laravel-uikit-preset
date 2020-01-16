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
        static::removeNodeModules();
        static::updateWebpackConfiguration();
        static::updateGitignore();
        static::updateEditorConfig();
        static::updatePackages();
        static::updateSass();
        static::updateJavaScript();
        static::updateTemplates();
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

    protected static function updatePackages()
    {
        (new Filesystem)->delete(base_path('package.json'));
        (new Filesystem)->delete(base_path('package-lock.json'));
        copy(__DIR__ . '/stubs/package.json', base_path('package.json'));
    }

    protected static function updateSass()
    {
        (new Filesystem)->deleteDirectory(resource_path('sass'));
        (new Filesystem)->copyDirectory(__DIR__ . '/stubs/sass', resource_path('sass'));
    }

    protected static function updateJavaScript()
    {
        (new Filesystem)->deleteDirectory(resource_path('js'));
        (new Filesystem)->copyDirectory(__DIR__ . '/stubs/js', resource_path('js'));
    }

    protected static function updateTemplates()
    {
        (new Filesystem)->deleteDirectory(resource_path('views'));
        (new Filesystem)->copyDirectory(__DIR__ . '/stubs/views', resource_path('views'));
    }
}
