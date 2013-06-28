<?php
/**
 * How to use:
 *
 * 1) Copy this file as rebuild.php into "JPATH_ROOT/media/k2/items"
 * 2) Check Variabels, use a size of 0 for not processing this image size
 * 3) run it "php -f rebuild.php"
 *
 * @author Robert Deutz <rdeutz@googlemail.com>
 */

// Variabels
$sizeG  = 300;
$sizeL  = 655;
$sizeM  = 325;
$sizeS  = 200;
$sizeXL = 900;
$sizeXS = 100;
$jpeg_quality = 70;

/**
 * DO NOT CHANGE ANYTHING AFTER THIS LINE IF YOU DON'T KNOW WHAT YOU ARE DOING!
 */

$uploadclassfile = dirname(__FILE__).'/../../../administrator/components/com_k2/lib/class.upload.php';

if(!file_exists($uploadclassfile))
{
  echo "Can't find class.upload.php! Is K2 installed? Do you copied rebuild.php to the right directroy?";
}

define('_JEXEC',1);
require_once ($uploadclassfile);

// dirs
$sourcedir = dirname(__FILE__).'/src';
$targetdir = dirname(__FILE__).'/cache';

$sizes = array('G' => $sizeG,'L' => $sizeL,'M' => $sizeM,'S' => $sizeS,'XL' => $sizeXL,'XS' => $sizeXS);

if ($fhandle = opendir($sourcedir)) {
    while (false !== ($entry = readdir($fhandle)))
    {
    	$file = $sourcedir.'/'.$entry;
    	if (is_file($file))
    	{
			echo '.';
			$r = buildImages($file, $targetdir, $sizes, $jpeg_quality);
			if ($r === true)
			{
				echo "File: ".$entry . " SUCCESSFUL\n";
			}
			else
			{
				echo "File: ".$entry . " FAIL\n";
				echo "Details:\n";
				foreach($sizes AS $key => $value)
				{
					$result = 'Success';
					if (array_key_exists($key, $r))
					{
						$result = 'Failed';
					}
					echo "Size $key ($value px): ".$result."\n";
				}
			}
    	}

    }
    closedir($fhandle);
}

function buildImages($sourcefile, $targetdir, $sizes, $jpeg_quality=70)
{
	$resultsummery = true;
	foreach($sizes AS $key => $value)
	{
		if ($value != 0)
		{
			$filename = basename($sourcefile,'.jpg');
			$targetfile = $targetdir.'/'.$filename.'_'.$key.'.jpg';
			if (buildImage($sourcefile, $targetfile, $value) !== true)
			{
				// Successful
				$resultdetails[$key] = true;
			}
			else
			{
				// Failed
				$resultsummery = false;
				$resultdetails[$key] = false;
			}
		}
	}

	return $resultsummery ? true : $resultdetails;
}

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
	$handle->file_new_name_body = basename($targetfile,'.jpg');
	$handle->image_x = (int) $size;
	return $handle->Process($savepath);
}
