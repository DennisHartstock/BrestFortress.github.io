<?php

global $options;

foreach ($options as $value) {

    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }

}

?>

<div class="clearer">&nbsp;</div>

</div>

<div id="foot"><div id="foot_inner">

<div class="about">

<h2><?php if ($bol_about_title) { echo $bol_about_title; } else { echo "О сайте"; } ?></h2>

<p><?php if ($bol_image_url) { echo "<img src=\"$bol_image_url\" alt=\"\">"; } ?><?php if ($bol_about_message) { echo $bol_about_message; } else { echo "Этот текст можно отредактировать в настройках темы. Дизайн от DemusDesign. Дизайнер не коммунист. Он просто считает, что у в этом есть эстетика, восхитительный винтажный стиль."; } ?></p>

</div>



<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer") ) : ?>

<ul>

	<li><h2>Архивы</h2></li>

	<?php wp_get_archives('limit=4'); ?>

</ul>

<ul>

	<li><h2>Недавно</h2></li>

	<?php wp_get_archives('type=postbypost&limit=4'); ?>

</ul>

<?php endif; ?>



<div class="clearer">&nbsp;</div>

<p class="credit">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> | <a href="http://wp-templates.ru/">Wordpress шаблоны</a>. <?php if ( (is_home())&&!(is_paged()) ){ ?><?php }else{ ?><?php } ?></p>



</div>

</div>

<?php wp_footer(); ?>

</body>

</html>