

<aside id="sidebar-container">
    <ul id="sidebar">
    <?php 
        // If the sidebar is empty, output the static content
        if ( !dynamic_sidebar( 'right-column' ) ) : ?>
			<img src="<?php bloginfo('template_directory'); ?>/images/photo_with_shadow.jpg" alt="solar panels" />
			<h3>Can Solar Work For You?</h3>
			<ul>
				<li><a href="">What will my house look like?</a></li>
				<li><a href="">What is clean power?</a></li>
				<li><a href="">Can I save Money?</a></li>
			</ul>
			
			<img id="cash" src="<?php bloginfo('template_directory'); ?>/images/money.jpg" alt="cash" />

    <?php endif; ?>
    </ul>
</aside> <!-- #sidebar-container ends -->
