(function ($) {
    "use strict";

    function initBlogTabs($scope) {
        var $wrappers = $scope.find('.absl-blog-tabs');
        if (!$wrappers.length) {
            return;
        }

        $wrappers.each(function () {
            var $wrap = $(this);
            if ($wrap.data('abslTabsInit')) {
                return;
            }

            var perPage = parseInt($wrap.data('per-page'), 10) || 6;
            var maxPosts = parseInt($wrap.data('max-posts'), 10) || 24;
            var pagination = String($wrap.data('pagination')) === 'yes';
            var defaultTab = $wrap.data('default-tab') || 'all';
            var orderby = $wrap.data('orderby') || 'date';
            var order = $wrap.data('order') || 'DESC';
            var emptyText = $wrap.data('empty-text') || 'No posts found.';

            var categories = [];
            try {
                categories = JSON.parse($wrap.attr('data-categories') || '[]');
            } catch (e) {
                categories = [];
            }

            var $tabs = $wrap.find('.absl-blog-tab');
            var $grid = $wrap.find('.absl-blog-grid');
            var $cards = $grid.find('.absl-blog-card');
            var $pagination = $wrap.find('.absl-blog-pagination');
            var activeFilter = defaultTab;
            var currentPage = 1;
            var lastTotalPages = 1;

            var ajaxUrl = (window.abslBlogTabs && abslBlogTabs.ajaxUrl) ? abslBlogTabs.ajaxUrl : '';
            var useAjax = String($wrap.data('ajax')) === 'yes' && ajaxUrl;
            var nonce = $wrap.data('ajax-nonce') || '';
            if (!nonce) {
                useAjax = false;
            }

            function getAttr(name, fallback) {
                var val = $wrap.attr('data-' + name);
                return typeof val === 'undefined' ? fallback : val;
            }

            function addPageButton(label, page, isActive, isDisabled) {
                var $btn = $('<button type="button"></button>')
                    .text(label)
                    .attr('data-page', page);
                if (isActive) {
                    $btn.addClass('active');
                }
                if (isDisabled) {
                    $btn.prop('disabled', true);
                }
                return $btn;
            }

            function renderPagination(totalPages) {
                lastTotalPages = totalPages;
                $pagination.empty();

                if (!pagination || totalPages <= 1) {
                    $pagination.hide();
                    return;
                }

                $pagination.show();

                $pagination.append(addPageButton('Prev', 'prev', false, currentPage === 1));

                var maxButtons = 7;
                var start = 1;
                var end = totalPages;

                if (totalPages > maxButtons) {
                    start = Math.max(1, currentPage - 2);
                    end = Math.min(totalPages, currentPage + 2);

                    if (start <= 2) {
                        start = 1;
                        end = 5;
                    } else if (end >= totalPages - 1) {
                        start = totalPages - 4;
                        end = totalPages;
                    }
                }

                if (start > 1) {
                    $pagination.append(addPageButton('1', 1, currentPage === 1, false));
                    if (start > 2) {
                        $pagination.append('<span class="absl-ellipsis">...</span>');
                    }
                }

                for (var i = start; i <= end; i++) {
                    $pagination.append(addPageButton(String(i), i, currentPage === i, false));
                }

                if (end < totalPages) {
                    if (end < totalPages - 1) {
                        $pagination.append('<span class="absl-ellipsis">...</span>');
                    }
                    $pagination.append(addPageButton(String(totalPages), totalPages, currentPage === totalPages, false));
                }

                $pagination.append(addPageButton('Next', 'next', false, currentPage === totalPages));
            }

            function fallbackToLocal() {
                if (useAjax) {
                    useAjax = false;
                    updateView();
                }
            }

            function updateFromAjax() {
                if (!useAjax) {
                    return false;
                }

                $wrap.addClass('absl-loading');

                $.ajax({
                    url: ajaxUrl,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'absl_blog_tabs_search',
                        nonce: nonce,
                        category: activeFilter,
                        page: currentPage,
                        per_page: perPage,
                        max_posts: maxPosts,
                        orderby: orderby,
                        order: order,
                        categories: categories,
                        show_thumbnail: getAttr('show-thumbnail', 'yes'),
                        show_category_badge: getAttr('show-category-badge', 'yes'),
                        show_date: getAttr('show-date', 'yes'),
                        show_read_time: getAttr('show-read-time', 'yes'),
                        show_author: getAttr('show-author', 'yes'),
                        read_time_wpm: getAttr('read-time-wpm', 200),
                        meta_icon_size: getAttr('meta-icon-size', 24),
                        meta_icon_unit: getAttr('meta-icon-unit', 'px'),
                        show_date_icon: getAttr('show-date-icon', 'yes'),
                        show_read_time_icon: getAttr('show-read-time-icon', 'yes'),
                        show_author_icon: getAttr('show-author-icon', 'yes'),
                        date_icon: getAttr('date-icon', ''),
                        read_time_icon: getAttr('read-time-icon', ''),
                        author_icon: getAttr('author-icon', ''),
                        show_excerpt: getAttr('show-excerpt', 'yes'),
                        excerpt_length: getAttr('excerpt-length', 18),
                        excerpt_more_text: getAttr('excerpt-more-text', '...'),
                        show_read_more: getAttr('show-read-more', 'yes'),
                        read_more_text: getAttr('read-more-text', 'Read Article')
                    }
                }).done(function (resp) {
                    if (resp && resp.success) {
                        var data = resp.data || {};
                        var html = data.html || '';
                        var totalPages = data.total_pages || 0;
                        if (totalPages > 0 && currentPage > totalPages) {
                            currentPage = 1;
                            updateFromAjax();
                            return;
                        }
                        $grid.html(html);
                        $cards = $grid.find('.absl-blog-card');
                        if (!html) {
                            $grid.html('<div class="absl-blog-empty">' + emptyText + '</div>');
                        }
                        renderPagination(totalPages);
                    } else {
                        fallbackToLocal();
                    }
                }).fail(function () {
                    fallbackToLocal();
                }).always(function () {
                    $wrap.removeClass('absl-loading');
                });

                return true;
            }

            function filterCards() {
                return $cards.toArray().filter(function (card) {
                    var cats = String(card.getAttribute('data-cats') || '').split(' ');
                    if (activeFilter === 'all') {
                        return true;
                    }
                    if (cats.indexOf(activeFilter) === -1) {
                        return false;
                    }
                    return true;
                });
            }

            function showCards(filtered) {
                $cards.hide();

                if (!pagination || perPage <= 0) {
                    $(filtered).show();
                    return;
                }

                var start = (currentPage - 1) * perPage;
                var end = start + perPage;

                $(filtered.slice(start, end)).show();
            }

            function updateView() {
                if (updateFromAjax()) {
                    return;
                }

                var filtered = filterCards();
                var totalPages = (!pagination || perPage <= 0) ? 1 : Math.ceil(filtered.length / perPage);

                if (currentPage > totalPages) {
                    currentPage = 1;
                }

                showCards(filtered);
                renderPagination(totalPages);
            }

            $tabs.on('click', function () {
                var $tab = $(this);
                activeFilter = String($tab.data('filter') || 'all');
                currentPage = 1;
                $tabs.removeClass('active');
                $tab.addClass('active');
                updateView();
            });

            $pagination.on('click', 'button', function () {
                var page = $(this).data('page');
                var totalPages = lastTotalPages || 1;

                if (page === 'prev') {
                    currentPage = Math.max(1, currentPage - 1);
                } else if (page === 'next') {
                    currentPage = Math.min(totalPages, currentPage + 1);
                } else {
                    currentPage = parseInt(page, 10) || 1;
                }

                updateView();
            });

            if (!$tabs.filter('[data-filter="' + defaultTab + '"]').length) {
                defaultTab = 'all';
            }
            $tabs.removeClass('active');
            $tabs.filter('[data-filter="' + defaultTab + '"]').addClass('active');

            updateView();

            $wrap.data('abslTabsInit', true);
        });
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/absl_blog_tabs.default',
            function ($scope) {
                initBlogTabs($scope);
            }
        );
    });

    $(function () {
        initBlogTabs($(document));
    });

})(jQuery);
