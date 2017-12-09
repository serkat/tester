<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Tester
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
	<section class="head-image">
		<div class="wrap">

			<div class="row justify-content-between">
			    <div class="col-6 title-block">
			      <?php echo the_field('main_title'); ?>
				  <div class="amount">
					  <?php echo the_field('amount'); ?>
				  </div>
			    </div>
			    <div class="col-5 login-block">
					<?php
  					  echo rcl_get_authorize_form('pageform');
  				  	?>
			    </div>
		  	</div>

		</div>
	</section>
	<section>
		<div class="wrap">
			<div class="row">
				<div class="onetest-block">
					<div class="onetest-inner">
						<div class="onetest-info">
							<p>Стоимость участия</p>
							<span>в любой олимпиаде за 1 тест</span>
						</div>
						<div class="onetest-price">
							<?php echo the_field('onetest'); ?>
							<span>руб.</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="participation">
		<div class="wrap">
            <?php

            $id = 76; // add the ID of the page where the zero is
            $p = get_page($id);
            $t = $p->post_title;
            echo '<h3>'.apply_filters('post_title', $t).'</h3>'; // the title is here wrapped with h3
            echo apply_filters('the_content', $p->post_content);
            ?>
		</div>
	</section>

    <?php
    // Get each of our panels and show the post data.
    if ( 0 !== twentyseventeen_panel_count() || is_customize_preview() ) : // If we have pages to show.

        /**
         * Filter number of front page sections in Twenty Seventeen.
         *
         * @since Twenty Seventeen 1.0
         *
         * @param int $num_sections Number of front page sections.
         */
        $num_sections = apply_filters( 'twentyseventeen_front_page_sections', 4 );
        global $twentyseventeencounter;

        // Create a setting and control for each of the sections available in the theme.
        for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
            $twentyseventeencounter = $i;
            twentyseventeen_front_page_section( null, $i );
        }

    endif; // The if ( 0 !== twentyseventeen_panel_count() ) ends here. ?>

    <section class="all-russia">
        <h3>Работаем по всей России</h3>
        <div class="wrap">
            <div class="school-counter">
                <p>более</p>
                <p class="sch-counter"><?php echo the_field('schools'); ?></p>
                <p>учебных заведений</p>
                <p>уже проводят</p>
                <p>олимпиады с нами</p>
            </div>
        </div>
    </section>
    <section class="why-us">
        <div class="wrap">
            <?php

            $id = 99; // add the ID of the page where the zero is
            $p = get_page($id);
            $t = $p->post_title;
            echo '<h3>'.apply_filters('post_title', $t).'</h3>'; // the title is here wrapped with h3
            echo apply_filters('the_content', $p->post_content);
            ?>
        </div>
    </section>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
