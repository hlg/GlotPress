<?php
	function render_nested_list($proj){
		echo '<li>';
		gp_link_project( $proj, esc_html($proj->name));
                $translated_count = $proj->touched_count - $proj->current_count;
                $untouched_count = $proj->original_count - $proj->touched_count;
                echo ': '.$proj->current_count.'/'.$translated_count.'/'.$untouched_count;
                echo '<span style="position:relative; display: inline-block; height: 1em; width:'.($proj->original_count*2).'px; border: 1px solid black; vertical-align: text-bottom; background-color:#FF0000; margin-left: 5px;">';
                echo '<div style="position: absolute; height: 100%; width: '.($proj->current_count*2).'px; background-color:#00FF00"></div>';
                echo '<div style="position: absolute; height: 100%; left: '.($proj->current_count*2).'px; width: '.($translated_count*2).'px; background-color:#FFFF00"></div>';
                echo '</span>';

		if(!empty($proj->subprojects)){
			echo PHP_EOL, '<ul>', PHP_EOL;
			foreach($proj->subprojects as $p){ render_nested_list($p); }
			echo '</ul>', PHP_EOL;
		}
		echo '</li>', PHP_EOL;
	}

gp_title( sprintf( __('%s &lt; GlotPress'), esc_html( $project->name ) ) );
gp_breadcrumb_project( $project );
gp_tmpl_header(); 

?>
<h2><?php echo esc_html( $project->name ); ?></h2>
<h3>Statistics for <?php echo $full_locale_name; ?></h3>
<div>Overall translation status: <?php echo $s_current_count.' ('.$s_percent_current.') / '.($s_touched_count-$s_current_count).' ('.$s_percent_status.') / '.($s_original_count-$s_touched_count); ?>
<span style="position:relative; display: inline-block; height: 1em; border: 1px solid black; vertical-align: text-bottom; background-color:#FF0000; margin-left:5px; width:200px">
<?php $s_current_width=$s_current_count*200/$s_original_count ?>
<?php $s_translated_width=($s_touched_count-$s_current_count)*200/$s_original_count ?>
<?php echo '<div style="position: absolute; height: 100%; background-color: #00FF00; width: '.$s_current_width.'px"></div>' ?>
<?php echo '<div style="position: absolute; height: 100%; background-color: #FFFF00; left: '.$s_current_width.'px; width: '.$s_translated_width.'px"></div>' ?>
</span>
</div>
<ul>
<?php render_nested_list($project); ?>
</ul>

<?php gp_tmpl_footer(); ?>
