<?php
new Metaboxes_slides;

class Metaboxes_slides {

	public $post_type = 'slideraz';
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
		add_action( 'save_post_' . $this->post_type, array( $this, 'save_metabox' ) );
		add_action( 'admin_print_footer_scripts', array( $this, 'show_assets' ), 10, 999 );
	}

	## Добавляет мeтабоксы
	public function add_metabox() {
		add_meta_box( 'box_slides', 'Slides', array( $this, 'render_metabox' ), $this->post_type, 'advanced', 'high' );
	}

	## Отображает метабокс на странице редактирования поста
	public function render_metabox( $post ) {
		$default = RC_TC_PLUGIN_URL .'noimage.png';
		//$effect="0";
		$pager	 ="0";
		//$height  ="";
		$rtl 	 ="off"; 
		$text_position = "bottom";
		$options = get_post_meta($post->ID, 'options', 1);
		if($options){
			//if (isset($options['effect'])){$effect = $options['effect'];}
			if (isset($options['pager'])){$pager = $options['pager'];}
			//if (isset($options['height'])){$height = $options['height'];}
			if (isset($options['rtl'])){$rtl =$options['rtl']; }
			if (isset($options['TextPosition'])){$text_position =$options['TextPosition']; }
		}
		
		?>
		<input type="text" disabled="disabled" value='[slideraz id="<?php echo $post->ID ;?>" pager="<?php echo $pager ;?>"  rtl="<?php echo $rtl; ?>" text="<?php echo $text_position; ?>"] ' style="width:100%;"><!--height="<?php// echo $height;?>" -->
		<table class="form-table table-slide">
			<tr><input type="button" class="add-slide" value="Add new slide">
				<ul  id="sortable" class="slide-list">	
					<?php
					$input = '
					<li class="item-slide ui-state-default ui-accordion-header">
						<span class="dashicons dashicons-arrow-down-alt2 open-accordion">
						</span>Slide<span class="dashicons dashicons-trash remove-slide"></span>
						
						<div class="slide-container hidden" style="display:none;">
							<div class="slide-image-container">
								<img src="%s"/>
									<button type="submit" class="upload_image_button button">Загрузить</button>
									<input type="hidden" name="image[]" value="%s" />
									
							</div>
							<textarea class="slides-text" name="slides[]" placeholder="slide text">%s</textarea>
						</div>
					</li>
					';
					$slides = get_post_meta( $post->ID, 'slides', true );
					if ( is_array( $slides ) ) {
						$image = $slides[0];
						$slide = $slides[1];
						for ($i = 0; $i < count($image); $i++) {
							$url=wp_get_attachment_image_url($image[$i]);
							printf( $input,esc_attr($url),esc_attr($image[$i]), esc_attr( $slide[$i]));
						}
					} else {
						printf( $input,esc_attr($default) , '' , '' );
					}
					?>
				</ul>
			</tr>

		</table>

		<?php
	}

	## Очищает и сохраняет значения полей
	public function save_metabox( $post_id ) {

		// Check if it's not an autosave.
		//if ( wp_is_post_autosave( $post_id ) )
			//return;

		if ( isset( $_POST['slides'] ) && is_array( $_POST['slides'] ) ) {
			$slides = $_POST['slides'];//массив с текстом слайдов
			$image  = $_POST['image'];//массив с изображениями слайдов
			$slidesMas = [$image,$slides];
			if ( $slidesMas ){ 
				update_post_meta( $post_id, 'slides',$slidesMas );
				
			}
			else {
				delete_post_meta( $post_id, 'slides' );
			}

		}
	}
		## Подключает скрипты и стили
	public function show_assets() {
		if ( is_admin() && get_current_screen()->id == $this->post_type ) {
			$this->show_scripts();
		}
	}
	public function show_scripts() {
	    $url = RC_TC_PLUGIN_URL;
		?>
			<script>var sliderazUrl = '<?php echo $url; ?>'; </script> 
		<?php
	}
}
