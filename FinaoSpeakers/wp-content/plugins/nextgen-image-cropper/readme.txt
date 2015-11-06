=== NextGEN Image Cropper ===
Contributors: Mitch McCoy
Donate link: http://tinyurl.com/6oc6mt5
Tags: photos,images,gallery,media,admin,photo-albums,pictures,photo,picture,image,nextgen-gallery,nextgen gallery,cropping,crop
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: 1.2

NextGEN Image Cropper extends the NextGen Gallery plugin to allow cropping of images.

== Description ==

NextGEN Image Cropper uses the jQuery jCrop plugin(included) to allow a user to crop an image within a NextGen gallery.
Using NextGen Gallery libraries, a backup of the original image is made and the image is cropped based on selected dimensions and saved.
The NextGen image meta data is also updated with the new image dimensions.

== Installation ==

Requires jQuery 1.7 (or higher)

Requires NextGen Gallery plugin (1.8.4 or higher)

1.  After activating, select Manage Gallery under the NextGen Gallery menu.
2.  Select your gallery to display the image list.
3.  Each image now has a Crop link.

You will also see a new menu item called Image Cropping where you can set the default cropping dimensions and maximum image display size which is helpful for scaling large images.

== Frequently Asked Questions ==

Q:  How could I automatically set the cropping dimensions based on my theme (for a homepage slideshow for instance)?

A:  The plugin options are stored as a site option array called 'ngg_crop'.  You can set the cropping dimensions by adding these lines to your functions.php file in your theme directory.


     // Set the dimensions of the Home Page slideshow
     $ngg_crop = array();
     $ngg_crop['crop_width'] 	=	400;
     $ngg_crop['crop_height']	=	400;
     $ngg_crop['imagesize']	=	500;
     
     update_option('ngg_crop', $ngg_crop); 

== Screenshots ==

1.  Select the area you wish to crop.
2.  View the new image with a confirmation message.

== Changelog ==

= 1.2 - 02.26.2013 =
* Fixed: Crop link missing when using foreign language

= 1.1 - 02.26.2013 =
* Fixed: Crop form action url (Removed $_SERVER['REDIRECT_URL'])
* Changed: Converted all jQuery events to .on  (requires jQuery 1.7)
* NEW: Added link to edit thumbnail after cropping image

= 1.0 - 12.25.2011 =
* Initial revision

