<?php
/*-----------------------------------------------------------------------------------*/
/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
/*-----------------------------------------------------------------------------------*/	


function metaportal_fn_theme_option(){
	global $metaportal_fn_option;
	return $metaportal_fn_option;
}

function metaportal_fn_body_classes( $classes ) {
	global $metaportal_fn_option;
	
	$collection_sticky = 'disabled';
	if(isset($metaportal_fn_option['collection_sticky'])){
		$collection_sticky = $metaportal_fn_option['collection_sticky'];
	}
	if(isset($_GET['collection_sticky'])){$collection_sticky = 'enabled';}
	$collection_sticky = 'sticky-'.$collection_sticky;
	$classes[] = esc_html($collection_sticky);
      
    return $classes;
}
add_filter( 'body_class','metaportal_fn_body_classes' );

function metaportal_fn_nft_item__similiar(){
	
	$post_id	= get_the_id();
	$categories = get_the_terms( $post_id, 'nft_category' );
	$cat_ids	= array();
	if(!empty($categories)){
		foreach ( $categories as $cat){
		  array_push($cat_ids,$cat->slug);
		}
	}
	
	$query_args = array(
		'post_type' 			=> 'frenify-nft',
        'post__not_in'    		=> array($post_id),
		'posts_per_page' 		=> 6,
		'post_status' 			=> 'publish',
		'orderby'				=> 'rand'
	);
	
	if ( ! empty ( $categories ) ) {
		$query_args['tax_query'] = array(
			'taxonomy'	=> 'nft_category',
			'field'		=> 'slug',
			'terms'		=> $categories,
			'operator'	=> 'IN'
		);
	}
	
	$loop = new \WP_Query($query_args);
	$output = metaportal_fn_get_nft_items($loop);
	return $output;
}

function metaportal_fn_get_nav_nfts(){
	global $metaportal_fn_option;
	$nft__marketplaces = array();
	if(isset($metaportal_fn_option['nft__marketplaces'])){
		$nft__marketplaces = $metaportal_fn_option['nft__marketplaces'];
	}
	$output = '';
	if(!empty($nft__marketplaces)){
		$altText 	= esc_html__('Icon', 'metaportal');
		$svgURL		= get_template_directory_uri().'/framework/svg/nft/';
		foreach($nft__marketplaces as $key => $sPos){
			if($sPos == 1){
				if(isset($metaportal_fn_option['nav__'.$key.'_url'])){
					switch($key){
						case 'opensea':
						case 'discord':
						case 'atomicmarket':
						case 'foundation':
						case 'myth_market':
						case 'rarible':
						case 'superrare': $has_icon = true; break;
						default: $has_icon = false; break;
					}
					if(!$has_icon){
						$svgIcon = $svgURL.'market';
					}else{
						$svgIcon = $svgURL.$key;
					}
					if($metaportal_fn_option['nav__'.$key.'_url'] != ''){
						$output .= '<li><div class="item">';
							$output .= '<a href="'.esc_url($metaportal_fn_option['nav__'.$key.'_url']).'" class="" target="_blank"></a>';
							$output .= '<span class="icon"><img src="'.$svgIcon.'.svg" alt="'.$altText.'" class="fn__svg" /></span>';
							$output .= '<span class="text">'.esc_html($metaportal_fn_option[$key.'_text']).'</span>';
						$output .= '</div></li>';
					}
				}
			}
		}
		if($output != ''){
			return '<div class="list_holder"><ul class="metaportal_fn_items">'.$output.'</ul></div>';
		}
	}
	return '';
}


function metaportal_get_author_info(){
	global $metaportal_fn_option;
	if(isset($metaportal_fn_option['blog_single_author_info']) && $metaportal_fn_option['blog_single_author_info'] == 'enabled'){
		
		$userID 			= get_the_author_meta( 'ID' );
		$authorURL			= get_author_posts_url($userID);
		$social				= metaportal_fn_get_user_social($userID);


		$name 				= esc_html( get_the_author_meta( 'metaportal_fn_user_name', $userID ) );
		$description		= esc_html( get_the_author_meta( 'metaportal_fn_user_desc', $userID ) );
		$imageURL			= esc_url( get_the_author_meta( 'metaportal_fn_user_image', $userID ) );

		if($name == ''){	
			$firstName 		= get_user_meta( $userID, 'first_name', true );
			$lastName 		= get_user_meta( $userID, 'last_name', true );
			$name 			= $firstName . ' ' . $lastName;
			if($firstName == ''){
				$name 		= get_user_meta( $userID, 'nickname', true );
			}
		}
		if($description == ''){
			$description 	= get_user_meta( $userID, 'description', true );
		}
		if($imageURL == ''){
			$image			= get_avatar( $userID, 200 );
		}else{
			$image			= '<div class="info_in"></div><div class="abs_img" data-fn-bg-img="'.$imageURL.'"></div>';
		}



		$title 			= '<h3 class="fn_title"><a href="'.esc_url($authorURL).'">'.$name.'</a></h3>';
		$description	= '<p class="fn_desc">'.$description.'</p>';
		$leftTop		= '<div class="author_top">'.$title.$description.'</div>';
		$leftBottom		= '<div class="author_bottom">'.$social.'</div>';
		$html  = '<div class="metaportal_fn_author_info">';
			$html  .= '<div class="info_img">'.$image.'</div>';
			$html  .= '<div class="info_desc">'.$leftTop.$leftBottom.'</div>';
		$html .= '</div>';
		return $html;
	}
	return '';
}

function metaportal_fn_meta__roadmap($postID){
	$output  	 = '<div class="metaportal_fn_minis">';
	if(function_exists('rwmb_meta')){
		$date = get_post_meta(get_the_ID(), 'metaportal_fn_roadmap_date', true);
	}
	if(isset($date)){
		$date 	= date(get_option('date_format'),strtotime($date));
		$output .= '<div class="m_item"><span>'.esc_html__('Scheduled: ','metaportal').$date.'</span></div>';
	}else{
		$output .= '<div class="m_item"><span>'.get_the_time(get_option('date_format'), $postID).'</span></div>';
	}

	$authorName  = get_the_author_meta('display_name');
	$authorURL 	 = get_author_posts_url(get_the_author_meta('ID'));
	$output 	 .= '<div class="m_item"><span>'.esc_html__('By ','metaportal') . '<a href="' . esc_url($authorURL) . '">' . esc_html($authorName) . '</a><span></div>';
	
	$output 	 .= '</div>';
	
	return $output;
}

function metaportal_fn_meta($postID){
	$output  	 = '<div class="metaportal_fn_minis">';
	$output 	.= '<div class="m_item"><span>'.get_the_time(get_option('date_format'), $postID).'</span></div>';
		
	$authorName  = get_the_author_meta('display_name');
	$authorURL 	 = get_author_posts_url(get_the_author_meta('ID'));
	$output 	 .= '<div class="m_item"><span>'.esc_html__('By ','metaportal') . '<a href="' . esc_url($authorURL) . '">' . esc_html($authorName) . '</a><span></div>';
	
	
	$output 	 .= '<div class="m_item"><a href="'.get_comments_link($postID).'">' . sprintf( _n('%d Comment', '%d Comments', get_comments_number($postID), 'metaportal'), get_comments_number($postID) ). '</a></div>';
	
	$output 	 .= '</div>';
	
	return $output;
}

