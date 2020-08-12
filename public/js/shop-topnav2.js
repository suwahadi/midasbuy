"use strict";

function getCurrentCountry2Name(e) {
    return currentCountry = e.toLowerCase()
}

function redirectToAllSearchResult(e, t) {
    var r, n = checkCurrentUrl(window.location.origin, "codashop.com"),
        a = checkCurrentUrl(window.location.origin, "codashop-test-new");
    $("body").hasClass("theme-page--landing-page") ? r = window.location.href + "search?q=" + e : $("body").hasClass("theme-page--product-page") ? r = n || a ? window.location.origin + "/" + t + "/search?q=" + e : window.location.origin + "/shop/" + t + "/search?q=" + e : $("body").hasClass("theme-page--all-results") && (r = window.location.origin + window.location.pathname + "?q=" + e), window.location.href = r
}

function searchFieldInputUpdater() {
    $(".search-input-container--productpage").toggleClass("active"), $(".search-icon").toggleClass("active"), $("#search-keyword").val(""), $("#search-input").val(""), $(".search-result-list").hide().empty(), $(".top-nav--general .search-input-container").slideToggle("fast"), $("#search-keyword").focus(), $("#search-input").focus(), inputKeyword = "", matchedResults.length = 0
}

function buildResultElement(e) {
    $(".search-result-list").empty(), $(".search-result-list").slideDown(), e.length && Array.isArray(e) ? e.length > 5 ? ($.each(e.slice(0, 5), function(e, t) {
        $("<a class='search-element-link' href='" + t.productUrl + "'><div class='search-element-container'> <div class='search-element__image'>" + productImageChecker(t.productImage) + "</div> <div class='search-element__name'> " + productNameLimiter(t.productName) + " </div> </div></a>").appendTo(".search-result-list")
    }), $("<a class='search-element__all-results'> <span class='result__arrow-left'>&#8592;</span>" + viewAllText + " " + e.length + " " + resultUnitText + "<span class='result__arrow-right'>&#8594;</span> </a>").appendTo(".search-result-list")) : $.each(e, function(e, t) {
        $("<a class='search-element-link' href='" + t.productUrl + "'><div class='search-element-container'> <div class='search-element__image'>" + productImageChecker(t.productImage) + "</div> <div class='search-element__name'> " + productNameLimiter(t.productName) + " </div> </div></a>").appendTo(".search-result-list")
    }) : $("<div class='search-element__not-found'> <span class='text-not-found'>" + notFoundText + "</span> </div>").appendTo(".search-result-list")
}

function productNameLimiter(e) {
    return e && e.length > 122 ? e.substring(0, 122) + "..." : e
}

function productImageChecker(e) {
    return e ? "<img src='" + e + "'>" : "<div class='search-element__img-placeholder'></div>"
}

function isFoundInSearchTerm(e, t) {
    if (!e) return !1;
    var r = !1;
    return $.each(e.toLowerCase().split(","), function() {
        if ($.trim(this) == t) return r = !0, !0
    }), r
}

function matchingSingleKeyword(e, t) {
    matchedResults.length = 0, $(".search-result-list").show(), $.each(e, function(e, r) {
        (r.productName.toLowerCase().includes(t) || isFoundInSearchTerm(r.additionalSearchTerms, t)) && -1 == $.inArray(r, matchedResults) && matchedResults.push(r)
    }), buildResultElement(matchedResults)
}

function matchingMultipleKeywords(e, t) {
    var r = [],
        n = [],
        a = [],
        o = [],
        s = t.splice(0, 1);
    $.each(e, function(e, t) {
        (t.productName.toLowerCase().includes(s) || isFoundInSearchTerm(t.additionalSearchTerms, s)) && -1 == $.inArray(t, r) && r.push(t)
    }), t.length > 1 ? ($.each(t, function(e, t) {
        $.each(r, function(e, r) {
            r.productName.toLowerCase().includes(t) || isFoundInSearchTerm(r.additionalSearchTerms, t) ? -1 == $.inArray(r, a) && a.push(r) : a.length > 0 && $.each(a, function(e, t) {
                t.productName == r.productName && n.push(t)
            }), o = a.filter(function(e) {
                return !n.some(function(t) {
                    return e.productName == t.productName
                })
            })
        })
    }), buildResultElement(o)) : 1 == t.length ? matchingSingleKeyword(r, t[0]) : matchingSingleKeyword(r, s)
}

