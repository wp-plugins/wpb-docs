<?php
class Custom_Post_Type_Doc
	{
	protected $plugin_slug = 'wpb-docs';
	private $token = 'doc';

	protected $pluginUrl ;
		/* Class constructor */
		public function __construct()
		{
			// Set some important variables
			$this->pluginUrl = WP_PLUGIN_URL .'/'. $this->plugin_slug;  	
			
			// Add action to register the post type, if the post type doesnt exist
			if( ! post_type_exists( $this->token ) )
			{
				add_action( 'init', array( &$this, $this->token.'_init' ) );
			}
		add_filter( 'enter_title_here', array( &$this, 'enter_title_here' ) );
		
		// Allows filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( &$this, 'add_taxonomy_filters' ) );
		
		// Show post counts in the dashboard
		add_action( 'right_now_content_table_end', array( &$this, 'add_'.$this->token.'_counts' ) );
		
		}
		
		/* Method which registers the post type */
		public 	function doc_init() {
	
		/**
		 * Enable the Custom Post Type
		 * http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		$labels = array(
			'name'                => _x( 'Documents', 'Post Type General Name', $this->plugin_slug ),
			'singular_name'       => _x( 'Document', 'Post Type Singular Name', $this->plugin_slug ),
			'menu_name'           => __( 'Documents', $this->plugin_slug ),
			'parent_item_colon'   => __( 'Parent Document:', $this->plugin_slug ),
			'all_items'           => __( 'All Documents', $this->plugin_slug ),
			'view_item'           => __( 'View Document', $this->plugin_slug ),
			'add_new_item'        => __( 'Add New Document', $this->plugin_slug ),
			'add_new'             => __( 'New Document', $this->plugin_slug ),
			'edit_item'           => __( 'Edit Document', $this->plugin_slug ),
			'update_item'         => __( 'Update Document', $this->plugin_slug ),
			'search_items'        => __( 'Search Documents', $this->plugin_slug ),
			'not_found'           => __( 'No documents found', $this->plugin_slug ),
			'not_found_in_trash'  => __( 'No documents found in Trash', $this->plugin_slug ),
		);
	
		$rewrite = array(
			'slug'            		=> $this->token,
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => false,
		);
	
		$args = array(
			'label'               => __( 'doc', $this->plugin_slug ),
			'description'         => __( 'Document information pages', $this->plugin_slug ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', ),
			'taxonomies'          => array( 'doc_category' ),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'      			=> $this->pluginUrl . '/assets/img/icon.png',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'query_var'           => $this->token,
			'rewrite'             => $rewrite,
			'capability_type'     => 'page',
		);
	
		register_post_type( $this->token, $args );
		
		/**
		 * Register a taxonomy for Custom Post Type Categories
		 * http://codex.wordpress.org/Function_Reference/register_taxonomy
		 */
	    $doc_category_labels = array(
			'name' => _x( 'Categories', $this->plugin_slug ),
			'singular_name' => _x( 'Category', $this->plugin_slug ),
			'search_items' => _x( 'Search Categories', $this->plugin_slug ),
			'popular_items' => _x( 'Popular Categories', $this->plugin_slug ),
			'all_items' => _x( 'All Categories', $this->plugin_slug ),
			'parent_item' => _x( 'Parent Category', $this->plugin_slug ),
			'parent_item_colon' => _x( 'Parent Category:', $this->plugin_slug ),
			'edit_item' => _x( 'Edit Category', $this->plugin_slug ),
			'update_item' => _x( 'Update Category', $this->plugin_slug ),
			'add_new_item' => _x( 'Add New Category', $this->plugin_slug ),
			'new_item_name' => _x( 'New Category Name', $this->plugin_slug ),
			'separate_items_with_commas' => _x( 'Separate categories with commas', $this->plugin_slug ),
			'add_or_remove_items' => _x( 'Add or remove categories', $this->plugin_slug ),
			'choose_from_most_used' => _x( 'Choose from the most used categories', $this->plugin_slug ),
			'menu_name' => _x( 'Categories', $this->plugin_slug ),
	    );
		
	    $doc_category_args = array(
			'labels' => $doc_category_labels,
			'public' => true,
			'show_in_nav_menus' => false,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_tagcloud' => true,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => 'doc-category' ),
			'query_var' => true
	    );
		
	    register_taxonomy( 'doc_category', array( $this->token ), $doc_category_args );

	}
		
	/**
	 * Flushes rewrite rules on plugin activation to ensure custom post type don't 404
	 * http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
	 */
	function plugin_activation() {
		$this->testimonials_init();
		flush_rewrite_rules();
	}

	/**
	 * Adds taxonomy filters to the custom post type admin page
	 * Code artfully lifed from http://pippinsplugins.com
	 */
	function add_taxonomy_filters() {
		global $typenow;
		
		// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array( 'doc_category' );
	 
		// must set this to the post type you want the filter(s) displayed on
		if ( $typenow == 'doc' ) {
	 
			foreach ( $taxonomies as $tax_slug ) {
				$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms($tax_slug);
				if ( count( $terms ) > 0) {
					echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
					echo "<option value=''>$tax_name</option>";
					foreach ( $terms as $term ) {
						echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
					}
					echo "</select>";
				}
			}
		}
	}
	
	/**
	 * Add Custom Post Type count to "Right Now" Dashboard Widget
	 */
	function add_doc_counts() {
	        if ( ! post_type_exists( $this->token ) ) {
	             return;
	        }
	
	        $num_posts = wp_count_posts( $this->token );
	        $num = number_format_i18n( $num_posts->publish );
	        $text = _n( 'Documents Items', 'Document Items', intval($num_posts->publish) );
	        if ( current_user_can( 'edit_posts' ) ) {
	            $num = "<a href='edit.php?post_type=doc'>$num</a>";
	            $text = "<a href='edit.php?post_type=doc'>$text</a>";
	        }
	        echo '<td class="first b b-doc">' . $num . '</td>';
	        echo '<td class="t doc">' . $text . '</td>';
	        echo '</tr>';
	
	        if ($num_posts->pending > 0) {
	            $num = number_format_i18n( $num_posts->pending );
	            $text = _n( 'docs Item Pending', 'docs Items Pending', intval($num_posts->pending) );
	            if ( current_user_can( 'edit_posts' ) ) {
	                $num = "<a href='edit.php?post_status=pending&post_type=doc'>$num</a>";
	                $text = "<a href='edit.php?post_status=pending&post_type=doc'>$text</a>";
	            }
	            echo '<td class="first b b-docs">' . $num . '</td>';
	            echo '<td class="t docs">' . $text . '</td>';
	
	            echo '</tr>';
	        }
	}


	//Customise the "Enter title here" text.
	function enter_title_here ( $title ) {
  global $post;

		if( $this->token == $post->post_type ) {
			$title = __( 'Enter the section\'s name here', $this->plugin_slug );
		}
		return $title;
	} // End enter_title_here()

}
		
new Custom_Post_Type_Doc;

?>