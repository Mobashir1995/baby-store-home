<?php
/**
 *
 * Template Name: Template Home
 *
 */
 get_header();
the_post();

?>
		<!-- Banner -->
		<section class="m-t-40 m-t-xs-0">
			<div class="container">
				<div class="banner banner-1 bg-img-3 position-left bg-size-2 p-0">
					<div class="row">
						<div class="col-sm-8 col-md-7 col-lg-6 pull-right float-none-xs text-right">
							<div class="caption-2">
								<h3 class="heading-size-5">Gift for kids</h3>
								<h1 class="heading-size-1 color-4">Save</h1>
								<h4 class="heading-size-4 color-c">up to 25% off</h4>
								<div class="heading-size-2 color-3 m-t-10">$176.0</div>
								<a href="#" class="btn ht-btn p-5"><i class="fa fa-long-arrow-right"></i> Shop now</a>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</section>
		<!-- Product tabs -->
		<section>
			<div class="container">
				<div class="ht-tabs ht-tabs-product text-center">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs m-b-20" role="tablist">
						<li role="presentation" class="active">
							<a href="#tab-description" aria-controls="tab-description" role="tab" data-toggle="tab">New Products</a>
						</li>
						<li role="presentation">
							<a href="#tab-special" aria-controls="tab-special" role="tab" data-toggle="tab">Special</a>
						</li>
						<li role="presentation">
							<a href="#tab-best-seller" aria-controls="tab-best-seller" role="tab" data-toggle="tab">Best Seller</a>
						</li>
					</ul>
					<!-- Tab panes -->

					<div class="tab-content">
					<?php
					 the_content();
						$new_products = new WP_Query(
											array(
												'post_type'	=>	'product',
												'posts_per_page'  => 4,
												'orderby'	=>	'date',
												'order'	=>	'DESC',
											)
										);
						if( $new_products->have_posts() ){ 
					?>
						<div role="tabpanel" class="tab-pane active" id="tab-description">
							<div class="row product-bor">
							<?php while( $new_products->have_posts() ){ $new_products->the_post(); global $product; ?>
								<div class="col-sm-6 col-md-3">
									<!-- Product item -->
									<div class="product-item hover-img">
										<a href="<?php the_permalink(); ?>" class="product-img">
											<?php if(has_post_thumbnail()){ the_post_thumbnail('medium'); } ?>
										</a>
										<div class="product-caption">
											<h4 class="product-name">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h4>
											<div class="product-price-group">
<?php if( $product->is_on_sale() ) {
        echo $product->get_sale_price();
    }?>
												<span class="product-price-old"><?php if($product->get_price() < $product->get_regular_price() ){ echo wc_price($product->get_regular_price()); } ?></span>
												<span class="product-price"><?php echo wc_price($product->get_price()); ?></span>
											</div>
										</div>
										<div class="absolute-caption">
											<a href="#"><i class="fa fa-heart-o"></i></a>
											<a href="#"><i class="fa fa-exchange"></i></a>
											<a href="<?php echo esc_url($product->add_to_cart_url()); ?>"><i class="fa fa-cart-plus"></i></a>
											<?php woocommerce_template_loop_add_to_cart( $new_products->post, $product ); ?>
										</div>
									</div>
								</div>
							<?php } wp_reset_postdata(); ?>
							</div>
						</div>
					<?php } ?>

					<?php
					    $tax_query   = WC()->query->get_tax_query();
					    $tax_query[] = array(
					        'taxonomy' => 'product_visibility',
					        'field'    => 'name',
					        'terms'    => 'featured',
					        'operator' => 'IN',
					    );

					    $args = array(
					        'post_type'           => 'product',
					        'post_status'         => 'publish',
					        'ignore_sticky_posts' => 1,
					        'posts_per_page'      => 4,
					        'tax_query'           => $tax_query,
					    );
						// $special_products = new WP_Query(array(
						// 					    'post_type' => 'product',
						// 					    'posts_per_page' => 12,
						// 					    'tax_query' => array(
						// 					            array(
						// 					                'taxonomy' => 'product_visibility',
						// 					                'field'    => 'name',
						// 					                'terms'    => 'featured',
						// 					            ),
						// 					        ),
						// 					    ));
						$special_products = new WP_Query( $args );
						if( $special_products->have_posts() ){ 
					?>
						<div role="tabpanel" class="tab-pane" id="tab-special">		
							<div class="row product-bor">
							<?php while( $special_products->have_posts() ){ $special_products->the_post(); global $product; ?>
								<div class="col-sm-6 col-md-3">
									<!-- Product item -->
									<div class="product-item hover-img">
										<a href="<?php the_permalink(); ?>" class="product-img">
											<?php if(has_post_thumbnail()){ the_post_thumbnail('medium'); } ?>
										</a>
										<div class="product-caption">
											<h4 class="product-name">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h4>
											<div class="product-price-group">
												<span class="product-price-old"><?php if($product->get_price() < $product->get_regular_price() ){ echo wc_price($product->get_regular_price()); } ?></span>
												<span class="product-price"><?php echo wc_price($product->get_price()); ?></span>
											</div>
										</div>
										<div class="absolute-caption">
											<a href="#"><i class="fa fa-heart-o"></i></a>
											<a href="#"><i class="fa fa-exchange"></i></a>
											<a href="<?php echo esc_url($product->add_to_cart_url()); ?>"><i class="fa fa-cart-plus"></i></a>
											<?php woocommerce_template_loop_add_to_cart( $new_products->post, $product ); ?>
										</div>
									</div>
								</div>
							<?php } wp_reset_postdata(); ?>
							</div>
						</div>
					<?php } ?>
					
					<?php
						$best_selling = new WP_Query(array(
											    	'post_type' => 'product',
													'orderby'   => 'meta_value_num',
													'meta_key'  => 'total_sales',
													'posts_per_page' => 4,
											    )
											);						
					?>
						<div role="tabpanel" class="tab-pane" id="tab-best-seller">		
							<div class="row product-bor">
							<?php if( $best_selling->have_posts() ){  while( $best_selling->have_posts() ){ $best_selling->the_post(); global $product; ?>
								<div class="col-sm-6 col-md-3">
									<!-- Product item -->
									<div class="product-item hover-img">
										<a href="<?php the_permalink(); ?>" class="product-img">
											<?php if(has_post_thumbnail()){ the_post_thumbnail('medium'); } ?>
										</a>
										<div class="product-caption">
											<h4 class="product-name">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h4>
											<div class="product-price-group">
												<span class="product-price"><?php echo wc_price($product->get_price()); ?></span>
											</div>
										</div>
										<div class="absolute-caption">
											<a href="#"><i class="fa fa-heart-o"></i></a>
											<a href="#"><i class="fa fa-exchange"></i></a>
											<a href="<?php echo esc_url($product->add_to_cart_url()); ?>"><i class="fa fa-cart-plus"></i></a>
											<?php woocommerce_template_loop_add_to_cart( $new_products->post, $product ); ?>
										</div>
									</div>
								</div>
							<?php } wp_reset_postdata(); } ?>
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>
		<?php print_r( woocommerce_catalog_ordering() ); ?>
		<!-- Newsletter -->
		<section class="text-center m-t-30">
			<div class="container">
				<div class="newsletter newsletter-1">
					<h3 class="title">Subscribe to our Newsletters</h3>
					<p>Lorem ipsum dolor sit amet consectetur Lorem ipsum dolor dolor sit amet consectetur</p>	
					<form>
						<input type="text" class="form-item" placeholder="Enter your email">
						<button type="button"><i class="fa fa-paper-plane-o"></i></button>
					</form>
					<img src="<?php echo get_template_directory_uri(); ?>/images/default4.png" class="w-80" alt="image">
				</div>
			</div>
		</section>
		<!-- Product slider-->
		<section class="text-center">
			<div class="container">
				<h3 class="title m-b-20">New Products</h3>
				<div class="row product-bor">
					<div class="owl" data-items="4" data-itemsDesktop="3" data-itemsDesktopSmall="2" data-itemsTablet="2" data-itemsMobile="1" data-transitionstyle="backslide" data-singleItem="false" data-autoplay="false" data-pag="false" data-buttons="true">
						<div class="col-lg-12">
							<!-- Product item -->
							<div class="product-item hover-img">
								<a href="product_detail.html" class="product-img">
									<img src="<?php echo get_template_directory_uri(); ?>/images/default.png" alt="image">
								</a>
								<div class="product-caption">
									<h4 class="product-name">
										<a href="#">Lorem ipsum dolor sit amet</a>
									</h4>
									<div class="product-price-group">
										<span class="product-price">$64.00</span>
									</div>
								</div>
								<div class="absolute-caption">
									<a href="#"><i class="fa fa-heart-o"></i></a>
									<a href="#"><i class="fa fa-exchange"></i></a>
									<a href="#"><i class="fa fa-cart-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<!-- Product item -->
							<div class="product-item hover-img">
								<a href="product_detail.html" class="product-img">
									<img src="<?php echo get_template_directory_uri(); ?>/images/default.png" alt="image">
								</a>
								<div class="product-caption">
									<h4 class="product-name">
										<a href="#">Lorem ipsum dolor sit amet</a>
									</h4>
									<div class="product-price-group">
										<span class="product-price">$6,00</span>
									</div>
								</div>
								<div class="absolute-caption">
									<a href="#"><i class="fa fa-heart-o"></i></a>
									<a href="#"><i class="fa fa-exchange"></i></a>
									<a href="#"><i class="fa fa-cart-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<!-- Product item -->
							<div class="product-item hover-img">
								<a href="product_detail.html" class="product-img">
									<img src="<?php echo get_template_directory_uri(); ?>/images/default.png" alt="image">
								</a>
								<div class="product-caption">
									<h4 class="product-name">
										<a href="#">Lorem ipsum dolor sit amet</a>
									</h4>
									<div class="product-price-group">
										<span class="product-price">$6,00</span>
									</div>
								</div>
								<div class="absolute-caption">
									<a href="#"><i class="fa fa-heart-o"></i></a>
									<a href="#"><i class="fa fa-exchange"></i></a>
									<a href="#"><i class="fa fa-cart-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<!-- Product item -->
							<div class="product-item hover-img">
								<a href="product_detail.html" class="product-img">
									<img src="<?php echo get_template_directory_uri(); ?>/images/default.png" alt="image">
								</a>
								<div class="product-caption">
									<h4 class="product-name">
										<a href="#">Lorem ipsum dolor sit amet</a>
									</h4>
									<div class="product-price-group">
										<span class="product-price">$64.00</span>
									</div>
								</div>
								<div class="absolute-caption">
									<a href="#"><i class="fa fa-heart-o"></i></a>
									<a href="#"><i class="fa fa-exchange"></i></a>
									<a href="#"><i class="fa fa-cart-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<!-- Product item -->
							<div class="product-item hover-img">
								<a href="product_detail.html" class="product-img">
									<img src="<?php echo get_template_directory_uri(); ?>/images/default.png" alt="image">
								</a>
								<div class="product-caption">
									<h4 class="product-name">
										<a href="#">Lorem ipsum dolor sit amet</a>
									</h4>
									<div class="product-price-group">
										<span class="product-price">$64.00</span>
									</div>
								</div>
								<div class="absolute-caption">
									<a href="#"><i class="fa fa-heart-o"></i></a>
									<a href="#"><i class="fa fa-exchange"></i></a>
									<a href="#"><i class="fa fa-cart-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<!-- Product item -->
							<div class="product-item hover-img">
								<a href="product_detail.html" class="product-img">
									<img src="<?php echo get_template_directory_uri(); ?>/images/default.png" alt="image">
								</a>
								<div class="product-caption">
									<h4 class="product-name">
										<a href="#">Lorem ipsum dolor sit amet</a>
									</h4>
									<div class="product-price-group">
										<span class="product-price">$64.00</span>
									</div>
								</div>
								<div class="absolute-caption">
									<a href="#"><i class="fa fa-heart-o"></i></a>
									<a href="#"><i class="fa fa-exchange"></i></a>
									<a href="#"><i class="fa fa-cart-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<!-- Product item -->
							<div class="product-item hover-img">
								<a href="product_detail.html" class="product-img">
									<img src="<?php echo get_template_directory_uri(); ?>/images/default.png" alt="image">
								</a>
								<div class="product-caption">
									<h4 class="product-name">
										<a href="#">Lorem ipsum dolor sit amet</a>
									</h4>
									<div class="product-price-group">
										<span class="product-price">$64.00</span>
									</div>
								</div>
								<div class="absolute-caption">
									<a href="#"><i class="fa fa-heart-o"></i></a>
									<a href="#"><i class="fa fa-exchange"></i></a>
									<a href="#"><i class="fa fa-cart-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<!-- Product item -->
							<div class="product-item hover-img">
								<a href="product_detail.html" class="product-img">
									<img src="<?php echo get_template_directory_uri(); ?>/images/default.png" alt="image">
								</a>
								<div class="product-caption">
									<h4 class="product-name">
										<a href="#">Lorem ipsum dolor sit amet</a>
									</h4>
									<div class="product-price-group">
										<span class="product-price">$64.00</span>
									</div>
								</div>
								<div class="absolute-caption">
									<a href="#"><i class="fa fa-heart-o"></i></a>
									<a href="#"><i class="fa fa-exchange"></i></a>
									<a href="#"><i class="fa fa-cart-plus"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Brand logo -->
		<div class="m-t-60">
			<div class="container">
				<div class="brand">
					<div class="row">
						<div class="owl" data-items="6" data-itemsDesktop="5" data-itemsDesktopSmall="3" data-itemsTablet="2" data-itemsMobile="1" data-transitionstyle="backslide" data-singleItem="false" data-autoplay="true" data-pag="false" data-buttons="false">
							<div class="col-lg-12">
								<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/default.png" alt="image"></a>
							</div>
							<div class="col-lg-12">
								<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/default.png" alt="image"></a>
							</div>
							<div class="col-lg-12">
								<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/default.png" alt="image"></a>
							</div>
							<div class="col-lg-12">
								<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/default.png" alt="image"></a>
							</div>
							<div class="col-lg-12">
								<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/default.png" alt="image"></a>
							</div>
							<div class="col-lg-12">
								<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/default.png" alt="image"></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
		<div class="bg-landscape1"></div>
	<?php get_footer(); ?>
