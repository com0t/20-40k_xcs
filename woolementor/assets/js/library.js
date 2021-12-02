/* global elementor, elementorCommon */
/* eslint-disable */

const analog = window.analog = window.analog || {};

"undefined" != typeof jQuery &&
	!(function($) {
		$(function() {

			function wl_loader() {
				$('.dialog-loading.dialog-lightbox-loading').show();
					$('#woolementor-categories').hide();
					$('#woolementor-templates').hide();
				setTimeout(function() {
					$('.dialog-loading.dialog-lightbox-loading').hide();
					$('#woolementor-categories').show();
					$('#woolementor-templates').show();
				}, 2000 );
			}

			function modal() {
				const insertIndex = 0 < jQuery(this).parents(".elementor-section-wrap").length ? jQuery(this).parents(".elementor-add-section").index() : -1;

				analog.insertIndex = insertIndex;

				elementorCommon &&
					(window.woolementorLibraryPopup ||
						((window.woolementorLibraryPopup = elementorCommon.dialogsManager.createWidget(
							"lightbox",
							{
								id: "elementor-template-library-modal",
								class: "elementor-templates-modal",
								headerMessage: "",
								header: "",
								message: "",
								hide: {
									auto: !1,
									onClick: !1,
									onOutsideClick: !1,
									onOutsideContextMenu: !1,
									onBackgroundClick: !0
								},
								position: {
									my: "center",
									at: "center"
								},
								onShow: function() {

									const widget = window.woolementorLibraryPopup.getElements("widget");
									widget.addClass('elementor-templates-modal');

									const header = window.woolementorLibraryPopup.getElements("header");
									header.append('<div class="elementor-templates-modal__header"></div>');

									const message = window.woolementorLibraryPopup.getElements("content");
									message.append('<div id="woolementor-categories" class="wrap"></div>');
									message.append('<div id="woolementor-templates" class="wrap"></div>');

									const loading = window.woolementorLibraryPopup.getElements("loading");
									loading.append('<div id="elementor-template-library-loading"></div>');

									$('.dialog-widget-content.dialog-lightbox-widget-content').css({
										top: '63.5px',
										left: '360px'
									});
									$('#woolementor-templates').css('display', 'grid');

									var data = {
										cats: 		WOOLEMENTOR_LIB.categories,
										pages : 	WOOLEMENTOR_LIB.pages,
										blocks : 	WOOLEMENTOR_LIB.blocks
									};

							        var modal_header 		= _.template($('#tmpl-wl-templates-modal__header').html() );
							        $('.elementor-templates-modal__header').html( modal_header() );

							        var modal_header_logo 	= _.template($('#tmpl-wl-templates-modal__header__logo').html() );
							        $('.elementor-templates-modal__header__logo-area').html( modal_header_logo() );

							        var modal_header_menu 	= _.template($('#tmpl-wl-template-modal__header__menu').html() );
							        $('.elementor-templates-modal__header__menu-area').html( modal_header_menu() );

							        var modal_header_action = _.template($('#tmpl-wl-template-modal__header__actions').html() );
							        $('#elementor-template-library-header-tools').html( modal_header_action() );

							        var loader_content 		= _.template($('#tmpl-wl-template-library-loading').html() );
							        $('#elementor-template-library-loading').html( loader_content() );

							        var wl_categories 		= _.template($('#tmpl-wl-template-library-filters').html() );
							        $('#woolementor-categories').html( wl_categories(data));

							        var wl_templates 		= _.template($('#tmpl-wl-template-library-blocks').html() );
							        $('#woolementor-templates').html( wl_templates(data));

							        // var isPro = true;

							        // if ( isPro ) {
							        // 	var pro_button 		= _.template($('#tmpl-wl-template-library-pro-button').html() );
							        // 	$('.elementor-template-library-template-footer').html( pro_button() );
							        // }

									wl_loader();

							        $("#wl-template-library-search input").on("keyup", function() {
									    var value = $(this).val().toLowerCase();

									    $("#woolementor-templates .import-this").filter(function() {
									      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
									    });
									});

                                    requestTemplateData = function (e, t) {
                                        var i = { unique_id: e, data: { source: 'remote', edit_mode: !0, display: !0, template_id: e } };
                                        t && jQuery.extend(!0, i, t), elementorCommon.ajax.addRequest("get_wl_template_data", i);
                                    }

                                    getModal = function () {
                                        return o || (o = new a.Modal()), o;
                                    }

									var event = new Event("modal-close");
									$("#woolementor-templates, #elementor-template-library-modal").on(
										"click",
										".close-modal",
										function() {
											document.dispatchEvent(event);
											return window.woolementorLibraryPopup.hide(), !1;
										}
									);
									$("#woolementor-categories").on(
										"click",
										"#wl-template-library-categories > select",
										function(e) {
											// document.dispatchEvent(event);
											// return window.woolementorLibraryPopup.hide(), !1;
											var cat = $(this).val()
											// console.log(cat)
											if( '' != cat ) {
												$('.elementor-template-library-template-remote').hide();
												$('.elementor-template-library-template-remote.cat-'+cat).show();
											}
											else {
												$('.elementor-template-library-template-remote').show();
											}
										}
									);
									$("#woolementor-templates").on(
										"click",
										".elementor-template-library-template-preview",
										function(e) {
											var url 		= $(this).data('url');
											var template_id = $(this).data('tab');

											wl_loader();

											var wl_preview 		= _.template($('#tmpl-wl-templates-modal__preview').html() );
							        		$('#woolementor-templates').html( wl_preview() ).css('display', 'block');
											$('.tmpl-wl-templates-modal-preview-iframe iframe').attr("src", url)


							        		var modal_header_back 	= _.template($('#tmpl-wl-template-library-header-back').html() );
							        		$('.elementor-templates-modal__header__logo-area').html( modal_header_back() );

							        		var modal_header_responsive 	= _.template($('#tmpl-wl-template-library-header-menu-responsive').html() );
							        		$('.elementor-templates-modal__header__menu-area').html( modal_header_responsive() );

							        		var modal_header_preview 	= _.template($('#tmpl-wl-template-library-header-preview').html() );
							        		$('#elementor-template-library-header-tools').html( modal_header_preview() );

							        		$('#elementor-template-library-header-preview-insert-wrapper a').attr( 'data-tab', template_id );

							        		$('#wl-template-library-filters').remove();
							        		$('#woolementor-categories').css('margin-bottom', '0');
										}
									);
									$("#elementor-template-library-modal").on(
										"click",
										".tmpl-wl-template-library-header-preview-back",
										function(e) {

											var modal_header_logo 	= _.template($('#tmpl-wl-templates-modal__header__logo').html() );
									        $('.elementor-templates-modal__header__logo-area').html( modal_header_logo() );

									        var modal_header_menu 	= _.template($('#tmpl-wl-template-modal__header__menu').html() );
									        $('.elementor-templates-modal__header__menu-area').html( modal_header_menu() );

									        var modal_header_action = _.template($('#tmpl-wl-template-modal__header__actions').html() );
									        $('#elementor-template-library-header-tools').html( modal_header_action() );

									        var wl_templates 		= _.template($('#tmpl-wl-template-library-pages').html() );
							        		$('#woolementor-templates').html( wl_templates(data));

									        // var wl_templates 		= _.template($('#tmpl-wl-template-library-blocks').html() );
							        		// $('#woolementor-templates').html( wl_templates(data));

									        var wl_categories 		= _.template($('#tmpl-wl-template-library-filters').html() );
							        		$('#woolementor-categories').html( wl_categories(data));
							        		
							        		$('#woolementor-categories').css('margin-bottom', '20px');
											$('#woolementor-templates').css('display', 'grid');
										}
									);
									$("#elementor-template-library-modal").on(
										"click",
										".wl__responsive-menu-item",
										function(e) {
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
											// console.log(tab_view)
										}
									);
									$("#elementor-template-library-modal").on(
										"click",
										".elementor-template-library-menu-item",
										function(e) {

											// wl_loader();

											var template = $(this).data('tab');

											$('.elementor-template-library-menu-item').removeClass('elementor-active')

											switch ( template ) {
												case 'blocks':
													$(this).addClass('elementor-active')
											        var wl_templates = _.template($('#tmpl-wl-template-library-blocks').html() );
											        $('#woolementor-templates').html( wl_templates(data));
													break;
												case 'pages':
													$(this).addClass('elementor-active')
													var wl_templates = _.template($('#tmpl-wl-template-library-pages').html() );
											        $('#woolementor-templates').html( wl_templates(data));
													break;
												default:
													var wl_templates = _.template($('#tmpl-wl-template-library-pages').html() );
											        $('#woolementor-templates').html( wl_templates(data));
													break;
											}
											// console.log(tab_view)
										}
									);
                                    $("#woolementor-templates, #elementor-template-library-modal").on(
                                        "click",
                                        ".tmpl-wl-template-insert",
                                        function(e) {

                                        	$('.dialog-loading.dialog-lightbox-loading').show();
                                        	$('#elementor-template-library-header-preview-insert-wrapper a')
                                        	.removeClass('tmpl-wl-template-insert').text('Inserting...')

                                            // document.dispatchEvent(event);
                                            // return window.woolementorLibraryPopup.hide(), !1;
                                            var template_id = $(this).data('tab')
                                            // alert(template_id)

                                            var eleModel = elementor.elementsModel,
                                                $this = this;


                                            requestTemplateData(template_id, {
                                                success: function (e) {
                                                    // i.getModal().hideLoadingView(), i.getModal().hideModal();
                                                    var a = {};
                                                    $e.run("document/elements/import", { model: eleModel, data: e, options: a }), ($this.atIndex = -1);

                                                    $('.dialog-loading.dialog-lightbox-loading').hide();
                                                },
                                                error: function (e) {
                                                    // i.showErrorDialog(e);
                                                    console.log(e)
                                                },
                                                complete: function (e) {
                                                	window.woolementorLibraryPopup.hide();
                                                    window.elementor.$previewContents.find(".elementor-add-section .elementor-add-section-close").click();
                                                },
                                            });
                                        }
                                    );

                                    $("#elementor-template-library-modal").on(
                                        "click",
                                        "#elementor-template-library-header-sync",
                                        function(e) {
                                        	$('#elementor-template-library-header-sync i').addClass('eicon-sync eicon-animation-spin');
                                        	elementorCommon.ajax.addRequest(
												'get_wl_template_sync', {
													success: function( data ) {
                                        				$('#elementor-template-library-header-sync i').removeClass('eicon-animation-spin');
														console.log(data)
													},
													error: function() {
														console.log( 'An error occurred' );
													},
												},
												true
											);
                                        }
                                    );
								},
								onHide: function() {
									window.woolementorLibraryPopup
									.getElements("header").html('')
								}
							}
						)),
						window.woolementorLibraryPopup
							.getElements("message")
							.append(window.woolementorLibraryPopup.addElement("content"))
							.append(window.woolementorLibraryPopup.addElement("loading"))
						),
						window.woolementorLibraryPopup.show());
			}

			window.woolementorLibraryPopup = null;

			const template = $("#tmpl-elementor-add-section");

			if (0 < template.length && typeof elementor !== undefined) {
				let text = template.text();

				(text = text.replace(
					'<div class="elementor-add-section-drag-title',
					'<div class="elementor-add-section-area-button elementor-add-woolementor-button" title="Woolementor Templates">&nbsp;</div> <div class="elementor-add-section-drag-title'
				)),
					template.text(text),
					elementor.on("preview:loaded", function() {
						$(elementor.$previewContents[0].body).on(
							"click",
							".elementor-add-woolementor-button",
							modal
						);
					});
			}
		});
	})(jQuery);
