opjq(document).ready(function($){

    // We don't want to trigger a popup if any other popup is already opened.
    var popupOpen = false;

    $('.op-popup-button').each(function () {

        var $this = $(this);
        var $popup = $this.parent();
        var $popupContent = $this.next();
        var userWidth = $popup.data('width') || '0';
        var openEffect;
        var userOpenEffect = $popup.data('open-effect') || 'fade';
        var openMethod;
        var userOpenMethod = $popup.data('open-method') || 'zoomIn';
        var closeEffect;
        var userCloseEffect = $popup.data('close-effect') || 'fade';
        var borderColor = $popup.data('border-color') || '#ffffff';
        var borderSize = $popup.data('border-size');
        var autoSize;
        var width;
        var paddingTop = $popup.data('padding-top');
        var paddingBottom = $popup.data('padding-bottom');
        var paddingLeft = $popup.data('padding-left');
        var paddingRight = $popup.data('padding-right');
        var padding;
        var popupId = $popup.data('popup-id');

        // Overlay pop options
        var exitIntent = $popup.data('exit-intent');
        var triggerTime = $popup.data('trigger-time')
        var triggerDontshow = $popup.data('trigger-dontshow');
        var triggerTimeTimeout;
        var dontShowOnTablet = $popup.data('dont-show-on-tablet');
        var dontShowOnMobile = $popup.data('dont-show-on-mobile');

        // Number of seconds that has to pass until popup is shown again
        // (unless triggerDontShow) is set
        var dontShowPopupTime = 10;

        // Number of pixels from top of the page where popup is triggered.
        // When user moves the moust fast, pixels are skipped, that's why this is necessery.
        var exitIntentSensitivity = 40;

        var exitIntentTriggered = false;
        var exitIntentTriggeredTimeout;
        var clientYprev;

        // Opens the popup
        var openPopup = function (e) {

            // Obviously, if popup is already opened we can quit here
            if (popupOpen) {
                return false;
            }

            // It's not always opened through a click event
            if (e) {
                e.preventDefault();
            }

            // Global var that tracks if any of popups is already opened.
            popupOpen = true;

            // Set exit intent temp timeout
            // (because we don't want to open a popup automatically immediately after it has been closed)
            setExitIntentTriggeredTimeout();

            // Set cookie for opening if applicable
            setDontshow();

            // We don't want to trigger popup on time automatically if it has already been shown/opened
            clearTimeout(triggerTimeTimeout);

            if (typeof borderSize !== 'number') {
                borderSize = 15;
            }

            if (parseInt(userWidth, 10) === 0) {
                autoSize = true;
                width = 'auto';
                minWidth = 20;
            } else {
                autoSize = false;
                width = userWidth;
                minWidth = userWidth;
            }

            switch (userOpenEffect) {
                case 'fade':
                    openEffect = 'fade';
                    openMethod = 'zoomIn';
                    break;
                case 'elastic':
                    openEffect = 'fade';
                    openMethod = 'changeIn';
                    break;
                case 'none':
                    openEffect = 'none';
                    openMethod = 'zoomIn';
                    break;
            }

            switch (userCloseEffect) {
                case 'fade':
                    closeEffect = 'fade';
                    break;
                case 'zoomOut':
                    closeEffect = 'elastic';
                    break;
                case 'none':
                    closeEffect = 'none';
                    break;
            }

            $popupContent
                .css({ padding: paddingTop + 'px ' + paddingRight + 'px ' + paddingBottom + 'px ' + paddingLeft + 'px' })
                .addClass('op-popup-content-visible');

            $.fancybox({
                content: $popupContent,

                autoSize: autoSize,
                minHeight: 20,
                width: width,
                minWidth: minWidth,
                padding: borderSize,
                autoHeight: true,
                height: 'auto',

                openEffect: openEffect,
                openMethod: openMethod,     // zoomIn value must be paired with fade effect
                closeEffect: closeEffect,   // none, elastic or fade (elastic works as zoom out)
                closeMethod: 'zoomOut',     // Fanybox causes errors if this isn't fixed to zoom
                openSpeed: $popup.data('open-speed') || 'normal',
                closeSpeed: $popup.data('close-speed') || 'normal',

                wrapCSS: 'op-popup-fancybox',

                beforeShow: function () {
                    $popupContent.parent().parent().css('background-color', borderColor);
                },

                afterShow: function () {
                    // JS plugins can hook up to this event like so: $(window).on('op-popup-opened', func);
                    $(window).trigger('op-popup-opened');
                },

                // When window is resized, or popup opened, make sure that width of the popup/fancybox is proper.
                onUpdate: function () {

                    var $fancyboxWrap = $popupContent.parent().parent().parent();
                    var fancyboxOuterWidth = $fancyboxWrap.width();
                    var fancyboxOuterPadding = parseInt($fancyboxWrap.css('left'), 10) * 2;
                    var windowWidth = $(window).width();

                    if (windowWidth <= fancyboxOuterWidth) {
                        $fancyboxWrap.css({
                            width: (fancyboxOuterWidth - fancyboxOuterPadding - 12) + 'px',
                            left: '26px'
                        });
                        $('#fancybox-overlay').css({ width: windowWidth + 'px' });
                    }

                },

                afterClose: function () {
                    $popupContent.removeClass('op-popup-content-visible');
                    $(window).trigger('op-popup-closed', $popupContent[0]);
                    $this.after($popupContent);
                    popupOpen = false;
                }

            });

        }

        $this.on('click', openPopup);

        // retruns true or false based on dontShowOnTablet & dontShowOnMobile options according to current screen size
        var showOnThisScreen = function () {
            var docWidth = false;

            if (dontShowOnTablet === 'Y') {
                docWidth = window.innerWidth;
                if (docWidth <= 959 && docWidth >= 768) {
                    return false;
                }
            }

            if (dontShowOnMobile === 'Y') {
                docWidth = docWidth || window.innerWidth;
                if (docWidth <= 767) {
                    return false;
                }
            }

            return true;
        }

        // When a popup is opened we most likely don't want to show it again (automatically) for at least dontShowPopupTime seconds
        var setExitIntentTriggeredTimeout = function () {
            exitIntentTriggered = true;
            exitIntentTriggeredTimeout = setTimeout(function () {
                exitIntentTriggered = false;
            }, dontShowPopupTime * 1000);
        }

        // Trigger the popup after x number of seconds (if set).
        triggerTime = triggerTime ? parseInt(triggerTime) : 0;
        if (triggerTime > 0) {
            triggerTimeTimeout = setTimeout(function() {
                if (!exitIntentTriggered && !isDontShowSet() && showOnThisScreen()) {
                    openPopup();
                }
            }, triggerTime * 1000);
        }

        // If exitIntent is set, handle it. duh.
        if (exitIntent === 'Y') {
            exitIntentTriggered = false;
            exitIntentTriggeredTimeout;
            clientYprev = -1;

            $('body').on('mousemove', function (e) {
                // Only open popup if
                // - popup is not already opened
                // - popup is not recently closed
                // - dontshow cookie is not set
                // - mouse doesn't enter the top of the page top-down (not exit intent)
                // - popup should be shown on this screen size (dont-show-on-tablet & dont-show-on-mobile options)
                if (exitIntentTriggered || isDontShowSet() || clientYprev <= e.clientY || !showOnThisScreen()) {
                    clientYprev = e.clientY;
                    return false;
                }
                clientYprev = e.clientY;

                if (e.clientY < exitIntentSensitivity) {
                    openPopup();
                }
            });
        }

        triggerDontshow = triggerDontshow ? parseInt(triggerDontshow) : 0;
        // Sets cookie with dontShow value, so that popup isn't opened for next dontShow days
        var setDontshow = function () {
            if (triggerDontshow > 0) {
                OptimizePress.cookie.create(popupId, 'dontshow', triggerDontshow);
            }
        }

        // returns true if cookie is set and popup shouldn't be automatically opened
        var isDontShowSet = function () {
            return !!OptimizePress.cookie.read(popupId);
        }

    });

});