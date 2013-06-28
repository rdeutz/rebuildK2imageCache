rebuildK2imageCache
===================

Rebuilds the image cache directory for the Joomla Component K2

It can take some time to rebuild the image cache, on my MacBook Pro it takes 5 seconds for rebuilding all sizes for one image. 

How to use:

1) Copy this file as rebuild.php into "JPATH_ROOT/media/k2/items"

2) Check Variables, use a size of 0 for not processing this image size

3) run it "php -f rebuild.php" (it overwrites existing files without notice)
