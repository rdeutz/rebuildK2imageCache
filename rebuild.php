<?php
/**
 * How to use:
 *
 * 1) Place this file into the root folder of your Joomla site (where your configuration.php file exists)
 * 2) Adjust the variables section below; use a size of 0 if you DO NOT want to process a specific image size
 * 3) Execute via terminal with "php -f rebuild.php" (it overwrites existing files without notice!)
 *
 * @version  1.0
 * @author   Robert Deutz <rdeutz@googlemail.com>
 *
 * @version  1.2
 * @author   JoomlaWorks Ltd.
 * @date     June 11th, 2019
 * @TODO     Implement as Joomla system plugin
 *
 */

// Variables
$sizeXS = 80;
$sizeS  = 160;
$sizeM  = 320;
$sizeL  = 640;
$sizeXL = 900;
$sizeG  = 280;
$jpeg_quality = 80;



/**
 * DO NOT CHANGE ANYTHING AFTER THIS LINE IF YOU DON'T KNOW WHAT YOU ARE DOING!
 */

// Load class.upload.php
$uploadclassfile = '';
$oldUploadClassLocation = dirname(__FILE__).'/administrator/components/com_k2/lib/class.upload.php';
$newUploadClassLocation = dirname(__FILE__).'/media/k2/assets/vendors/verot/class.upload.php/src/class.upload.php';

if (file_exists($oldUploadClassLocation) && is_readable($oldUploadClassLocation)) {
    $uploadclassfile = $oldUploadClassLocation;
}

if (file_exists($newUploadClassLocation) && is_readable($newUploadClassLocation)) {
    $uploadclassfile = $newUploadClassLocation;
}

if (!$uploadclassfile) {
    echo "Can't find class.upload.php! Is K2 installed? Did you copy rebuild.php to the root folder of your Joomla site?";
    exit;
}

define('_JEXEC', 1);
require_once($uploadclassfile);

// Helper functions
function buildImage($sourcefile, $targetfile, $size, $jpeg_quality=70)
{
    $handle = new Upload($sourcefile);
    $savepath = dirname($targetfile);
    $handle->image_resize = true;
    $handle->image_ratio_y = true;
    $handle->image_convert = 'jpg';
    $handle->jpeg_quality = $jpeg_quality;
    $handle->file_auto_rename = false;
    $handle->file_overwrite = true;
    $handle->file_new_name_body = basename($targetfile, '.jpg');
    $handle->image_x = (int) $size;
    return $handle->Process($savepath);
}

function buildImages($sourcefile, $targetdir, $sizes, $jpeg_quality=80)
{
    $resultsummery = true;
    foreach ($sizes as $key => $value) {
        if ($value != 0) {
            $filename = basename($sourcefile, '.jpg');
            $targetfile = $targetdir.'/'.$filename.'_'.$key.'.jpg';
            if (buildImage($sourcefile, $targetfile, $value) !== true) {
                // Successful
                $resultdetails[$key] = true;
            } else {
                // Failed
                $resultsummery = false;
                $resultdetails[$key] = false;
            }
        }
    }

    return $resultsummery ? true : $resultdetails;
}

// Set directories and image sizes
$sourcedir = dirname(__FILE__).'/media/k2/items/src';
$targetdir = dirname(__FILE__).'/media/k2/items/cache';

$sizes = array(
    'XS'      => $sizeXS,
    'S'       => $sizeS,
    'M'       => $sizeM,
    'L'       => $sizeL,
    'XL'      => $sizeXL,
    'Generic' => $sizeG
);

// Convert the images
if ($fhandle = opendir($sourcedir)) {
    while (false !== ($entry = readdir($fhandle))) {
        $file = $sourcedir.'/'.$entry;
        if (is_file($file)) {
            echo '.';
            $r = buildImages($file, $targetdir, $sizes, $jpeg_quality);
            if ($r === true) {
                echo "File: ".$entry . " SUCCESSFUL\n";
            } else {
                echo "File: ".$entry . " FAIL\n";
                echo "Details:\n";
                foreach ($sizes as $key => $value) {
                    $result = 'Success';
                    if (array_key_exists($key, $r)) {
                        $result = 'Failed';
                    }
                    echo "Size $key ($value px): ".$result."\n";
                }
            }
        }
    }
    closedir($fhandle);
}
