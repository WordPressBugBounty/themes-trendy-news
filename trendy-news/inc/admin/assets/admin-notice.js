/**
 * Theme Info
 * 
 * @package Trendy News
 * @since 1.2.0
 */
 jQuery(document).ready(function($) {
    var ajaxUrl = trendyNewsThemeInfoObject.ajaxUrl, _wpnonce = trendyNewsThemeInfoObject._wpnonce, container = $( ".trendy-news-admin-notice" )

    // dismiss admin welcome notice
    var dismissWelcomeNotice = $( ".trendy-news-welcome-notice .notice-dismiss-button" )
    if( dismissWelcomeNotice.length > 0 ) {
        dismissWelcomeNotice.on( "click", function(e) {
            e.preventDefault();
            _this = $(this)
            $.ajax({
                url: ajaxUrl,
                type: 'post',
                data: {
                    "action": "trendy_news_dismiss_welcome_notice",
                    "_wpnonce": _wpnonce
                },
                beforeSend: function() {
                    _this.text(trendyNewsThemeInfoObject.dismissingText)
                },
                success: function(res) {
                    var notice = JSON.parse(res);
                    if( notice.status ) {
                        dismissWelcomeNotice.parents(".trendy-news-welcome-notice").fadeOut();
                    }
                }
            })
        })
    }

    // redirect notice button
    if( container.length ) {
        container.on( "click", ".notice-actions .button", function(e) {
            e.preventDefault();
            var _this = $(this), redirect = _this.data("redirect")
            $.ajax({
                url: ajaxUrl,
                type: 'post',
                data: {
                    "action": "trendy_news_set_ajax_transient",
                    "_wpnonce": _wpnonce
                },
                success: function(res) {
                    var notice = JSON.parse(res);
                    if( notice.status ) {
                        container.fadeOut();
                    }
                },
                complete: function() {
                    if( redirect ) {
                        window.open( redirect, "_blank" )
                    }
                }
            })
        })
    }
 })