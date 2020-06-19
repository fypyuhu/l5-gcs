# Google Cloud Storage ServiceProvider for Laravel 7.0+

Just Wraps [cedricziel/flysystem-gcs](https://github.com/cedricziel/flysystem-gcs) in a Laravel 5.5+ compatible Service Provider. and add some other functionality that I need.

## Addition Feature for Laravel 
* Can use [temporaryUrl](https://laravel.com/docs/5.5/filesystem#file-urls) method.
* Can add metadata when write object.

## Installation
```composer require fypyuhu/l5-gcs```

Register the service provider in `app.php`
```php
'providers' => [
    // ...
    fypyuhu\GCSProvider\GoogleCloudStorageServiceProvider::class,
]
```

Add a new disk to your `filesystems.php` config
```php
'gcs' => [
    'driver' => 'gcs',
    'projectId' => env('GCS_PROJECT_ID'),
    'bucket' => env('GCS_BUCKET'),
    'keyFilePath' => storage_path(env('GCS_KEY_FILE')),
    'url' => env('GCS_CUSTOM_URL'), // optional: for custom url only
],
```

## Usage
Use it like any other Flysystem Adapter with the Storage-Facade.
```php
$disk = Storage::disk('gcs');

// Put a private file on the 'gcs' disk which is a Google Cloud Storage bucket
$disk->put('test.png', file_get_contents(storage_path('app/test.png')));

// Put a public-accessible file on the 'gcs' disk which is a Google Cloud Storage bucket
$disk->put(
    'test-public.png',
    file_get_contents(storage_path('app/test-public.png')),
    \Illuminate\Contracts\Filesystem\Filesystem::VISIBILITY_PUBLIC
);

// Put a public-accessible file with metadata on the 'gcs' disk which is a Google Cloud Storage bucket 
$disk->put(
    'test.png',
    file_get_contents(storage_path('app/test.png')),
    [
        'metadata' => [
            'contentDisposition' => 'attachment; filename=file.png',
            'contentType' => 'image/png',
        ],
        'visibility' => \Illuminate\Contracts\Filesystem\Filesystem::VISIBILITY_PUBLIC
    ]
);

// Retrieve a file
$file = $disk->get('test.png');

// Get a temporary url for 1 hour
$disk->temporaryUrl('test.png', time() + 3600);

// Get a temporary url for 1 hour with other options
// see other option: https://googlecloudplatform.github.io/google-cloud-php/#/docs/google-cloud/v0.45.1/storage/storageobject?method=signedUrl
$disk->temporaryUrl('test.pdf', time() + 3600, ['saveAsName' => 'file.png']);
```

# License
MIT
