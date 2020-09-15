(function ($, root, undefined) {

    $(function () {

        'use strict';

        // $(document).mouseup(function (e) {//hide menu when user clicks outside
        //     const container = $(".menubar");
        //     if (!container.is(e.target) && container.has(e.target).length === 0) {
        //         $('.menubar__burger').click();
        //     }
        // });

        $('.menubar  a[href="#"]')
            .click(function (evt) {//stop empty links changing the url
                evt.preventDefault();
            })

        $(".menubar .menubar__burger")
            .mouseenter(function (evt) {//show menu on burger hover
                evt.stopPropagation();
                const ul = $(this).children("ul");
                ul.addClass('animated-c');
                ul.animate({"max-height": ul[0].scrollHeight}, {queue: false, duration: 300});
                $(this)
                    .find('.burger')
                    .addClass('burger--active');
            });

        $(".menubar .menu-item-has-children")//toggle menu - submenu on click
            .click(function (evt) {
                evt.stopPropagation();
                const ul = $(this).children("ul");
                if (ul.hasClass('animated-c')) {//hide menu - submenu
                    ul.removeClass('animated-c');
                    ul.animate({"max-height": 0}, {queue: false, duration: 300});
                    if ($(this).hasClass('menubar__burger')) {//if top list gets toggled remove burger animation
                        $(this)
                            .find('.burger')
                            .removeClass('burger--active');
                    }
                } else {//show menu - submenu
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
