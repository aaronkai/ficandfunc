<?php get_header(); ?>

<div id="main-container">
   
    
    <?php 
        // Start the loop
        if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    ?>
    
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header>
               
            </header>
            <?php
                // The content
                the_content();
                
                // If singular and comments are open
                if ( is_singular() && comments_open() )
                comments_template( '', true );
            ?>
        </article>
        
    <?php 
        // Loop ends
        endwhile; 
        // Nothing in the loop?
        else : 
    ?>
    
        <article id="post-0" class="post no-results not-found">
            <header>
                <h2 class="entry-title">Nothing Found</h2>
            </header>
            <p>We're sorry, but we couldn't find anything for your. Please try and search for whatever it was you were looking for.</p>
            <?php get_search_form(); ?>
        </article>
        
    <?php 
        // And we're done
        endif; 
    ?>
        
    </div> <!-- #main-container ends -->
    
<?php get_sidebar(); ?>
<?php get_footer(); ?>

</div><!--end content-container-inner-->

