Rebuild K2 Image Cache
===

A command-line (terminal) utility to rebuild the image cache of K2 (a Joomla component).

Depending on the number of K2 items with images, this process can take some time to finish up.

How to use:
1) Place this file into "/media/k2/items/"

2) Adjust the variables section below; use a size of 0 if you DO NOT want to process a specific image size

3) Execute via terminal with "php -f rebuild.php" (it overwrites existing files without notice!)

### CREDITS
Originally written by [Robert Deutz](https://github.com/rdeutz) and published here: https://github.com/rdeutz/rebuildK2imageCache

Forked in Oct 2018 by JoomlaWorks with fixes to make the utility work in newer K2 versions (v2.8.0+). JoomlaWorks will further upgrade the utility (in upcoming releases) as a Joomla system plugin so it's not required to be executed via terminal and to allow for the utility to execute on demand and not in batch.
