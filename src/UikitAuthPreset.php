<?php

namespace Zacksmash\UIkitPreset;

use Illuminate\Filesystem\Filesystem;
use Laravel\Ui\Presets\Preset as BasePreset;

class UIkitAuthPreset extends BasePreset
{
  protected $views = [
    'auth/login.stub' => 'auth/login.blade.php',
    'auth/passwords/confirm.stub' => 'auth/passwords/confirm.blade.php',
    'auth/passwords/email.stub' => 'auth/passwords/email.blade.php',
    'auth/passwords/reset.stub' => 'auth/passwords/reset.blade.php',
    'auth/register.stub' => 'auth/register.blade.php',
    'auth/verify.stub' => 'auth/verify.blade.php',
    'home.stub' => 'home.blade.php',
    'layouts/app.stub' => 'layouts/app.blade.php',
  ];

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
    static::updateControllers();
    static::updateRoutes();
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
    (new Filesystem)->copyDirectory(__DIR__ . '/stubs/auth/views', resource_path('views'));
  }

  protected static function updateControllers()
  {
    (new Filesystem)->delete(base_path('app/Http/Controllers/HomeController.php'));
    copy(__DIR__ . '/stubs/auth/controllers/HomeController.php', base_path('app/Http/Controllers/HomeController.php'));
  }

  protected static function updateRoutes()
  {
    (new Filesystem)->delete(base_path('routes/web.php'));
    copy(__DIR__ . '/stubs/auth/routes.php', base_path('routes/web.php'));
  }
}
