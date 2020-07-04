<?php
/*
 * - Create symbolic link
 *      php artisan storage:link
 * - Permission file/dir
 * - Cache file S3 -> performance CachedAdapter flysystem-cached-adapter
 */
?>
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class FileUploadController extends BaseController
{
    private const FILE_PATH = 'images/file_abc.txt';

    public function localTest()
    {
        phpinfo();
    }

    public function localBasic()
    {
        // Get file path
        $file = asset(self::FILE_PATH);
        dump($file);

        // Create a file with content in `hinh_anh/file_abc.txt`
        // `images`: link
        // `private`: permission => xem config/filesystems.php disks > local > permission > file > private
        Storage::disk('local')->put(self::FILE_PATH, 'Noi dung o day', 'private');
        //Storage::setVisibility('images/file_abc.txt', 'private');

        // Get visibility
        $visibility = Storage::getVisibility(self::FILE_PATH);
        dump($visibility);

        //Get file url:
        $url = Storage::url(self::FILE_PATH);
        dump($url);

        // Get file size:
        $size= Storage::size(self::FILE_PATH);
        dump($size);

        // Get last modified
        $lastModified = Storage::lastModified(self::FILE_PATH);
        dump($lastModified);

        // Prepend
        Storage::prepend(self::FILE_PATH, 'truoc ');

        // Append
        Storage::append(self::FILE_PATH, ' sau');

//        Storage::copy(self::FILE_PATH, 'abc/result_copy.txt');
//        Storage::move(self::FILE_PATH, 'abc/result_move.txt');
    }

    public function getLocalFile()
    {
        // Check the file exists
        $fileExsts = Storage::disk('local')->exists(self::FILE_PATH);
        dump($fileExsts);

        // Get content file
        $file = Storage::get(self::FILE_PATH);
        dump($file);

        // Check file is missing
        $missing1 = Storage::disk('local')->missing('abc.txt');
        $missing2 = Storage::disk('local')->missing(self::FILE_PATH);
        dump($missing1, $missing2);
    }

    public function downloadLocalFile()
    {
        $headers = [];

        return Storage::download(self::FILE_PATH, 'new_name_file_download.txt', $headers);
    }

    // Work only without local disk
    public function setTempUrl1Minute()
    {
        // Set temp url in 1 minute
        $urlTmp = Storage::temporaryUrl(self::FILE_PATH, now()->addMinutes(1));
        dump($urlTmp);
    }

    public function uploadLocalFile()
    {
        return view('upload_file_local.index');
    }

    public function uploadLocalFilePost(Request $request)
    {
        // Set max size:
        /*
         * phpinfo();
         * /etc/php/7.xx/cli/php.ini
         * post_max_size=15M
         * upload_max_filesize=15M
         *
         *
         */
        $result = $request->file('hinh')->store('images');
        dd($result);
    }
}
