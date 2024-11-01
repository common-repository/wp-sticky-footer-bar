<?php
/*
Plugin Name: Sticky Footer Bar	
Plugin URI: http://www.arwebzone.com
Description: Add a beautiful sticky floating bar at the footer of wordpress site.The bar will contain random post from selected category.
Version: 1.2.4
Author: Ahmad Raza
Author URI: http://arwebzone.com
License: GPL 2
*/
/* plugin is activated */
register_activation_hook(__FILE__,'floating_sticky_bar_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'floating_sticky_bar_remove' );

function floating_sticky_bar_install() {
/* Storing Category */
add_option("floating_sticky_bar_cat", 'uncategorized', '', 'yes');
}
function floating_sticky_bar_remove() {
/* Deletes the category from database */
delete_option('floating_sticky_bar_cat');
}
?>
<?php 
function close_button_script() {  
?> 
<script type='text/javascript'> 
//<![CDATA[ 
var stickyfooter_arr = new Array(); 
var stickyfooter_clear = new Array(); 
function stickyfooterFloat(stickyfooter) { 
stickyfooter_arr[stickyfooter_arr.length] = this; 
var stickyfooterpointer = eval(stickyfooter_arr.length-1); 
this.pagetop = 0; 
this.cmode = (document.compatMode && document.compatMode!="BackCompat") ? document.documentElement : document.body; 
this.stickyfootersrc = document.all? document.all[stickyfooter] : document.getElementById(stickyfooter); 
this.stickyfootersrc.height = this.stickyfootersrc.offsetHeight; 
this.stickyfooterheight = this.cmode.clientHeight; 
this.stickyfooteroffset = stickyfooterGetOffsetY(stickyfooter_arr[stickyfooterpointer]); 
var stickyfooterbar = 'stickyfooter_clear['+stickyfooterpointer+'] = setInterval("stickyfooterFloatInit(stickyfooter_arr['+stickyfooterpointer+'])",1);'; 
stickyfooterbar = stickyfooterbar; 
eval(stickyfooterbar); 
} 
function stickyfooterGetOffsetY(stickyfooter) { 
var mtaTotOffset = parseInt(stickyfooter.stickyfootersrc.offsetTop); 
var parentOffset = stickyfooter.stickyfootersrc.offsetParent; 
while ( parentOffset != null ) { 
stickyfooterTotOffset += parentOffset.offsetTop; 
parentOffset = parentOffset.offsetParent; 
} 
return stickyfooterTotOffset; 
} 
function stickyfooterFloatInit(stickyfooter) { 
stickyfooter.pagetop = stickyfooter.cmode.scrollTop; 
stickyfooter.stickyfootersrc.style.top = stickyfooter.pagetop - stickyfooter.stickyfooteroffset + "px"; 
} 
function closeTopAds() { 
document.getElementById("closestick").style.visibility = "hidden"; 
} 
//]]> 
</script> 
    <?php 
} 
 
add_action('wp_head', 'close_button_script' ); 
 
?>
<?php
    /**
     * Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
     */
    add_action( 'wp_enqueue_scripts', 'prefix_add_my_stylesheet' );

    /**
     * Enqueue plugin style-file
     */
    function prefix_add_my_stylesheet() {
        // Respects SSL, Style.css is relative to the current file
        wp_register_style( 'prefix-style', plugins_url('style.css', __FILE__) );
        wp_enqueue_style( 'prefix-style' );
    }
?>
<?php
if ( is_admin() ){

/*creating admin menu */
add_action('admin_menu', 'floating_sticky_bar_admin_menu');

function floating_sticky_bar_admin_menu() {
add_options_page('Sticky Footer Bar', 'Sticky Footer Bar', 'administrator',
'floating-sticky-bar', 'floating_sticky_bar_html_page');
}
}
?>
<?php
function floating_sticky_bar_html_page() {
?>
<div class='wrap'>

<div id="icon-tools" class="icon32"></div><h2>WP Sticky Footer Bar options</h2><br>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<table class="widefat" width="510">
<tr valign="top">
<th width="92" scope="row">Enter Category Name:</th>
<td width="406">
<input name="floating_sticky_bar_cat" type="text" id="floating_sticky_bar_cat"
value="<?php echo get_option('floating_sticky_bar_cat'); ?>" />
(ex. WordPress)</td>
</tr>
</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="floating_sticky_bar_cat" />

<p><br>
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>

<br>
<p><hr></p>
<br>
<h3>Do You Like this Plugin?</h3><br>
<h3 style="color:green;background-color:yellow;"> Support Us</h3>
<br>
<a href="http://arwebzone.com" target="_blank" class="button-secondary">Visit Author's Website</a>
<br><br />
<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2FArwebzonecom&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=true&amp;font&amp;colorscheme=light&amp;action=like&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe>
<div align=left"><iframe allowtransparency="true" frameborder="0" scrolling="no"
  src="//platform.twitter.com/widgets/follow_button.html?screen_name=arwebzone"
  style="width:300px; height:20px;"></iframe></div>
  <br>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<g:plus href="https://plus.google.com/u/0/102856850064967446296/" rel="author"></g:plus>
<br>
<p style="background-color;grey;">Need Any Help? <a href="http://arwebzone.com/wordpress-sticky-footer-bar-plugin/" target="_blank">Check Plugin Support Thread.</a></p?
<br>
</div>

<?php
}
?>
<?php
/*Getting Random Article From The Category */
 function random_article() { 
query_posts(array(
  'orderby' => 'rand', 
  'category_name'  => get_option( 'floating_sticky_bar_cat' ),
  'posts_per_page' => 1
)); 
if (have_posts()) : while (have_posts()) : the_post(); ?>
 <div id="closestick">
 <div class="fixedbar">
 <div class="floatingbox">
 <ul id="tips">
 <li><a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php the_title(); ?> </a></li><span style='padding:0px; float:right'> 
<img border='0' onClick='closeTopAds();return false;' src='<?php echo plugins_url(); ?>/wp-sticky-footer-bar/images/cancel.png'  style='cursor:hand;cursor:pointer;position:absolute;top:5px;right:5px;'/></span>
 </ul>
 </div>
 </div>
 </div>
<?php endwhile; endif; wp_reset_query(); 
}
add_action('wp_footer', 'random_article');
?>