Rebuild K2 Image Cache
===

A command-line (terminal) utility to rebuild the image cache of K2 (https://getk2.org).

Depending on the number of K2 items with images, this process can take some time to finish up. For example, converting around 50,000 images on an average VPS server may take up to 30 hours to finish, while the site is being served.

How to use:
- Place this file at the root folder of your Joomla site (where the configuration.php file exists)
- Adjust the image sizes to convert to; use a size of 0 if you DO NOT want to process a specific image size
- Set a range (optional)
- Execute via terminal with "php -f rebuild.php" (the process overwrites existing files without notice!)


### ADDITIONAL INFO
Current version is 1.2, updated on June 11th, 2019.

It is compatible with all K2 versions in the 2.x series.

This script is not Joomla dependent so it will work on any Joomla release that has K2 installed (from 1.5 to 3.x at the time of writing).


### CREDITS
Originally written by [Robert Deutz](https://github.com/rdeutz) and published here: https://github.com/rdeutz/rebuildK2imageCache

Forked in Oct 2018 by JoomlaWorks with fixes to make the utility work in newer K2 versions (v2.8.0+). JoomlaWorks will further upgrade the utility (in upcoming releases) and eventually build the script as a Joomla system plugin so it's not required to be executed via terminal and to allow for the utility to execute on demand and not in batch if required.
