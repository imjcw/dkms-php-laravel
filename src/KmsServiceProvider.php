<?php
namespace Lucky\Dkms;

use Illuminate\Support\ServiceProvider;
use Lucky\Dkms\Clients\DkmsClient;
use Lucky\Dkms\Clients\DkmsMailClient;

/**
 * DKmsServiceProvider
 */
class DKmsServiceProvider extends ServiceProvider
{
    protected $key = "dkms";

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (is_a($this->app, "\\Laravel\\Lumen\\Application")) {
            $this->app->configure($this->key);
        }
        $this->mergeConfigFrom($this->configPath(), $this->key);

        $config = \config($this->key);
        $drivers = $config["drivers"] ?: [];
        $default = $config["default"] ?: "online";
        unset($config["drivers"]);
        unset($config["default"]);
        foreach ($drivers as $key => $driver) {
            $appName = $this->key;
            if ($default != $key) {
                $appName .= "." . $key;
            }
            $driver = array_merge($config, $driver);
            $this->app->bind($appName, function ($app) use ($driver) {
                return new DkmsClient($driver);
            });
        }
    }

    /**
     * Default config file path
     *
     * @return string
     */
    protected function configPath()
    {
        return __DIR__ . "/config.php";
    }
}