<article id= ”post-<?php the_ID(); ?>” <?php post-class(); ?> >
	<header>
		<h2 class=”entry-title”>
			<a href=”<?php the_permalink(); ?>” title=”<?php the_title_attribute(); rel="bookmark" >
				<?php the_title(); ?>
			</a>
		</h2>
		
		<p class=”entry-meta”>
			Posted on <time datetime=”<?php echo get_the_date(); ?>”><?php the_time(); ?></time> 
			by <?php the_author_link(); ?>
			
			<?php
				//are the comments open? 
				if ( comments_open() ) : ?>
				&bull; <?php comments_popup_link( ‘No comments’, ‘1 comment’, ‘%comments’ ); 
			?>
			
			<?php endif; ?>
		</p>
		</header>
		<?php
			//the content
			the_content();
		?>
</article>
		
