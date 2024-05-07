<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Google\Cloud\Storage\StorageClient;
use League\Flysystem\Filesystem;
// use Spatie\GoogleCloudStorageAdapter\GoogleCloudStorageAdapter;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use Illuminate\Support\Facades\Storage;

class GoogleStorageProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('gcs', function($app, $config) {
            $storageClient = new StorageClient([
                // 'project_id' => $config['project_id'],
                // 'keyFilePath' => $config['key_file'],


                'project_id' => 'shuttlewiser',
                'keyFilePath' => '/var/www/html/shuttlewiser-5ce581cceec5.json',
            ]);

            // dd($storageClient);

            $bucket = $storageClient->bucket('shuttlewiser-bucket');

            $adapter = new GoogleCloudStorageAdapter($bucket);
            // $adapter = new GoogleCloudStorageAdapter($bucket, 'onelook-test-storage');

            return new Filesystem($adapter);

            // \Storage::extend('dropbox', function ($app, $config) {
            //     $adapter = new DropboxAdapter(
            //         new DropboxClient($config['authorization_token'])
            //     );
             
            //     return new FilesystemAdapter(
            //         new Filesystem($adapter, $config),
            //         $adapter,
            //         $config
            //     );
            // });

            

        });
    }
}