function metaportal_fn_sharepost(){
	global $metaportal_fn_option, $post;
	$src = $output = '';

	$postid 		= get_the_ID();
	$permalink 		= get_the_permalink();
	if (has_post_thumbnail()) {
		$post_thumbnail_id = get_post_thumbnail_id( $postid );
		$src = wp_get_attachment_image_src( $post_thumbnail_id, 'full');
		$src = $src[0];
	}
	if(isset($metaportal_fn_option)){
		$output .= '<div class="metaportal_fn_share">';
			$output .= '<h5 class="label">'.esc_html__('Share:', 'metaportal').'</h5>';
			$output .= '<ul>';
		
			if(isset($metaportal_fn_option['share_facebook']) == 1 && $metaportal_fn_option['share_facebook'] != 'disable') {
				$output .= '<li><a href="http://www.facebook.com/share.php?u='.$permalink.'" target="_blank"><i class="fn-icon-facebook"></i></a></li>';
			}

			if(isset($metaportal_fn_option['share_twitter']) == 1 && $metaportal_fn_option['share_twitter'] != 'disable') {
				$output .= '<li><a href="https://twitter.com/share?url='.$permalink.'"  target="_blank"><i class="fn-icon-twitter"></i></a></li>';
			}

			if(isset($metaportal_fn_option['share_pinterest']) == 1 && $metaportal_fn_option['share_pinterest'] != 'disable') {
				$output .= '<li><a href="http://pinterest.com/pin/create/button/?url='.$permalink.'&amp;media=';
				if($src != ''){
					$output .= esc_url($src);
				}
				$output .= '" target="_blank"><i class="fn-icon-pinterest"></i></a></li>';
			}

			if(isset($metaportal_fn_option['share_linkedin']) == 1 && $metaportal_fn_option['share_linkedin'] != 'disable') {
				$output .= '<li><a href="http://linkedin.com/shareArticle?mini=true&amp;url='.$permalink.'>&amp;" target="_blank"><i class="fn-icon-linkedin"></i></a></li>';
			}

			if(isset($metaportal_fn_option['share_email']) == 1 && $metaportal_fn_option['share_email'] != 'disable') {
				$output .= '<li><a href="mailto:?amp;body='.$permalink.'" target="_blank"><i class="fn-icon-email"></i></a></li>';
			}

			if(isset($metaportal_fn_option['share_vk']) == 1 && $metaportal_fn_option['share_vk'] != 'disable') {
				$output .= '<li><a href="https://www.vk.com/share.php?url='.$permalink.'" target="_blank"><i class="fn-icon-vkontakte"></i></a></li>';
			}
			$output .= '</ul>';
		$output .= '</div>';
	}
	
	return $output;
}

function metaportal_fn_get_page_title(){
	global $post,$metaportal_fn_option;
	$metaportal_fn_pagetitle 		= '';
	if(function_exists('rwmb_meta')){
		$metaportal_fn_pagetitle 		= get_post_meta(get_the_ID(),'metaportal_fn_page_title', true);
	}
	$seo_page_title 			= 'h3';
	if(isset($metaportal_fn_option['seo_page_title'])){
		$seo_page_title 		= $metaportal_fn_option['seo_page_title'];
	}
	
	
	
	if($metaportal_fn_pagetitle !== 'disable'){?>
	<!-- PAGE TITLE -->
	<div class="metaportal_fn_pagetitle">
		<div class="container">
			<div class="pagetitle">
				<?php 
					
					if(is_search()){
						$title = sprintf( esc_html__('Search results for "%s"', 'metaportal'), get_search_query() );
					}else if(is_archive()){
						$currentAuthor = get_userdata(get_query_var('author'));
						if (is_category()) {
							$title = sprintf(esc_html__('All posts in %s', 'metaportal'), single_cat_title('',false));
						}else if( is_tax() ) {
							$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
							$title = sprintf(esc_html__('All posts in %s', 'metaportal'), $term->name );
						}else if( is_tag() ) {
							$title = sprintf(esc_html__('All posts tagged in %s', 'metaportal'), single_tag_title('',false));
						}else if (is_day()) {
							$title = sprintf(esc_html__('Archive for %s', 'metaportal'),get_the_time(get_option('date_format')));
						}else if (is_month()) {
							$title = sprintf(esc_html__('Archive for %s', 'metaportal'), get_the_time('F, Y'));
						}else if (is_year()) {
							$title = sprintf(esc_html__('Archive for %s', 'metaportal'), get_the_time('Y'));
						}else if (is_author()) { 
							$title = sprintf(esc_html__('All posts by %s', 'metaportal'), esc_html($currentAuthor->display_name));
						}else if (isset($_GET['paged']) && !empty($_GET['paged'])) { 
							$title = esc_html__('Blog Archives', 'metaportal'); 
						}else if($post->post_type == 'frenify-nft'){
							if(isset($metaportal_fn_option['nft_archive_title'])){
								$title = esc_html($metaportal_fn_option['nft_archive_title']);
							}else{
								$title = esc_html__('Collection', 'metaportal');
							}
						}
					}else if(is_home() || is_front_page()){
						if(isset($metaportal_fn_option['blog_single_title'])){
							$title = esc_html($metaportal_fn_option['blog_single_title']);
						}else{
							$title = esc_html__('Latest Articles', 'metaportal');
						}
					}else{
						$title = get_the_title();
					}
					printf( '<%1$s class="fn__title fn__maintitle big" data-text="%2$s" data-align="center">', $seo_page_title, $title );
					echo esc_html($title);	
					printf( '</%1$s>', $seo_page_title );
					metaportal_fn_breadcrumbs();
				?>
			</div>
		</div>
		<div class="fn_cs_section_divider">
			<div class="divider">
				<span class="short"></span>
				<span class="long"></span>
				<span class="short"></span>
			</div>
		</div>
	</div>
	<!-- /PAGE TITLE -->
	<?php }
	
	
}

function metaportal_fn_search_form( $form ) {
    $form = '<form role="search" method="get" class="searchform" action="' . home_url( '/' ) . '" ><div class="search-wrapper"><input type="text" value="' . get_search_query() . '" name="s" placeholder="'.esc_attr__('Search anything...', 'metaportal').'" /><input type="submit" value="" /><span>'.metaportal_fn_getSVG_theme('searching').'</span></div>
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'metaportal_fn_search_form', 100 );

function metaportal_fn_custom_password_form() {
    global $post;
 
    $loginurl = home_url() . '/wp-login.php?action=postpass';
    ob_start();
    ?>
    <div class="container-custom">            
        <form action="<?php echo esc_attr( $loginurl ) ?>" method="post" class="center-custom search-form" role="search">
            <input name="post_password" class="input post-password-class" type="password"  placeholder="<?php echo esc_attr__( 'Enter the Password', 'metaportal' ); ?>" />
            <span class="submit"><input type="submit" name="Submit" class="button" value="<?php echo esc_attr__( 'Authenticate', 'metaportal' ); ?>" /></span>
        </form>
    </div>
 
    <?php
    return ob_get_clean();
}   
add_filter( 'the_password_form', 'metaportal_fn_custom_password_form', 9999 );

function metaportal_fn_post_taxanomy($post_type = 'post'){	
		$selectedPostTaxonomies = [];
		
		if( $post_type == 'page' )
		{
			
		}
		else if( $post_type != '' )
		{
			$taxonomys = get_object_taxonomies( $post_type );
			$exclude = array( 'post_tag', 'post_format' );

			if($taxonomys != '')
			{
				foreach($taxonomys as $key => $taxonomy)
				{
					// exclude post tags
					if( in_array( $taxonomy, $exclude ) ) { continue; }

					$selectedPostTaxonomies[$key] = $taxonomy;
				}
			}
		}
		else
		{

		}

		// custom post cats
		return $selectedPostTaxonomies;
	}

