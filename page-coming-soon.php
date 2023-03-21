<?php
/*
	Template Name: Coming Soon Page
*/
get_header();

global $post;
if(function_exists('rwmb_meta')){
	$date 			= rwmb_meta( 'metaportal_fn_coming_time' );
	$rwmb_title 	= rwmb_meta( 'metaportal_fn_coming_title' );
	$rwmb_desc 		= rwmb_meta( 'metaportal_fn_coming_desc' );
}

if(isset($date)){
	$date 			= date('F j, Y H:i:s',strtotime($date));
}else{
	$date			= '';
}
if(!isset($rwmb_title) || $rwmb_title === ''){
	$rwmb_title 	= esc_html__('Public Minting is Coming Soon','metaportal');
}
if(!isset($rwmb_desc) || $rwmb_desc === ''){
	$rwmb_desc 		= esc_html__('Our website is coming soon. We are currently working on our website. Please check again within couple days.','metaportal');
}
// CHeck if page is password protected	
if(post_password_required($post)){
	$protected = metaportal_fn_protectedpage();
	echo wp_kses($protected, 'post');
}
else
{
?>
<div class="metaportal_fn_roadmaps">
	<?php metaportal_fn_get_page_title(); ?>
	
	<!-- Coming Soon -->
	<div class="metaportal_fn_coming_soon">
		<div class="container">
			
			<div class="soon_countdown">
				<!-- 
					There is two types of countdown: due_date (Due Date), ever (Evergreen timer)
						1. 	data-type="due_date"
							In this case you have to change value of data-date. For example:
							data-date="October 13, 2022 12:30:00"
							It will mean that mint will finished at this time

						2. 	data-type="ever"
							In this case you have to change values of data-days, data-hours, data-minutes and data-seconds. For example:
							data-days="34"
							data-hours="10"
							data-minutes="20"
							data-seconds="0"
							It will mean that the time expires after this time, but when the page is refreshed, the value will return again. It means, it won't end.
					Add boxed class to get #1 type of countdown
				-->
				<?php
 					$days_text = esc_html__('Days', 'metaportal');
 					$hours_text = esc_html__('Hours', 'metaportal');
 					$minutes_text = esc_html__('Minutes', 'metaportal');
 					$seconds_text = esc_html__('Seconds', 'metaportal');
 				?>
				<h3 class="metaportal_fn_countdown boxed" data-type="due_date" data-date="<?php echo esc_attr($date);?>" data-days="" data-hours="" data-minutes="" data-seconds="" data-text-days="<?php echo esc_attr($days_text); ?>" data-text-hours="<?php echo esc_attr($hours_text); ?>" data-text-minutes="<?php echo esc_attr($minutes_text); ?>" data-text-seconds="<?php echo esc_attr($seconds_text); ?>">0d: 0h: 0m: 0s</h3>
			</div>
			<div class="soon_title">
				<h3><?php echo esc_html($rwmb_title); ?></h3>
				<p><?php echo esc_html($rwmb_desc); ?></p>
			</div>
			
		</div>			
	</div>
	<!-- !Coming Soon -->
	
	
	
	
	<!-- Content -->
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="roadmap_content">
			<div class="container">
				<?php the_content(); ?>
			</div>
		</div>
	<?php endwhile; endif;?>
	<!-- /Content -->

</div>
<?php } ?>

<?php get_footer(); ?>  