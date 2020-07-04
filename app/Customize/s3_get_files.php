<?php
// require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

function createS3Client()
{
    // https://docs.aws.amazon.com/general/latest/gr/rande.html
    // https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_configuration.html
    $sharedConfig = [
        //        'profile' => 'default',
        'region' => config('customize.MY_S3_DEFAULT_REGION'),
        'version' => 'latest',
        'credentials' => [ // if you don't provide this, aws sdk will auto load from env file
            'key' => config('customize.MY_S3_ACCESS_KEY_ID'),
            'secret' => config('customize.MY_S3_SECRET_ACCESS_KEY'),
        ],
    ];
    $sdk = new \Aws\Sdk($sharedConfig);
    $s3Client = $sdk->createS3();

    return $s3Client;
}


$s3Client = createS3Client();
$result = $s3Client->getObject([
    'Bucket' => config('customize.MY_S3_BUCKET'),
    'Key' => 'doraemon.jpg',
]);
$image = $result->getIterator()['@metadata']['effectiveUri'];
?>

<img src="<?php echo $image ?>" alt="">
