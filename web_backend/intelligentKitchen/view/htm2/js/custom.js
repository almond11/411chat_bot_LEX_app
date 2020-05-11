(function(a) {
    var b = b || {};
    var c = 0;
    a.fn.exists = function(e) {
        var d = [].slice.call(arguments, 1);
        if (this.length) {
            e.call(this, d)
        }
        return this
    };
    b.navbar = function() {
        var k = function() {
            a(".sticky-nav").sticky();
            a(".sticky-nav").on({
                "sticky-start": function() {},
                "sticky-end": function() {}
            })
        };
        var g = function() {
            a("#ht-main-nav li.mega-menu").each(function() {
                a(this).on({
                    mouseenter: function(l) {
                        a(this).addClass("active");
                        a(this).find("ul").first().css({
                            display: "block"
                        }).stop().animate({
                            opacity: 1
                        },
                        {
                            duration: 300
                        })
                    },
                    mouseleave: function(l) {
                        a(this).removeClass("active");
                        a(this).find("ul").first().stop().animate({
                            opacity: 0
                        },
                        {
                            duration: 300,
                            complete: function() {
                                a(this).css({
                                    display: "none"
                                })
                            }
                        })
                    }
                })
            })
        };
        var f = function() {
            a("#ht-main-nav li.dropdown-menu").each(function() {
                a(this).on({
                    mouseenter: function(l) {
                        a(this).addClass("active");
                        a(this).find("ul").first().css({
                            display: "block"
                        }).stop().animate({
                            opacity: 1
                        },
                        {
                            duration: 300
                        })
                    },
                    mouseleave: function(l) {
                        a(this).removeClass("active");
                        a(this).find("ul").first().stop().animate({
                            opacity: 0
                        },
                        {
                            duration: 300,
                            complete: function() {
                                a(this).css({
                                    display: "none"
                                })
                            }
                        })
                    }
                });
                a(this).find("ul").first().find("li").on({
                    mouseenter: function(l) {
                        a(this).addClass("active");
                        a(this).find("ul").first().css({
                            display: "block"
                        }).stop().animate({
                            opacity: 1
                        },
                        {
                            duration: 300
                        })
                    },
                    mouseleave: function(l) {
                        a(this).removeClass("active");
                        a(this).find("ul").first().stop().animate({
                            opacity: 0
                        },
                        {
                            duration: 300,
                            complete: function() {
                                a(this).css({
                                    display: "none"
                                })
                            }
                        })
                    }
                })
            })
        };
        var j = function() {
            a(".ct-search").find("button").each(function() {
                var l = a(this).parent().find("input");
                a(this).on("click",
                function(m) {
                    if (!l.hasClass("is-visible")) {
                        l.addClass("is-visible").focus();
                        l.animate({
                            width: 180,
                            opacity: 1
                        },
                        {
                            duration: 300
                        });
                        a(this).addClass("is-active")
                    } else {
                        l.removeClass("is-visible");
                        l.animate({
                            width: 0,
                            opacity: 0
                        },
                        {
                            duration: 300
                        });
                        a(this).removeClass("is-active")
                    }
                    m.preventDefault();
                    m.stopPropagation()
                })
            });
            a("#ht-search-form").on("show.bs.modal",
            function(l) {
                a(".search-toggle").addClass("active")
            }).on("shown.bs.modal",
            function(l) {
                a(this).find("input").focus()
            }).on("hidden.bs.modal",
            function(l) {
                a(".search-toggle").removeClass("active")
            })
        };
        var h = function() {
            a(".mobile-control-toggle button.mobile-nav-toggle").on("click",
            function(l) {
                if (!a(".mobile-nav").hasClass("is-open")) {
                    a(".mobile-nav").addClass("is-open");
                    a("body").addClass("mobile-menu-is-open");
                    a(this).addClass("is-open")
                } else {
                    a(".mobile-nav").removeClass("is-open");
                    a("body").removeClass("mobile-menu-is-open");
                    a(this).removeClass("is-open")
                }
                l.stopPropagation()
            })
        };
        var i = function() {
            a(".mobile-nav").find(".sub-menu-toggle").on("click",
            function(l) {
                var m = a(this).parent().find("ul").first();
                var n = a(this).parent();
                if (m.css("display") != "block") {
                    m.css("display", "block");
                    n.addClass("is-open")
                } else {
                    m.css("display", "none");
                    n.removeClass("is-open")
                }
                l.stopPropagation()
            })
        };
        var d = function() {
            a(document).on("click",
            function() {
                var l = a(".main-nav-control-toggles").find("input");
                if (l.hasClass("is-visible")) {
                    l.removeClass("is-visible");
                    l.animate({
                        width: 0,
                        opacity: 0
                    },
                    {
                        duration: 300
                    });
                    a(".ct-search").find("button").removeClass("is-active")
                }
                var m = a(".mobile-nav");
                if (m.hasClass("is-open")) {
                    a("body").removeClass("mobile-menu-is-open");
                    a(".mobile-nav").removeClass("is-open");
                    a(".mobile-control-toggle button.mobile-nav-toggle").removeClass("is-open")
                }
            })
        };
        var e = function() {
            var l = a(".mobile-nav");
            var m = a(".ct-search input");
            a(l, m).on("click",
            function(n) {
                n.stopPropagation()
            })
        };
        k();
        g();
        f();
        j();
        h();
        i();
        d();
        e()
    };
    b.slider = function() {
        a(".flexslider.basic").each(function() {
            a(this).flexslider({
                namespace: "flex-",
                selector: ".slides > li",
                animation: a(this).data("effect"),
                slideshow: a(this).data("auto"),
                easing: "easeInOutExpo",
                useCSS: true,
                direction: a(this).data("direction"),
                controlNav: a(this).data("pager"),
                directionNav: a(this).data("navi"),
                animationSpeed: a(this).data("animation-speed"),
                slideshowSpeed: a(this).data("slide-speed"),
                smoothHeight: true,
                prevText: '<i class ="fa fa-chevron-left"></i>',
                nextText: '<i class ="fa fa-chevron-right"></i>'
            })
        });
        a(".flexslider.sync").each(function() {
            a(a(this).data("sync")).flexslider({
                asNavFor: a("#" + a(this).attr("id")),
                animation: "slide",
                itemWidth: 60,
                directionNav: false,
                controlNav: false,
                animationLoop: false,
                itemMargin: 0
            });
            a(this).flexslider({
                sync: a(this).data("sync"),
                namespace: "flex-",
                selector: ".slides > li",
                animation: a(this).data("effect"),
                slideshow: a(this).data("auto"),
                useCSS: true,
                direction: a(this).data("direction"),
                controlNav: a(this).data("pager"),
                directionNav: a(this).data("navi"),
                animationSpeed: a(this).data("animation-speed"),
                slideshowSpeed: a(this).data("slide-speed"),
                smoothHeight: false,
                prevText: '<i class ="fa fa-chevron-left"></i>',
                nextText: '<i class ="fa fa-chevron-right"></i>'
            })
        });
        a(".ht-carousel").each(function() {
            a(this).find(".slides").owlCarousel({
                responsive: {
                    0 : {
                        items: a(this).data("items")[0]
                    },
                    481 : {
                        items: a(this).data("items")[1]
                    },
                    769 : {
                        items: a(this).data("items")[2]
                    },
                    993 : {
                        items: a(this).data("items")[3]
                    },
                    1201 : {
                        items: a(this).data("items")[4]
                    }
                },
                loop: a(this).data("loop"),
                autoplay: a(this).data("auto"),
                autoplayTimeout: a(this).data("slide-speed"),
                autoplayHoverPause: true,
                smartSpeed: a(this).data("animation-speed"),
                fallbackEasing: "swing",
                nestedItemSelector: false,
                itemElement: "div",
                stageElement: "div",
                themeClass: "",
                baseClass: "owl-carousel",
                itemClass: "owl-item",
                centerClass: "center",
                activeClass: "active",
                dots: a(this).data("pager"),
                nav: a(this).data("navi"),
                navText: ['<i class ="fa fa-chevron-left"></i>', '<i class ="fa fa-chevron-right"></i>']
            })
        })
    };
    b.isotope = function() {
        a(".isotope-filter").each(function() {
            var d = a(this).data("target");
            a(d).isotope({
                itemSelector: ".entry",
                layoutMode: "masonry",
                transitionDuration: "1s"
            });
            a(this).find("a").on("click",
            function(f) {
                a(this).parent().parent().find("li").removeClass("is-filtered");
                a(this).parent().addClass("is-filtered");
                var g = a(this).data("filter");
                a(d).isotope({
                    filter: g,
                    transitionDuration: "1s"
                });
                f.preventDefault()
            })
        })
    };
    b.masonry = function() {
        a(".ht-masonry-layout").each(function() {
            var d = a(this).data("grid-size");
            a(this).isotope({
                layoutMode: "masonry",
                columnWidth: d,
                isFitWidth: true,
                gutter: "1"
            })
        })
    };
    b.commentReply = function() {
        var d = '<div class="comment-reply"><button class="close">&times;</button><div class=""><h3 class="heading">REPLY TO THIS COMMENT</h3></div><form action=""><div class="form-group half"><label for="">Name <span class="label-description">(ex: William) <sup>*</sup></span></label><input type="text"></div><div class="form-group half"><label for="">Email <span class="label-description">(Not Published)</span> <sup>*</sup></label><input type="text"></div><div class="form-group half"><label for="">Website <span class="label-description">(Optional)</span></label><input type="text"></div><div class="form-group"><label for="">Comment <sup>*</sup></label><textarea name="" id="" cols="30" rows="5"></textarea></div><div class="form-group submit-group"><div><input type="checkbox"> Notify me of followup comments in this post via email</div><button type="submit" class="ht-button view-more-button"><i class="fa fa-arrow-left"></i> SUBMIT <i class="fa fa-arrow-right"></i></button></div></form></div>';
        a(".comment-reply-link").on("click",
        function() {
            var e = a(this).attr("href");
            if (a(e).find(".comment-reply").length == 0) {
                a(e).find(".comment-content").append(d)
            }
        });
        a(document).on("click", ".comment-reply .close",
        function() {
            a(this).parent().remove()
        })
    };
    b.googleMapAPI = function() {
        var d = 1;
        a(".ht-map").each(function() {
            a(this).attr("id", "ht-map-" + d);
            d++;
            var f = a(this).data("coor");
            var g = a(this).attr("id");
            var m = a(this).data("zoom");
            var i = a(this).data("map-type");
            var e = a(this).data("control-ui") ? false: true;
            var k = a(this).data("scroll-wheel");
            var j = a(this).data("marker");
            var l = a(this).data("style");
            a(this).css("height", a(this).data("height"));
            function h() {
                var o = document.getElementById(g);
                var r = new google.maps.LatLng(f[0], f[1]);
                var p = {
                    center: r,
                    zoom: m,
                    mapTypeId: i,
                    disableDefaultUI: e,
                    scrollwheel: k,
                    styles: l
                };
                var n = new google.maps.Map(o, p);
                if (j != "") {
                    var q = new google.maps.Marker({
                        position: r,
                        map: n,
                        title: j
                    })
                }
            }
            google.maps.event.addDomListener(window, "load", h)
        })
    };
    b.recipeSubmit = function() {
        var d = function(g) {
            var e = Math.floor(g / 60);
            var f = g % 60;
            e = e > 9 ? e: "0" + e;
            f = f > 9 ? f: "0" + f;
            return e + ":" + f
        };
        a(".upload").each(function() {
            var f = a(a(this).data("target"));
            var e = a(this).find("a.upload-trigger");
            var g = a(this).find(".upload-visible");
            e.on("click",
            function(h) {
                f.trigger("click");
                h.preventDefault()
            });
            f.on("change",
            function() {
                g.val(a(this).val())
            })
        });
        a(".slider-range").each(function() {
            var f = a(this);
            var e = a(a(this).data("target"));
            f.slider({
                min: 0,
                max: a(this).data("max") * 60,
                step: 1,
                values: [0],
                slide: function(g, h) {
                    e.val(d(h.values[0]))
                }
            })
        })
    };
    b.lightbox = function() {
        a(".ht-lightbox-gallery").exists(function() {
            var e = 1;
            var d = a(this).data("child");
            a(".ht-lightbox-gallery").each(function() {
                var f = "ht-lightbox-gallery-" + e;
                e++;
                a(this).find(d).each(function() {
                    a(this).addClass("ht-lightbox").attr("data-lightbox-gallery", f)
                })
            })
        });
        a("a.ht-lightbox").nivoLightbox({
            effect: "fadeScale",
            theme: "default",
            keyboardNav: true,
            clickOverlayToClose: true,
            onInit: function() {},
            beforeShowLightbox: function() {},
            afterShowLightbox: function(d) {},
            beforeHideLightbox: function() {},
            afterHideLightbox: function() {},
            onPrev: function(d) {},
            onNext: function(d) {},
            errorMessage: "The requested content cannot be loaded. Please try again later."
        })
    };
    b.navScrollTop = function() {};
    b.parallaxGen = function() {
        a("[data-ht-parallax]").each(function() {
            var g = a(this).attr("data-ht-parallax");
            var d, f, e, h;
            if (a(this).is("#ht-top-area")) {
                var i = a(this).outerHeight();
                d = "data-0";
                f = "background-position:0px 0px";
                e = "data-" + i;
                h = "background-position: 0px " + g + "px"
            } else {
                d = "data-bottom-top";
                f = "background-position: 0px -" + g + "px";
                e = "data-top-bottom";
                h = "background-position:0px 0px"
            }
            a(this).attr(d, f).attr(e, h)
        })
    };
    b.parallaxInit = function() {
        var e = a(window).width();
        if (e >= 768) {
            var d = skrollr.init({
                forceHeight: false,
                smoothScrolling: false
            })
        } else {
            var d = skrollr.init();
            d.destroy()
        }
        if (Modernizr.touch) {
            var d = skrollr.init();
            d.destroy()
        }
    };
    b.others = function() {
        a("#dp-hook").DateTimePicker();
        a(".ht-accordion").each(function() {
            var d = a(this);
            a(this).find(".panel-heading").on("click",
            function() {
                d.find(".panel-heading").removeClass("current");
                a(this).addClass("current")
            })
        });
        a(".entry-ingredient").find("tr").on("click",
        function() {
            a(this).toggleClass("is-done")
        });
        a(".action-print").printPage({
            message: "Loading print ..."
        });
        a(".action-share").each(function() {
            a(this).on({
                mouseenter: function(d) {
                    if (a(window).width() >= 768) {
                        a(this).find(".entry-social").css({
                            display: "block"
                        }).stop().animate({
                            opacity: 1,
                            top: "-60"
                        },
                        {
                            duration: 300
                        })
                    }
                },
                mouseleave: function(d) {
                    if (a(window).width() >= 768) {
                        a(this).find(".entry-social").stop().animate({
                            opacity: 0,
                            top: "-40"
                        },
                        {
                            duration: 300,
                            complete: function() {
                                a(this).css({
                                    display: "none"
                                })
                            }
                        })
                    }
                }
            })
        })
    };
    a(document).ready(function() {
        b.navbar();
        b.slider();
        b.isotope();
        b.masonry();
        b.lightbox();
        b.commentReply();
        b.googleMapAPI();
        b.recipeSubmit();
        b.parallaxGen();
        b.parallaxInit();
        b.others()
    });
    a(window).on("load",
    function() {
        b.isotope();
        b.masonry()
    }).on("resize",
    function() {})
})(jQuery);