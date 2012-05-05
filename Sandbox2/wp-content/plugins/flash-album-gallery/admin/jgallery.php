<?php global $wpdb, $post;
$flag_options = get_option ('flag_options');
$siteurl = get_option ('siteurl');
$isCrawler = flagGetUserNow($_SERVER['HTTP_USER_AGENT']); // check if is a crowler
extract($altColors);
?>
<?php $bg = ($wmode == 'window')? '#'.$Background : 'transparent'; ?>
<style type="text/css">
<?php if(!$isCrawler) { ?>@import url("<?php echo FLAG_URLPATH; ?>admin/css/flagallery_nocrawler.css");<?php } ?>
@import url("<?php echo FLAG_URLPATH; ?>admin/css/flagallery_noflash.css");
<?php if($isCrawler) { ?>
.flag_alternate .flagCatMeta h4 { padding: 4px 10px; margin: 7px 0; border: none; font: 14px Tahoma; text-decoration: none; background:#292929 none; color: #ffffff; }
.flag_alternate .flagCatMeta p { font-size: 12px; }
<?php } ?>
<?php if($BarsBG) {
	$bgBar = ($wmode == 'window')? '#'.$BarsBG : 'transparent';
	if(!$isCrawler){
?>
#fancybox-title-over .title { color: #<?php echo $TitleColor; ?>; }
#fancybox-title-over .descr { color: #<?php echo $DescrColor; ?>; }
.flag_alternate .flagcatlinks { background-color: #<?php echo $BarsBG; ?>; }
.flag_alternate .flagcatlinks a.flagcat { border-color: #<?php echo $CatColor; ?>; color: #<?php echo $CatColor; ?>; background-color: #<?php echo $CatBGColor; ?>; }
.flag_alternate .flagcatlinks a.flagcat:hover { border-color: #<?php echo $CatColor; ?>; }
.flag_alternate .flagcatlinks a.active, .flag_alternate .flagcatlinks a.flagcat:hover { color: #<?php echo $CatColorOver; ?>; background-color: #<?php echo $CatBGColorOver; ?>; }
	<?php } ?>
.flag_alternate .flagcategory a.flag_pic_alt { background-color: #<?php echo $ThumbBG; ?>; border: 2px solid #<?php echo $ThumbBG; ?>; color: #<?php echo $ThumbBG; ?>; }
.flag_alternate .flagcategory a.flag_pic_alt:hover { background-color: #<?php echo $ThumbBG; ?>; border: 2px solid #<?php echo $ThumbLoaderColor; ?>; color: #<?php echo $ThumbLoaderColor; ?>; }
.flag_alternate .flagcategory a.flag_pic_alt.current, .flag_alternate .flagcategory a.flag_pic_alt.last { border-color: #<?php echo $ThumbLoaderColor; ?>; }
<?php }; ?>
<?php if($altColors['FullWindow'] && !$isCrawler){ ?>
.flag_alternate a.backlink { float: right; display: block; padding: 2px 5px; border: 1px solid #000; border-radius: 1px; background: #000; color: #fff; text-decoration: none; outline: none; font-size: 12px; font-family: Verdana; font-weight: bold; }
.flag_alternate a.backlink:hover { text-decoration: underline; }
<?php } ?>
</style>
<?php if(!$isCrawler){
	if(!$flag_options['jAlterGalScript']) { ?>
	<script type="text/javascript">var ExtendVar='fancybox', hitajax = '<?php echo plugins_url("/lib/hitcounter.php", dirname(__FILE__)); ?>';</script>
	<?php } else if($flag_options['jAlterGalScript'] == 1) { ?>
	<style type="text/css">@import url("<?php echo plugins_url('/admin/js/photoswipe/photoswipe.css', dirname(__FILE__)); ?>");</style>
	<script type="text/javascript" src="<?php echo plugins_url('/admin/js/photoswipe/klass.min.js', dirname(__FILE__)); ?>"></script>
	<script type="text/javascript" src="<?php echo plugins_url('/admin/js/photoswipe/code.photoswipe.jquery-3.0.4.min.js', dirname(__FILE__)); ?>"></script>
	<script type="text/javascript">var ExtendVar='photoswipe';</script>
<?php }
 } ?>
<div id="<?php echo $skinID; ?>_jq" class="flag_alternate">
		<div class="flagcatlinks"><?php
			if($altColors['FullWindow'] && !$isCrawler){
				$flag_custom = get_post_custom($post->ID);
				$backlink = $flag_custom["mb_button_link"][0];
				if(!$backlink || $backlink == 'http://'){ $backlink = $_SERVER["HTTP_REFERER"]; }
				if($backlink){
					echo '<a class="backlink" href="'.$backlink.'">'.$flag_custom["mb_button"][0].'</a>';
				}
			}
		?></div>
<?php
$gID = explode( '_', $galleryID ); // get the gallery id
if ( is_user_logged_in() ) $exclude_clause = '';
else $exclude_clause = ' AND exclude<>1 ';
foreach ( $gID as $galID ) {
	$galID = (int) $galID;
	if ( $galID == 0) {
		$thepictures = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->flaggallery AS t INNER JOIN $wpdb->flagpictures AS tt ON t.gid = tt.galleryid WHERE 1=1 {$exclude_clause} ORDER BY tt.{$flag_options['galSort']} {$flag_options['galSortDir']} ");
	} else {
		$thepictures = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->flaggallery AS t INNER JOIN $wpdb->flagpictures AS tt ON t.gid = tt.galleryid WHERE t.gid = '{$galID}' {$exclude_clause} ORDER BY tt.{$flag_options['galSort']} {$flag_options['galSortDir']} ");
	}
	$captions = '';
?>
	<?php if (is_array ($thepictures) && count($thepictures)){ ?>
		<div class="flagCatMeta">
			<h4><?php echo stripslashes($thepictures[0]->title);?></h4>
			<p><?php echo htmlspecialchars_decode(stripslashes($thepictures[0]->galdesc));?></p>
		</div>
		<div class="flagcategory" id="gid_<?php echo $galID.'_'.$skinID; ?>">
			<?php $n = count($thepictures);
				$var = floor($n/5);
				if($var==0 || $var > 4) $var=4;
				$split = ceil($n/$var);
				$j=0;
		if ($isCrawler){
			foreach ($thepictures as $picture) { ?><a style="display:block; overflow: hidden; height: auto; width: auto; margin-bottom: 10px; background-color: #eeeeee; background-position: 22px 44px; text-align: left;" class="i<?php echo $j++; ?> flag_pic_alt" href="<?php echo $siteurl.'/'.$picture->path.'/'.$picture->filename; ?>" id="flag_pic_<?php echo $picture->pid; ?>" rel="gid_<?php echo $galID.'_'.$skinID; ?>"><img style="float:left; margin-right: 10px;" title="<?php echo strip_tags(stripslashes($picture->alttext)); ?>" alt="<?php echo strip_tags(stripslashes($picture->alttext)); ?>" src="<?php echo $siteurl.'/'.$picture->path.'/thumbs/thumbs_'.$picture->filename; ?>" width="115" height="100" /><span style="display: block; overflow: hidden; text-decoration: none; color: #000; font-weight: normal;" class="flag_pic_desc" id="flag_desc_<?php echo $picture->pid; ?>"><strong><?php echo strip_tags(stripslashes($picture->alttext)); ?></strong><br /><?php echo strip_tags(stripslashes($picture->description),'<b><u><i><span>'); ?></span></a><?php
			}
		} else {
			foreach ($thepictures as $picture) { ?><a class="i<?php echo $j++; ?> flag_pic_alt" href="<?php echo $siteurl.'/'.$picture->path.'/'.$picture->filename; ?>" id="flag_pic_<?php echo $picture->pid; ?>" rel="gid_<?php echo $galID.'_'.$skinID; ?>" title="<?php echo strip_tags(stripslashes($picture->alttext)); ?>">[img src=<?php echo $siteurl.'/'.$picture->path.'/thumbs/thumbs_'.$picture->filename; ?>]<span class="flag_pic_desc" id="flag_desc_<?php echo $picture->pid; ?>"><strong><?php echo htmlspecialchars(stripslashes($picture->alttext)); ?></strong><br /><span><?php echo htmlspecialchars(stripslashes($picture->description)); ?></span></span></a><?php
			}
		} ?>
		</div>
	<?php } ?>
<?php } ?>
</div>
