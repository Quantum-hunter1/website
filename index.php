<?php

get_header();

global $post;
$metaportal_fn_pagestyle = 'full';

if($metaportal_fn_pagestyle == 'ws' && !metaportal_fn_if_has_sidebar()){
	$metaportal_fn_pagestyle	= 'full';
}

// CHeck if page is password protected	
if(post_password_required($post)){
	$protected = metaportal_fn_protectedpage();
	echo wp_kses($protected, 'post');
}else{	
	metaportal_fn_get_page_title();
?>
<div class="metaportal_fn_blog_page index_page">

	<?php if($metaportal_fn_pagestyle == 'full'){ ?>

	<!-- WITHOUT SIDEBAR -->
	<div class="container">
		<div class="metaportal_fn_nosidebar">
			<div class="metaportal_fn_bloglist">
				<ul class="fn__masonry bloglist">
					<?php get_template_part( 'inc/templates/posts' );?>
				</ul>
			</div>	
		</div>
		<?php metaportal_fn_pagination(); ?>
	</div>
	<!-- /WITHOUT SIDEBAR -->
	<?php }else{ ?>

	<!-- WITH SIDEBAR -->
	<div class="container fn_index_sidebar">
		<div class="metaportal_fn_hassidebar">
			<div class="metaportal_fn_leftsidebar">
				<div class="sidebar_in">
					<div class="metaportal_fn_bloglist">
						<ul class="fn__masonry bloglist">
							<?php get_template_part( 'inc/templates/posts' );?>
						</ul>
					</div>
				</div>
			</div>

			<div class="metaportal_fn_rightsidebar">
				<div class="sidebar_in">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>
	<?php metaportal_fn_pagination(); ?>
	<!-- /WITH SIDEBAR -->

	<?php } ?>
</div>

<?php } ?>

<?php get_footer(); ?>  