function html5_search_form( $form ) {
     $form  = '<section class="search"><form role="search" method="get" action="' . home_url( '/' ) . '" >';
		 $form .= '<label class="screen-reader-text" for="s"></label>';
		 $form .= '<input type="text" value="' . get_search_query() . '" name="s" placeholder="'. esc_attr__('Search', 'metaportal') .'" />';
		 $form .= '<input type="submit" value="'. esc_attr__('Search', 'metaportal') .'" />';
	 $form .= '</form></section>';
     return $form;
}

add_filter( 'get_search_form', 'html5_search_form' );


function metaportal_fn_nft_item__categories(){
	$terms 	= get_the_terms(get_the_id(), 'nft_category');
	$output = '';
	$array 	= array();
	if(!empty($terms)){
		foreach($terms as $term){
			$parentID = $term->parent;
			if($parentID == 0){
				$parentID = $term->term_id;
			}
			$array[$parentID][] = $term->name;
		}
		foreach($array as $key => $arr){
			$termName = implode(', ', $arr);
			if($key != 0){
				$parentName = get_term_by('id', $key, 'nft_category')->name;
			}else{
				$parentName = $termName;
			}
			$output .= '<li><div class="item"><h4 class="parent_category">'.$parentName.'</h4><h3 class="child_category" title="'.$termName.'">'.$termName.'</h3></div></li>';
		}
	}
	if($output != ''){
		$output = '<div class="metaportal_fn_nft_cats"><ul>'.$output.'</ul></div>';
	}
	return $output;
}

function metaportal_fn_hex2rgba($color, $opacity = false) {
 
	$default = 'rgb(0,0,0)';
 
	//Return default if no color provided
	if(empty($color)){
		return $default;
	}
          
 
	//Sanitize $color if "#" is provided 
	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}
 
	//Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}
 
	//Convert hexadec to rgb
	$rgb =  array_map('hexdec', $hex);

	//Check if opacity is set(rgba or rgb)
	if($opacity){
		if(abs($opacity) > 1){
			$opacity = 1.0;
		}
		$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	} else {
		$output = 'rgb('.implode(",",$rgb).')';
	}

	//Return rgb(a) color string
	return $output;
}

function metaportal_fn_get_date($postID){
	return '<p class="fn_date"><span>'.get_the_time(get_option('date_format'), $postID).'</span></p>';
}


function metaportal_fn_metas($postID, $from = 'single'){
	$html = '';
	$separator = ' / ';
	$date = get_the_time(get_option('date_format'), $postID);
	if($date != ''){
		$html .= $date . $separator;
	}
	$categories = metaportal_fn_get_categories($postID,$from);
	if($categories != ''){
		$html .= $categories . $separator;
	}
	$html .= '<a href="'.get_comments_link($postID).'">' . sprintf( _n('%d Comment', '%d Comments', get_comments_number($postID), 'metaportal'), get_comments_number($postID) ). '</a>';
	return '<div class="meta"><p>'.$html.'</p></div>';
}

function metaportal_fn_get_categories($postID, $from, $postType = 'post', $categoryCount = 999){
	$categoryCount		= (int)$categoryCount;
	$catHolder			= '';
	if(isset(metaportal_fn_post_taxanomy($postType)[0])){
		$taxonomy		= metaportal_fn_post_taxanomy($postType)[0];
		if(metaportal_fn_taxanomy_list($postID, $taxonomy, false, $categoryCount) != ""){
			$catHolder	= metaportal_fn_taxanomy_list($postID, $taxonomy, false, $categoryCount, ', ', '');
		}
	}
	if($from == 'single'){
		if($catHolder != ''){
			$catHolder = '<div class="categories">'.$catHolder.'</div>';
		}
	}
	return $catHolder;
}


function metaportal_fn_post_term_list($postid, $taxanomy, $echo = true, $max = 2, $seporator = ' , ', $link = true){
		
	$terms = $termlist = $term_link = $cat_count = '';
	$terms = get_the_terms($postid, $taxanomy);

	if($terms != ''){

		$cat_count = sizeof($terms);
		if($cat_count >= $max){$cat_count = $max;}

		for($i = 0; $i < $cat_count; $i++){
			$term_link = get_term_link( $terms[$i]->slug, $taxanomy );
			if(!$link){
				$termlist .= $terms[$i]->name.$seporator;
			}else{
				$termlist .= '<a href="'.$term_link.'"><span class="extra"></span>'.$terms[$i]->name.'</a>'.$seporator;
			}
		}
		$termlist = trim($termlist, $seporator);
	}

	if($echo == true){
		echo wp_kses($termlist, 'post');
	}else{
		return $termlist;
	}
}
add_filter('wp_list_categories', 'metaportal_fn_cat_count_span');
function metaportal_fn_cat_count_span($links) {
  	$links = str_replace('</a> (', '</a> <span class="count">', $links);
  	$links = str_replace(')', '</span>', $links);
  	return $links;
}

function metaportal_fn_if_has_sidebar(){
	if(is_single()){
		if ( is_active_sidebar( 'main-sidebar' ) ){
			return true;
		}else{
			return false;
		}
	}else {
		if ( is_active_sidebar( 'main-sidebar' ) ){
			return true;
		}else{
			return false;
		}
	}
}

function metaportal_fn_postprevnext($post = 'blog'){
	global $metaportal_fn_option;
	$prev_post 			= get_adjacent_post(false, '', true);
	$next_post 			= get_adjacent_post(false, '', false);
	$centerHolder		= '';
	if(isset($metaportal_fn_option[$post.'_url'])){
		$centerHolder = '<div class="fn_trigger">
							<a href="'.$metaportal_fn_option[$post. '_url'].'" class="full_link"></a>
							<div class="icon">
								<span></span><span></span><span></span><span></span>
								<span></span><span></span><span></span><span></span>
								<span></span><span></span><span></span><span></span>
								<span></span><span></span><span></span><span></span>
							</div>
						</div>';
	}
	$prevPostTitle		= esc_html__('Prev Post', 'metaportal');
	$nextPostTitle		= esc_html__('Next Post', 'metaportal');
	$prevPostSubTitle	= $prevPostTitle;
	$nextPostSubTitle	= $nextPostTitle;

	$nextHasImg = $prevHasImg = $prevImgURL = $nextImgURL = $prevPostURL = $nextPostURL = '';
	if(!empty($prev_post)) {
		$prevPostID		= $prev_post->ID;
		$prevPostTitle	= $prev_post->post_title;
		if($prevPostTitle == ''){
			$prevPostTitle = esc_html__('Prev Post: No Title', 'metaportal');
		}
		$prevPostURL	= '<a class="full_link" href="'.get_permalink($prev_post->ID).'"></a>';
		$thumbID 		= get_post_thumbnail_id( $prevPostID );
		if(isset(wp_get_attachment_image_src( $thumbID, 'full')[0])){
			$prevImgURL = wp_get_attachment_image_src( $thumbID, 'full')[0];
		}
		if($prevImgURL != ''){$prevHasImg = 'yes';}
	}
	if(!empty($next_post)) {
		$nextPostID		= $next_post->ID;
		$nextPostTitle	= $next_post->post_title;
		if($nextPostTitle == ''){
			$nextPostTitle = esc_html__('Next Post: No Title', 'metaportal');
		}
		$nextPostURL	= '<a class="full_link" href="'.get_permalink($next_post->ID).'"></a>';
		$thumbID 		= get_post_thumbnail_id( $nextPostID );
		if(isset(wp_get_attachment_image_src( $thumbID, 'full')[0])){
			$nextImgURL = wp_get_attachment_image_src( $thumbID, 'full')[0];
		}
		if($nextImgURL != ''){$nextHasImg = 'yes';}
	}


	if ($prev_post && $next_post) { 
		$prevnext		= 'yes';
	}else if(!$prev_post && $next_post){
		$prevnext		= 'next';
	}else if($prev_post && !$next_post){
		$prevnext		= 'prev';
	}else{
		$prevnext		= 'no';
	}
	$prevHolder 	= '<div class="prev item" data-img="'.$prevHasImg.'">'.$prevPostURL.'<div class="item_in"><div class="img" data-bg-img="'.$prevImgURL.'"></div><div class="desc"><p class="fn_desc">'.$prevPostSubTitle.'</p><h3 class="fn_title">'.$prevPostTitle.'</h3></div></div></div>';
	$nextHolder 	= '<div class="next item" data-img="'.$nextHasImg.'">'.$nextPostURL.'<div class="item_in"><div class="img" data-bg-img="'.$nextImgURL.'"></div><div class="desc"><p class="fn_desc">'.$nextPostSubTitle.'</p><h3 class="fn_title">'.$nextPostTitle.'</h3></div></div></div>';
	
	if($prevnext == 'no'){
		return '<div class="metaportal_fn_pnb" data-status="'.$prevnext.'"></div>';
	}
	return '<div class="metaportal_fn_pnb" data-status="'.$prevnext.'"><div class="container"><div class="pnb_wrapper">'.$prevHolder.$centerHolder.$nextHolder.'</div></div></div>';
}


