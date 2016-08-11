<?php

/* Custom Language Switcher */
function thb_language_switcher () {

	if ( function_exists('icl_get_languages')) {
		global $data;
		?>
			<li class="menu-item-has-children">
				<a href="#"><?php
						$languages = icl_get_languages('skip_missing=0');
						if(1 < count($languages)){
							foreach($languages as $l){
								echo esc_attr($l['active'] ? $l['native_name'] : '');
							}
						}
					?> <i class="fa fa-angle-down"></i></a>
				<ul class="sub-menu" id="thb_language_selector">
				<?php
					$languages = icl_get_languages('skip_missing=0');
					if(1 < count($languages)){
						foreach($languages as $l){
							
							if (!$l['active']) {
								echo '<li><a href="'.$l['url'].'">'.$l['native_name'].'</a></li>';
							}
						}
					} else {
						echo '<li>'.esc_html__('Add Languages', 'goodlife').'</li>';	
					}
				?>
				</ul>
			</li>
		<?php 
	}
}
add_action( 'thb_language_switcher', 'thb_language_switcher',3 );
?>