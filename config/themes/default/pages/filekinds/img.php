<?php /* Should the image be inlined or just show download info? */

$max_size = Subfolio::get_setting('display_max_filesize');
$size = Subfolio::current_file('rawsize');
#$retina_url = Subfolio::current_file('retina');
$is_retina = Subfolio::current_file('is_retina');
$has_shadow = Subfolio::current_file('has_shadow');
$has_browser = Subfolio::current_file('has_browser');
$shadow_style = Kohana::config('filebrowser.shadow_style_css');

if ($size > ($max_size * 1024 * 1024)) {
  require("_download_box.php");
} else { ?>

  <?php
  if ($has_shadow) {
    echo '<div class="detailIMG__wrapper" style="box-shadow:' . $shadow_style . ';">';
  } elseif ($has_browser) {
    echo '<div class="detailIMG__wrapper detailIMG__wrapper--browser" style="box-shadow:' . $shadow_style . ';">';
  } ?>

  <?php if($is_retina) { ?>
	  <img
	  	width="<?php echo Subfolio::current_file('width')/2 ?>"
	  	height="<?php echo Subfolio::current_file('height')/2 ?>"
	  	src="<?php echo Subfolio::current_file('url') ?>"
	  	class="detailIMG"
	  	data-behavior="toggle_img"
	  />
  <?php } else { ?>
	  <img
	  	width="<?php echo Subfolio::current_file('width') ?>"
	  	height="<?php echo Subfolio::current_file('height') ?>"
	  	src="<?php echo Subfolio::current_file('url') ?>"
	  	class="detailIMG"
	  	data-behavior="toggle_img"
	  />
  <?php } ?>

  <?php if ($has_shadow || $has_browser) { echo '</div>'; } ?>

  <?php if (SubfolioTheme::get_option('display_info')) { require("_hideable_download_box.php"); } ?>
<?php } ?>