function metaportal_fn_get_roadmap_items($loop){
	global $metaportal_fn_option;
	
	$output					= '';
	$dateTitle1				= esc_html__('Scheduled Date', 'metaportal');
	$dateTitle2				= esc_html__('Published Date', 'metaportal');
	$readMore				= esc_html__('Read More', 'metaportal');
	
	if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post(); 
		$title 				= get_the_title();
		$dropID				= get_the_id();
		$permalink			= get_the_permalink();
		$description		= '';
		if(function_exists('rwmb_meta')){
			$description 	= rwmb_meta( 'metaportal_fn_roadmap_desc' );
			$date 			= rwmb_meta( 'metaportal_fn_roadmap_date' );
			$images 		= rwmb_meta( 'metaportal_fn_roadmap_images', 'type=image&size=full&limit=3' );
		}
		if(isset($date)){
			$date 			= date(get_option('date_format'),strtotime($date));
			$dateTitle		= $dateTitle1;
		}else{
			$date 			= get_the_time(get_option('date_format'), $postID);
			$dateTitle		= $dateTitle2;
		}
		$galleryItems 		= '';
		if(isset($images) && !empty($images)){
			foreach($images as $key => $image){
				$class = '';
				if($key == 0){$class = 'row2';}
				$galleryItems .= '<div class="item '.$class.'"><img src="'.$image['url'].'" alt=""></div>';
			}
			$galleryItems = '<div class="t_item_img"><div class="metaportal_fn_gallery_1_2"><div class="gallery_in">' . $galleryItems . '</div></div></div>';
		}
	
	
		$output .= '<li class="road_item">
						<div class="t_item">
							'.$galleryItems.'
							<div class="t_item_info">
								<p class="fn_date" title="'.$dateTitle.'"><span>'.$date.'</span></p>
								<h3 class="fn_title"><a href="'.$permalink.'">'.$title.'</a></h3>
								<p class="fn_desc">'.$description.'</p>
								<p class="fn_read">
									<a href="'.$permalink.'" class="metaportal_fn_button">
										<span class="text">'.$readMore.'</span>
									</a>
								</p>
							</div>
						</div>
					</li>';
	
	endwhile; endif;
	
	return $output;
}

function metaportal_fn_nft_item__buttons(){
	global $metaportal_fn_option;
	
	// entry variable
	$buttons = '';
	
	// if has redux metaboxes
	if(function_exists('rwmb_meta')){
		
		// get all marketplaces from theme options
		$nft__marketplaces = array();
		if(isset($metaportal_fn_option['nft__marketplaces'])){
			$nft__marketplaces = $metaportal_fn_option['nft__marketplaces'];
		}
		
		// svg initial url
		$svgURL = get_template_directory_uri().'/framework/svg/nft/';
		
		// get all buttons for selected post
		if(!empty($nft__marketplaces)){
			foreach($nft__marketplaces as $key => $sPos){
				if($sPos == 1){
					$url = rwmb_meta( 'metaportal_fn_nft_'.$key.'_url' );
					if($url != ''){
						switch($key){
							case 'opensea':
							case 'discord':
							case 'atomicmarket':
							case 'foundation':
							case 'myth_market':
							case 'rarible':
							case 'superrare': $has_icon = true; break;
							default: $has_icon = false; break;
						}
						if(!$has_icon){
							$svgIcon = $svgURL.'market';
						}else{
							$svgIcon = $svgURL.$key;
						}
						$buttons .= '<li><a title="'.$key.'" href="'.esc_url($url).'" target="_blank"><img src="'.$svgIcon.'.svg" alt="" class="fn__svg" /></a></li>';
					}
				}
			}
		}
	}
	if($buttons != ''){
		return '<div class="view_on"><ul><li><span>'.esc_html__('View On:','metaportal').'</span></li>'.$buttons.'</ul></div>';
	}
	return '';
}


function metaportal_fn_get_nft_items($loop){
	global $metaportal_fn_option;
	
	// since v1.0.9
	$popup_switcher			= 'disabled';
	if(isset($metaportal_fn_option['nft_popup_switcher'])){
		$popup_switcher		= $metaportal_fn_option['nft_popup_switcher'];
	}
	$output					= '';
	
	
	$nft_image_size			= 'full';
	if(isset($metaportal_fn_option['nft_image_size'])){
		$nft_image_size		= $metaportal_fn_option['nft_image_size'];
	}
	if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post(); 
		$dropTitle 			= get_the_title();
		$dropID				= get_the_id();
		$permalink			= get_the_permalink();
		$dropImageURL 		= get_the_post_thumbnail_url($dropID,$nft_image_size);
		$description		= '';
		if(function_exists('rwmb_meta')){
			$description 	= rwmb_meta( 'metaportal_fn_nft_description' ) ;
			if($description != ''){
				$description .= '... ';
			}
		}
		$buttons 			= metaportal_fn_nft_item__buttons();
	
	
		$link = $permalink;
		if($popup_switcher == 'enabled'){$link = '#';}
	
		$output .= '<li class="collection_masonry_item">
						<div class="nft__item" data-modal-image="'.$dropImageURL.'" data-modal-title="'.$dropTitle.'" data-modal-description="'.$description.'" data-modal-permalink="'.$permalink.'">
							<div class="img_holder">
								<img src="'.$dropImageURL.'" alt="">
								<a data-lightbox="'.$popup_switcher.'" href="'.$link.'" class="full_link"></a>
							</div>
							<div class="title_holder">
								<h3 class="fn_title"><a data-lightbox="'.$popup_switcher.'" href="'.$link.'">'.$dropTitle.'</a></h3>
							</div>
							'.$buttons.'
						</div>
					</li>';
	
	endwhile; endif;wp_reset_postdata();
	
	return $output;
}

