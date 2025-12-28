(function($){

    function initGallery($scope){
        const $g = $scope.find('.absl-image-gallery');
        if(!$g.length) return;

        const per = parseInt($g.data('per-page'),10);
        const hover = $g.data('hover');
        const hoverSpeed = $g.data('hover-speed');
        const ulEnabled = $g.data('ul') === 'yes';
        const ulColor = $g.data('ul-color');
        const ulHeight = $g.data('ul-height');

        $g.css('--hover-speed', hoverSpeed + 'ms');
        $g.css('--ul-color', ulColor);
        $g.css('--ul-height', ulHeight + 'px');

        let visible = per;

        const $items = $g.find('.absl-gallery-item');
        const $btn = $g.find('.absl-load-more');

        /* Apply hover animation class */
        $items
            .removeClass('absl-hover-none absl-hover-lift absl-hover-zoom absl-hover-zoom-rotate')
            .addClass('absl-hover-' + hover);

        /* Underline on/off */
        if(!ulEnabled){
            $g.addClass('absl-ul-off');
        } else {
            $g.removeClass('absl-ul-off');
        }

        function applyFilter(filter){
            const $filtered = $items.filter(function(){
                return filter === '*' || $(this).data('category') === filter;
            });

            $items.hide();
            $filtered.slice(0, visible).fadeIn(200);

            ($filtered.length > visible) ? $btn.show() : $btn.hide();
        }

        applyFilter('*');

        $btn.on('click', function(){
            visible += per;
            applyFilter($g.find('.absl-filter button.active').data('filter'));
        });

        $g.find('.absl-filter button').on('click', function(){
            visible = per;
            $(this).addClass('active').siblings().removeClass('active');
            applyFilter($(this).data('filter'));
        });
    }

    $(window).on('elementor/frontend/init', function(){
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/absl_image_gallery.default',
            initGallery
        );
    });

})(jQuery);
