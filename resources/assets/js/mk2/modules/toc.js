module.exports = () => {
    function UrlExists(url) {
        var http = new XMLHttpRequest();
        http.open('HEAD', url, false);
        http.send();
        return http.status != 404;
    }
    // const filter = require('../filter');
    var loc = window.location.href;
    var pathname = window.location.pathname;
    pathname = pathname.replace(/\/\/+/g, '/');
    var routeComponents = pathname.split("/");

    // they are the same for now but might change in the future to
    // to have different TOCxml routes

    var product = routeComponents[1];
    var version = routeComponents[2];

    $(".toc__container").html("");


    var loc = window.location.href;
    var pathname = window.location.pathname;
    pathname = pathname.replace(/\/\/+/g, '/');
    var routeComponents = pathname.split("/");
    var TOCxml = "/documentation_files/"+product+"/"+version+"/OnlineOutput.xml";

<<<<<<< HEAD:resources/assets/js/mk2/modules/toc.js
=======
    // they are the same for now but might change in the future to
    // to have different TOCxml routes
    if (0) {
        // used for staging

        var year = routeComponents[1];
        console.log(year);
        var product = routeComponents[2].toLowerCase();
        var version = routeComponents[3];
        var lang = routeComponents[4];
        var linkPrefix = "/" + year + "/" + product + "/" + version + "/" + lang;
        var TOCxml = "/documentation_files/" + year + "/" + product + "/" + version + "/Content/" + lang + "/OnlineOutput.xml";
    } else {
        // used for live
        var year = routeComponents[1];
        var product = routeComponents[2].toLowerCase();
        var version = routeComponents[3];
        var lang = routeComponents[4];
        var linkPrefix = "/" + year + "/" + product + "/" + version + "/" + lang;
        //hardcoding which toc to return based on language. currently, NL is the only language to have a properly translated TOC
        //this should be changed so that if a properly translated toc doesn't exist, it defaults to english
        // if(lang == "nl"){
        //     var TOCxml = "/documentation_files/" + year + "/" + product + "/" + version + "/Content/" + lang + "/OnlineOutput.xml";
        // }
        var properlyTranslated = ["en", "nl"];
        if(window.location.href.indexOf("SE-Authoring") > -1){
            if (properlyTranslated.includes(lang)){
                var TOCxml = "/documentation_files/" + year + "/" + product + "/" + version + "/Content/" + lang + "/SE-Authoring-TOC.xml";
            }
            else {
                var TOCxml = "/documentation_files/" + year + "/" + product + "/" + version + "/Content/en/SE-Authoring-TOC.xml";
            }
        }
        else{
            if (properlyTranslated.includes(lang)) {
                var TOCxml = "/documentation_files/" + year + "/" + product + "/" + version + "/Content/" + lang + "/OnlineOutput.xml";
            }
            else {
                var TOCxml = "/documentation_files/" + year + "/" + product + "/" + version + "/Content/en/OnlineOutput.xml";
            }
        }
    }
>>>>>>> a3cea90447d3bfff8634f705f47976825b735548:resources/assets/js/modules/toc.js

    $.ajax({
        type: "GET",
        url: TOCxml,
        success: function (xml) {
            console.log("found toc");
            var ul_main = $('<ul class="toc notranslate">');
            $(xml).find("TocEntry").each(function () {
                if ($(this).children().length && $(this).parent().is("CatapultToc")) {
                    var subCatList = $('<ul class="toc__sub-category-wrap">');
                    $(this).children().each(function () {
                        if ($(this).children().length) {
                            var topicList = $('<ul class="toc__topic-wrap">');
                            $(this).children().each(function () {
                                var classes;
                                if (($(this).attr("conditions"))) {
                                    producttags = $(this).attr("conditions").replace("Product.", "toc__filters--").toLowerCase() + "-js";
                                } else {
                                    producttags = " ";
                                };
                                if ($(this).attr("Link") && loc.includes($(this).attr("Link").replace(".html", "").replace(".htm", ""))) {
                                    topicList.append('<li class="current-page ' + producttags + '"><a href="' + $(this).attr("Link") + '">' + $(this).attr("Title") + '</a></li>');
                                } else {
                                    topicList.append('<li class="' + producttags + '"><a href="' + $(this).attr("Link") + '">' + $(this).attr("Title") + '</a></li>');
                                }

                            });
                            var link;
                            if ($(this).attr("Link")) {
                                link = '<a href="' + $(this).attr("Link") + '">';
                            } else {
                                link = '';
                            }
                            var li = $('<li class="toc__sub-category"><a class="chevron" href="' + $(this).attr("Link") + '">' + $(this).attr("Title") + '</a>');

                            subCatList.append(li.append(topicList));
                        } else {
                            if ($(this).attr("Link") && loc.includes($(this).attr("Link"))) {
                                subCatList.append('<li class="current-page toc__sub-category"><a class="chevron" href="' + $(this).attr("Link") + '">' + $(this).attr("Title") + '</a>');
                            } else {
                                subCatList.append('<li class="toc__sub-category"><a class="chevron" href="' + $(this).attr("Link") + '">' + $(this).attr("Title") + '</a>');
                            }
                        }
                    });
                    var li = $('<li class="toc__category"><a class="chevron" href="#">' + $(this).attr("Title") + '</a>');
                    ul_main.append(li.append(subCatList));
                }
                // else{
                //     ul_main.append('<li class="toc__category"><a class="chevron" href="#">' + $(this).attr("Title") + '</a>');
                // }

            });

            $(".toc__container").append(ul_main);

            //expand section of current page
            $(".current-page").parent().addClass("toc__topic-wrap--is-expanded");
            $(".current-page").parent().parent().parent().addClass("toc__sub-category-wrap--is-expanded");


            $(".current-page").parent().addClass("toc__sub-category-wrap--is-expanded");
            $(".current-page").parent().parent().parent().addClass("toc__sub-category-wrap--is-expanded");

            ifSiblingElementExists();

            tocExpandToggle();

            CheckExpandedLists();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });

    // checks to see where to add class to rotate the chevron for expanded toc lists
    // TODO: might have to polyfill .closest() for IE`
    function CheckExpandedLists() {
        const CURRENT_PAGE = document.querySelectorAll('.current-page') || null;
        CURRENT_PAGE.forEach(el => {
            el.closest('.toc__sub-category').classList.add('toc__category--is-open');
            el.closest('.toc__category').classList.add('toc__category--is-open');
        })

    }


    // if an anchor in the toc doesn't have a ul as a next sibling
    // remove the chevron
    function ifSiblingElementExists() {
        const tocLinks = document.querySelectorAll('.toc__container a');
        tocLinks.forEach((btn) => {
            if (btn.nextElementSibling === null) {
                btn.classList.remove('chevron');
            }
        });
    }

    // toc event listener to expand and collapse navs
    function tocExpandToggle() {
        const tocLinks = document.querySelectorAll('.toc__container a');

        tocLinks.forEach((link) => {
            link.addEventListener('click', (event) => {
                const nextElementSibling = event.target.nextElementSibling;
                const thisElParentNode = event.target.parentNode;

                if (link.classList.contains('chevron')) {
                    event.preventDefault();

                    if (nextElementSibling !== null) {
                        const nextElSiblingClass = nextElementSibling.classList;

                        if (nextElSiblingClass.contains('toc__sub-category-wrap')) {
                            if (nextElSiblingClass.contains('toc__sub-category-wrap--is-expanded')) {
                                nextElSiblingClass.remove('toc__sub-category-wrap--is-expanded');
                                toggleParentisExpandClass(thisElParentNode);
                            } else {
                                nextElSiblingClass.add('toc__sub-category-wrap--is-expanded');
                                toggleParentisExpandClass(thisElParentNode);
                            }
                        } else if (nextElSiblingClass.contains('toc__topic-wrap')) {
                            if (nextElSiblingClass.contains('toc__topic-wrap--is-expanded')) {
                                nextElSiblingClass.remove('toc__topic-wrap--is-expanded');
                                toggleParentisExpandClass(thisElParentNode);
                            } else {
                                nextElSiblingClass.add('toc__topic-wrap--is-expanded');
                                toggleParentisExpandClass(thisElParentNode);
                            }
                        }
                    }
                }
            });
        });
    }

    // toggle class that handles rotating chevron
    function toggleParentisExpandClass(el) {
        el.classList.contains('toc__category--is-open') ?
            el.classList.remove('toc__category--is-open') :
            el.classList.add('toc__category--is-open')
    }


};