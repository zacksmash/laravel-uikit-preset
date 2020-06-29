<?php

namespace Zacksmash\UIkitPreset;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Laravel\Ui\Presets\Preset;
use Symfony\Component\Finder\SplFileInfo;

class UIkitPreset extends Preset
{
    private static $command;

    public static function install($command)
    {
        static::$command = $command;
        static::updatePackages();
        static::updatePackages(false);
        static::updateAssets();
        static::updateBootstrapping();
        static::updateWelcomePage();
        // static::updatePagination();
        static::removeNodeModules();
    }

    public static function installAuth($command)
    {
        static::$command = $command;
        static::scaffoldController();
        static::scaffoldAuth();
    }

    protected static function updatePackageArray(array $packages, string $key)
    {
        if (file_exists(base_path('package-lock.json'))) {
            unlink(base_path('package-lock.json'));
        }

        if ($key == 'devDependencies') {
            static::$command->info('dev deps');

            return array_merge([
                'laravel-mix' => '^5.0.1'
            ], Arr::except($packages, [
                'axios',
                'bootstrap',
                'bootstrap-sass',
                'popper.js',
                'lodash',
                'laravel-mix',
            ]));
        }

        if ($key == 'dependencies') {
            static::$command->info('deps');

            return [
                'js-dom-router' => '^1.0.0',
                'jquery' => '^3.5.0',
                'uikit' => '^3.5.0'
            ];
        }
    }

    protected static function updateAssets()
    {
        tap(new Filesystem, function ($filesystem) {
            $filesystem->deleteDirectory(resource_path('sass'));
            $filesystem->deleteDirectory(resource_path('js'));
            $filesystem->delete(public_path('js/app.js'));
            $filesystem->delete(public_path('css/app.css'));

            if (!$filesystem->isDirectory($directory = resource_path('scss'))) {
                $filesystem->makeDirectory($directory, 0755, true);
            }

            $filesystem->copyDirectory(__DIR__ . '/stubs/resources/scss', resource_path('scss'));
            $filesystem->copyDirectory(__DIR__ . '/stubs/resources/js', resource_path('js'));
        });
    }

    protected static function updateBootstrapping()
    {
        copy(__DIR__ . '/stubs/webpack.mix.js', base_path('webpack.mix.js'));

        copy(__DIR__ . '/stubs/gitignore', base_path('.gitignore'));

        copy(__DIR__ . '/stubs/editorconfig', base_path('.editorconfig'));
    }

    // protected static function updatePagination()
    // {
    //     (new Filesystem)->delete(resource_path('views/vendor/paginate'));

    //     (new Filesystem)->copyDirectory(__DIR__ . '/stubs/resources/views/vendor/pagination', resource_path('views/vendor/pagination'));
    // }

    protected static function updateWelcomePage()
    {
        (new Filesystem)->delete(resource_path('views/welcome.blade.php'));

        copy(__DIR__ . '/stubs/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));
    }

    protected static function scaffoldController()
    {
        if (!is_dir($directory = app_path('Http/Controllers/Auth'))) {
            mkdir($directory, 0755, true);
        }

        $filesystem = new Filesystem;

        collect($filesystem->allFiles(base_path('vendor/laravel/ui/stubs/Auth')))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                $filesystem->copy(
                    $file->getPathname(),
                    app_path('Http/Controllers/Auth/' . Str::replaceLast('.stub', '.php', $file->getFilename()))
                );
            });
    }

    protected static function scaffoldAuth()
    {
        file_put_contents(app_path('Http/Controllers/HomeController.php'), static::compileControllerStub());

        file_put_contents(
            base_path('routes/web.php'),
            "\n\nAuth::routes();\n\nRoute::get('/home', 'HomeController@index')->name('home');\n\n",
            FILE_APPEND
        );

        tap(new Filesystem, function ($filesystem) {
            $filesystem->copyDirectory(__DIR__ . '/stubs/resources/views', resource_path('views'));

            collect($filesystem->allFiles(base_path('vendor/laravel/ui/stubs/migrations')))
                ->each(function (SplFileInfo $file) use ($filesystem) {
                    $filesystem->copy(
                        $file->getPathname(),
                        database_path('migrations/' . $file->getFilename())
                    );
                });
        });
    }

    protected static function compileControllerStub()
    {
        return str_replace(
            '{{namespace}}',
            Container::getInstance()->getNamespace(),
            file_get_contents(__DIR__ . '/stubs/controllers/HomeController.stub')
        );
    }
}
