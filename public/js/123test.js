$(document).ready(function() {
    //setTimeout(animatedCounter, 10);
    animateMenuInfo();
    set_collapse_event();
});

$(window).scroll(function() {
    its123ScrollEvent();
});
! function($) {
    "use strict";
    var Collapse = function(element, options) {
        this.$element = $(element)
        this.options = $.extend({}, $.fn.collapse.defaults, options)
        if (this.options.parent) {
            this.$parent = $(this.options.parent)
        }
        this.options.toggle && this.toggle()
    }
    Collapse.prototype = {
        constructor: Collapse,
        dimension: function() {
            var hasWidth = this.$element.hasClass('width')
            return hasWidth ? 'width' : 'height'
        },
        show: function() {
            var dimension, scroll, actives, hasData
            if (this.transitioning || this.$element.hasClass('in'))
                return
            dimension = this.dimension()
            scroll = $.camelCase(['scroll', dimension].join('-'))
            actives = this.$parent && this.$parent.find('> .accordion-group > .in')
            if (actives && actives.length) {
                hasData = actives.data('collapse')
                if (hasData && hasData.transitioning)
                    return
                actives.collapse('hide')
                hasData || actives.data('collapse', null)
            }
            this.$element[dimension](0)
            this.transition('addClass', $.Event('show'), 'shown')
            $.support.transition && this.$element[dimension](this.$element[0][scroll])
        },
        hide: function() {
            var dimension
            if (this.transitioning || !this.$element.hasClass('in'))
                return
            dimension = this.dimension()
            this.reset(this.$element[dimension]())
            this.transition('removeClass', $.Event('hide'), 'hidden')
            this.$element[dimension](0)
        },
        reset: function(size) {
            var dimension = this.dimension()
            this.$element.removeClass('collapse')[dimension](size || 'auto')[0].offsetWidth
            this.$element[size !== null ? 'addClass' : 'removeClass']('collapse')
            return this
        },
        transition: function(method, startEvent, completeEvent) {
            var that = this,
                complete = function() {
                    if (startEvent.type == 'show')
                        that.reset()
                    that.transitioning = 0
                    that.$element.trigger(completeEvent)
                }
            this.$element.trigger(startEvent)
            if (startEvent.isDefaultPrevented())
                return
            this.transitioning = 1
            this.$element[method]('in')
            $.support.transition && this.$element.hasClass('collapse') ? this.$element.one($.support.transition.end, complete) : complete()
        },
        toggle: function() {
            this[this.$element.hasClass('in') ? 'hide' : 'show']()
        }
    }
    var old = $.fn.collapse
    $.fn.collapse = function(option) {
        return this.each(function() {
            var $this = $(this),
                data = $this.data('collapse'),
                options = $.extend({}, $.fn.collapse.defaults, $this.data(), typeof option == 'object' && option)
            if (!data)
                $this.data('collapse', (data = new Collapse(this, options)))
            if (typeof option == 'string')
                data[option]()
        })
    }
    $.fn.collapse.defaults = {
        toggle: true
    }
    $.fn.collapse.Constructor = Collapse
    $.fn.collapse.noConflict = function() {
        $.fn.collapse = old
        return this
    }
}(window.jQuery);

function set_collapse_event() {
    $("[data-toggle=collapse]").not('.itsAjaxLoader').on("click", collapse_event).addClass('itsAjaxLoader');
}

function collapse_event(e) {
    var $this = $(this),
        href, target = $this.attr('data-target') || e.preventDefault() || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, ''),
        option = $(target).data('collapse') ? 'toggle' : $this.data()
    $this[$(target).hasClass('in') ? 'addClass' : 'removeClass']('collapsed')
    $(target).collapse(option)
}

function its123ScrollEvent() {
    var scroll = $(window).scrollTop();
    var navigation = $(".its123-fixed-header");
    var subheader = $('#its123CounterSubHeader');
    var socialSidebar = $(".social-media-sidebar");
    if (scroll >= 80) {
        navigation.addClass("fix-header").removeClass("unfix-header");
        subheader.addClass("hide-sub").removeClass("show-sub");
    } else {
        navigation.removeClass("fix-header").addClass("unfix-header");
        subheader.removeClass("hide-sub").addClass("show-sub");
    }
    if (scroll >= 250) {
        socialSidebar.addClass("show").removeClass("hide");
    }
}

function its123ThousandSeparateNumber(val) {
    var thousandNotation = ",";
    if (document.getElementById('its123ThousandNotationFromJson') != null) {
        thousandNotation = document.getElementById('its123ThousandNotationFromJson').value;
    }
    while (/(\d+)(\d{3})/.test(val.toString())) {
        val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1" + thousandNotation);
    }
    return val;
}

function animateMenuInfo() {
    // $("#menuInfoInstruments").animate({
    //     opacity: 0.85,
    //     left: "+=50",
    //     height: "toggle"
    // }, 1000, function() {
    //     // Animation complete.

    // });
    $("#its123footer").show();

}

function animatedCounter() {
    $('#its123CounterSubHeader').show();
    $(".its123-count").each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $('#its123CountTestFromJson').val()
        }, {
            duration: 2500,
            easing: 'swing',
            step: function(now) {
                $(this).text(its123ThousandSeparateNumber(Math.ceil(now)));
            }
        });
    });
}