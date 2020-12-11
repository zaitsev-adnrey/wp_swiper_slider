<?php
new Meta_options_sliders;

class Meta_options_sliders{
	public $post_type = 'slideraz';
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
		add_action( 'save_post_' . $this->post_type, array( $this, 'save_metabox' ) );
	}
	## Добавляет мeтабоксы
	public function add_metabox() {
		add_meta_box( 'box_slides_options', 'Options', array( $this, 'render_metabox' ), $this->post_type, 'side', 'low' );
	}
	
	public function render_metabox( $post ) {
		$effect			= "0";
		$pager			= "0";
		$height 		= "";
		$autoplay 		= "";
		$initialSlide   = "";
		$slidesPerView  = "";
		$rtl 			= "off";
		$options = get_post_meta($post->ID, 'options', 1);
		if($options){
			if (isset($options['effect'])){$effect = $options['effect'];}
			if (isset($options['pager'])){$pager = $options['pager'];}
			if (isset($options['height'])){$height = $options['height'];}
			if (isset($options['autoplay'])){$autoplay = $options['autoplay'];}
			if (isset($options['initialSlide'])){$initialSlide = $options['initialSlide'];}
			if (isset($options['slidesPerView'])){$slidesPerView = $options['slidesPerView'];}
			if (isset($options['rtl'])){$rtl = $options['rtl'];}
		}
		?><label for="effect">Effect<select class="select-slider-az" id="effect" name="options[effect]">
			<option value="0">----</option>
			<option value="coverflow"<?php selected( $effect, 'coverflow' )?>>coverflow</option>
			<option value="fade"<?php selected( $effect, 'fade' )?>>fade</option>
		</select></label>
		<label for="pager">Pager<select class="select-slider-az"  id="pager" name="options[pager]">
			<option value="0" <?php selected( $pager, '0' ) ?>>nothing</option>
			<option value="navigation"<?php selected( $pager, 'navigation' ) ?>>navigation</option>
			<option value="pagination"<?php selected( $pager, 'pagination' )?>>pagination</option>
		</select></label>
		<label for="rtl-select">rtl<select class="select-slider-az" id="rtl-select" name="options[rtl]">
			<option value="off"<?php selected( $rtl, 'off' )?>>Off</option>
			<option value="on"<?php selected( $rtl, 'on' )?>>On</option>
		</select></label>
		<!--<label for="height">Height<input class="inputs-slider-az" type="text" id="height" name="options[height]" value="<?php echo $height; ?>"></label> -->
		<label for="autoplay">Autoplay (ms)<input class="inputs-slider-az" type="text" id="autoplay" name="options[autoplay]" value="<?php echo $autoplay; ?>"></label>
		<label for="initialSlide">initialSlide (number)<input class="inputs-slider-az"  type="text" id="initialSlide" name="options[initialSlide]" value="<?php echo $initialSlide; ?>"></label>
		<label for="slidesPerView">slidesPerView (number)<input class="inputs-slider-az"  type="text" id="slidesPerView" name="options[slidesPerView]" value="<?php echo $slidesPerView; ?>"></label>
		<?php
	}

	public function save_metabox( $post_id ) {
		if ( wp_is_post_autosave( $post_id ) ){
			return;
			}
		if (isset($_POST['options'])){
			$options = $_POST['options'];
			if( $options ){
				update_post_meta( $post_id, 'options', $options );
			}
			else{
				delete_post_meta( $post_id, 'options', $options );
				}
		}
	}
}