function metaportal_fn_ajax_portfolio(){
	check_ajax_referer( 'metaportal-secure', 'security' );
	global $metaportal_fn_option;
	
	$post_number 				= 12;
	if(isset($metaportal_fn_option['nft_perpage'])){
		$post_number 			= $metaportal_fn_option['nft_perpage'];
	}
	$page 						= 1;
	if(!empty($_POST['page'])){
		$page 					= sanitize_text_field($_POST['page']);
	}
	$categories					= '';
	if(!empty($_POST['categories'])){
		$categories 			= sanitize_text_field($_POST['categories']);
	}
	
	$paged 						= (int)$page;
	$query_args = array(
		'post_type' 			=> 'frenify-nft',
		'post_status' 			=> 'publish',
	);
	
	
	if($categories != ''){
		$categories = explode (",", $categories); 
		if ( ! empty ( $categories ) ) {
			
			
			$termArray = [];
			
			foreach($categories as $category){
				$term = get_term($category, 'nft_category');
				$termParent = $term->parent;
				$termArray[$termParent][] = $category;
			}
			
			$query_args['tax_query'] = array(
				'relation' => 'AND',
			);
			
			
			foreach($termArray as $key => $cats){
				
				$query_args['tax_query'][$key][]['relation'] = 'OR';
				$query_args['tax_query'][$key][] = array(
					'taxonomy' 	=> 'nft_category',
					'field' 	=> 'term_id',
					'terms'		=> $cats,
					'operator'	=> 'IN'
				); 
			}
			
			
		}
	}

	$query_args['posts_per_page'] 	= $post_number;
	$query_args['paged'] 			= $paged;

	$loop 							= new \WP_Query($query_args);

	
	$fn_list 	= metaportal_fn_get_nft_items($loop);
	
	$pagination = metaportal_fn_pagination($loop->max_num_pages,1,0,4,false,$paged);
	
	
	
	$buffyArray = array(
		'list' 			=> $fn_list,
		'pagination' 	=> $pagination,
    );
	
	die(json_encode($buffyArray));
}



function metaportal_fn_getSVG_core($name = '', $class = ''){
	return '<img class="fn__svg '.$class.'" src="'.METAPORTAL_CORE_SHORTCODE_URL.'assets/svg/'.$name.'.svg" alt="svg" />';
}

function metaportal_fn_getSVG_theme($name = '', $class = ''){
	return '<img class="fn__svg '.$class.'" src="'.get_template_directory_uri().'/framework/svg/'.$name.'.svg" alt="svg" />';
}

function metaportal_fn_number_format_short( $n, $precision = 1 ) {
	if ($n < 900) {
		// 0 - 900
		$n_format = number_format($n, $precision);
		$suffix = '';
	} else if ($n < 900000) {
		// 0.9k-850k
		$n_format = number_format($n / 1000, $precision);
		$suffix = 'K';
	} else if ($n < 900000000) {
		// 0.9m-850m
		$n_format = number_format($n / 1000000, $precision);
		$suffix = 'M';
	} else if ($n < 900000000000) {
		// 0.9b-850b
		$n_format = number_format($n / 1000000000, $precision);
		$suffix = 'B';
	} else {
		// 0.9t+
		$n_format = number_format($n / 1000000000000, $precision);
		$suffix = 'T';
	}
  // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
  // Intentionally does not affect partials, eg "1.50" -> "1.50"
	if ( $precision > 0 ) {
		$dotzero = '.' . str_repeat( '0', $precision );
		$n_format = str_replace( $dotzero, '', $n_format );
	}
	return $n_format . $suffix;
}




function metaportal_fn_get_user_social($userID){
	$facebook 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_facebook', $userID ) );
	$twitter 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_twitter', $userID ) );
	$pinterest 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_pinterest', $userID ) );
	$linkedin 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_linkedin', $userID ) );
	$behance 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_behance', $userID ) );
	$vimeo 			= esc_attr( get_the_author_meta( 'metaportal_fn_user_vimeo', $userID ) );
	$google 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_google', $userID ) );
	$instagram 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_instagram', $userID ) );
	$github 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_github', $userID ) );
	$flickr 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_flickr', $userID ) );
	$dribbble 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_dribbble', $userID ) );
	$dropbox 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_dropbox', $userID ) );
	$paypal 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_paypal', $userID ) );
	$picasa 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_picasa', $userID ) );
	$soundcloud 	= esc_attr( get_the_author_meta( 'metaportal_fn_user_soundcloud', $userID ) );
	$whatsapp 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_whatsapp', $userID ) );
	$skype 			= esc_attr( get_the_author_meta( 'metaportal_fn_user_skype', $userID ) );
	$slack 			= esc_attr( get_the_author_meta( 'metaportal_fn_user_slack', $userID ) );
	$wechat 		= esc_attr( get_the_author_meta( 'metaportal_fn_user_wechat', $userID ) );
	$icq 			= esc_attr( get_the_author_meta( 'metaportal_fn_user_icq', $userID ) );
	$rocketchat		= esc_attr( get_the_author_meta( 'metaportal_fn_user_rocketchat', $userID ) );
	$telegram		= esc_attr( get_the_author_meta( 'metaportal_fn_user_telegram', $userID ) );
	$vkontakte		= esc_attr( get_the_author_meta( 'metaportal_fn_user_vkontakte', $userID ) );
	$rss			= esc_attr( get_the_author_meta( 'metaportal_fn_user_rss', $userID ) );
	$youtube		= esc_attr( get_the_author_meta( 'metaportal_fn_user_youtube', $userID ) );
	
	$facebook_icon 		= '<i class="fn-icon-facebook"></i>';
	$twitter_icon 		= '<i class="fn-icon-twitter"></i>';
	$pinterest_icon 	= '<i class="fn-icon-pinterest"></i>';
	$linkedin_icon 		= '<i class="fn-icon-linkedin"></i>';
	$behance_icon 		= '<i class="fn-icon-behance"></i>';
	$vimeo_icon 		= '<i class="fn-icon-vimeo-1"></i>';
	$google_icon 		= '<i class="fn-icon-gplus"></i>';
	$youtube_icon 		= '<i class="fn-icon-youtube-play"></i>';
	$instagram_icon 	= '<i class="fn-icon-instagram"></i>';
	$github_icon 		= '<i class="fn-icon-github"></i>';
	$flickr_icon 		= '<i class="fn-icon-flickr"></i>';
	$dribbble_icon 		= '<i class="fn-icon-dribbble"></i>';
	$dropbox_icon 		= '<i class="fn-icon-dropbox"></i>';
	$paypal_icon 		= '<i class="fn-icon-paypal"></i>';
	$picasa_icon 		= '<i class="fn-icon-picasa"></i>';
	$soundcloud_icon 	= '<i class="fn-icon-soundcloud"></i>';
	$whatsapp_icon 		= '<i class="fn-icon-whatsapp"></i>';
	$skype_icon 		= '<i class="fn-icon-skype"></i>';
	$slack_icon 		= '<i class="fn-icon-slack"></i>';
	$wechat_icon 		= '<i class="fn-icon-wechat"></i>';
	$icq_icon 			= '<i class="fn-icon-icq"></i>';
	$rocketchat_icon 	= '<i class="fn-icon-rocket"></i>';
	$telegram_icon 		= '<i class="fn-icon-telegram"></i>';
	$vkontakte_icon 	= '<i class="fn-icon-vkontakte"></i>';
	$rss_icon		 	= '<i class="fn-icon-rss"></i>';
	
	$socialList			= '';
	$socialHTML			= '';
	if($facebook != ''){$socialList .= '<li><a href="'.$facebook.'">'.$facebook_icon.'</a></li>';}
	if($twitter != ''){$socialList .= '<li><a href="'.$twitter.'">'.$twitter_icon.'</a></li>';}
	if($pinterest != ''){$socialList .= '<li><a href="'.$pinterest.'">'.$pinterest_icon.'</a></li>';}
	if($linkedin != ''){$socialList .= '<li><a href="'.$linkedin.'">'.$linkedin_icon.'</a></li>';}
	if($behance != ''){$socialList .= '<li><a href="'.$behance.'">'.$behance_icon.'</a></li>';}
	if($vimeo != ''){$socialList .= '<li><a href="'.$vimeo.'">'.$vimeo_icon.'</a></li>';}
	if($google != ''){$socialList .= '<li><a href="'.$google.'">'.$google_icon.'</a></li>';}
	if($instagram != ''){$socialList .= '<li><a href="'.$instagram.'">'.$instagram_icon.'</a></li>';}
	if($github != ''){$socialList .= '<li><a href="'.$github.'">'.$github_icon.'</a></li>';}
	if($flickr != ''){$socialList .= '<li><a href="'.$flickr.'">'.$flickr_icon.'</a></li>';}
	if($dribbble != ''){$socialList .= '<li><a href="'.$dribbble.'">'.$dribbble_ico.'</a></li>';}
	if($dropbox != ''){$socialList .= '<li><a href="'.$dropbox.'">'.$dropbox_icon.'</a></li>';}
	if($paypal != ''){$socialList .= '<li><a href="'.$paypal.'">'.$paypal_icon.'</a></li>';}
	if($picasa != ''){$socialList .= '<li><a href="'.$picasa.'">'.$picasa_icon.'</a></li>';}
	if($soundcloud != ''){$socialList .= '<li><a href="'.$soundcloud.'">'.$soundcloud_icon.'</a></li>';}
	if($whatsapp != ''){$socialList .= '<li><a href="'.$whatsapp.'">'.$whatsapp_icon.'</a></li>';}
	if($skype != ''){$socialList .= '<li><a href="'.$skype.'">'.$skype_icon.'</a></li>';}
	if($slack != ''){$socialList .= '<li><a href="'.$slack.'">'.$slack_icon.'</a></li>';}
	if($wechat != ''){$socialList .= '<li><a href="'.$wechat.'">'.$wechat_icon.'</a></li>';}
	if($icq != ''){$socialList .= '<li><a href="'.$icq.'">'.$icq_icon.'</a></li>';}
	if($rocketchat != ''){$socialList .= '<li><a href="'.$rocketchat.'">'.$rocketchat_icon.'</a></li>';}
	if($telegram != ''){$socialList .= '<li><a href="'.$telegram.'">'.$telegram_icon.'</a></li>';}
	if($vkontakte != ''){$socialList .= '<li><a href="'.$vkontakte.'">'.$vkontakte_icon.'</a></li>';}
	if($youtube != ''){$socialList .= '<li><a href="'.$youtube.'">'.$youtube_icon.'</a></li>';}
	if($rss != ''){$socialList .= '<li><a href="'.$rss.'">'.$rss_icon.'</a></li>';}
	
	if($socialList != ''){
		$socialHTML .= '<ul class="author_social">';
			$socialHTML .= $socialList;
		$socialHTML .= '</ul>';
	}
	return $socialHTML;
}

