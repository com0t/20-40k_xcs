jQuery(function($){

	$('.wcd_help_tablinks .wcd_help_tablink').on( 'click', function(e){
        e.preventDefault();
        var tab_id = $(this).attr('id');
        $('.wcd_help_tablink').removeClass('active');
        $(this).addClass('active');

        $('.wcd_tabcontent').hide();
        $('#'+tab_id+'_content').show();
    } );

	$('.wcd_template_tabs .wcd_template_tab').on( 'click', function(e){
        e.preventDefault();
        var tab_id = $(this).attr('id');
        $('.wcd_template_tab').removeClass('active');
        $(this).addClass('active');

        $('.wcd_template_content').hide();
        $('#'+tab_id+'_content').show();

        // template
		$('.tmpl-wl-templates-modal-preview-iframe').hide();
		$('.wcd-tmpl-wrapper').show();
		$('.tmpl-wl-templates-modal-preview-iframe iframe').attr("src", '');
    } );

	$('#wl_faq').click(function (e) {
		$('#wl_vidtt, #wl_support').removeClass('active');
		$(this).addClass('active');

		$('#wl_vidtt_content, #wl_support_content').removeClass('active');
		$('#wl_faq_content').addClass('active');
	});
	$('#wl_vidtt').click(function (e) {
		$('#wl_faq, #wl_support').removeClass('active');
		$(this).addClass('active');

		$('#wl_faq_content, #wl_support_content').removeClass('active');
		$('#wl_vidtt_content').addClass('active');
	});
	$('#wl_support').click(function (e) {
		$('#wl_faq, #wl_vidtt').removeClass('active');
		$(this).addClass('active');
		
		$('#wl_faq_content, #wl_vidtt_content').removeClass('active');
		$('#wl_support_content').addClass('active');
	});

	$('.woolementor-help-heading').click(function(e){
		var $this = $(this);
		var target = $this.data('target');
		$('.woolementor-help-text:not('+target+')').slideUp();
		if($(target).is(':hidden')){
			$(target).slideDown();
		}
		else {
			$(target).slideUp();
		}
	});

	$('#wl-report-copy').click(function(e) {
		e.preventDefault();
		$('#woolementor_tools-report').select();

		try {
			var successful = document.execCommand('copy');
			if( successful ){
				$(this).html('<span class="dashicons dashicons-saved"></span>');
			}
		} catch (err) {
			console.log('Oops, unable to copy!');
		}
	});

	$('.wcd-tmpl-wrapper').on( "click", ".elementor-template-library-template-preview", function(e) {
		$('.tmpl-admin-template-loader').show();
		var url = $(this).data('url');

		$(this).parents('.wcd-tmpl-wrapper').hide();
		$('.tmpl-wl-templates-modal-preview-iframe iframe').attr("src", url);
		$('.tmpl-wl-templates-modal-preview-iframe').show();

		$('.wcd_tab_btns.wcd-tmpl-btns').hide();
		$('.tmpl-admin-template-header').show();

		setTimeout(function(){
			$('.tmpl-admin-template-loader').hide();
		}, 1000);

	});

	$(document).on( "click", ".tmpl-wl-template-library-header-preview-back", function(e) {
		$('.tmpl-admin-template-header').hide()
		$('.wcd_tab_btns.wcd-tmpl-btns').show()

		$('.tmpl-wl-templates-modal-preview-iframe').hide();
		$('.wcd-tmpl-wrapper').show();
		$('.tmpl-wl-templates-modal-preview-iframe iframe').attr("src", '');
		$('.tmpl-wl-templates-modal-preview-iframe').css('width', '100%');

		$('.wl__responsive-menu-item[data-tab="desktop"]').click();
	});

	$(document).on( "click", ".wl__responsive-menu-item", function(e) {
		var tab_view = $(this).data('tab');

		$('.wl__responsive-menu-item').removeClass('elementor-active')

		switch ( tab_view ) {
			case 'desktop':
				$(this).addClass('elementor-active')
				$('.tmpl-wl-templates-modal-preview-iframe').css('width', '100%');
				break;
			case 'tab':
				$(this).addClass('elementor-active')
				$('.tmpl-wl-templates-modal-preview-iframe').css('width', '768px');
				break;
			case 'mobile':
				$(this).addClass('elementor-active')
				$('.tmpl-wl-templates-modal-preview-iframe').css('width', '360px');
				break;
			default:
				$(this).css('width', '100%');
				break;
		}
	});

	/**
	 * Template Libray synce
	 * 
	 * @author Jakaria Istauk <jakariamd35@gmail.com> 
	 */
	 $(document).on('click', '#wcd-template-sync.clickable',function(e) {
	 	e.preventDefault();
	 	var sync_btn = $(this);
	 	sync_btn.addClass('spin').removeClass('clickable');
	 	$.ajax({
	 		url: WOOLEMENTOR.ajaxurl,
	 		data: { 'action' : 'wcd-template-sync', _wpnonce : WOOLEMENTOR.nonce },
	 		type: 'POST',
	 		dataType: 'JSON',
	 		success: function( resp ) {
	 			console.log(resp.message);
	 			sync_btn.removeClass('spin').addClass('clickable');
	 			if ( resp.status == 1 ) {
	 				window.location.href='';
	 			}
	 		},
	 		error: function( resp ) {
	 			console.log(resp);
	 			sync_btn.removeClass('spin').addClass('clickable');
	 		}
	 	});
	 });

	$(document).ready(function(){
		$("#wl-template-categories").on("change", function() {
			$("#wl-template-search").val('')
			var value = $(this).val().toLowerCase();
				$(".wcd-tmpl-wrapper .elementor-template-library-template-remote").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
			});
		});

		$("#wl-template-search").on("keyup", function() {
			$("#wl-template-categories").val('')
			var value = $(this).val().toLowerCase();
				$(".wcd-tmpl-wrapper .elementor-template-library-template-remote").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
			});
		});
	});

	$(document).on('click','.wl-widget-type-title',function(e) {
		var par = $(this).parent();
		$('.wl-pro-widget-list-wrapper').slideUp();
		$('.wl-pro-widget-list-wrapper', par).slideToggle();
	});
})