=== Gallery ===
Contributors: bestwebsoft
Donate link: https://www.2checkout.com/checkout/purchase?sid=1430388&quantity=10&product_id=13
Tags: gallery, image, gallery image, album, foto, fotoalbum, website gallery, multiple pictures, pictures, photo, photoalbum, photogallery
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: 3.03

This plugin allows you to implement gallery page into your web site.

== Description ==

This plugin makes it possible to implement as many galleries as you want into your website. You can add multiple pictures and description for each gallery, show them all at one page, view each one separately. Moreover, it's possible to upload HQ pictures.

<a href="http://wordpress.org/extend/plugins/gallery-plugin/faq/" target="_blank">FAQ</a>
<a href="http://bestwebsoft.com/plugin/gallery-plugin/" target="_blank">Support</a>

= Features =

* Actions: Create any quantity of the albums in gallery.
* Description: Add description to each album.
* Actions: Possibility to set featured image as cover of the album.
* Actions: Possibility to load any number of photos to each album in the gallery.
* Caption: Add caption to each photo in the album.
* Display: You can select dimensions of the thumbnails for the cover of the album as well as for photos in the album.
* Display: A possibility to select a number of the photos for the separate page of album of the gallery which will be placed in one line.
* Slideshow: User can review all photos in album in full size and in slideshow.

= Translation =

* Czech (cs_CZ) (thanks to Josef Sukdol)
* Dutch (nl_NL) (thanks to <a href="ronald@hostingu.nl">HostingU, Ronald Verheul</a>)
* French (fr_FR) (thanks to Didier)
* Georgian (ka_GE) (thanks to Vako Patashuri)
* German (de_DE) (thanks to Thomas Bludau)
* Hungarian (hu_HU) (thanks to Mészöly Gábor) 
* Italian (it_IT) (thanks to Stefano Ferruggiara)
* Polish (pl_PL) (thanks to Janusz Janczy, Bezcennyczas.pl)
* Russian (ru_RU)
* Ukrainian (uk_UA)(thanks to Ted Mosby)

If you create your own language pack or update an existing one, you can send <a href="http://codex.wordpress.org/Translating_WordPress" target="_blank">the text in PO and MO files</a> for <a href="http://bestwebsoft.com/" target="_blank">BWS</a> and we'll add it to the plugin. You can download the latest version of the program for work with PO and MO files  <a href="http://www.poedit.net/download.php" target="_blank">Poedit</a>.

= Technical support =

Dear users, if you have any questions or propositions regarding our plugins (current options, new options, current issues) please feel free to contact us. Please note that we accept requests in English only. All messages on another languages wouldn't be accepted. 

== Installation ==

1. Upload `Gallery` folder to the directory `/wp-content/plugins/`.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Please check if you have the `gallery-template.php` template file as well as `gallery-single-template.php` template file in your templates directory. If you are not able to find these files, then just copy it from `/wp-content/plugins/gallery/template/` directory to your templates directory.

== Frequently Asked Questions ==

= I cannot view my Gallery page =

1. First of all, you need to create your first Gallery page and choose 'Gallery' from the list of available templates (which will be used for displaying our gallery).
2. If you cannot find 'Gallery' in the list of available templates, then just copy it from `/wp-content/plugins/gallery-plugin/template/` directory to your templates directory.

= How to use plugin? =

1. Choose 'Add New' from the 'Galleries' menu and fill out your page.
2. Upload pictures by using an uploader in the bottom of the page. 
3. Save the page.

= How to add an image? =

- Choose the necessary gallery from the list on the Galleries page in admin section (or create a new gallery - choose 'Add New' from the 'Galleries' menu). 
- Use the option 'Upload a file' available in the uploader, choose the necessary pictures and click 'Open'
- The files uploading process will start.
- Once all pictures are uploaded, please save the page.
- If you see the message 'Please enable JavaScript to use the file uploader.', you should enable JavaScript in your browser.

= How to add many image? =

The multiple files upload is supported by all modern browsers except Internet Explorer. 

== Screenshots ==

1. Gallery Admin page.
2. Galleries albums page on frontend.
3. Gallery Options page in admin panel.
4. Single gallery page.
5. PrettyPhoto pop-up window with images from the album.

== Changelog ==

= V3.03 - 19.04.2012 =
* Bugfix : The bug related with the upload of the photos on the multisite network was fixed.

