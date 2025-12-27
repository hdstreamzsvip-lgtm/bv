<?php
get_header();
?>

<div class="container mx-auto px-4 py-8">
	<div class="flex flex-col">
		<main id="primary" class="content-area w-full">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'page' );
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			endwhile;
			?>
		</main>
	</div>
</div>

<?php
get_footer();
