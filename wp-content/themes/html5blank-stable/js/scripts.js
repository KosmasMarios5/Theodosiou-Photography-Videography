(function ($, root, undefined) {

    $(function () {

        'use strict';

        $(".menubar .menu-item-has-children")
            .click(function (evt) {
                evt.stopPropagation();
                const ul = $(this).children("ul");
                if (ul.hasClass('animated-c')) {
                    ul.removeClass('animated-c');
                    ul.animate({"max-height": 0}, {queue: false, duration: 300});
                } else {
                    ul.addClass('animated-c');
                    ul.animate({"max-height": ul[0].scrollHeight}, {queue: false, duration: 300});

                    $(this).parents('.animated-c').map(function () {
                        const p = $(this);
                        p.css("max-height", p[0].scrollHeight + ul[0].scrollHeight);
                    })
                }

            })
    });

})(jQuery, this);