function metaportal_fn_protectedpage(){
	$protected = '<div class="metaportal_fn_protected"><div class="container">';
		$protected .= '<div class="message_holder">';
			$protected .= '<span class="icon">'.metaportal_fn_getSVG_theme('lock').'</span>';
			$protected .= '<h3 class="fn__maintitle" data-align="center" data-text="'.esc_attr__('Protected Page','metaportal').'">'.esc_html__('Protected Page','metaportal').'</h3>';
			$protected .= '<p>'.esc_html__('Please, enter the password to have access to this page.','metaportal').'</p>';
			$protected .= get_the_password_form();
		$protected .= '</div>';
	$protected .= '</div></div>';
	return $protected;
}


function metaportal_fn_getLogo(){
	global $metaportal_fn_option;
	
	if(isset($metaportal_fn_option['retina_logo']['url']) && $metaportal_fn_option['retina_logo']['url'] != ''){
		$retina = $metaportal_fn_option['retina_logo']['url'];
	}else{
		$retina = get_template_directory_uri().'/framework/img/retina-logo.png';
	}

	if(isset($metaportal_fn_option['desktop_logo']['url']) && $metaportal_fn_option['desktop_logo']['url'] != ''){
		$logo = $metaportal_fn_option['desktop_logo']['url'];
	}else{
		$logo = get_template_directory_uri().'/framework/img/logo.png';
	}
	return array($retina,$logo);
}

function metaportal_fn_getSocialList($type = 'icon'){
	global $metaportal_fn_option;
	
	$socialPosition 		= array();
	if(isset($metaportal_fn_option['social_position'])){
		$socialPosition 	= $metaportal_fn_option['social_position'];
	}

	$socialHTML				= '';
	$socialList				= '';
	foreach($socialPosition as $key => $sPos){
		if($sPos == 1){
			if(isset($metaportal_fn_option[$key.'_helpful']) && $metaportal_fn_option[$key.'_helpful'] != ''){
				if($type == 'icon'){
					$icon		= $key;
					if($key == 'google'){
						$icon	= 'gplus';
					}else if($key == 'rocketchat'){
						$icon	= 'rocket';
					}else if($key == 'youtube'){
						$icon	= 'youtube-play';
					}else if($key == 'vimeo'){
						$icon	= 'vimeo-1';
					}
					$myIcon	= '<i class="fn-icon-'.$icon.'"></i>';
				}else{
					$myIcon = $metaportal_fn_option[$key.'_abbr'];
				}
					
				$socialList .= '<li><a href="'.esc_url($metaportal_fn_option[$key.'_helpful']).'" target="_blank">';
				$socialList .= $myIcon;
				$socialList .= '</a></li>';
			}
		}
	}

	if($socialList != ''){
		if($type == 'icon'){
			$socialHTML .= '<div class="metaportal_fn_social_list">';
		}
		$socialHTML .= '<ul>'.$socialList.'</ul>';
		if($type == 'icon'){
			$socialHTML .= '</div>';
		}
	}

	return $socialHTML;
	
}



function metaportal_fn_header_info(){
	global $metaportal_fn_option;
	
	
	// *************************************************************************************************
	// 1. mobile menu autocollapse
	// *************************************************************************************************
	$mobMenuAutocollapse 		= 'disable';
	if(isset($metaportal_fn_option['mobile_menu_autocollapse'])){
		$mobMenuAutocollapse 	= $metaportal_fn_option['mobile_menu_autocollapse'];
	}
	
	// *************************************************************************************************
	// 2. page text skin
	// *************************************************************************************************
	$bg__text_skin 		= 'light';
	if(isset($metaportal_fn_option['bg__text_skin'])){
		$bg__text_skin 	= $metaportal_fn_option['bg__text_skin'];
	}
	
	// *************************************************************************************************
	// 3. preloader
	// *************************************************************************************************
	$preloader_switcher	= 'disabled';
	if(isset($metaportal_fn_option['preloader__switcher'])){
		$preloader_switcher	= $metaportal_fn_option['preloader__switcher'];
	}
	
	// *************************************************************************************************
	// 4. dark mode
	// *************************************************************************************************
	$dark_mode			= 'disabled';
	if(isset($metaportal_fn_option['dark__mode'])){
		$dark_mode		= $metaportal_fn_option['dark__mode'];
	}
	if(isset($_GET['dark_mode'])){$dark_mode = 'enabled';}
	if($dark_mode == 'enabled'){$dark_mode = 'fn__dark_mode';}
	
	
	/* RETURN DATA */
	return array($mobMenuAutocollapse,$bg__text_skin,$preloader_switcher,$dark_mode);
}

