<?php
function create_slider_js($ID,$options){
	$containerID = "swiper$ID";
	?>
	<script>var <?php echo $containerID;?> = new Swiper('#<?php echo $containerID;?>',{
		autoHeight: true,
		<?php 
		if($options['pager'] == 'pagination' ){ 
			echo "pagination: {
				el: '.swiper-pagination',
				clickable: true,
			  },";
			}else{
					echo "navigation: {
						nextEl: '.swiper-button-next',
						prevEl: '.swiper-button-prev',
					  },";
				}
			 
		if($options['effect'] == 'coverflow' ){ 
				 echo "   effect: 'coverflow',
						  centeredSlides: true,
						  coverflowEffect: {
							rotate: 50,
							stretch: 0,
							depth: 100,
							modifier: 1,
							slideShadows: false,
						  },";
		}
		if($options['effect'] == 'fade' ){ 
			echo 'effect: "fade",';
		}
		if($options['autoplay'] != '' ){ 
			echo "autoplay: {
				delay: ". $options['autoplay'].",
				disableOnInteraction: false,
			  },";
		}
		if($options['initialSlide'] != '' ){ 
			echo 'initialSlide: '.$options['initialSlide'].',';
		}
		if($options['slidesPerView'] != '' ){ 
			echo 'slidesPerView: '.$options['slidesPerView'].',';
		}
		//if ($options['height'] !=""){
				//echo 'height: '.$options['height'].',';
		//}
		//else{
			//echo "";
		//}
		?>
	});
		</script>
		<?php
		//if($options['template'] == 'coverflow' ){ 
				//echo "		<style>
				//#$containerID .swiper-slide {
				  //background-position: center;
				  //background-size: cover;
				  //width: 300px;
				  //height: 300px;

				//}
		//</style>";
			//}
			
}
function template_return($ID,$pager,$rtl){//,$height
			$containerID = "swiper$ID";
			$slides = get_post_meta( $ID, 'slides', true );
			$imageMas = $slides[0];
			$slidemas = $slides[1];
			if ($rtl == "on"){
					$rtl = 'dir="rtl"';
				}
			else{
					$rtl = "trs";
				}
			$rendering_slider =  '<div id="swiper'.$ID.'" class="swiper-container swiper-default" '.$rtl.'>
					<div class="swiper-wrapper">';  
						for ($i = 0; $i < count($imageMas); $i++) {
							$image = $imageMas[$i];
							$slide = $slidemas[$i];
							$rendering_slider .='<div class="swiper-slide" >
								<div class="slideraz-slide-container"><div class="slideraz-slide-text">'.$slide.'</div></div>';

							if( wp_attachment_is_image( $image ) ){
								$rendering_slider .='<img 
									 src="'. wp_get_attachment_image_url( $image, array(2560,1600) ) .'"
									 srcset="'.  wp_get_attachment_image_srcset( $image, array(2560,1600) ) .'"
									 sizes="'.  wp_get_attachment_image_sizes( $image, array(2560,1600) ) .'"
								 >
							</div>';
							}
							else{
								$video = wp_get_attachment_metadata( $image );
								$content_width = $video['width'];
								$video_url = wp_get_attachment_url( $image );
									$rendering_slider .= '<iframe 
										class="slideraz-iframe" 
										width="'.$video['width'].'" 
										height="'.$video['height'].'" 
										src="'.$video_url.'" 
										frameborder="0">
									</iframe></div>';
								}
						}

						$rendering_slider .='</div>';
													if($pager == 'pagination') {
									$rendering_slider .= '<!-- Add Pagination -->
										  <div class="swiper-pagination"></div>';
								}
							elseif($pager == 'navigation'){
									$rendering_slider .= '    <!-- Add Arrows -->
											  <div class="swiper-button-next"></div>
											  <div class="swiper-button-prev"></div>';
								}
							else{
									$rendering_slider .= '<!-- No pager -->';
								}
				  $rendering_slider .='</div>';
		return $rendering_slider;
			
	}
