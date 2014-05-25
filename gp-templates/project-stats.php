<?php
	function render_nested_list($proj){
		$lessthan25 = ($proj->touched_count < $proj->original_count * 0.25);
		$morethan80 = ($proj->touched_count > $proj->original_count * 0.8);
		$statusstyle = $lessthan25 ? ' style="background-color: #FFAAAA;"' : ($morethan80 ? ' style="background-color: #AAFFAA"' : '');
		echo '<li>';
		gp_link_project( $proj, esc_html($proj->name));
		echo ': <span'.$statusstyle.'>'.$proj->touched_count.' / '.$proj->original_count.' ('.$proj->percent_status.')</span>';
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
<p>Overall translation status: <?php echo $s_touched_count.' / '.$s_original_count.' ('.$s_percent_status.')'; ?></p>
<ul>
<?php render_nested_list($project); ?>
</ul>

<?php gp_tmpl_footer(); ?>
