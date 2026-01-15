(function($){
    function setOpen($item, open){
        var $body = $item.find('.absl-course-body');
        if(!$body.length){
            return;
        }
        if(open){
            $item.addClass('is-open');
            $body.css('max-height', $body.get(0).scrollHeight + 'px');
            $item.find('.absl-course-header').attr('aria-expanded', 'true');
        } else {
            $item.removeClass('is-open');
            $body.css('max-height', 0);
            $item.find('.absl-course-header').attr('aria-expanded', 'false');
        }
    }

    function initAccordion($scope){
        var $accordions = $scope.find('.absl-course-accordion');
        if(!$accordions.length){
            return;
        }

        $accordions.each(function(){
            var $root = $(this);
            var allowMultiple = $root.data('allow-multiple') === 'yes';

            $root.find('.absl-course-item').each(function(){
                var $item = $(this);
                setOpen($item, $item.hasClass('is-open'));
            });

            $root.on('click', '.absl-course-header', function(){
                var $item = $(this).closest('.absl-course-item');
                var isOpen = $item.hasClass('is-open');
                if(!allowMultiple){
                    $item.siblings('.absl-course-item.is-open').each(function(){
                        setOpen($(this), false);
                    });
                }
                setOpen($item, !isOpen);
            });

            $root.on('keydown', '.absl-course-header', function(e){
                if(e.key !== 'Enter' && e.key !== ' '){
                    return;
                }
                e.preventDefault();
                $(this).trigger('click');
            });

            $(window).on('resize', function(){
                $root.find('.absl-course-item.is-open .absl-course-body').each(function(){
                    $(this).css('max-height', this.scrollHeight + 'px');
                });
            });
        });
    }

    $(window).on('elementor/frontend/init', function(){
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/absl_course_accordion.default',
            initAccordion
        );
    });
})(jQuery);
