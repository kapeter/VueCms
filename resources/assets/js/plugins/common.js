var App = function() {
    // Helper variables - set in uiInit()
    var $lHtml, $lBody, $lPage, $lSidebar, $lSidebarScroll, $lSideOverlay, $lSideOverlayScroll, $lHeader, $lMain, $lFooter;

    /*
     ********************************************************************************************
     *
     * BASE UI FUNCTIONALITY
     *
     * Functions which handle vital UI functionality such as main navigation and layout
     * They are auto initialized in every page
     *
     *********************************************************************************************
     */

    // User Interface init
    var uiInit = function() {
        // Set variables
        $lHtml              = jQuery('html');
        $lBody              = jQuery('body');
        $lPage              = jQuery('#page-container');
        $lSidebar           = jQuery('#sidebar');
        $lSidebarScroll     = jQuery('#sidebar-scroll');
        $lSideOverlay       = jQuery('#side-overlay');
        $lSideOverlayScroll = jQuery('#side-overlay-scroll');
        $lHeader            = jQuery('#header-navbar');
        $lMain              = jQuery('#main-container');
        $lFooter            = jQuery('#page-footer');

        // Initialize Tooltips
        $('[data-toggle="tooltip"], .js-tooltip').tooltip({
            container: 'body',
            animation: false
        });

        // Initialize Popovers
        $('[data-toggle="popover"], .js-popover').popover({
            container: 'body',
            animation: true,
            trigger: 'hover'
        });
    };

    // Layout functionality
    var uiLayout = function() {

        // Init sidebar and side overlay custom scrolling
        uiHandleScroll('init');

        // Init transparent header functionality (solid on scroll - used in frontend)
        if ($lPage.hasClass('header-navbar-fixed') && $lPage.hasClass('header-navbar-transparent')) {
            jQuery(window).on('scroll', function(){
                if (jQuery(this).scrollTop() > 20) {
                    $lPage.addClass('header-navbar-scroll');
                } else {
                    $lPage.removeClass('header-navbar-scroll');
                }
            });
        }
    };

    // Handles sidebar and side overlay custom scrolling functionality
    var uiHandleScroll = function($mode) {
        var $windowW = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

        // Init scrolling
        if ($mode === 'init') {
            // Init scrolling only if required the first time
            uiHandleScroll();

            // Handle scrolling on resize or orientation change
            var $sScrollTimeout;

            jQuery(window).on('resize orientationchange', function(){
                clearTimeout($sScrollTimeout);

                $sScrollTimeout = setTimeout(function(){
                    uiHandleScroll();
                }, 150);
            });
        } else {
            // If screen width is greater than 991 pixels and .side-scroll is added to #page-container
            if ($windowW > 991 && $lPage.hasClass('side-scroll')) {
                // Turn scroll lock off (sidebar and side overlay - slimScroll will take care of it)
                jQuery($lSidebar).scrollLock('disable');
                jQuery($lSideOverlay).scrollLock('disable');

                // If sidebar scrolling does not exist init it..
                if ($lSidebarScroll.length && (!$lSidebarScroll.parent('.slimScrollDiv').length)) {
                    $lSidebarScroll.slimScroll({
                        height: $lSidebar.outerHeight(),
                        color: '#fff',
                        size: '5px',
                        opacity : .35,
                        wheelStep : 15,
                        distance : '2px',
                        railVisible: false,
                        railOpacity: 1
                    });
                }
                else { // ..else resize scrolling height
                    $lSidebarScroll
                        .add($lSidebarScroll.parent())
                        .css('height', $lSidebar.outerHeight());
                }

                // If side overlay scrolling does not exist init it..
                if ($lSideOverlayScroll.length && (!$lSideOverlayScroll.parent('.slimScrollDiv').length)) {
                    $lSideOverlayScroll.slimScroll({
                        height: $lSideOverlay.outerHeight(),
                        color: '#000',
                        size: '5px',
                        opacity : .35,
                        wheelStep : 15,
                        distance : '2px',
                        railVisible: false,
                        railOpacity: 1
                    });
                }
                else { // ..else resize scrolling height
                    $lSideOverlayScroll
                        .add($lSideOverlayScroll.parent())
                        .css('height', $lSideOverlay.outerHeight());
                }
            } else {
                // Turn scroll lock on (sidebar and side overlay)
                jQuery($lSidebar).scrollLock('enable');
                jQuery($lSideOverlay).scrollLock('enable');

                // If sidebar scrolling exists destroy it..
                if ($lSidebarScroll.length && $lSidebarScroll.parent('.slimScrollDiv').length) {
                    $lSidebarScroll
                        .slimScroll({destroy: true});
                    $lSidebarScroll
                        .attr('style', '');
                }

                // If side overlay scrolling exists destroy it..
                if ($lSideOverlayScroll.length && $lSideOverlayScroll.parent('.slimScrollDiv').length) {
                    $lSideOverlayScroll
                        .slimScroll({destroy: true});
                    $lSideOverlayScroll
                        .attr('style', '');
                }
            }
        }
    };

    // Blocks options functionality
    var uiBlocks = function() {
        // Init default icons fullscreen and content toggle buttons
        uiBlocksApi(false, 'init');

        // Call blocks API on option button click
        jQuery('[data-toggle="block-option"]').on('click', function(){
            uiBlocksApi(jQuery(this).closest('.block'), jQuery(this).data('action'));
        });
    };

    // Blocks API
    var uiBlocksApi = function($block, $mode) {
        // Set default icons for fullscreen and content toggle buttons
        var $iconFullscreen         = 'si si-size-fullscreen';
        var $iconFullscreenActive   = 'si si-size-actual';

        if ($mode === 'init') {
            // Auto add the default toggle icons to fullscreen and content toggle buttons
            jQuery('[data-toggle="block-option"][data-action="fullscreen_toggle"]').each(function(){
                var $this = jQuery(this);

                $this.html('<i class="' + (jQuery(this).closest('.block').hasClass('block-opt-fullscreen') ? $iconFullscreenActive : $iconFullscreen) + '"></i>');
            });

        } else {
            // Get block element
            var $elBlock = ($block instanceof jQuery) ? $block : jQuery($block);

            // If element exists, procceed with blocks functionality
            if ($elBlock.length) {
                // Get block option buttons if exist (need them to update their icons)
                var $btnFullscreen  = jQuery('[data-toggle="block-option"][data-action="fullscreen_toggle"]', $elBlock);

                // Mode selection
                switch($mode) {
                    case 'fullscreen_toggle':
                        $elBlock.toggleClass('block-opt-fullscreen');

                        // Enable/disable scroll lock to block
                        if ($elBlock.hasClass('block-opt-fullscreen')) {
                            jQuery($elBlock).scrollLock('enable');
                        } else {
                            jQuery($elBlock).scrollLock('disable');
                        }

                        // Update block option icon
                        if ($btnFullscreen.length) {
                            if ($elBlock.hasClass('block-opt-fullscreen')) {
                                jQuery('i', $btnFullscreen)
                                    .removeClass($iconFullscreen)
                                    .addClass($iconFullscreenActive);
                            } else {
                                jQuery('i', $btnFullscreen)
                                    .removeClass($iconFullscreenActive)
                                    .addClass($iconFullscreen);
                            }
                        }
                        break;
                    case 'fullscreen_on':
                        $elBlock.addClass('block-opt-fullscreen');

                        // Enable scroll lock to block
                        jQuery($elBlock).scrollLock('enable');

                        // Update block option icon
                        if ($btnFullscreen.length) {
                            jQuery('i', $btnFullscreen)
                                .removeClass($iconFullscreen)
                                .addClass($iconFullscreenActive);
                        }
                        break;
                    case 'fullscreen_off':
                        $elBlock.removeClass('block-opt-fullscreen');

                        // Disable scroll lock to block
                        jQuery($elBlock).scrollLock('disable');

                        // Update block option icon
                        if ($btnFullscreen.length) {
                            jQuery('i', $btnFullscreen)
                                .removeClass($iconFullscreenActive)
                                .addClass($iconFullscreen);
                        }
                        break;
                    case 'content_hide':
                        $elBlock.addClass('block-opt-hidden');

                        // Update block option icon
                        if ($btnToggle.length) {
                            jQuery('i', $btnToggle)
                                .removeClass($iconContent)
                                .addClass($iconContentActive);
                        }
                        break;
                    case 'content_show':
                        $elBlock.removeClass('block-opt-hidden');

                        // Update block option icon
                        if ($btnToggle.length) {
                            jQuery('i', $btnToggle)
                                .removeClass($iconContentActive)
                                .addClass($iconContent);
                        }
                        break;
                    case 'refresh_toggle':
                        $elBlock.toggleClass('block-opt-refresh');

                        // Return block to normal state if the demostration mode is on in the refresh option button - data-action-mode="demo"
                        if (jQuery('[data-toggle="block-option"][data-action="refresh_toggle"][data-action-mode="demo"]', $elBlock).length) {
                            setTimeout(function(){
                                $elBlock.removeClass('block-opt-refresh');
                            }, 2000);
                        }
                        break;
                    case 'state_loading':
                        $elBlock.addClass('block-opt-refresh');
                        break;
                    case 'state_normal':
                        $elBlock.removeClass('block-opt-refresh');
                        break;
                    case 'close':
                        $elBlock.hide();
                        break;
                    case 'open':
                        $elBlock.show();
                        break;
                    default:
                        return false;
                }
            }
        }
    };

    // Scroll to element animation helper
    var uiScrollTo = function() {
        jQuery('[data-toggle="scroll-to"]').on('click', function(){
            var $this           = jQuery(this);
            var $target         = $this.data('target');
            var $speed          = $this.data('speed') ? $this.data('speed') : 1000;
            var $headerHeight   = ($lHeader.length && $lPage.hasClass('header-navbar-fixed')) ? $lHeader.outerHeight() : 0;

            jQuery('html, body').animate({
                scrollTop: jQuery($target).offset().top - $headerHeight
            }, $speed);
        });
    };

    // Toggle class helper
    var uiToggleClass = function() {
        jQuery('[data-toggle="class-toggle"]').on('click', function(){
            var $el = jQuery(this);

            jQuery($el.data('target').toString()).toggleClass($el.data('class').toString());

            if ($lHtml.hasClass('no-focus')) {
                $el.blur();
            }
        });
    };

    // Manage page loading screen functionality
    var uiLoader = function($mode) {
        var $lpageLoader = jQuery('#page-loader');

        if ($mode === 'show') {
            if ($lpageLoader.length) {
                $lpageLoader.fadeIn(250);
            } else {
                $lBody.prepend('<div id="page-loader"></div>');
            }
        } else if ($mode === 'hide') {
            if ($lpageLoader.length) {
                $lpageLoader.fadeOut(250);
            }
        }

        return false;
    };

    /*
     ********************************************************************************************
     *
     * UI HELPERS (ON DEMAND)
     *
     * Third party plugin inits or various custom user interface helpers to extend functionality
     * They need to be called in a page to be initialized. They are included here to be easy to
     * init them on demand on multiple pages (usually repeated init code in common components)
     *
     ********************************************************************************************
     */

    /*
     * Print Page functionality
     *
     * App.initHelper('print-page');
     *
     */
    var uiHelperPrint = function() {
        // Store all #page-container classes
        var $pageCls = $lPage.prop('class');

        // Remove all classes from #page-container
        $lPage.prop('class', '');

        // Print the page
        window.print();

        // Restore all #page-container classes
        $lPage.prop('class', $pageCls);
    };

    /*
     * jQuery SlimScroll, for more examples you can check out http://rocha.la/jQuery-slimScroll
     *
     * App.initHelper('slimscroll');
     *
     */
    var uiHelperSlimscroll = function(){
        // Init slimScroll functionality
        jQuery('[data-toggle="slimscroll"]').each(function(){
            var $this       = jQuery(this);
            var $height     = $this.data('height') ? $this.data('height') : '200px';
            var $size       = $this.data('size') ? $this.data('size') : '5px';
            var $position   = $this.data('position') ? $this.data('position') : 'right';
            var $color      = $this.data('color') ? $this.data('color') : '#000';
            var $avisible   = $this.data('always-visible') ? true : false;
            var $rvisible   = $this.data('rail-visible') ? true : false;
            var $rcolor     = $this.data('rail-color') ? $this.data('rail-color') : '#999';
            var $ropacity   = $this.data('rail-opacity') ? $this.data('rail-opacity') : .3;

            $this.slimScroll({
                height: $height,
                size: $size,
                position: $position,
                color: $color,
                alwaysVisible: $avisible,
                railVisible: $rvisible,
                railColor: $rcolor,
                railOpacity: $ropacity
            });
        });
    };

    /*
     ********************************************************************************************
     *
     * All the following helpers require each plugin's resources (JS, CSS) to be included in order to work
     *
     ********************************************************************************************
     */

    return {
        init: function($func) {
            switch ($func) {
                case 'uiInit':
                    uiInit();
                    break;
                case 'uiLayout':
                    uiLayout();
                    break;
                case 'uiBlocks':
                    uiBlocks();
                    break;
                case 'uiToggleClass':
                    uiToggleClass();
                    break;
                case 'uiScrollTo':
                    uiScrollTo();
                    break;
                case 'uiLoader':
                    uiLoader('hide');
                    break;
                default:
                    // Init all vital functions
                    uiInit();
                    uiLayout();
                    uiBlocks();
                    uiToggleClass();
                    uiScrollTo();
                    uiLoader('hide');
            }
        },
        loader: function($mode) {
            uiLoader($mode);
        },
        blocks: function($block, $mode) {
            uiBlocksApi($block, $mode);
        },
        initHelper: function($helper) {
            switch ($helper) {
                case 'print-page':
                    uiHelperPrint();
                    break;
                case 'slimscroll':
                    uiHelperSlimscroll();
                    break;
                default:
                    return false;
            }
        },
        initHelpers: function($helpers) {
            if ($helpers instanceof Array) {
                for(var $index in $helpers) {
                    App.initHelper($helpers[$index]);
                }
            } else {
                App.initHelper($helpers);
            }
        }
    };
}();

// Create an alias for App (you can use OneUI in your pages instead of App if you like)
var OneUI = App;

// Initialize app when page loads
jQuery(function(){
    if (typeof angular == 'undefined') {
        App.init();
    }
});