function firstLetterChecker(e) {
    return !$(".search-invalid").length && (" " == e.substring(0, 1) ? ($(".search-result-list").show(), $("<div class='search-invalid'> <span class='text-invalid-input'> Invalid Input </span> </div>").appendTo(".search-result-list").show(), !1) : void 0)
}

function fetchSearchResult(e) {
    var t, r = CODA.Shop.searchUrl,
        n = {
            q: e,
            countryCode: parseInt(countryCode)
        };
    return $.ajax({
        type: "POST",
        async: !1,
        url: r,
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json"
        },
        data: JSON.stringify(n),
        timeout: 1e4,
        success: function(e) {
            e && (t = e)
        },
        complete: function(e, t) {},
        error: function(e, t, r) {
            console.log(r)
        },
        dataType: "json"
    }), t
}

function checkKeywordLength(e) {
    var t = e.split(" "),
        r = t.filter(function(e) {
            return "" != e
        }),
        n = fetchSearchResult(e);
    t.length > 1 && n.length ? matchingMultipleKeywords(n, r) : matchingSingleKeyword(n, r)
}

function reloadSearch(e) {
    isLoading || (e.length >= 2 ? ($(".search-loader").length || $(".search-element-link").length || $(".search-element__not-found").length || $(".search-invalid").length || ($("<div class='search-loader'>Loading...</div>").appendTo(".search-result-list"), $(".search-result-list").show()), timeout = setTimeout(function() {
        isLoading = !0, setTimeout(function() {
            0 != firstLetterChecker(e[0]) && checkKeywordLength(e), isLoading = !1
        }, 250)
    }, delay)) : ($(".search-result-list").hide().empty(), $(".search-element__not-found").hide(), firstLetterChecker(e), e = "", matchedResults.length = 0))
}

function checkCurrentUrl(e, t) {
    return !!e.includes(t)
}
var matchedResults = [],
    inputKeyword, countryCode, currentCountry, timeout, delay = 300,
    isLoading = !1;
$(document).ready(function() {
    $(".top-nav--productpage .logo-image").hasClass("theme-default__logo") || $(".search-input-container").remove(), $(".search-icon, .search-icon--productpage").on("click", function() {
        searchFieldInputUpdater()
    }), $("#search-keyword").on("keyup", function() {
        inputKeyword = $("#search-keyword").val().toLowerCase(), timeout && clearTimeout(timeout), reloadSearch(inputKeyword), $("#search-keyword").val() && $("#search-input").val($("#search-keyword").val()), $("#search-input").val($("#search-keyword").val())
    }), $("#search-input").on("keyup", function() {
        inputKeyword = $("#search-input").val().toLowerCase(), timeout && clearTimeout(timeout), reloadSearch(inputKeyword), $("#search-keyword").val($("#search-input").val())
    }), $("#search-keyword").keypress(function(e) {
        var t, r, n = e.keyCode ? e.keyCode : e.which;
        if (inputKeyword = $("#search-keyword").val().toLowerCase(), "13" == n) {
            if (!inputKeyword.length || $(".search-element__not-found").length) return !1;
            t = inputKeyword.split(" ").join("+"), r = currentCountry, redirectToAllSearchResult(t, r)
        }
    }), $("#search-input").keypress(function(e) {
        var t, r = e.keyCode ? e.keyCode : e.which,
            n = inputKeyword.split(" ").join("+");
        if (inputKeyword = $("#search-input").val().toLowerCase(), "13" == r) {
            if (!inputKeyword.length || $(".search-element__not-found").length) return !1;
            n = inputKeyword.split(" ").join("+"), t = currentCountry, redirectToAllSearchResult(n, t)
        }
    }), $("#search-input, #search-keyword").on("keydown", function() {
        ($("#search-input").val() || $("#search-keyword").val()) && $(".search-input-container").addClass("on-resize")
    }), $(".search-result-list").on("click", ".search-element__all-results", function() {
        redirectToAllSearchResult(inputKeyword.split(" ").join("+"), currentCountry)
    })
});