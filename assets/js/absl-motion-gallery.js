(function ($) {

    function initMotionGallery($scope) {

        const $gallery = $scope.find('.absl-motion-gallery');
        if (!$gallery.length) return;

        const track = $gallery.find('.absl-track')[0];
        if (!track) return;

        const speedControl = parseFloat($gallery.data('speed')) || 40;
        const speed = 100 / speedControl;

        const isRight = $gallery.hasClass('dir-right');

        /* --------- CLONE CONTENT (ONCE) --------- */
        if (!track.dataset.infinite) {
            track.innerHTML += track.innerHTML;
            track.innerHTML += track.innerHTML; // 3x content
            track.dataset.infinite = 'true';
        }

        /* --------- FREEZE WIDTH (CRITICAL) --------- */
        const baseWidth = track.scrollWidth / 3;

        let pos = 0;

        function animate() {

            pos -= speed;

            /*
             * MODULO LOOP
             * Never jumps, never resets
             */
            pos = pos % baseWidth;

            track.style.transform = `translateX(${isRight ? -pos : pos}px)`;

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