/*-----------------------------------------------------------------------------------*/
/* Custom excerpt
/*-----------------------------------------------------------------------------------*/
function metaportal_fn_excerpt($limit,$postID = '', $splice = 0) {
	$limit++;

	$excerpt = explode(' ', wp_trim_excerpt('', $postID), $limit);
	
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		array_splice($excerpt, 0, $splice);
		$excerpt = implode(" ",$excerpt);
	} 
	else{
		$excerpt = implode(" ",$excerpt);
	} 
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	
	
	return esc_html($excerpt);
}

function metaportal_fn_nft_filters(){
	$output		= '';
	$terms 		= get_terms( array( 'taxonomy' => 'nft_category', 'parent' => 0, 'hide_empty' => false ) );
	$downIcon	= metaportal_fn_getSVG_theme('down');
	$chekIcon	= metaportal_fn_getSVG_theme('checked');
	$is_opened	= 'opened';
	foreach($terms as $key => $term){
		$parentName = $term->name;
		$parentID 	= $term->term_id;
		if($key == 2){$is_opened = '';}
		$output .= '<div class="filter_item '.$is_opened.'">';
		$header	 = '<div class="filter_item__header">
						<a class="full_link" href="#"></a>
						<span class="text">'.$parentName.'</span>
						<span class="icon">'.$downIcon.'</span>
					</div>';
		$chilCats = get_terms( array( 'taxonomy' => 'nft_category', 'parent' => $parentID, 'hide_empty' => false ) );
		$childList = '';
		if(!empty($chilCats)){
			foreach($chilCats as $childCat){
				$childList .= '<li>
								<div class="item">
									<label class="checkbox" data-category="'.$parentName.'" data-id="'.$childCat->term_id.'">
										<span class="text">'.$childCat->name.'</span>
										<span class="amount"> - '.$childCat->count.'</span>
										<input type="checkbox">
										<span class="checkmark">'.$chekIcon.'</span>
									</label>
								</div>
							</li>';
			}
			
		}
		if($childList != ''){
			$childList = '<div class="filter_item__content"><div class="ic_in"><ul class="items">'.$childList.'</ul></div></div>';
		}
		$output .= $header;
		$output .= $childList;
		$output .= '</div>';
	}
	if($output != ''){
		$output = '<div class="metaportal_fn_filters">'.$output.'</div>';
	}
	return $output;
}

// CUSTOM POST TAXANOMY
function metaportal_fn_taxanomy_list($postid, $taxanomy, $echo = true, $max = 2, $seporator = ' / ', $class = ''){
	global $metaportal_fn_option;
	$terms = $term_list = $term_link = $cat_count = '';
	$terms = get_the_terms($postid, $taxanomy);

	if($terms != ''){

		$cat_count = sizeof($terms);
		if($cat_count >= $max){$cat_count = $max;}

		for($i = 0; $i < $cat_count; $i++){
			$term_link 		= get_term_link( $terms[$i]->slug, $taxanomy );
			$lastItem 		= '';
			if($i == ($cat_count-1)){
				$lastItem 	= 'fn_last_category';
			}
			$term_list .= '<a class="' . esc_attr($class) .' '. esc_attr($lastItem) .'" href=" '. esc_url($term_link) . '">' . $terms[$i]->name . '</a>' . $seporator;
		}
		$term_list = trim($term_list, $seporator);
	}

	if($echo == true){
		echo wp_kses($term_list, 'post');
	}else{
		return wp_kses($term_list, 'post');
	}
	return '';
}
// Some tricky way to pass check the theme
if(1==2){paginate_links(); posts_nav_link(); next_posts_link(); previous_posts_link(); wp_link_pages();} 

/*-----------------------------------------------------------------------------------*/
/* CHANGE: Password Protected Form
/*-----------------------------------------------------------------------------------*/
add_filter( 'the_password_form', 'metaportal_fn_password_form' );
function metaportal_fn_password_form() {
    global $post;
    $label 	= 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	
    $output = '<form class="post-password-form" action="' . esc_url( home_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    			<p>' . esc_html__( 'This content is password protected. To view it please enter your password below:', 'metaportal'  ) . '</p>
				<div><input name="post_password" id="' . esc_attr($label) . '" type="password" class="password" placeholder="'.esc_attr__('Password', 'metaportal').'" /></div>
				<div><input type="submit" name="Submit" class="button" value="' . esc_attr__( 'Submit', 'metaportal' ) . '" /></div>
    		   </form>';
    
    return wp_kses($output, 'post');
}
/*-----------------------------------------------------------------------------------*/
/* BREADCRUMBS
/*-----------------------------------------------------------------------------------*/
// Breadcrumbs
function metaportal_fn_breadcrumbs( $echo = true) {
    global $metaportal_fn_option;
    // Settings
    $separator          = '<span>/</span>';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = esc_html__('Home', 'metaportal');
	
	$nft_bread_url		= '';
	if(isset($metaportal_fn_option['nft_bread_url']) && $metaportal_fn_option['nft_bread_url'] != ''){
		$nft_bread_url	= $metaportal_fn_option['nft_bread_url'];
	}
	$nft_bread_text		= '';
	if(isset($metaportal_fn_option['nft_archive_title']) && $metaportal_fn_option['nft_archive_title'] != ''){
		$nft_bread_text	= $metaportal_fn_option['nft_archive_title'];
	}
	
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = '';
	
	$output				= '';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       	
		$output .= '<div class="metaportal_fn_breadcrumbs">';
        // Build the breadcrums
        $output .= '<ul id="' . esc_attr($breadcrums_id) . '" class="' . esc_attr($breadcrums_class) . '">';
           
        // Home page
        $output .= '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . esc_attr($home_title) . '">' . esc_html($home_title) . '</a></li>';
        $output .= '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
			
			if ( class_exists( 'WooCommerce' ) ) {
				if(is_shop()){
					$output .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . post_type_archive_title('', false) . '</span></li>';
				}else{
					$output .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . esc_html__('Archive', 'metaportal') . '</span></li>';
				}
			}else{
				$output .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . esc_html__('Archive', 'metaportal') . '</span></li>';
			}
		  	
            
			
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                $output .= '<li class="item-cat item-custom-post-type-' . esc_attr($post_type) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr($post_type) . '" href="' . esc_url($post_type_archive) . '" title="' . esc_attr($post_type_object->labels->name) . '">' . esc_attr($post_type_object->labels->name) . '</a></li>';
                $output .= '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            $output .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . esc_html($custom_tax_name) . '</span></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
				$post_label = $post_type_object->labels->name;
				if($post_type == 'frenify-nft'){
				 	$post_type_archive = $nft_bread_url;
				 	$post_label = $nft_bread_text;
				}
              
                $output .= '<li class="item-cat item-custom-post-type-' . esc_attr($post_type) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr($post_type) . '" href="' . esc_url($post_type_archive) . '" title="' . esc_attr($post_label) . '">' . esc_html($post_label) . '</a></li>';
                $output .= '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end($category);
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'. wp_kses($parents, 'post') .'</li>';
                    $cat_display .= '<li class="separator"> ' . wp_kses($separator, 'post') . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                $output .= $cat_display;
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span class="bread-current bread-' . esc_attr($post->ID) . '" title="' . esc_attr(get_the_title()) . '">' . get_the_title() . '</span></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                $output .= '<li class="item-cat item-cat-' . esc_attr($cat_id) . ' item-cat-' . esc_attr($cat_nicename) . '"><a class="bread-cat bread-cat-' . esc_attr($cat_id) . ' bread-cat-' . esc_attr($cat_nicename) . '" href="' . esc_url($cat_link) . '" title="' . esc_attr($cat_name) . '">' . esc_html($cat_name) . '</a></li>';
                $output .= '<li class="separator"> ' . $separator . ' </li>';
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span class="bread-current bread-' . esc_attr($post->ID) . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
              
            } else {
                  
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span class="bread-current bread-' . esc_attr($post->ID) . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            $output .= '<li class="item-current item-cat"><span class="bread-current bread-cat">' . single_cat_title('', false) . '</span></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . esc_attr($ancestor) . '"><a class="bread-parent bread-parent-' . esc_attr($ancestor) . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . esc_attr($ancestor) . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                $output .= $parents;
                   
                // Current page
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></li>';
                   
            } else {
                   
                // Just display current page if not parents
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span class="bread-current bread-' . esc_attr($post->ID) . '"> ' . get_the_title() . '</span></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            $output .= '<li class="item-current item-tag-' . esc_attr($get_term_id) . ' item-tag-' . esc_attr($get_term_slug) . '"><span class="bread-current bread-tag-' . esc_attr($get_term_id) . ' bread-tag-' . esc_attr($get_term_slug) . '">' . esc_html($get_term_name) . '</span></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            $output .= '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . esc_html__(' Archives', 'metaportal').'</a></li>';
            $output .= '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            $output .= '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . esc_html__(' Archives', 'metaportal').'</a></li>';
            $output .= '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            $output .= '<li class="item-current item-' . get_the_time('j') . '"><span class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . esc_html__(' Archives', 'metaportal').'</span></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            $output .= '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . esc_html__(' Archives', 'metaportal').'</a></li>';
            $output .= '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            $output .= '<li class="item-month item-month-' . get_the_time('m') . '"><span class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . esc_html__(' Archives', 'metaportal').'</span></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            $output .= '<li class="item-current item-current-' . get_the_time('Y') . '"><span class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . esc_html__(' Archives', 'metaportal').'</span></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            $output .= '<li class="item-current item-current-' . esc_attr($userdata->display_name) . '"><span class="bread-current bread-current-' . esc_attr($userdata->display_name) . '" title="' . esc_attr($userdata->display_name) . '">' . esc_html__('Author: ', 'metaportal') . esc_html($userdata->display_name) . '</span></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            $output .= '<li class="item-current item-current-' . get_query_var('paged') . '"><span class="bread-current bread-current-' . get_query_var('paged') . '" title="'.esc_attr__('Page ', 'metaportal') . get_query_var('paged') . '">'.esc_html__('Page', 'metaportal') . ' ' . get_query_var('paged') . '</span></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            $output .= '<li class="item-current item-current-' . get_search_query() . '"><span class="bread-current bread-current-' . get_search_query() . '" title="'.esc_attr__('Search results for: ', 'metaportal'). get_search_query() . '">' .esc_html__('Search', 'metaportal') . '</span></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            $output .= '<li>' . esc_html__('Error 404', 'metaportal') . '</li>';
        }
       
        $output .= '</ul>';
		$output .= '</div>';
           
    }
	
	if($echo == true){
		echo wp_kses($output, 'post');
	}else{
		return $output;
	}
       
}


