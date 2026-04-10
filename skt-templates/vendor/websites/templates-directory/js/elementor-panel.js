/* global sktElementorPanel, jQuery, elementor */

/**
 * SKT Templates – Elementor Panel Integration
 *
 * Fixes applied v2:
 *  1. Single toolbar button — _booted flag + DOM check prevents any duplicate.
 *  2. Import INTO current page — reads post_id from editor URL, calls
 *     /import_into_page which appends sections without creating a new page.
 *     Reloads the editor after success so new content is visible immediately.
 */
( function( $ ) {
	'use strict';

	var SKTPanel = {

		templates : [],
		modal     : null,
		isLoaded  : false,
		_booted   : false,

		/* ------------------------------------------------------------------ */
		/*  Bootstrap                                                          */
		/* ------------------------------------------------------------------ */

		init: function() {
			if ( typeof elementor !== 'undefined' && elementor.channels ) {
				SKTPanel.boot();
			} else {
				$( window ).on( 'elementor:init', function() {
					SKTPanel.boot();
				} );
			}
		},

		boot: function() {
			if ( SKTPanel._booted ) return;
			SKTPanel._booted = true;
			SKTPanel.buildModal();
			SKTPanel.addToolbarButton();
			SKTPanel.bindEvents();
		},

		/* ------------------------------------------------------------------ */
		/*  Get current post ID from the editor URL                           */
		/* ------------------------------------------------------------------ */

		getCurrentPostId: function() {
			var match = window.location.search.match( /[?&]post=(\d+)/ );
			if ( match ) return parseInt( match[1], 10 );
			if (
				typeof elementor !== 'undefined' &&
				elementor.documents &&
				elementor.documents.getCurrentId
			) {
				return elementor.documents.getCurrentId();
			}
			return 0;
		},

		/* ------------------------------------------------------------------ */
		/*  Build modal (once)                                                 */
		/* ------------------------------------------------------------------ */

		buildModal: function() {
			if ( SKTPanel.modal ) return;
			if ( $( '#skt-template-modal' ).length ) {
				SKTPanel.modal = $( '#skt-template-modal' );
				return;
			}

			var modal = $(
				'<div id="skt-template-modal" class="skt-modal" style="display:none;" role="dialog" aria-modal="true">' +
					'<div class="skt-modal-inner">' +
						'<div class="skt-modal-header">' +
							'<span class="skt-modal-title">' + sktElementorPanel.strings.loading + '</span>' +
							'<div class="skt-modal-search-wrap">' +
								'<input type="search" id="skt-modal-search" class="skt-modal-search" placeholder="' + sktElementorPanel.strings.searchPlaceholder + '" />' +
							'</div>' +
							'<button class="skt-modal-close" aria-label="Close">&times;</button>' +
						'</div>' +
						'<div class="skt-modal-body">' +
							'<div id="skt-modal-grid" class="skt-modal-grid"></div>' +
						'</div>' +
					'</div>' +
				'</div>'
			);

			$( 'body' ).append( modal );
			SKTPanel.modal = modal;
		},

		/* ------------------------------------------------------------------ */
		/*  Add ONE toolbar button                                             */
		/* ------------------------------------------------------------------ */

		addToolbarButton: function() {
			if ( $( '#skt-editor-btn' ).length ) return;

			var tries    = 0;
			var maxTries = 25;

			var interval = setInterval( function() {
				tries++;

				/* Secondary guard inside the interval */
				if ( $( '#skt-editor-btn' ).length ) {
					clearInterval( interval );
					return;
				}

				var header = $( '#elementor-panel-header, .elementor-panel-header' ).first();

				if ( header.length || tries >= maxTries ) {
					clearInterval( interval );
					if ( ! header.length ) return;

					var btn = $(
						'<button id="skt-editor-btn" class="skt-editor-toolbar-btn" title="Browse Free SKT Templates">' +
							'<img src="/wp-content/plugins/skt-templates/images/logo.png" width="15" height="15" />' +
							'<span class="skt-btn-label"> SKT Templates</span>' +
						'</button>'
					);

					var anchor = header.find( '#elementor-panel-header-menu-button, #elementor-panel-header-kit' ).first();
					if ( anchor.length ) {
						btn.insertBefore( anchor );
					} else {
						header.prepend( btn );
					}

					btn.on( 'click', function( e ) {
						e.preventDefault();
						e.stopPropagation();
						SKTPanel.openModal();
					} );
				}
			}, 400 );
		},

		/* ------------------------------------------------------------------ */
		/*  Events                                                             */
		/* ------------------------------------------------------------------ */

		bindEvents: function() {
			$( document ).on( 'click', '#skt-template-modal .skt-modal-close', function() {
				SKTPanel.closeModal();
			} );

			$( document ).on( 'click', '#skt-template-modal', function( e ) {
				if ( $( e.target ).is( '#skt-template-modal' ) ) SKTPanel.closeModal();
			} );

			$( document ).on( 'keydown.sktPanel', function( e ) {
				if ( e.key === 'Escape' && SKTPanel.modal && SKTPanel.modal.is( ':visible' ) ) {
					SKTPanel.closeModal();
				}
			} );

			$( document ).on( 'input', '#skt-modal-search', function() {
				SKTPanel.filterTemplates( $( this ).val() );
			} );

			$( document ).on( 'click', '.skt-modal-import-btn', function( e ) {
				e.preventDefault();
				SKTPanel.importTemplate( $( this ), $( this ).data( 'import-file' ), $( this ).data( 'title' ) );
			} );

			$( document ).on( 'click', '.skt-open-template-browser', function( e ) {
				e.preventDefault();
				SKTPanel.openModal();
			} );
		},

		/* ------------------------------------------------------------------ */
		/*  Open / close                                                       */
		/* ------------------------------------------------------------------ */

		openModal: function() {
			SKTPanel.modal.fadeIn( 200 );
			$( '#skt-modal-search' ).val( '' );
			if ( SKTPanel.isLoaded ) {
				SKTPanel.renderGrid( SKTPanel.templates );
			} else {
				SKTPanel.loadTemplates();
			}
		},

		closeModal: function() {
			SKTPanel.modal.fadeOut( 200 );
		},

		/* ------------------------------------------------------------------ */
		/*  Load template list via AJAX                                        */
		/* ------------------------------------------------------------------ */

		loadTemplates: function() {
			$( '#skt-modal-grid' ).html(
				'<div class="skt-modal-loading"><span class="skt-spinner"></span><p>' + sktElementorPanel.strings.loading + '</p></div>'
			);
			$( '.skt-modal-title' ).text( sktElementorPanel.strings.loading );

			$.ajax( {
				url  : sktElementorPanel.ajaxUrl,
				type : 'POST',
				data : { action: 'skt_get_elementor_templates', nonce: sktElementorPanel.ajaxNonce },
				success: function( response ) {
					if ( response.success && response.data ) {
						SKTPanel.templates = response.data;
						SKTPanel.isLoaded  = true;
						//$('.skt-modal-title').text('Explore ' + response.data.length + '+ Free Ready to Use Templates');
						$('.skt-modal-title').html(
  'Explore ' + response.data.length + '+ Free Ready to Use Templates<br>' +
  '<span><a href="https://www.sktthemes.org/shop/all-themes/" target="_blank" style="color:#ff5a5f;font-weight:600;text-decoration:underline;">Buy All Themes</a> (420+ templates) for just $69. ' + 'With 1 year of unlimited support.</span>'
);
						SKTPanel.renderGrid( response.data );
					} else {
						SKTPanel.showError();
					}
				},
				error: function() { SKTPanel.showError(); }
			} );
		},

		showError: function() {
			$( '#skt-modal-grid' ).html( '<p class="skt-modal-error">' + sktElementorPanel.strings.noTemplates + '</p>' );
		},

		/* ------------------------------------------------------------------ */
		/*  Render grid                                                        */
		/* ------------------------------------------------------------------ */

		renderGrid: function( templates ) {
			var grid = $( '#skt-modal-grid' );
			grid.empty();

			if ( ! templates || ! templates.length ) {
				grid.html( '<p class="skt-modal-error">' + sktElementorPanel.strings.noTemplates + '</p>' );
				return;
			}

			var fragment = document.createDocumentFragment();

			$.each( templates, function( i, tpl ) {
				var card = document.createElement( 'div' );
				card.className = 'skt-modal-card';

				var img = tpl.screenshot
					? '<img src="' + tpl.screenshot + '" alt="' + SKTPanel.esc( tpl.title ) + '" loading="lazy" />'
					: '<div class="skt-no-screenshot"><span class="eicon-image-bold"></span></div>';

				card.innerHTML =
					'<div class="skt-card-thumb">' + img +
						'<div class="skt-card-overlay">' +
							( tpl.demo_url && tpl.demo_url !== '#'
								? '<a href="' + tpl.demo_url + '" target="_blank" class="skt-card-preview-btn">' + sktElementorPanel.strings.preview + '</a>'
								: '' ) +
							( tpl.import_file
								? '<button class="skt-modal-import-btn" data-import-file="' + tpl.import_file + '" data-title="' + SKTPanel.esc( tpl.title ) + '">' + sktElementorPanel.strings.import + '</button>'
								: '' ) +
						'</div>' +
					'</div>' +
					'<div class="skt-card-meta"><span class="skt-card-title">' + SKTPanel.esc( tpl.title ) + '</span></div>';

				fragment.appendChild( card );
			} );

			grid[0].appendChild( fragment );
		},

		/* ------------------------------------------------------------------ */
		/*  Filter                                                             */
		/* ------------------------------------------------------------------ */

		filterTemplates: function( query ) {
			query = query.toLowerCase().trim();
			if ( ! query ) { SKTPanel.renderGrid( SKTPanel.templates ); return; }
			SKTPanel.renderGrid( SKTPanel.templates.filter( function( tpl ) {
				return ( tpl.title + ' ' + ( tpl.keywords || '' ) ).toLowerCase().indexOf( query ) !== -1;
			} ) );
		},

		/* ------------------------------------------------------------------ */
		/*  Import template INTO the currently open Elementor page            */
		/* ------------------------------------------------------------------ */

		importTemplate: function( btn, importUrl, title ) {
			if ( ! importUrl ) return;

			var postId       = SKTPanel.getCurrentPostId();
			var originalText = btn.text();
			var card         = btn.closest( '.skt-modal-card' );

			btn.text( sktElementorPanel.strings.importing )
			   .prop( 'disabled', true )
			   .addClass( 'skt-importing' );

			card.append( '<div class="skt-card-importing-overlay"><span class="skt-spinner"></span></div>' );

			if ( postId ) {
				/* ── Insert sections into the open page ── */
				$.ajax( {
					url        : sktElementorPanel.importIntoPageUrl,
					type       : 'POST',
					beforeSend : function( xhr ) {
						xhr.setRequestHeader( 'X-WP-Nonce', sktElementorPanel.nonce );
					},
					data: {
						template_url  : importUrl,
						template_name : title,
						post_id       : postId
					},
					success: function( response ) {
						card.find( '.skt-card-importing-overlay' ).remove();

						if ( response && response.success ) {
							btn.text( '✓ Imported!' ).addClass( 'skt-import-done' );
							SKTPanel.closeModal();
							/* Reload the editor so the freshly appended sections appear */
							setTimeout( function() { window.location.reload(); }, 700 );
						} else {
							var msg = ( response && response.message ) ? response.message : 'unknown error';
							btn.text( originalText ).prop( 'disabled', false ).removeClass( 'skt-importing' );
							alert( 'Import failed: ' + msg );
						}
					},
					error: function() {
						card.find( '.skt-card-importing-overlay' ).remove();
						btn.text( originalText ).prop( 'disabled', false ).removeClass( 'skt-importing' );
						alert( 'Import failed. Please try again.' );
					}
				} );

			} else {
				/* ── Fallback: no post ID, create a new page (original behaviour) ── */
				$.ajax( {
					url        : sktElementorPanel.importUrl,
					type       : 'POST',
					beforeSend : function( xhr ) {
						xhr.setRequestHeader( 'X-WP-Nonce', sktElementorPanel.nonce );
					},
					data: { template_url: importUrl, template_name: title },
					success: function( redirectUrl ) {
						card.find( '.skt-card-importing-overlay' ).remove();
						if ( redirectUrl && redirectUrl !== 'no-elementor' ) {
							window.location.href = redirectUrl;
						} else {
							btn.text( originalText ).prop( 'disabled', false ).removeClass( 'skt-importing' );
							alert( 'Import failed. Ensure Elementor is active.' );
						}
					},
					error: function() {
						card.find( '.skt-card-importing-overlay' ).remove();
						btn.text( originalText ).prop( 'disabled', false ).removeClass( 'skt-importing' );
						alert( 'Import failed. Please try again.' );
					}
				} );
			}
		},

		/* ------------------------------------------------------------------ */
		/*  HTML escape helper                                                 */
		/* ------------------------------------------------------------------ */

		esc: function( str ) {
			return String( str )
				.replace( /&/g, '&amp;' ).replace( /</g, '&lt;' )
				.replace( />/g, '&gt;' ).replace( /"/g, '&quot;' )
				.replace( /'/g, '&#039;' );
		}
	};

	SKTPanel.init();

} )( jQuery );