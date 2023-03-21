<?php
function metaportal_fn_pagination($pages = '', $range = 1, $home = 0, $type = 3, $echo = true, $paged = ''){  
	$currentPage 	= '';
	$showitems 		= ($range * 1) + 1;
	$output			= '';
	
	global $metaportal_fn_paged;
    
	if(get_query_var('paged')){
		$metaportal_fn_paged = get_query_var('paged');
	}elseif(get_query_var('page')) {
		$metaportal_fn_paged = get_query_var('page');
	}else {
		$metaportal_fn_paged = 1;
	}
	if($paged != ''){
		$metaportal_fn_paged = $paged;
	}

	global $wp_query;
	if($pages == ''){
		$pages = $wp_query->max_num_pages;
		if(!$pages){$pages = 1;}
	}


	if(1 != $pages){
		$output .= '<div class="metaportal_fn_pagination fn_type_'.$type.'"><div class="container"><ul>';
		if($type == 4){
			for ($i=1; $i <= $pages; $i++){
				if($metaportal_fn_paged == $i){
					$output .= '<li><a class="current" href="#">'.$i.'<input type="hidden" value="'.$i.'" /></a></li>';
				}else{
					$output .= '<li><a href="#">'.$i.'<input type="hidden" value="'.$i.'" /></a></li>';
				}
			}
		}else{
			if($metaportal_fn_paged > 1 && $showitems < $pages && $type == 1){
				$output .= "<li><a href='".get_pagenum_link(1)."' title='".esc_attr__('first','metaportal')."'>&larr; </a></li>";
			}
			$list = '';
			for ($i=1; $i <= $pages; $i++){
				if (1 != $pages &&( !($i >= $metaportal_fn_paged+$range+1 || $i <= $metaportal_fn_paged-$range-1) || $pages <= $showitems )){
					if($home == 1){
						if($metaportal_fn_paged == $i){
							$list .= "<li><span class='current'>".esc_html($i)."</span></li>";
						}else{
							$list .= "<li><a href='".esc_url(add_query_arg( 'page', $i))."' class='inactive' >".esc_html($i)."</a></li>";
						}
					}else{
						if($metaportal_fn_paged == $i){
							$list .= "<li class='active'><span class='current'>".esc_html($i)."</span></li>";
						}else{
							$list .= "<li><a href='".esc_url( get_pagenum_link($i))."' class='inactive' >".esc_html($i)."</a></li>";
						}
					}
					if($metaportal_fn_paged == $i){
						$currentPage = $i;
					}
				}
			}
			if($currentPage != 1 && $type != 1){
				$output .= "<li class='prev'><a href='".esc_url( get_pagenum_link($currentPage-1))."' class='inactive'>".esc_html__('Prev','metaportal')."<span></span></a></li>";
			}
			$output .= $list;
			if($metaportal_fn_paged < $pages && $showitems < $pages && $type == 1){
				$output .= "<li><a href='".esc_url( get_pagenum_link($pages))."' title='".esc_attr__('last','metaportal')."'>&rarr;</a></li>";
			}
			if($type == 1){
				$output .= '<li class="view"><p>'.sprintf('%s %s %s %s',esc_html__('Viewing page', 'metaportal'), $currentPage, esc_html__('of', 'metaportal'), $pages).'</p></li>';
			}

			if($currentPage < $pages && $type != 1){
				$output .= "<li class='next'><a href='".esc_url( get_pagenum_link($currentPage+1))."' class='inactive'>".esc_html__('Next','metaportal')."<span></span></a></li>";
			}
		}
			

		$output .= "</ul></div></div>\n";
	}
	if($echo){
		echo wp_kses($output, 'post');
	}else{
		return $output;
	}
	
}



?>
