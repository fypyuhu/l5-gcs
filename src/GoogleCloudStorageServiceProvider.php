<?php


namespace fypyuhu\GCSProvider;


use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;

class GoogleCloudStorageServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->app->get('filesystem')->extend('gcs', function ($app, $config) {
            $adapter = new LaravelGoogleCloudStorageAdapter(null, $config);

            return new Filesystem($adapter);
        });
    }
}
