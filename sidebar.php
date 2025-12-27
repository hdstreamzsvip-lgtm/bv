<aside id="secondary" class="widget-area w-full lg:w-1/3">
	<div class="aap-trending-widget mb-10">
		<div class="aap-widget__titleTR flex items-center justify-between p-4 bg-primary-600 text-white rounded-t-xl">
			<h3 class="aap-widget__title-text text-base font-bold flex items-center gap-2 m-0">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
				Trending Apps
			</h3>
		</div>
		<div class="aap-trending-apps-container bg-white border border-t-0 rounded-b-xl overflow-hidden p-4">
			<div class="aap-trending-apps-ngrid flex flex-col gap-3">
				<?php
				$args = array(
					'post_type' => 'post',
					'posts_per_page' => 5,
					'orderby' => 'meta_value_num',
					'meta_key' => 'weekly_views',
				);
				$query = new WP_Query($args);
				if ($query->have_posts()) :
					while ($query->have_posts()) : $query->the_post();
					?>
					<a href="<?php the_permalink(); ?>" class="aap-similar-app-item flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-12 h-12 rounded-lg object-cover' ) ); ?>
						<?php endif; ?>
						<div class="aap-app-details flex-1 min-w-0">
							<span class="aap-app-name block font-semibold text-sm truncate"><?php the_title(); ?></span>
							<div class="aap-app-size text-xs text-gray-500"><?php echo get_post_meta(get_the_ID(), 'app_size', true) ?: '12 MB'; ?></div>
							<div class="aap-app-rating text-[10px] text-yellow-500 font-bold">4.8 ★</div>
						</div>
					</a>
					<?php
					endwhile;
					wp_reset_postdata();
				else:
					// Fallback if no posts with weekly_views
					$fallback_args = array('post_type' => 'post', 'posts_per_page' => 5);
					$fallback_query = new WP_Query($fallback_args);
					while ($fallback_query->have_posts()) : $fallback_query->the_post();
					?>
					<a href="<?php the_permalink(); ?>" class="aap-similar-app-item flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-12 h-12 rounded-lg object-cover' ) ); ?>
						<?php endif; ?>
						<div class="aap-app-details flex-1 min-w-0">
							<span class="aap-app-name block font-semibold text-sm truncate"><?php the_title(); ?></span>
							<div class="aap-app-size text-xs text-gray-500">22.4 MB</div>
							<div class="aap-app-rating text-[10px] text-yellow-500 font-bold">4.8 ★</div>
						</div>
					</a>
					<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
		</div>
	</div>

	<div class="aap-recent-widget mb-10">
		<div class="aap-widget__title flex items-center justify-between mb-4 border-b-2 border-gray-100 pb-2">
			<h3 class="aap-widget__title-text text-lg font-bold uppercase tracking-wider">
				Recent Updates
			</h3>
		</div>
		<ul class="aap-recent-list space-y-4">
			<?php
			$recent_args = array('post_type' => 'post', 'posts_per_page' => 5);
			$recent_query = new WP_Query($recent_args);
			while ($recent_query->have_posts()) : $recent_query->the_post();
			?>
			<li class="aap-hwguides group">
				<a href="<?php the_permalink(); ?>" class="block">
					<strong class="block text-sm font-bold group-hover:text-primary-600 transition-colors"><?php the_title(); ?></strong>
					<small class="text-xs text-gray-400">Updated On: <?php echo get_the_modified_date('d M Y'); ?></small>
				</a>
			</li>
			<?php
			endwhile;
			wp_reset_postdata();
			?>
		</ul>
	</div>

	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
