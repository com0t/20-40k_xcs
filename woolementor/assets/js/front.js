jQuery(function($){
	// add to wishlist
	$('.ajax_add_to_wish').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		var $product_id = $this.data('product_id');
		
		$.ajax({
			url: WOOLEMENTOR.ajaxurl,
			data: { 'action' : 'add-to-wish', _wpnonce : WOOLEMENTOR._nonce, product_id : $product_id },
			type: 'POST',
			dataType: 'JSON',
			success: function( resp ) {
				if(resp.action=='added') {
					$this.addClass('fav-item')
				}
				else {
					$this.removeClass('fav-item')
				}
			},
			error: function( resp ) {
				console.log(resp)
			}
		})
	});
	// remove from wishlist
	$('.ajax_remove_from_wish').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		var $product_id = $this.data('product_id');
		
		$.ajax({
			url: WOOLEMENTOR.ajaxurl,
			data: { 'action' : 'add-to-wish', _wpnonce : WOOLEMENTOR._nonce, product_id : $product_id },
			type: 'POST',
			dataType: 'JSON',
			success: function( resp ) {
				if(resp.action=='removed') {
					$this.closest('tr').remove()
				}
			},
			error: function( resp ) {
				console.log(resp)
			}
		});
	});

	// multiple-product-add-to-cart
	$('.multiple-product-add-to-cart').on('submit',function(e){
		e.preventDefault();
		var $formData = $( this ).serializeArray();
		$.ajax({
			url: WOOLEMENTOR.ajaxurl,
			data: $formData,
			type: 'POST',
			dataType: 'JSON',
			success: function( resp ) {
				if ( resp.status == 1 ) {
					$('.multiselect-view-cart').show()
				}
			},
			error: function( resp ) {
				console.log(resp)
			}
		});
	});

	$('.wl-product-comparison-button').on('click',function(e) {
		// e.preventDefault();
		var compare_btn = $(this);
		var product_id 	= compare_btn.data('product');
		var action 		= compare_btn.data('action');
		var redir_url 	= compare_btn.data('url');

		compare_btn.attr('disabled',true);

		$.ajax({
			url: WOOLEMENTOR.ajaxurl,
			data: { 'action' : 'add-to-compare', _wpnonce : WOOLEMENTOR._nonce, product_id : product_id },
			type: 'POST',
			dataType: 'JSON',
			success: function( resp ) {
				// console.log(resp)
				if(resp.status == 1){
					compare_btn.html('<a href='+redir_url+'>'+resp.btn_text+'</a>');
				}
				if (action == 'redirect') {
					window.location.href=redir_url;
				}
				compare_btn.attr('disabled',false);
			},
			error: function( resp ) {
				console.log(resp)
				compare_btn.attr('disabled',false);
			}
		})
	});
	
	$('.wl-pct-product-remove').on('click',function(e) {
		e.preventDefault();
		var compare_btn = $(this);
		var product_id 	= compare_btn.data('product');

		compare_btn.attr('disabled',true);

		$.ajax({
			url: WOOLEMENTOR.ajaxurl,
			data: { 'action' : 'remove-from-compare', _wpnonce : WOOLEMENTOR._nonce, product_id : product_id },
			type: 'POST',
			dataType: 'JSON',
			success: function( resp ) {
				console.log(resp)
				if(resp.status == 1){
					window.location.href=window.location.pathname;
				}
				compare_btn.attr('disabled',false);
			},
			error: function( resp ) {
				console.log(resp)
				compare_btn.attr('disabled',false);
			}
		})
	});
});