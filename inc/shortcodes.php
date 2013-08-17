<?php
function wpb_docs_shortcode( $atts ) {
    
	extract( shortcode_atts( array( 'posts_per_page' => -1, 'post_type' => 'doc', 'doc_category'=>'', 'order' => 'DESC', 'orderby' =>'menu_order'), $atts ) ); 
						
	global $post;
	global $paged;
	$loop = new WP_Query(  array ( 
		'posts_per_page' => $posts_per_page, 
		'post_type' => $post_type, 
		'order' => 'DESC', 
		'orderby' =>'menu_order', 
		'doc_category'=>$doc_category,        
		'paged' => $paged ) );
?>
	<div class="content">
		<div class="row">	
			<div class="col-lg-3">
				<div class="bs-sidebar" data-spy="affix" data-offset-top="250" >
					<ul class="nav bs-sidenav">
						<?php  while ( $loop->have_posts() ) : $loop->the_post(); ?>
						<li><a href="#post-<?php the_ID(); ?>"><?php the_title(); ?></a></li>
						<?php endwhile; ?>
					</ul>
				</div>
			</div>		
			<div class="col-lg-9">
			
				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
  			<section class="bs-docs-section clearfix">			
						<div class="page-header">
							<h1><?php permalink_anchor();?><?php the_title(); ?></h1>
						</div>
						<?php the_content(); ?>		
				</section>
				<?php endwhile; ?>		
			</div>			
		</div>
	</div>
	<div class="clearboth"></div>
<?php  wp_reset_query(); 
}

function register_shortcodes(){
	add_shortcode( 'wpb_docs', 'wpb_docs_shortcode' );
}
add_action( 'init', 'register_shortcodes');