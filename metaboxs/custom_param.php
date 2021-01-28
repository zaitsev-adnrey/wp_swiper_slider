<?php
new Meta_custom_param_sliders;

class Meta_custom_param_sliders{
	public $post_type = 'slideraz';
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
		add_action( 'save_post_' . $this->post_type, array( $this, 'save_metabox' ) );
	}
	## Добавляет мeтабоксы
	public function add_metabox() {
		add_meta_box( 'box_slides_custom_param', 'custom parametrs', array( $this, 'render_metabox' ), $this->post_type, 'side', 'low' );
	}
	
	public function render_metabox( $post ) {
		$custom = "";
		$options = get_post_meta($post->ID, 'options', 1);
		if($options){
				if (isset($options['custom'])){$custom = $options['custom'];}
			}
			?>
<textarea id="custom" rows="10" cols="60" name="options[custom]"><?php echo $custom; ?></textarea>
		
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
