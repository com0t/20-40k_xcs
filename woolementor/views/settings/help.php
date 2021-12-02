<?php

$args = [
	'wcd_faq' 		=> __( 'Documentation', 'woolementor' ),
	'wcd_roadmap' 	=> __( 'Roadmap', 'woolementor' ),
	'wcd_changelog' 	=> __( 'Changelog', 'woolementor' ),
	'wcd_ideas' 	=> __( 'Ideas', 'woolementor' ),
	'wcd_support' 	=> __( 'Ask Support', 'woolementor' ),
];
$tab_links = apply_filters( 'wcd_help_tab_link', $args );

echo "<div class='wcd_tab_btns'>";
echo "<ul class='wcd_help_tablinks'>";

$count 	= 0;
foreach ( $tab_links as $id => $tab_link ) {
	$active = $count == 0 ? 'active' : '';
	echo "<li class='wcd_help_tablink {$active}' id='{$id}'>{$tab_link}</li>";
	$count++;
}

echo "</ul>";
echo "</div>";
?>

<div id="wcd_faq_content" class="wcd_tabcontent active">
	 <div class='wrap'>
	 	<div id='woolementor-helps'>
	    <?php

	    $helps = get_option( 'woolementor-docs_json', [] );
		$utm = [ 'utm_source' => 'dashboard', 'utm_medium' => 'settings', 'utm_campaign' => 'faq' ];
	    if( is_array( $helps ) ) :
	    foreach ( $helps as $help ) {
	    	$help_link = add_query_arg( $utm, $help['link'] );
	        ?>
	        <div id='woolementor-help-<?php echo $help['id']; ?>' class='woolementor-help'>
	            <h2 class='woolementor-help-heading' data-target='#woolementor-help-text-<?php echo $help['id']; ?>'>
	                <a href='<?php echo $help_link; ?>' target='_blank'>
	                <span class='dashicons dashicons-admin-links'></span></a>
	                <span class="heading-text"><?php echo $help['title']['rendered']; ?></span>
	            </h2>
	            <div id='woolementor-help-text-<?php echo $help['id']; ?>' class='woolementor-help-text' style='display:none'>
	                <?php echo wpautop( wp_trim_words( $help['content']['rendered'], 55, " <a class='sc-more' href='{$help_link}' target='_blank'>[more..]</a>" ) ); ?>
	            </div>
	        </div>
	        <?php

	    }
	    else:
	        _e( 'Something is wrong! No help found!', 'woolementor' );
	    endif;
	    ?>
	    </div>
	</div>
</div>

<div id="wcd_roadmap_content" class="wcd_tabcontent loopedin-wrap">
	<iframe src="https://app.loopedin.io/wc-designer#/roadmap" height="910" width="100%" frameborder="0"></iframe>
</div>

<div id="wcd_changelog_content" class="wcd_tabcontent loopedin-wrap">
	<iframe src="https://app.loopedin.io/wc-designer#/updates" height="910" width="100%" frameborder="0"></iframe>
</div>

<div id="wcd_ideas_content" class="wcd_tabcontent loopedin-wrap">
	<iframe src="https://app.loopedin.io/wc-designer#/ideas" height="910" width="100%" frameborder="0"></iframe>
</div>

<div id="wcd_support_content" class="wcd_tabcontent">
	<p class="wl-desc"><?php _e( 'Having an issue or got something to say? Feel free to reach out to us! Our award winning support team is always ready to help you.', 'woolementor' ); ?></p>
	<div id="support_btn_div" class="wcd-edf-btns">
		<a href="<?php echo wcd_help_link(); ?>" class="wcd-edf-btn active" target="_blank"><?php _e( 'Submit a Ticket', 'woolementor' ); ?></a>
	</div>
</div>

<?php do_action( 'wcd_help_tab_content' ); ?>