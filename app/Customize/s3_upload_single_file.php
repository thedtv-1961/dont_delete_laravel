<?php
// require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

if (isset($_FILES['hinh'])) {
    $fileName = uniqid() .'_'. strtotime('now') .'_'.  $_FILES['hinh']['name'];
    $tempFileLocation = $_FILES['hinh']['tmp_name'];

    $s3Client = createS3Client();
    // https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-s3-2006-03-01.html#putobject
    // https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-s3-2006-03-01.html#putobject
    $resultUpload = $s3Client->putObject([
        'ACL' => 'public-read',
        'Bucket' => config('customize.MY_S3_BUCKET'),
        'Key' => strtolower($fileName),
        'Body' => $tempFileLocation,
    ]);
    dump($resultUpload);
}

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

?>

<form action="<?php echo route('file_upload_s3.upload_single_file_post') ?>" method="post"
      enctype="multipart/form-data">
    <?php echo csrf_field() ?>
    <input type="file" name="hinh">
    <input type="submit" value="Upload">
</form>
