(function($){

    function initGallery($scope){
        const $g = $scope.find('.absl-image-gallery');
        if(!$g.length) return;

        const per = parseInt($g.data('per-page'),10);
        const loadMode = ($g.attr('data-load-mode') || 'load_more').toString();
        const hover = $g.data('hover');
        const hoverSpeed = $g.data('hover-speed');
        const ulEnabled = $g.data('ul') === 'yes';
        const ulColor = $g.data('ul-color');
        const ulHeight = $g.data('ul-height');

        $g.css('--hover-speed', hoverSpeed + 'ms');
        $g.css('--ul-color', ulColor);
        $g.css('--ul-height', ulHeight + 'px');

        const perPage = Math.max(1, per || 1);
        let visible = perPage;
        let currentFilter = '*';
        let lastFilteredCount = 0;
        let observer = null;

        const $items = $g.find('.absl-gallery-item');
        const $btn = $g.find('.absl-load-more');
        const $sentinel = $g.find('.absl-load-sentinel');

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

            lastFilteredCount = $filtered.length;

            if(loadMode === 'infinite'){
                $btn.hide();
                (lastFilteredCount > visible) ? $sentinel.show() : $sentinel.hide();
            } else {
                $sentinel.hide();
                (lastFilteredCount > visible) ? $btn.show() : $btn.hide();
            }
        }

        function setupInfiniteObserver(){
            if(loadMode !== 'infinite') return;
            if(!('IntersectionObserver' in window)){
                $btn.show();
                $sentinel.hide();
                return;
            }
            if(observer){ observer.disconnect(); }
            observer = new IntersectionObserver(function(entries){
                entries.forEach(function(entry){
                    if(!entry.isIntersecting) return;
                    if(visible >= lastFilteredCount) return;
                    visible += perPage;
                    applyFilter(currentFilter);
                });
            }, { rootMargin: '200px 0px' });
            if($sentinel.length){
                observer.observe($sentinel[0]);
            }
        }

        currentFilter = '*';
        applyFilter(currentFilter);
        setupInfiniteObserver();

        $btn.on('click', function(){
            visible += perPage;
            applyFilter(currentFilter);
        });

        $g.find('.absl-filter button').on('click', function(){
            visible = perPage;
            $(this).addClass('active').siblings().removeClass('active');
            currentFilter = $(this).data('filter');
            applyFilter(currentFilter);
        });
    }

    $(window).on('elementor/frontend/init', function(){
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/absl_image_gallery.default',
            initGallery
        );
    });

})(jQuery);
