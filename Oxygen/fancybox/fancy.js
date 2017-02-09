$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			 */

			$('.fancybox').fancybox();



			// Change title type, overlay closing speed
			$(".fancybox-effects-a").fancybox({
				helpers: {
					title : {
						type : 'outside'
					},
					overlay : {
						speedOut : 0
					}
				}
			});

			// Disable opening and closing animations, change title type
			$(".fancybox-effects-b").fancybox({
				openEffect  : 'none',
				closeEffect	: 'none',

				helpers : {
					title : {
						type : 'over'
					}
				}
			});

			// Set custom style, close if clicked, change title type and overlay color
			$(".fancybox-effects-c").fancybox({
				wrapCSS    : 'fancybox-custom',
				closeClick : true,

				openEffect : 'none',

				helpers : {
					title : {
						type : 'inside'
					},
					overlay : {
						css : {
							'background' : 'rgba(238,238,238,0.85)'
						}
					}
				}
			});

			// Remove padding, set opening and closing animations, close if clicked and disable overlay
			$(".fancybox-effects-d").fancybox({
				padding: 0,

				openEffect : 'elastic',
				openSpeed  : 150,

				closeEffect : 'elastic',
				closeSpeed  : 150,

				closeClick : true,

				helpers : {
					overlay : null
				}
			});

			/*
			 *  Button helper. Disable animations, hide close button, change title type and content
			 */

			$('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});
 
			$('.fancybox-thumbs').fancybox({
				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,
				arrows    : false,
				nextClick : true,

				helpers : {
					thumbs : {
						width  : 50,
						height : 50
					}
				}
			});
			$("#fancy-galeria-1").click(function() {
				$.fancybox.open([
					{
						href : 'images/g_1/img_1.jpg',
						title : 'Oxygenos'
					}, {
						href : 'images/g_1/img_2.jpg',
                        title : 'Oxygenos'
					}, {
						href : 'images/g_1/img_3.jpg',
                        title : 'Oxygenos'
					}, {
                        href : 'images/g_1/img_4.jpg',
                        title : 'Oxygenos'
                    }, {
                        href : 'images/g_1/img_5.jpg',
                        title : 'Oxygenos'
                    }, {
                        href : 'images/g_1/img_6.jpg',
                        title : 'Oxygenos'
                    }, {
                        href : 'images/g_1/img_7.jpg',
                        title : 'Oxygenos'
                    }, {
                        href : 'images/g_1/img_8.jpg',
                        title : 'Oxygenos'
                    }, {
                        href : 'images/g_1/img_9.jpg',
                        title : 'Oxygenos'
                    }, {
                        href : 'images/g_1/img_10.jpg',
                        title : 'Oxygenos'
                    }, {
                        href : 'images/g_1/img_11.jpg',
                        title : 'Oxygenos'
                    }, {
                        href : 'images/g_1/img_12.jpg',
                        title : 'Oxygenos'
                    }
				], {
					helpers : {
						thumbs : {
							width: 75,
							height: 50
						}
					}
				});
			});
            $("#fancy-galeria-2").click(function() {
                $.fancybox.open([
                    {
                        href : 'images/g_2/img_1.jpg',
                        title : 'Oxyposada 2014'
                    }, {
                        href : 'images/g_2/img_2.jpg',
                        title : 'Oxyposada 2014'
                    }, {
                        href : 'images/g_2/img_3.jpg',
                        title : 'Oxyposada 2014'
                    }, {
                        href : 'images/g_2/img_4.jpg',
                        title : 'Oxyposada 2014'
                    }, {
                        href : 'images/g_2/img_5.jpg',
                        title : 'Oxyposada 2014'
                    }, {
                        href : 'images/g_2/img_6.jpg',
                        title : 'Oxyposada 2014'
                    }, {
                        href : 'images/g_2/img_7.jpg',
                        title : 'Oxyposada 2014'
                    }, {
                        href : 'images/g_2/img_8.jpg',
                        title : 'Oxyposada 2014'
                    }, {
                        href : 'images/g_2/img_9.jpg',
                        title : 'Oxyposada 2014'
                    }, {
                        href : 'images/g_2/img_10.jpg',
                        title : 'Oxyposada 2014'
                    }, {
                        href : 'images/g_2/img_11.jpg',
                        title : 'Oxyposada 2014'
                    }, {
                        href : 'images/g_2/img_12.jpg',
                        title : 'Oxyposada 2014'
                    }
                ], {
                    helpers : {
                        thumbs : {
                            width: 75,
                            height: 50
                        }
                    }
                });
            });
            $("#fancy-galeria-3").click(function() {
                $.fancybox.open([
                    {
                        href : 'images/g_3/img_1.jpg',
                        title : 'Julio Cancer WOD'
                    }, {
                        href : 'images/g_3/img_2.jpg',
                        title : 'Julio Cancer WOD'
                    }, {
                        href : 'images/g_3/img_3.jpg',
                        title : 'Julio Cancer WOD'
                    }, {
                        href : 'images/g_3/img_4.jpg',
                        title : 'Julio Cancer WOD'
                    }, {
                        href : 'images/g_3/img_5.jpg',
                        title : 'Julio Cancer WOD'
                    }, {
                        href : 'images/g_3/img_6.jpg',
                        title : 'Julio Cancer WOD'
                    }, {
                        href : 'images/g_3/img_7.jpg',
                        title : 'Julio Cancer WOD'
                    }, {
                        href : 'images/g_3/img_8.jpg',
                        title : 'Julio Cancer WOD'
                    }, {
                        href : 'images/g_3/img_9.jpg',
                        title : 'Julio Cancer WOD'
                    }, {
                        href : 'images/g_3/img_10.jpg',
                        title : 'Julio Cancer WOD'
                    }, {
                        href : 'images/g_3/img_11.jpg',
                        title : 'Julio Cancer WOD'
                    }, {
                        href : 'images/g_3/img_12.jpg',
                        title : 'Julio Cancer WOD'
                    }
                ], {
                    helpers : {
                        thumbs : {
                            width: 75,
                            height: 50
                        }
                    }
                });
            });

		});
