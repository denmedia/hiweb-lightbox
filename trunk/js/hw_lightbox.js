/**
 * Created by denmedia on 08.11.16.
 */

var hw_lightbox = {

        galleries: {},

        init: function () {
            hw_lightbox.do_collect_link_images();
        },


        do_collect_link_images: function () {
            jQuery('a').filter(function () {
                return jQuery(this).attr('href').match(/\.(jpg|png|gif)/i);
            }).each(function () {
                var el = jQuery(this);
                var gallery_id = el.closest('figure').length > 0 ? el.closest('figure').parent().attr('id') : hw_lightbox.makeid();
                ///
                if (!hw_lightbox.galleries.hasOwnProperty(gallery_id)) {
                    hw_lightbox.galleries[gallery_id] = [];
                }
                ///
                var index = hw_lightbox.galleries[gallery_id].length;
                el.on('click', function (e) {
                    e.preventDefault();
                    hw_lightbox.openPhotoSwipe(gallery_id, index);
                });
                ///
                hw_lightbox.galleries[gallery_id].push({
                    'el': el,
                    'src': el.attr('href'),
                    w: el.attr('data-full-width'),
                    h: el.attr('data-full-height')
                });
            });
        },

        makeid: function () {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < 5; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        },

        openPhotoSwipe: function (gallery_id, index, disableAnimation, fromURL) {
            var overlay = jQuery('.pswp');
            if (overlay.length == 0) {
                console.error('.pswp not found!');
                return;
            }
            var pswpElement = overlay[0],
                gallery,
                options,
                items;

            items = hw_lightbox.galleries[gallery_id];

            // define options (if needed)
            options = {

                // define gallery index (for URL)
                galleryUID: gallery_id,

                getThumbBoundsFn: function (index) {
                    // See Options -> getThumbBoundsFn section of documentation for more info
                    var thumbnail = items[index].el.find('img')[0], // find thumbnail
                        pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                        rect = thumbnail.getBoundingClientRect();
                    console.info({x: rect.left, y: rect.top + pageYScroll, w: rect.width});

                    return {x: rect.left, y: rect.top + pageYScroll, w: rect.width};
                }

            };

            // PhotoSwipe opened from URL
            if (fromURL) {
                if (options.galleryPIDs) {
                    // parse real index when custom PIDs are used
                    // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                    for (var j = 0; j < items.length; j++) {
                        if (items[j].pid == index) {
                            options.index = j;
                            break;
                        }
                    }
                } else {
                    // in URL indexes start from 1
                    options.index = parseInt(index, 10) - 1;
                }
            } else {
                options.index = parseInt(index, 10);
            }

            // exit if index not found
            if (isNaN(options.index)) {
                return;
            }

            if (disableAnimation) {
                options.showAnimationDuration = 0;
            }

            // Pass data to PhotoSwipe and initialize it
            gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        }

    }
    ;


jQuery(document).ready(hw_lightbox.init);