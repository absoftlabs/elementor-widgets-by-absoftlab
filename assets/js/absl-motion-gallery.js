(function ($) {

    function initMotionGallery($scope) {

        const $gallery = $scope.find('.absl-motion-gallery');
        if (!$gallery.length) return;

        const track = $gallery.find('.absl-track')[0];
        if (!track) return;

        const speedControl = parseFloat($gallery.data('speed')) || 40;
        const step = 100 / speedControl;

        const isRight = $gallery.hasClass('dir-right');

        /* clone once */
        if (!track.dataset.cloned) {
            track.innerHTML += track.innerHTML;
            track.dataset.cloned = 'true';
        }

        const baseWidth = track.scrollWidth / 2;

        // starting offset
        let x = isRight ? -baseWidth : 0;

        function animate() {

            // always move left
            x -= step;

            /*
             * MODULO-BASED LOOP
             * no hard reset = no flicker
             */
            if (x <= -baseWidth * 2) {
                x += baseWidth;
            }

            track.style.transform = `translateX(${x}px)`;
            requestAnimationFrame(animate);
        }

        animate();
    }

    $(window).on('elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction(
            'frontend/element_ready/absl_motion_gallery.default',
            initMotionGallery
        );

    });

})(jQuery);
