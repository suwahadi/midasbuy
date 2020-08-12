"use strict";

function _typeof(t) {
    return (_typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
        return typeof t
    } : function(t) {
        return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
    })(t)
}! function(t) {
    function e(r) {
        if (o[r]) return o[r].exports;
        var n = o[r] = {
            i: r,
            l: !1,
            exports: {}
        };
        return t[r].call(n.exports, n, n.exports, e), n.l = !0, n.exports
    }
    var o = {};
    e.m = t, e.c = o, e.d = function(t, o, r) {
        e.o(t, o) || Object.defineProperty(t, o, {
            enumerable: !0,
            get: r
        })
    }, e.r = function(t) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, {
            value: "Module"
        }), Object.defineProperty(t, "__esModule", {
            value: !0
        })
    }, e.t = function(t, o) {
        if (1 & o && (t = e(t)), 8 & o) return t;
        if (4 & o && "object" == _typeof(t) && t && t.__esModule) return t;
        var r = Object.create(null);
        if (e.r(r), Object.defineProperty(r, "default", {
                enumerable: !0,
                value: t
            }), 2 & o && "string" != typeof t)
            for (var n in t) e.d(r, n, function(e) {
                return t[e]
            }.bind(null, n));
        return r
    }, e.n = function(t) {
        var o = t && t.__esModule ? function() {
            return t.default
        } : function() {
            return t
        };
        return e.d(o, "a", o), o
    }, e.o = function(t, e) {
        return Object.prototype.hasOwnProperty.call(t, e)
    }, e.p = "", e(e.s = 13)
}({
    13: function(t, e, o) {
        function r(t) {
            return (r = "function" == typeof Symbol && "symbol" == _typeof(Symbol.iterator) ? function(t) {
                return _typeof(t)
            } : function(t) {
                return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : _typeof(t)
            })(t)
        }

        function n(t) {
            return (n = "function" == typeof Symbol && "symbol" == _typeof(Symbol.iterator) ? function(t) {
                return _typeof(t)
            } : function(t) {
                return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : _typeof(t)
            })(t)
        }

        function a(t) {
            return (a = "function" == typeof Symbol && "symbol" == _typeof(Symbol.iterator) ? function(t) {
                return _typeof(t)
            } : function(t) {
                return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : _typeof(t)
            })(t)
        }

        function i(t) {
            return (i = "function" == typeof Symbol && "symbol" == _typeof(Symbol.iterator) ? function(t) {
                return _typeof(t)
            } : function(t) {
                return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : _typeof(t)
            })(t)
        }
        o.r(e);
        var c, l = document.getElementById("data_landing_page");
        try {
            c = "string" == typeof l.value ? JSON.parse(l.value) : l.value
        } catch (t) {}
        var s = c,
            d = 3e3,
            u = function(t) {
                if (null != t && "object" == r(t) && "object" == r(t.images) && 0 != t.images.length) {
                    var e = "";
                    e += '<div class="promo-banner-container">';
                    var o, n = (new Date).getTime(),
                        a = 0,
                        i = !1;
                    $.each(t.images, function(t, o) {
                        if ("string" == typeof o.starttime) {
                            var r = o.starttime.split(/[^0-9]/),
                                i = new Date(r[0], r[1] - 1, r[2], r[3], r[4], r[5]).getTime();
                            if (isNaN(i)) return !0;
                            if (n < i) return !0
                        }
                        if ("string" == typeof o.endtime) {
                            r = o.endtime.split(/[^0-9]/);
                            var c = new Date(r[0], r[1] - 1, r[2], r[3], r[4], r[5]).getTime();
                            if (isNaN(c)) return !0;
                            if (n > c) return !0
                        }

                        o.srcUrl = "string" == typeof o.srcUrl ? o.srcUrl : "", o.altText = "string" == typeof o.altText ? o.altText : "No Alternate Text", "string" == typeof o.href ? "" == o.href && (o.href = "javascript:void(0)") : o.href = "javascript:void(0)", e += '<a target="_self" class="promo-banner-cell" href="' + o.href + '"><img class="promo-banner-image" alt="' + o.altText + '" title="' + o.altText + '" src="images/loading.jpg" data-flickity-lazyload="storage/' + o.srcUrl + '" /></a>', a++
                    }), e += "</div>", $(".footer-container").before(e), "number" == typeof t.cycleTime && (o = t.cycleTime, d = o), 0 == a && $(".promo-banner-container").remove(), a > 1 && (i = !0), $(".promo-banner-container").flickity({
                        contain: !0,
                        imagesLoaded: !0,
                        lazyLoad: !0,
                        prevNextButtons: i,
                        autoPlay: d,
                        wrapAround: !0,
                        pageDots: i
                    })
                }
            },
            f = function(t) {
                if (null != t && "object" == n(t) && "object" == n(t.images) && 0 != t.images.length) {
                    var e = "";
                    e += '<div class="coda-about__how-to-container">', "" !== t.title && (e += '<div class="coda-about__how-to-title"> ' + t.title + " </div>"), e += '<div class="coda-about__how-to-banner">', $.each(t.images, function(t, o) {
                        o.srcUrl = "string" == typeof o.srcUrl ? o.srcUrl : "", o.altText = "string" == typeof o.altText ? o.altText : "No Alternate Text", "string" == typeof o.href ? "" == o.href && (o.href = "javascript:void(0)") : o.href = "javascript:void(0)", e += '<img class="coda-about__how-to-banner-image how-to-holder" alt="' + o.altText + '" src="' + o.srcUrl + '" />'
                    }), e += "</div>", e += "</div>", $(".footer-container").before(e), "number" == typeof t.cycleTime && t.cycleTime, $(".coda-about__how-to-banner").flickity({
                        contain: !0,
                        imagesLoaded: !0,
                        lazyLoad: !0,
                        pageDots: !1,
                        wrapAround: !1,
                        prevNextButtons: !1
                    })
                }
            },
            y = function(t) {
                if (null != t && "object" == a(t) && "object" == a(t.content) && 0 != t.content.length) {
                    var e = "";
                    e += '<div class="news-container">', "" !== t.title && (e += '<div class="news__header"> ' + t.title + " </div>"), e += '<div class="news__card-row">';
                    var o = (new Date).getTime();
                    $.each(t.content, function(t, r) {
                        if ("string" == typeof r.starttime) {
                            var n = new Date(r.starttime).getTime();
                            if (isNaN(n)) return console.log("Invalid starttime."), !0;
                            if (o < n) return !0
                        }
                        if ("string" == typeof r.endtime) {
                            var a = new Date(r.endtime).getTime();
                            if (isNaN(a)) return console.log("Invalid endtime."), !0;
                            if (o > a) return !0
                        }
                        r.thumbNews = "string" == typeof r.thumbNews ? r.thumbNews : "", r.altText = "string" == typeof r.altText ? r.altText : "No Alternate Text", "string" == typeof r.href ? "" == r.href && (r.href = "javascript:void(0)") : r.href = "javascript:void(0)", "" == r.titleNews ? (e += '<div class="news__card-cell">', "" != r.slugNews ? (e += '<a target="_self" href="/news/' + r.slugNews + '" class="news_card_link">', e += '<img class="news__card-banner news__card-banner--full lozad" alt="' + r.altText + '" data-src="/storage/' + r.thumbNews + '" />', e += "</a>") : e += '<img class="news__card-banner news__card-banner--full lozad" alt="' + r.altText + '" data-src="/storage/' + r.thumbNews + '" />', e += "</div>") : (e += '<div class="news__card-cell">', "" != r.slugNews ? (e += '<a target="_self" class="news_card_link" href="/news/' + r.slugNews + '" class="">', e += '<div class="news__card-banner-frame"><img class="news__card-banner lozad" alt="' + r.altText + '" data-src="/storage/' + r.thumbNews + '" /></div>', e += '<div class="new__card-content-block"><div class="news__card-content-title">' + r.titleNews + "</div>", e += "</div>", e += "</a>") : (e += '<div class="news__card-banner-frame"><img class="news__card-banner lozad" alt="' + r.altText + '" data-src="' + r.thumbNews + '" /></div>', e += '<div class="new__card-content-block"><div class="news__card-content-title">' + r.titleNews + "</div>"), e += "</div>")
                    }), e += "</div>", e += "</div>", $(".footer-container").before(e), lozad().observe()
                }
            },
            m = document.getElementById("server") || "",
            b = function(t) {
                var e = "";
                e += '<div class="category-container">', e += '<div class="category__product-row">', e += '<div class="category__title">' + t.name + "</div>", "" !== t.shortDescription && (e += '<div class="category__sub-title">' + t.shortDescription + "</div>"), t.products.length;
                var o = !0,
                    r = !1,
                    n = void 0;
                try {
                    for (var a, i = t.products[Symbol.iterator](); !(o = (a = i.next()).done); o = !0) {
                        var c = a.value;
                        if (c.slug.startsWith("/")) {
                            var l = c.slug.substring(1);
                            e += '<a href="' + m.value + encodeURI(l) + '" class="category__product-container js-link-click">'
                        } else e += '<a href="buy/' + encodeURI(c.slug) + '" class="category__product-container js-link-click" target="_self">';
                        e += '<img data-src="storage/' + c.thumbnail + '" alt="" class="category__product-image lozad">', e += '<div class="category__product-title">' + c.name + "</div>", e += "</a>"
                    }
                } catch (t) {
                    r = !0, n = t
                } finally {
                    try {
                        o || null == i.return || i.return()
                    } finally {
                        if (r) throw n
                    }
                }
                e += "</div>", e += "</div>", $(".footer-container").before(e), $(".js-link-click").click(function(t) {
                    $(t.currentTarget.childNodes[0]).addClass("click-background"), setTimeout(function() {
                        $(t.currentTarget.childNodes[0]).removeClass("click-background")
                    }, 1500)
                }), lozad().observe()
            },
            _ = function(t) {
                if (null != t && "object" == i(t) && "object" == i(t.content) && 0 != t.content.length) {
                    var e = "";
                    e += '<div class="coda-about-container">', "" !== t.title && (e += '<div class="coda-about__header"> ' + t.title + " </div>"), "" !== t.subTitle && (e += '<div class="coda-about__short-description"> ' + t.subTitle + " </div>"), e += '<div class="coda-about-card-all">', $.each(t.content, function(t, o) {
                        o.imageUrl = "string" == typeof o.imageUrl ? o.imageUrl : "", o.altText = "string" == typeof o.altText ? o.altText : "No Alternate Text", e += '<div class="coda-about__card-container">', e += '<div class="coda-about__card__icon-area"><img class="coda-about__icon-card" src="' + o.imageUrl + '" alt="' + o.altText + '" id="coda-about__card__icon-style"></div>', e += '<div class="coda-about__card-content"> <div class="coda-about__card__title-area">' + o.title + '</div> <div class="coda-about__card__desc-area">' + o.subTitle + "</div> </div>", e += "</div>"
                    }), e += "</div></div>", $(".footer-container").before(e)
                }
            },
            v = function(t) {
                for (var e in t)
                    if (e.indexOf("-")) {
                        var o = e.split("-")[0];
                        "howToBannerSection" == o ? f(t[e]) : "promoBannerSection" == o ? u(t[e]) : "categorySection" == o ? b(t[e]) : "aboutSection" == o ? _(t[e]) : "newsBannerSection" == o && y(t[e])
                    } else "howToBannerSection" == e ? f(t.howToBannerSection) : "promoBannerSection" == e ? u(t.promoBannerSection) : "categorySection" == e ? b(t.categorySection) : "aboutSection" == e ? _(t.aboutSection) : "newsBannerSection" == e && y(t.newsBannerSection);
                return !0
            };
        $(document).ready(function() {
            v(s)
        })
    }
});