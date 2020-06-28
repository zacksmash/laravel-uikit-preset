<?php

namespace Zacksmash\LaravelPreset;

use Illuminate\Filesystem\Filesystem;
use Laravel\Ui\Presets\Preset as BasePreset;

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
        static::updateNodePackages();
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

    protected static function updateNodePackages()
    {
        (new Filesystem)->delete(base_path('package.json'));
        (new Filesystem)->delete(base_path('package-lock.json'));
        copy(__DIR__ . '/stubs/package.json', base_path('package.json'));
    }

    protected static function updateSass()
    {
        (new Filesystem)->deleteDirectory(resource_path('sass'));
        (new Filesystem)->copyDirectory(__DIR__ . '/stubs/base/scss', resource_path('scss'));
    }

    protected static function updateJavaScript()
    {
        (new Filesystem)->deleteDirectory(resource_path('js'));
        (new Filesystem)->copyDirectory(__DIR__ . '/stubs/base/js', resource_path('js'));
    }

    protected static function updateTemplates()
    {
        (new Filesystem)->deleteDirectory(resource_path('views'));
        (new Filesystem)->copyDirectory(__DIR__ . '/stubs/base/views', resource_path('views'));
    }
}
