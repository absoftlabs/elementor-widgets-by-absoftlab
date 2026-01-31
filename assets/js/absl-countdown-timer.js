(function ($) {
    "use strict";

    function abslInitCountdownTimer($scope) {
        var $timers = $scope.find('.absl-countdown-timer');
        if (!$timers.length) {
            return;
        }

        $timers.each(function () {
            var $timer = $(this);
            if ($timer.data('abslCountdownInit')) {
                return;
            }
            $timer.data('abslCountdownInit', true);

            var duration = parseInt($timer.data('duration'), 10);
            if (isNaN(duration) || duration < 0) {
                duration = 0;
            }

            var autoReset = String($timer.data('auto-reset')) === 'yes';
            var resetDelay = parseInt($timer.data('reset-delay'), 10);
            if (isNaN(resetDelay) || resetDelay < 0) {
                resetDelay = 0;
            }

            var animation = $timer.data('animation') || 'none';
            var animDuration = parseInt($timer.data('animation-duration'), 10);
            if (isNaN(animDuration) || animDuration < 50) {
                animDuration = 600;
            }

            var remaining = duration;
            var lastTick = Date.now();
            var intervalId = null;
            var isResetting = false;

            function pad(value) {
                return value < 10 ? '0' + value : String(value);
            }

            function splitTime(totalSeconds) {
                var days = Math.floor(totalSeconds / 86400);
                var hours = Math.floor((totalSeconds % 86400) / 3600);
                var minutes = Math.floor((totalSeconds % 3600) / 60);
                var seconds = Math.floor(totalSeconds % 60);
                return {
                    days: days,
                    hours: hours,
                    minutes: minutes,
                    seconds: seconds
                };
            }

            function animateGroup($group) {
                if (!animation || animation === 'none') {
                    return;
                }
                $group.addClass('absl-ct-animate');
                setTimeout(function () {
                    $group.removeClass('absl-ct-animate');
                }, animDuration);
            }

            function setUnit(unit, value, padValue) {
                var $group = $timer.find('.absl-ct-' + unit).first();
                if (!$group.length) {
                    return;
                }
                var $value = $group.find('.absl-ct-value').first();
                if (!$value.length) {
                    return;
                }
                var nextValue = padValue ? pad(value) : String(value);
                if ($value.text() !== nextValue) {
                    $value.text(nextValue);
                    animateGroup($group);
                }
            }

            function render(force) {
                var parts = splitTime(Math.max(0, remaining));
                setUnit('days', parts.days, true);
                setUnit('hours', parts.hours, true);
                setUnit('minutes', parts.minutes, true);
                setUnit('seconds', parts.seconds, true);

                if (force) {
                    $timer.find('.absl-ct-value').each(function () {
                        $(this).text($(this).text());
                    });
                }
            }

            function resetCountdown() {
                remaining = duration;
                lastTick = Date.now();
                render(true);
            }

            function tick() {
                if (duration <= 0) {
                    render(true);
                    if (intervalId) {
                        clearInterval(intervalId);
                        intervalId = null;
                    }
                    return;
                }

                var now = Date.now();
                if (isResetting) {
                    lastTick = now;
                    return;
                }
                var elapsed = Math.floor((now - lastTick) / 1000);
                if (elapsed < 1) {
                    return;
                }

                remaining -= elapsed;
                lastTick = now;

                if (remaining <= 0) {
                    remaining = 0;
                    render();
                    if (autoReset) {
                        if (!isResetting) {
                            isResetting = true;
                            setTimeout(function () {
                                isResetting = false;
                                resetCountdown();
                            }, resetDelay * 1000);
                        }
                    } else {
                        if (intervalId) {
                            clearInterval(intervalId);
                            intervalId = null;
                        }
                    }
                    return;
                }

                render();
            }

            render(true);
            intervalId = setInterval(tick, 250);
        });
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/absl_countdown_timer.default',
            function ($scope) {
                abslInitCountdownTimer($scope);
            }
        );
    });

    $(function () {
        abslInitCountdownTimer($(document));
    });
})(jQuery);
