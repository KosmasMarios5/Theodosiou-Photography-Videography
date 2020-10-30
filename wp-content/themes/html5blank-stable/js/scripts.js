(function ($, root, undefined) {

    $(function () {

        'use strict';

        $(window).scroll(function() {
            const scroll = $(window).scrollTop();

            const header = $("#page-header");

            if (scroll >= 100) {
                    header.css("box-shadow", "0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24)");
            }
            else{
                header.css("box-shadow", "none");
            }
        }); //missing );

        $(document).mouseup(function (e) {//hide menu when user clicks outside
            const container = $(".menubar");
            const list = $('.menubar__burger');
            if (!container.is(e.target) && container.has(e.target).length === 0 && list.hasClass('close')) {
                list.click();
            }
        });

        $('.menubar  a[href="#"]')
            .click(function (evt) {//stop empty links changing the url
                evt.preventDefault();
            })

        if (!('ontouchstart' in window)) {
            $(".menubar .menubar__burger")
                .mouseenter(function (evt) {//show menu on burger hover
                    evt.stopPropagation();
                    $(this).addClass('close');
                    const ul = $(this).children("ul");
                    ul.addClass('animated-c');
                    ul.animate({"max-height": ul[0].scrollHeight}, {queue: false, duration: 300});
                    $(this)
                        .find('.burger')
                        .addClass('burger--active');
                });
        }


        $(".menubar .menu-item-has-children")//toggle menu - submenu on click
            .click(function (evt) {
                evt.stopPropagation();
                const ul = $(this).children("ul");
                $(this).toggleClass('close');

                if (ul.hasClass('animated-c')) {//hide menu - submenu
                    ul.removeClass('animated-c');
                    ul.animate({"max-height": 0}, {queue: false, duration: 300});
                    if ($(this).hasClass('menubar__burger')) {//if top list gets toggled remove burger animation
                        $(this)
                            .find('.burger')
                            .removeClass('burger--active');
                    }
                } else {//show menu - submenu

                    $(this).siblings().find('ul').map(function () {//close other submenus
                        $(this).removeClass('animated-c');
                        $(this).parent().removeClass('close');
                        $(this).animate({"max-height": 0}, {queue: false, duration: 300});
                    });

                    ul.addClass('animated-c');
                    ul.animate({"max-height": ul[0].scrollHeight}, {queue: false, duration: 300});

                    $(this).parents('.animated-c').map(function () {//fix parents height
                        const p = $(this);
                        p.css("max-height", p[0].scrollHeight + ul[0].scrollHeight);
                        p.css("max-height", p[0].scrollHeight + ul[0].scrollHeight);
                    })
                }
            })
    });

})(jQuery, this);
