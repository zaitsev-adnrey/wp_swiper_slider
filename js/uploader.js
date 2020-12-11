jQuery(function($){
    /*
     * действие при нажатии на кнопку загрузки изображения
     * вы также можете привязать это действие к клику по самому изображению
     */
    var $tableSlide = $('#sortable');
    $tableSlide.on('click', '.upload_image_button', function () {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);
        wp.media.editor.send.attachment = function(props, attachment) {
            $(button).prev().attr('src', attachment.url);
            $(button).next().val(attachment.id);
            wp.media.editor.send.attachment = send_attachment_bkp;
        }
        wp.media.editor.open();
        return false;    
    });
    /*
     * удаляем значение произвольного поля
     * если быть точным, то мы просто удаляем value у input type="hidden"
     */
    $('.remove_image_button').click(function(){
            var src = $(this).parent().prev().attr('data-src');
            $(this).parent().prev().attr('src', src);
            $(this).prev().prev().val('');

    });
    var $tableSlide = $('#sortable');
				
				// Добавляет бокс с вводом адреса фирмы
				$('.add-slide').on('click',  function () {
					var $list = $('.slide-list');
						$item = $list.find('.item-slide').first().clone();

					$item.find('input').val(''); // чистим знанчение
					$item.find('img').attr('src',sliderazUrl+'noimage.png');
					$item.find('textarea').val(""); // чистим знанчение
					$list.append( $item );
				});

				// Удаляет бокс с вводом адреса фирмы
				$tableSlide.on('click', '.remove-slide', function () {
					if ($('.item-slide').length > 1) {
						$(this).closest('.item-slide').remove();
					}
					else {
						$(this).closest('.item-slide').find('input').val('');
					}
				});  
			$tableSlide.on('click', '.open-accordion', function () {	
					var button = $(this);
					var container =  $(button).next().next();
					//var container = $(header).next();
					if ($(container).hasClass('hidden')){
							$(container).show('slow');
							$(container).removeClass('hidden');
						}
					else{
							$(container).hide('slow');
							$(container).addClass('hidden');
						}
				
				}); 
				$( "#sortable" ).sortable({
				  forceHelperSize: true ,
				  revert: true
				  
				});


});

