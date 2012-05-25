<div id="footer-box">
	<nav id="bottom-navbar">
		<?php
			//Bottom navigation menu
			wp_nav_menu( array(
				‘theme_location’ => ‘bottom-navigation’ )
			);
		?>
	</nav>

	<div id="wp-footer">
		<p>	
			Copyright &copy; <?php echo date( ‘Y’ ); ?>
			<a href=”<?php echo home_url(); ?>” title=”<?php
				bloginfo( ‘name’ ); ?>”>
					<?php bloginfo ( ‘name’); ?>
			</a>
		</p>
	</div><!--close wp-footer-->

</div><!--#footer-box ends -->
</div><!--#inner-container ends -->
</div><!--#outer-container ends -->

<?php 
	//wrapping up wordpress just before the closing body tag
	wp_footer();
?>

</body>
</html>