= V3.02 - 12.04.2012 =
* Bugfix : The bug related with the display of the photo on the single page of the gallery was fixed.

= V3.01 - 12.04.2012 =
* NEW : Czech, Hungarian and German language files are added to the plugin.
* NEW : Possibility to set featured image as cover of the album.
* Change: Replace prettyPhoto library to fancybox library.
* Change: Code that is used to display a lightbox for images in `gallery-single-template.php` template file is changed.

= V2.12 - 27.03.2012 =
* NEW : Italian language files are added to the plugin.

= V2.11 - 26.03.2012 =
* Bugfix : The bug related with the indication of the menu item on the single page of the gallery was fixed.

= V2.10 - 20.03.2012 =
* NEW : Polish language files are added to the plugin.

= V2.09 - 12.03.2012 =
* Changed : BWS plugins section. 

= V2.08 - 24.02.2012 =
* Change : Code that is used to connect styles and scripts is added to the plugin for correct SSL verification.
* Bugfix : The bug with style for image block on admin page was fixed.

= V2.07 - 17.02.2012 =
* NEW : Ukrainian language files are added to the plugin.
* Bugfix : Problem with copying files gallery-single-template.php to theme was fixed.

= V2.06 - 14.02.2012 =
* NEW : Dutch language files are added to the plugin.

= V2.05 - 18.01.2012 =
* NEW : A link to the plugin's settings page is added.
* Change : Revised Georgian language files are added to the plugin.

= V2.04 - 13.01.2012 =
* NEW : French language files are added to the plugin.

= V2.03 - 12.01.2012 =
* Bugfix : Position to display images on a Gallery single page was fixed.

= V2.02 - 11.01.2012 =
* NEW : Georgian language files are added to the plugin.

= V2.01 - 03.01.2012 =
* NEW : Adding of the caption to each photo in the album.
* NEW : A possibility to select the dimensions of the thumbnails for the cover of the album and for photos in album is added.
* NEW : A possibility to select a number of the photos for a separate page of the album in the gallery which will be placed in one line is added.
* Change : PrettyPhoto library was updated up to version 3.1.3.
* Bugfix : Button 'Sluiten' is replaced with a 'Close' button.

= V1.02 - 13.10.2011 =
* noConflict for jQuery is added.  

= V1.01 - 23.09.2011 =
*The file uploader is added to the Galleries page in admin section. 

== Upgrade Notice ==

= V3.03 =
The bug related with the upload of the photos on the multisite network was fixed.

= V3.02 =
The bug related with the display of the photo on the single page of the gallery was fixed.

= V3.01 =
Czech, Hungarian and German language files are added to the plugin. Possibility to set featured image as cover of the album is added. Replace prettyPhoto library to fancybox library. Code that is used to display a lightbox for images in `gallery-single-template.php` template file is changed.

= V2.12 =
Italian language files are added to the plugin.

= V2.11 =
The bug related with the indication of the menu item on the single page of the gallery was fixed.

= V2.10 =
Polish language files are added to the plugin.

= V2.09 - 07.03.2012 =
BWS plugins section has been changed. 

= V2.08 =
Code that is used to connect styles and scripts is added to the plugin for correct SSL verification. The bug with a style for an image block on admin page was fixed.

= V2.07 =
Ukrainian language files are added to the plugin. Problem with copying files gallery-single-template.php to the theme was fixed.

= V2.06 =
Dutch language files are added to the plugin.

= V2.05 =
A link to the plugin's settings page is added. Revised Georgian language files are added to the plugin.

= V2.04 =
French language files are added to the plugin.

= V2.03 =
Position to display images on a single page of the Gallery was fixed. Please upgrade the Gallery plugin. Thank you.

= V2.02 =
Georgian language files are added to the plugin.

= V2.01 =
A possibility to add a caption to each photo of the album is added. A possibility to select dimensions of the thumbnails for the cover of the album and for photos in album is added. A possibility to select a number of the photos for a separate page of the album in the gallery which will be placed in one line is added. PrettyPhoto library was updated. Button 'Sluiten' is replaced with a 'Close' button. Please upgrade the Gallery plugin immediately. Thank you.

= V1.02 =
noConflict for jQuery is added.

= V1.01 =
The file uploader is added to the Galleries page in admin section.