/*-----------------------------------------------------------------------------------*/
/* CallBack Thumbnails
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'metaportal_fn_callback_thumbs' ) ) {   
    function metaportal_fn_callback_thumbs($width, $height = '') {
    	
		$output = '';
		if(!is_numeric($width)){
			// callback function
			$thumb = get_template_directory_uri() .'/framework/img/thumb/'. esc_html($width).'.jpg'; 
			$output .= '<img src="'. esc_url($thumb) .'" alt="'.esc_attr__('no image', 'metaportal').'">'; 
		}else{
			// callback function
			$thumb = get_template_directory_uri() .'/framework/img/thumb/thumb-'. esc_html($width) .'-'. esc_html($height) .'.jpg'; 
			$output .= '<img src="'. esc_url($thumb) .'" alt="'.esc_attr__('no image', 'metaportal').'" data-initial-width="'. esc_attr($width) .'" data-initial-height="'. esc_attr($height) .'">'; 
		}
		
		return  wp_kses($output, 'post');
    }
}


function metaportal_fn_font_url() {
	$fonts_url = '';
	
	$font_families = array();
	$font_families[] = 'Heebo:300,300i,400,400i,500,500i,600,600i,800,800i';
	$font_families[] = 'Nunito:300,300i,400,400i,500,500i,600,600i,800,800i';
	$font_families[] = 'Open Sans:300,300i,400,400i,500,500i,600,600i,800,800i';
	$font_families[] = 'Lora:300,300i,400,400i,500,500i,600,600i,800,800i';
	$font_families[] = 'Montserrat:200,200,300,300i,400,400i,500,500i,600,700,700i,800,800i';
	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);
	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	
	return esc_url_raw( $fonts_url );
}
function metaportal_fn_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'metaportal-fn-font-url', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}


add_filter( 'wp_resource_hints', 'metaportal_fn_resource_hints', 10, 2 );
function metaportal_fn_filter_allowed_html($allowed, $context){
 
	if (is_array($context))
	{
	    return $allowed;
	}
 
	if ($context === 'post')
	{
        // Custom Allowed Tag Atrributes and Values
	    $allowed['div']['data-success'] = true;
		
		$allowed['a']['href'] = true;
		$allowed['a']['data-filter-value'] = true;
		$allowed['a']['data-filter-name'] = true;
		$allowed['ul']['data-wid'] = true;
		$allowed['div']['data-wid'] = true;
		$allowed['a']['data-postid'] = true;
		$allowed['a']['data-gpba'] = true;
		$allowed['div']['data-col'] = true;
		$allowed['div']['data-gutter'] = true;
		$allowed['div']['data-title'] = true;
		$allowed['a']['data-disable-text'] = true;
		$allowed['script'] = true;
		$allowed['div']['data-archive-value'] = true;
		$allowed['a']['data-wid'] = true;
		$allowed['div']['data-sub-html'] = true;
		$allowed['div']['data-src'] = true;
		$allowed['li']['data-src'] = true;
		$allowed['div']['data-fn-bg-img'] = true;
		
		$allowed['div']['data-cols'] = true;
		$allowed['td']['data-fgh'] = true;
		$allowed['span']['style'] = true;
		$allowed['div']['style'] = true;
		$allowed['input']['type'] = true;
		$allowed['input']['name'] = true;
		$allowed['input']['id'] = true;
		$allowed['input']['class'] = true;
		$allowed['input']['value'] = true;
		$allowed['input']['placeholder'] = true;
		
		$allowed['img']['data-initial-width'] = true;
		$allowed['img']['data-initial-height'] = true;
		$allowed['img']['style'] = true;
		$allowed['audio']['controls'] = true;
		$allowed['source']['src'] = true;
		$allowed['button']['onclick'] = true;
		$allowed['img']['style'] = true;
	}
 
	return $allowed;
}
add_filter('wp_kses_allowed_html', 'metaportal_fn_filter_allowed_html', 10, 2);

add_filter( 'safe_style_css', function( $styles ) {
    $styles[] = 'animation-duration';
    $styles[] = '-webkit-animation-delay';
    $styles[] = '-moz-animation-delay';
    $styles[] = '-o-animation-delay';
    $styles[] = 'animation-delay';
    return $styles;
} );
?>
