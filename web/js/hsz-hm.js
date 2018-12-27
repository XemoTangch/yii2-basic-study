webpackJsonp([1], {
    "4/gI": function(e, t) {
        e.exports = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAABCklEQVRYR+2WWxHCMBBF7zpAAhKQAA5AAUjAATgBFCABHABOcHCZMCkT0kc2bZP+pL/p5Jze7G4qmPiRifkoAiWBbAmQnJmCF5G3W/hZBCz8ZsErVyK5gANfWIGLiOyqFHIInAFsLfAFYJktAZKd8G9NpJqEGngyAS08iUAMvCZA0lTqFcBGRJ6xxxML/xMgOQfwAGAGhhkWpl/VEn3gTQm4VauW6AtvrAFvs6DEEHhrEWolhsI7uyAkMQY82IYkjwAOtht+xzEWPChgXiBpLo6TI3EHsG6b7bGtqxrFnkTFqF0ssXBVAtWmnsQo8CgB5zj2/pXa58uz/Q+E5FQ1ENpkyHoRKAlMnsAHoQyYIb0/Nf0AAAAASUVORK5CYII="
    },
    "Fg+R": function(e, t) {},
    NHnr: function(e, t, i) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var n = {};
        i.d(n, "originData", function() {
            return L
        }),
            i.d(n, "pagesData", function() {
                return q
            }),
            i.d(n, "currentPageBg", function() {
                return U
            }),
            i.d(n, "currentPage", function() {
                return F
            }),
            i.d(n, "sceneInfo", function() {
                return G
            }),
            i.d(n, "sceneInfoSub", function() {
                return j
            });
        var s = {};
        i.d(s, "initOriginData", function() {
            return Z
        }),
            i.d(s, "selectPage", function() {
                return V
            });
        var r = {};
        i.d(r, "INITORIGINDATA", function() {
            return Q
        }),
            i.d(r, "SELECTPAGE", function() {
                return Y
            });
        i("j1ja");
        var a = i("mtWM")
            , o = i.n(a)
            , l = i("zL8q")
            , c = i.n(l)
            , d = i("BTaQ")
            , p = i.n(d)
            , u = i("7+uW")
            , h = i("NYxO")
            , f = void 0
            , host = 'love.jm-ai.com';
            // , host = 'www.yii2study.one';
        f = 'http://' + host + '/api/';
        var g = function(e, t) {
            var i = void 0;
            return "preview" === e ? i = f + "h5/getbycode?code=" + t : "publish" === e ? i = f + "h5/getbyusercode?code=" + t : "beforeview" === e && (i = f + "h5/getbyusercode?code=" + t),
                i
        }
            , v = function(e) {
            return f + "h5/interAction?id=" + e
        }
            , m = function(e) {
            return f + "h5/getInterAction?id=" + e
        }
            , y = function(e) {
            return f + "h5/submitform?data=" + e
        }
            , w = i("mvHQ")
            , x = i.n(w)
            , b = i("pFYg")
            , S = i.n(b)
            , _ = i("fZjL")
            , I = i.n(_)
            , C = i("Dd8w")
            , k = i.n(C)
            , W = i("7QTg")
            , T = i("7t+N")
            , A = i.n(T)
            , N = {
            data: function() {
                return {
                    endShow: !1,
                    tipShow: !0,
                    isEnd: !1,
                    msTime: {
                        show: !1,
                        day: 0,
                        hour: 0,
                        minutes: 0,
                        seconds: 0
                    },
                    star: "",
                    end: "",
                    current: ""
                }
            },
            props: {
                item: {
                    type: Object,
                    default: null
                },
                currentTime: {
                    type: Number
                },
                startTime: {
                    type: Number
                },
                endTime: {
                    type: Number
                },
                endText: {
                    type: String,
                    default: "已结束"
                },
                type: {
                    type: String
                }
            },
            watch: {
                endTime: function() {
                    this.init()
                }
            },
            mounted: function() {
                this.init()
            },
            methods: {
                setLineHeight: function(e) {
                    var t = e.in.css
                        , i = "";
                    return I()(t).forEach(function(e) {
                        var n = t[e];
                        "height" === e ? i += "lineHeight:" + .5 * (n - 20) + "px;" : "color" === e && (i += e + ":" + n + ";")
                    }),
                        i
                },
                setStyle: function(e) {
                    var t = e.in.css
                        , i = "";
                    return I()(t).forEach(function(e) {
                        var n = t[e];
                        if ("width" === e)
                            i += e + ":" + (n - 40) / 4 + "px;";
                        else if ("backgroundColor" === e) {
                            if ("" === e)
                                return void (i += e + ":rgb(0,0,0)");
                            i += e + ":" + n + ";"
                        }
                    }),
                        i
                },
                init: function() {
                    var e = this;
                    10 === this.startTime.toString().length ? this.star = 1e3 * this.startTime : this.star = this.startTime,
                        10 === this.endTime.toString().length ? this.end = 1e3 * this.endTime : this.end = this.endTime,
                        this.currentTime ? 10 === this.currentTime.toString().length ? this.current = 1e3 * this.currentTime : this.current = this.currentTime : this.current = (new Date).getTime(),
                    this.end < this.current || (this.current < this.star ? (this.$set(this, "tipShow", !0),
                        setInterval(function() {
                            e.runTime(e.star, e.current, e.start_message, !1)
                        }, 1e3)) : (this.end > this.current && this.star < this.current || this.star === this.current) && (this.$set(this, "tipShow", !1),
                        this.msTime.show = !0,
                        setInterval(function() {
                            e.runTime(e.end, (new Date).getTime(), e.end_message, !0)
                        }, 1e3)))
                },
                setInStyle: function(e) {
                    var t = e.in.css
                        , i = ""
                        , n = !1;
                    return I()(t).forEach(function(e) {
                        var s = t[e];
                        if ("width" === e) {
                            if (!isNaN(s))
                                return void (i += e + ":" + s + "px;");
                            i += e + ":" + s + ";"
                        } else if ("height" === e) {
                            if (!isNaN(s))
                                return void (i += e + ":" + s + "px;");
                            i += e + ":" + s + "px;"
                        } else if ("top" === e) {
                            if (!isNaN(s))
                                return void (i += e + ":" + s + "px;");
                            i += e + ":" + s + ";"
                        } else if ("left" === e) {
                            if (!isNaN(s))
                                return void (i += e + ":" + s + "px;");
                            i += e + ":" + s + ";"
                        } else if ("backgroundColor" === e) {
                            if ("" === e)
                                return void (i += e + ":rgb(0,0,0)");
                            i += e + ":" + s + ";"
                        } else if ("borderRadius" === e)
                            i += e + ":" + (s = "string" == typeof s ? parseInt(s.replace(/[^0-9]/gi, ""), 0) : s) + "px;";
                        else if ("word-wrap" === e)
                            n = !0;
                        else if ("fontSize" === e)
                            i += e + ":" + (s = "string" == typeof s ? parseInt(s.replace(/[^0-9]/gi, ""), 0) : s) + "px;";
                        else {
                            if ("backgroundImage" === e)
                                return;
                            if ("backgroundSize" === e)
                                return;
                            if ("backgroundPosition" === e)
                                return;
                            if ("borderWidth" === e)
                                return;
                            if ("borderStyle" === e)
                                return;
                            if ("borderColor" === e)
                                return;
                            if ("lineHeight" === e)
                                return;
                            i += e + ":" + s + ";"
                        }
                    }),
                    n || (i += "word-wrap:break-word"),
                        i
                },
                runTime: function(e, t, i) {
                    var n = this.msTime
                        , s = e - t;
                    s > 0 ? (this.msTime.show = !0,
                        n.day = Math.floor(s / 864e5),
                        s -= 864e5 * n.day,
                        n.hour = Math.floor(s / 36e5),
                        s -= 36e5 * n.hour,
                        n.minutes = Math.floor(s / 6e4),
                        s -= 6e4 * n.minutes,
                        n.seconds = Math.floor(s / 1e3).toFixed(0),
                        s -= 1e3 * n.seconds,
                    n.hour < 10 && (n.hour = "0" + n.hour),
                    n.minutes < 10 && (n.minutes = "0" + n.minutes),
                    n.seconds < 10 && (n.seconds = "0" + n.seconds)) : i()
                },
                start_message: function() {
                    var e = this;
                    this.$set(this, "tipShow", !1),
                        this.$emit("start_callback", this.msTime.show),
                        setTimeout(function() {
                            e.runTime(e.end, e.star, e.end_message, !0)
                        }, 1)
                },
                end_message: function() {
                    this.msTime.show = !1,
                        this.$emit("end_callback", this.msTime.show)
                }
            }
        }
            , E = {
            render: function() {
                var e = this
                    , t = e.$createElement
                    , i = e._self._c || t;
                return i("div", [e.msTime.show ? i("div", [i("div", {
                    staticClass: "countdownbox"
                }, [i("div", {
                    staticClass: "timepart",
                    style: e.setStyle(e.item)
                }, [i("h1", {
                    style: e.setLineHeight(e.item)
                }, [e._v(e._s(e.msTime.day))]), e._v(" "), i("p", {
                    style: e.setLineHeight(e.item)
                }, [e._v("天")])]), e._v(" "), i("div", {
                    staticClass: "timepart",
                    style: e.setStyle(e.item)
                }, [i("h1", {
                    style: e.setLineHeight(e.item)
                }, [e._v(e._s(e.msTime.hour))]), e._v(" "), i("p", {
                    style: e.setLineHeight(e.item)
                }, [e._v("时")])]), e._v(" "), i("div", {
                    staticClass: "timepart",
                    style: e.setStyle(e.item)
                }, [i("h1", {
                    style: e.setLineHeight(e.item)
                }, [e._v(e._s(e.msTime.minutes))]), e._v(" "), i("p", {
                    style: e.setLineHeight(e.item)
                }, [e._v("分")])]), e._v(" "), i("div", {
                    staticClass: "timepart",
                    style: e.setStyle(e.item)
                }, [i("h1", {
                    style: e.setLineHeight(e.item)
                }, [e._v(e._s(e.msTime.seconds))]), e._v(" "), i("p", {
                    style: e.setLineHeight(e.item)
                }, [e._v("秒")])])])]) : i("div", {
                    staticClass: "countdownwrap"
                }, [i("span", {
                    staticClass: "text",
                    staticStyle: {
                        display: "block"
                    },
                    style: e.setInStyle(e.item)
                }, [i("span", {
                    staticClass: "num"
                }, [e._v(e._s(e.endText))])])])])
            },
            staticRenderFns: []
        };
        var M = i("VU/8")(N, E, !1, function(e) {
            i("UTRX")
        }, "data-v-1d8132de", null).exports
            , H = {
            name: "preview",
            data: function() {
                var e = this;
                return {
                    has: !1,
                    pageSwitch: {},
                    pageEffect: {},
                    isPlay: !0,
                    h5Code: "",
                    scaleWidth: 0,
                    scaleHeight: 0,
                    isChange: !1,
                    top: 0,
                    flag: !0,
                    scrollIndex: 0,
                    pageStr: "",
                    is_page: !1,
                    effect: !1,
                    effectList: [{
                        value: "slide",
                        label: "位移切换"
                    }, {
                        value: "fade",
                        label: "淡入"
                    }, {
                        value: "cube",
                        label: "方块"
                    }, {
                        value: "coverflow",
                        label: "3d流"
                    }, {
                        value: "flip",
                        label: "3d翻转"
                    }],
                    height: 0,
                    swiperOption: {
                        direction: "vertical",
                        grabCursor: !0,
                        setWrapperSize: !0,
                        autoHeight: !0,
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: !0,
                            type: "progressbar"
                        },
                        roundLengths: !0,
                        resistanceRatio: 0,
                        speed: 300,
                        observer: !0,
                        observeParents: !0,
                        mousewheel: !0,
                        debugger: !0,
                        on: {
                            slidePrevTransitionStart: function() {
                                1 === e.swiper.previousIndex && e.swiper.realIndex === e.pagesData.length - 1 && (e.$Message.info("已经是第一页"),
                                    e.swiper.slideNext())
                            },
                            transitionStart: function() {
                                e.scrollIndex = e.$refs.mySwiper.swiper ? e.$refs.mySwiper.swiper.realIndex : 0,
                                    e.pageStr = (e.$refs.mySwiper.swiper ? e.$refs.mySwiper.swiper.realIndex : 0) + 1 + "/" + e.pagesData.length
                            }
                        }
                    }
                }
            },
            computed: k()({}, Object(h.b)(["pagesData", "currentPageBg", "sceneInfoSub", "additional", "sceneInfo", "currentPage"]), {
                swiper: function() {
                    return this.$refs.mySwiper.swiper
                }
            }),
            components: {
                countdownbox: M,
                Swiper: W.swiper,
                SwiperSlide: W.swiperSlide
            },
            mounted: function() {
                var e = this;
                window.prenext = this,
                    this.is_page = 1 === this.sceneInfoSub.is_page,
                    A()(window).resize(function() {
                        e.top = parseInt((A()(window).height() - 504 * e.scaleWidth) / 2, 0)
                    }),
                    this.effect = 1 === parseInt(window.effect, 0),
                this.effect || A()(".previewtk").addClass("noeffect");
                var t = this.pagesData
                    , i = [];
                I()(t).forEach(function(e) {
                    var n = t[e];
                    n.elements && I()(n.elements).forEach(function(e) {
                        var t = n.elements[e];
                        "text" === t.type && "" !== t.fontTag && "" !== t.fontUrl && (i[t.fontTag] = t.fontUrl)
                    })
                }),
                    I()(i).forEach(function(e) {
                        var t = i[e];
                        if (t) {
                            t = (t = t.replace("http://www.huanqing365.com", "https://res.huanqing365.com")).replace("https://www.huanqing365.com", "https://res.huanqing365.com");
                            var n = document.createElement("style")
                                , s = '@font-face {font-family: "';
                            s += e,
                                s += '"; src: url("',
                                s += t,
                                s += '"); font-weight: normal; font-style: normal;}',
                                n.appendChild(document.createTextNode(s)),
                                document.head.appendChild(n)
                        }
                    }),
                    this.$Message.config({
                        top: 260
                    })
            },
            created: function() {
                this.height = A()(window).height(),
                    this.scaleWidth = A()(window).width() / 320,
                    this.scaleHeight = A()(window).height() / 504,
                    this.top = Math.round((A()(window).height() - 504 * this.scaleWidth) / 2),
                    this.getPageEffect()
            },
            methods: {
                getPageEffect: function() {
                    A.a.isEmptyObject(this.sceneInfo.animateEffect) || "null" === this.sceneInfo.animateEffect ? (this.swiperOption.loop = !1,
                        this.swiperOption.effect = "slide",
                        this.is_page = !1) : (this.sceneInfo.animateEffect = JSON.parse(this.sceneInfo.animateEffect),
                    1 !== this.sceneInfo.animateEffect.autoplay && 0 !== this.sceneInfo.animateEffect.autoplay && ("true" === this.sceneInfo.animateEffect.autoplay || !0 === this.sceneInfo.animateEffect.autoplay ? this.sceneInfo.animateEffect.autoplay = 1 : this.sceneInfo.animateEffect.autoplay = 0),
                    this.sceneInfo.animateEffect.autoplay && (void 0 === this.sceneInfo.animateEffect.delay && (this.animateEffect.delay = 1),
                        this.swiperOption.autoplay = {
                            delay: this.sceneInfo.animateEffect.delay <= 1 ? 1e3 : 1e3 * this.sceneInfo.animateEffect.delay,
                            stopOnLastSlide: !this.swiperOption.loop,
                            disableOnInteraction: !1
                        }),
                        this.swiperOption.loop = this.sceneInfo.animateEffect.loop,
                        this.is_page = this.sceneInfo.animateEffect.showPageNumber,
                        void 0 === this.sceneInfo.animateEffect.value ? this.swiperOption.effect = "slide" : this.swiperOption.effect = this.sceneInfo.animateEffect.value)
                },
                nextPageClick: function() {
                    this.swiper.slideNext()
                },
                prePageClick: function() {
                    this.swiper.slidePrev()
                },
                goLocation: function(e) {
                    var t = this
                        , i = new window.BMap.Geolocation
                        , n = new window.BMap.Geocoder;
                    i.getCurrentPosition(function(i) {
                        n.getLocation(i.point, function(n) {
                            if (n) {
                                t.map = new window.BMap.Marker(i.point),
                                    t.lng = i.point.lng,
                                    t.lat = i.point.lat;
                                var s = {};
                                s.start = {
                                    address: n.surroundingPois[0].address,
                                    msg: n.addressComponents,
                                    lat: i.point.lat,
                                    lng: i.point.lng
                                },
                                    s.end = {
                                        address: e.address,
                                        lat: e.lat,
                                        lng: e.lng
                                    },
                                    t.navication(s)
                            }
                        })
                    }, {
                        enableHighAccuracy: !0
                    })
                },
                getSettingParam: function(e) {
                    var t = this.$store.state.originData.sceneinfo;
                    if ("page_mode" !== e)
                        return "autoplay" === e ? 1e3 * t[e] : 0 !== t[e];
                    switch (t[e]) {
                        case 1:
                            return "slide";
                        case 2:
                            return "fade";
                        case 3:
                            return "cube";
                        case 4:
                            return "coverflow";
                        case 5:
                            return "flip"
                    }
                    return ""
                },
                navication: function(e) {
                    window.parent.location.href = "https://api.map.baidu.com/direction?origin=latlng:" + e.start.lat + "," + e.start.lng + "|name:" + e.start.address + "&destination=" + e.end.address + "&mode=driving&region=" + e.start.msg.province + "&output=html&src=yourCompanyName|yourAppName"
                },
                setTop: function() {
                    var e = "";
                    return e += "position: relative;top:" + this.top + "px;"
                },
                exit: function() {},
                playOrPauseMusic: function() {
                    var e = document.getElementById("audio2");
                    e.paused ? (e.play(),
                        this.isPlay = !0) : (this.isPlay = !1,
                        e.pause())
                },
                initSwiper: function() {
                    this.flag && (this.flag = !1)
                },
                setBgStyle: function(e) {
                    var t = e.pagebg
                        , i = "";
                    return void 0 === t ? i += "background: #fff;" : (t.image && (i += "background-image: url(" + t.image + ");"),
                    t.color && (i += "background-color: " + t.color + ";"),
                    t.left && (i += "background-position-x: " + t.left + ";"),
                    t.top && (i += "background-position-y: " + t.top + ";"),
                    t.height && (i += "background-position-y: " + t.top + ";"),
                        i += "background-size: 100% 100%;"),
                        i
                },
                setOutStyle: function(e, t) {
                    var i = this
                        , n = ""
                        , s = !1;
                    return 3 !== t && (I()(e).forEach(function(r) {
                        var a = e[r];
                        if ("width" === r) {
                            if (!1 === isNaN(a))
                                return void (n += r + ":" + a * i.scaleWidth + "px;");
                            if (-1 === a.toString().indexOf("px"))
                                return void (n += r + ":" + a * i.scaleWidth + "px;");
                            n += r + ":" + a * i.scaleWidth + ";"
                        } else if ("height" === r) {
                            if (!1 === isNaN(a))
                                return n += r + ":" + a * i.scaleWidth + "px;",
                                    void ("checkbox" !== t && (n += "lineHeight:" + a * i.scaleWidth + "px;"));
                            if (-1 === a.toString().indexOf("px"))
                                return void (n += r + ":" + a * i.scaleWidth + "px;");
                            n += r + ":" + a * i.scaleWidth + "px;"
                        } else if ("fontSize" === r)
                            n += r + ":" + (a = "string" == typeof a ? parseInt(a.toString().replace(/[^0-9]/gi, ""), 0) : a) * i.scaleWidth + "px;";
                        else if ("top" === r) {
                            if (!1 === isNaN(a))
                                return void (n += r + ":" + a * i.scaleWidth + "px;");
                            if (-1 === a.toString().indexOf("px"))
                                return void (n += r + ":" + a * i.scaleWidth + "px;");
                            n += r + ":" + a * i.scaleWidth + ";"
                        } else if ("left" === r) {
                            if (!1 === isNaN(a))
                                return void (n += r + ":" + a * i.scaleWidth + "px;");
                            if (-1 === a.toString().indexOf("px"))
                                return void (n += r + ":" + a * i.scaleWidth + "px;");
                            n += r + ":" + a * i.scaleWidth + ";"
                        } else if ("color" === r && "interActionButton" === t)
                            n += r + ":#ffffff;";
                        else if ("word-wrap" === r)
                            s = !0;
                        else {
                            if ("lineHeight" === r)
                                return;
                            n += "borderRadius" === r ? r + ":" + parseInt(a ? a.toString() : 0, 0) + "px;" : r + ":" + a + ";"
                        }
                    }),
                    s || (n += "word-wrap:break-word")),
                        n
                },
                setInStyle: function(e) {
                    var t = this
                        , i = e.in.css
                        , n = ""
                        , s = !1;
                    return I()(i).forEach(function(r) {
                        var a = i[r];
                        if ("width" === r) {
                            if (!isNaN(a))
                                return void (n += r + ":" + a * t.scaleWidth + "px;");
                            n += r + ":" + a * t.scaleWidth + "px;"
                        } else if ("height" === r) {
                            if (!isNaN(a))
                                return n += r + ":" + a * t.scaleWidth + "px;",
                                    void (n += "lineHeight:" + a * t.scaleWidth + "px;");
                            n += "lineHeight:" + a * t.scaleWidth + "px;",
                                n += r + ":" + a * t.scaleWidth + "px;"
                        } else if ("top" === r) {
                            if (!isNaN(a))
                                return void (n += r + ":" + a * t.scaleWidth + "px;");
                            n += r + ":" + a * t.scaleWidth + ";"
                        } else if ("left" === r) {
                            if (!isNaN(a))
                                return void (n += r + ":" + a * t.scaleWidth + "px;");
                            n += r + ":" + a * t.scaleWidth + ";"
                        } else if ("backgroundColor" === r) {
                            if ("count" === e.type)
                                return void (n += r + ":#fff");
                            n += "" === r ? r + ":rgb(0,0,0)" : r + ":" + a + ";"
                        } else if ("borderRadius" === r)
                            n += r + ":" + (a = "string" == typeof a ? parseInt(a.toString().replace(/[^0-9]/gi, ""), 0) : a) * t.scaleWidth + "px;";
                        else if ("word-wrap" === r)
                            s = !0;
                        else if ("fontSize" === r)
                            n += r + ":" + (a = "string" == typeof a ? parseInt(a.toString().replace(/[^0-9]/gi, ""), 0) : a) * t.scaleWidth + "px;";
                        else {
                            if ("backgroundImage" === r)
                                return;
                            if ("backgroundSize" === r)
                                return;
                            if ("backgroundPosition" === r)
                                return;
                            if ("borderWidth" === r)
                                return;
                            if ("borderStyle" === r)
                                return;
                            if ("borderColor" === r)
                                return;
                            if ("lineHeight" === r)
                                return;
                            if (0 === r.toString().indexOf("padding"))
                                return;
                            n += r + ":" + a + ";"
                        }
                    }),
                    s || (n += "word-wrap:break-word"),
                        n
                },
                setFormTextSize: function(e) {
                    var t = void 0 === e.in.css.fontSize ? 15 : e.in.css.fontSize
                        , i = "fontSize:" + t * this.scaleWidth + "px;height:" + 2 * t * this.scaleHeight + "px;line-height: " + 2 * t * this.scaleHeight + "px;";
                    return i += "color :" + e.in.css.color + ";"
                },
                setSpanStyle: function(e) {
                    var t = this
                        , i = "";
                    return I()(e).forEach(function(n) {
                        var s = e[n];
                        "height" === n ? i += n + ":" + s * t.scaleWidth + "px;" : "height" !== n && ("lineHeight" === n ? i += n + ":" + parseInt(s.toString().replace(/[^0-9]/gi, ""), 0) * t.scaleWidth + "px;" : "lineHeight" !== n && ("fontSize" === n ? i += n + ":" + parseInt(s.toString().replace(/[^0-9]/gi, ""), 0) * t.scaleWidth + "px;" : "color" === n && (i += n + ":" + s + ";")))
                    }),
                        i
                },
                isHide: function(e) {
                    return e === this.scrollIndex ? "current" : "item"
                },
                setBtnStyle: function(e) {
                    var t = this
                        , i = "";
                    return I()(e).forEach(function(n) {
                        var s = e[n];
                        "fontSize" === n && (i += n + ":" + (s = "string" == typeof s ? parseInt(s.toString().replace(/[^0-9]/gi, ""), 0) : s) * t.scaleWidth + "px;")
                    }),
                        i
                },
                setInImageStyle: function(e, t) {
                    var i = this
                        , n = "";
                    return I()(t).forEach(function(e) {
                        var s = t[e];
                        if ("width" === e) {
                            if (!isNaN(s))
                                return void (n += e + ":" + s * i.scaleWidth + "px;");
                            n += e + ":" + parseInt(s, 0) * i.scaleWidth + ";"
                        } else if ("height" === e) {
                            if (!isNaN(s))
                                return void (n += 1 === s ? e + ":150px;" : e + ":" + s * i.scaleWidth + "px;");
                            n += e + ":" + parseInt(s, 0) * i.scaleWidth + ";"
                        } else {
                            if ("top" === e)
                                return;
                            if ("left" === e)
                                return;
                            if ("borderRadius" === e) {
                                if (!isNaN(s))
                                    return void (n += e + ":" + s * i.scaleWidth + "px;");
                                n += e + ":" + parseInt(s, 0) * i.scaleWidth + "px;"
                            }
                        }
                        "borderWidth" !== e ? "borderStyle" !== e ? "borderColor" === e && (n += e + ":" + s + ";") : n += e + ":" + s + ";" : n += e + ":" + s + "px;"
                    }),
                        n += "word-wrap: break-word;"
                },
                setOutImageStyle: function(e, t) {
                    var i = this
                        , n = "";
                    return I()(t).forEach(function(e) {
                        var s = t[e];
                        if ("width" === e) {
                            if (!isNaN(s))
                                return void (n += e + ":" + s * i.scaleWidth + "px;");
                            n += e + ":" + parseInt(s, 0) * i.scaleWidth + ";"
                        } else if ("height" === e) {
                            if (!isNaN(s))
                                return void (n += 1 === s ? e + ":150px;" : e + ":" + s * i.scaleWidth + "px;");
                            n += e + ":" + parseInt(s, 0) * i.scaleWidth + ";"
                        } else if ("top" === e) {
                            if (!isNaN(s))
                                return void (n += e + ":" + s * i.scaleWidth + "px;");
                            n += e + ":" + parseInt(s, 0) * i.scaleWidth + ";"
                        } else if ("left" === e) {
                            if (!isNaN(s))
                                return void (n += e + ":" + s * i.scaleWidth + "px;");
                            n += e + ":" + parseInt(s, 0) * i.scaleWidth + ";"
                        } else if ("borderRadius" === e) {
                            if (!isNaN(s))
                                return void (n += e + ":" + s * i.scaleWidth + "px;");
                            n += e + ":" + parseInt(s, 0) * i.scaleWidth + "px;"
                        }
                        "borderWidth" !== e ? "borderStyle" !== e ? "borderColor" === e && (n += e + ":" + s + ";") : n += e + ":" + s + ";" : n += e + ":" + s + "px;"
                    }),
                        n += "word-wrap: break-word;"
                },
                setTextStyle: function(e) {
                    var t = this
                        , i = e.in.css
                        , n = "";
                    return I()(i).forEach(function(s) {
                        var r = i[s];
                        if ("width" !== s)
                            if ("height" === s)
                                n += s + ":" + r * t.scaleWidth + "px;";
                            else if ("lineHeight" === s)
                                n += s + ":" + r + ";";
                            else {
                                if ("fontFamily" === s)
                                    return void (e.fontTag && e.fontUrl ? n += s + ":" + e.fontTag + ";" : n += s + ":" + r + ";");
                                if ("fontSize" === s)
                                    return void (n += s + ":" + parseInt(r, 0) * t.scaleWidth + "px;");
                                if ("color" === s)
                                    n += s + ":" + r + ";";
                                else if ("letterSpacing" === s)
                                    n += s + ":" + parseInt(r, 0) * t.scaleWidth + "px;";
                                else {
                                    if ("borderWidth" === s)
                                        return void (n += s + ":" + r + "px;");
                                    if ("borderStyle" === s)
                                        return void (n += s + ":" + r + ";");
                                    if ("borderColor" === s)
                                        return void (n += s + ":" + r + ";");
                                    if ("borderRadius" === s)
                                        return void (n += s + ":" + r + "px;");
                                    if ("textDecoration" === s)
                                        return void (n += s + ":" + r + ";");
                                    -1 !== s.indexOf("padding") && (n += "paddingBottom" === s || "paddingTop" === s ? s + ":" + parseFloat(r) + "em;" : s + ":" + parseFloat(r) + "px;")
                                }
                            }
                        else
                            n += s + ":" + r * t.scaleWidth + "px;"
                    }),
                        n
                },
                setTextStyle1: function(e) {
                    var t = e.out.css.width
                        , i = e.in.css.padding ? e.in.css.padding : "0"
                        , n = e.out.css.height
                        , s = e.in.css.fontFamily
                        , r = e.in.css.fontSize
                        , a = e.in.css.color
                        , o = e.out.css.lineHeight
                        , l = e.in.css.letterSpacing
                        , c = e.in.css.textDecoration
                        , d = e.in.css.backgroundColor
                        , p = e.in.css.borderStyle
                        , u = e.in.css.borderColor
                        , h = "string" == typeof e.in.css.borderWidth ? parseInt(e.in.css.borderWidth.toString().replace(/[^0-9]/gi, ""), 0) : e.in.css.borderWidth
                        , f = "string" == typeof e.in.css.borderRadius ? parseInt(e.in.css.borderRadius.toString().replace(/[^0-9]/gi, ""), 0) : e.in.css.borderRadius;
                    return "color:" + a + ";width:" + t * this.scaleWidth + "px;height:" + n * this.scaleWidth + "px;fontFamily:" + s + ";fontSize:" + parseInt(r, 0) * this.scaleWidth + "px;textDecoration:" + c + ";backgroundColor:" + d + ";borderWidth:" + h + "px;borderStyle:" + p + ";borderColor:" + u + ";borderRadius:" + f + "px;padding:" + i + ";lineHeight:" + o * this.scaleWidth + "px;letterSpacing:" + parseInt(l, 0) * parseInt(r, 0) * this.scaleWidth / 200 + "px;"
                },
                setRenderStyle: function(e) {
                    var t = this
                        , i = e.in.css
                        , n = "";
                    return I()(i).forEach(function(s) {
                        var r = i[s];
                        "width" === s && (n += s + ":" + parseInt(r * t.scaleWidth, 0) + "px;",
                        "picture" === e.type && (n += "background-size:100% 100%;")),
                        "height" === s && (n += s + ":" + parseInt(r * t.scaleWidth, 0) + "px;",
                        "count" === e.type && (n += "line-height:" + r + "px;")),
                        "rotate" === s && (n += "transform:rotate(" + r + "deg);"),
                        "opacity" === s && (n += s + ":" + (1 - r) + ";"),
                        "line-height" === s && (n += s + ":" + r + ";"),
                        "color" === s && (n += s + ":" + r + ";"),
                        "fontSize" === s && (n += s + ":" + r + "px;"),
                        "textAlign" === s && (n += s + ":" + r + ";"),
                            "link" === e.type ? e.isImg ? "backgroundColor" !== s && "background-color" !== s || (n += s + ":transparent;") : "backgroundColor" !== s && "background-color" !== s || (n += s + ":" + r + ";") : "backgroundColor" !== s && "background-color" !== s || ("count" === e.type && (n += s + ":inherit"),
                                n += "" === s ? s + ":rgb(0,0,0)" : s + ":" + r + ";"),
                        "letterSpacing" === s && (n += s + ":" + r + "px;"),
                        "lineHeight" === s && (n += s + ":" + r + ";"),
                        "fontWeight" === s && (n += s + ":" + r + ";"),
                        "fontStyle" === s && (n += s + ":" + r + ";"),
                        "textDecoration" === s && (n += s + ":" + r + ";"),
                        "writingMode" === s && (n += s + ":" + r + ";"),
                        "boxShadow" === s && (n += s + ":black 0px 0px " + r + "px;"),
                        "borderStyle" === s && (n += s + ":" + r + ";"),
                        "borderColor" === s && (n += s + ":" + r + ";"),
                        "borderRadius" === s && (n += s + ":" + (r = "string" == typeof r ? parseInt(r.toString().replace(/[^0-9]/gi, ""), 0) : r) + "px;"),
                        "borderWidth" === s && (n += s + ":" + (r = "string" == typeof r ? parseInt(r.toString().replace(/[^0-9]/gi, ""), 0) : r) + "px;")
                    }),
                        n
                },
                setRadioStyle: function(e, t) {
                    var i = e.in.css
                        , n = "overflow: hidden;";
                    return 3 !== t && I()(i).forEach(function(t) {
                        var s = i[t];
                        if ("width" === t) {
                            if (!isNaN(s))
                                return void (n += t + ":" + s + "px;");
                            n += t + ":" + s + ";"
                        } else if ("height" === t)
                            ;
                        else if ("top" === t) {
                            if (!isNaN(s))
                                return void (n += t + ":" + s + "px;");
                            n += t + ":" + s + ";"
                        } else if ("left" === t) {
                            if (!isNaN(s))
                                return void (n += t + ":" + s + "px;");
                            n += t + ":" + s + ";"
                        } else if ("background" === t)
                            "rate" !== e.type && "select" !== e.type ? n += "borderColor:" + s + ";" : n += t + ":" + s + ";";
                        else if ("backgroundColor" === t)
                            "rate" !== e.type && "select" !== e.type ? n += "borderColor:" + s + ";" : n += t + ":" + s + ";";
                        else if ("borderRadius" === t)
                            n += t + ":" + parseInt(s, 0) + "px;";
                        else if ("borderColor" === t)
                            n += t + ":" + s + ";";
                        else if ("fontSize" === t)
                            n += t + ":" + (s = "string" == typeof s ? parseInt(s.toString().replace(/[^0-9]/gi, ""), 0) : s) + "px;",
                                n += "lineHeight:" + 2 * (s = "string" == typeof s ? parseInt(s.replace(/[^0-9]/gi, ""), 0) : s) + "px;";
                        else if ("borderWidth" === t)
                            n += t + ":" + (s = "string" == typeof s ? parseInt(s.toString().replace(/[^0-9]/gi, ""), 0) : s) + "px;";
                        else if ("lineHeight" === t)
                            ;
                        else {
                            if (0 === t.indexOf("padding"))
                                return;
                            n += t + ":" + s + ";"
                        }
                    }),
                        n
                },
                setOptionStyle: function(e, t) {
                    var i = e.in.css
                        , n = "";
                    return 3 !== t && I()(i).forEach(function(e) {
                        var t = i[e];
                        "fontSize" === e && (n += e + ":" + .5 * (t = "string" == typeof t ? parseInt(t.toString().replace(/[^0-9]/gi, ""), 0) : t) + "px;")
                    }),
                        n
                },
                setRadioTitle: function(e) {
                    var t = e.in.css
                        , i = "";
                    return I()(t).forEach(function(e) {
                        var n = t[e];
                        if ("background" === e)
                            i += e + ":" + n + ";";
                        else if ("backgroundColor" === e)
                            i += e + ":" + n + ";";
                        else if ("fontSize" === e)
                            i += e + ":" + (n = "string" == typeof n ? parseInt(n.toString().replace(/[^0-9]/gi, ""), 0) : n) + "px;";
                        else if ("lineHeight" === e)
                            i += e + ":" + parseInt(n.toString(), 0) + "px;";
                        else if ("fontFamily" === e)
                            i += e + ":" + n + ";";
                        else {
                            if ("color" !== e)
                                return;
                            i += e + ":" + n + ";"
                        }
                    }),
                        i
                },
                setNewAni: function(e) {
                    var t = "";
                    if (e) {
                        I()(e).forEach(function(t) {
                            e[t].duration = void 0 !== e[t].duration ? parseFloat(e[t].duration) : 1,
                                e[t].delay = void 0 !== e[t].delay ? parseFloat(e[t].delay) : 1,
                                e[t].count = void 0 !== e[t].count ? parseInt(e[t].count, 0) : 1
                        }),
                            t += "animation: ";
                        var i = 0;
                        e.in && "none" !== e.in.type && (i += e.in.delay,
                            t += e.in.type + " " + e.in.duration + "s linear " + i + "s " + e.in.count,
                            i += e.in.duration),
                        e.on && "none" !== e.on.type && (i += e.on.delay,
                            t += ", " + e.on.type + " " + e.on.duration + "s linear " + i + "s " + e.on.count,
                            i += e.on.duration),
                        e.out && "none" !== e.out.type && (i += e.out.delay,
                            t += ", " + e.out.type + " " + e.out.duration + "s linear " + i + "s " + e.out.count),
                            t += ";animation-fill-mode: both;"
                    }
                    return t
                },
                setShapeHtml: function(e) {
                    var t = A()(e.svg)
                        , i = e.in.properties.colors
                        , n = void 0;
                    return (n = void 0 !== i ? I()(i) : []).length > 0 ? (t.find("[fill], [style*='fill']").each(function(e, t) {
                        void 0 === i[n[e]] ? A()(t).attr("fill", i[n[e - 1]]) : A()(t).attr("fill", i[n[e]])
                    }),
                        A()(t).attr({
                            width: e.in.css.width * this.scaleWidth,
                            height: e.in.css.height * this.scaleWidth,
                            preserveAspectRatio: "none meet"
                        }),
                        A()(t[t.length - 1]).prop("outerHTML")) : (A()(t).attr({
                        width: e.in.css.width * this.scaleWidth,
                        height: e.in.css.height * this.scaleWidth,
                        preserveAspectRatio: "none meet"
                    }),
                        A()(t[t.length - 1]).prop("outerHTML"))
                },
                setLiStyle: function(e) {
                    var t = 1;
                    e.in.properties.column && (t = parseInt(e.in.properties.column.toString(), 0));
                    var i = "";
                    t > 1 && (i += "float: left;",
                        i += "width: " + (92 / t - 5) + "%;");
                    return e.in.css.lineHeight && (i += "lineHeight: " + parseInt(e.in.css.lineHeight, 0) + "px;"),
                    e.in.css.margin && (i += "margin: " + e.in.css.margin + ";"),
                        i
                },
                getUrl: function(e) {
                    return e.in.properties.url.indexOf("http://") > -1 || e.in.properties.url.indexOf("https://") > -1 ? e.in.properties.url : "https://" + e.in.properties.url.toString().replace("http://", "")
                },
                requestUrl: function(e, t, i, n) {
                    var s = this;
                    this.$http({
                        method: "post",
                        url: i
                    }).then(function(t) {
                        1 === t.data.code ? (n ? (A()(".inputs").find("input").val(""),
                            A()(".inputs").find("input").nextAll("span").show()) : A()("#" + e.zanid).find("span").text(t.data.interAction),
                            s.$Message.success({
                                content: t.data.msg,
                                duration: 3
                            })) : s.$Message.error(t.data.msg)
                    }).catch(function() {
                        s.$Message.error("网络开小差啦~")
                    })
                },
                teleClick: function(e) {
                    window.location.href = "tel://" + e.in.properties.tel
                },
                submitZan: function(e, t) {
                    if (this.has)
                        this.$Message.warning("已点赞");
                    else if ("preview" === window.type)
                        this.$Message.success("点赞成功");
                    else {
                        var i = new URLSearchParams
                            , n = {
                            oid: this.sceneInfoSub.id,
                            pageid: t.id,
                            zanid: e.in.properties.id
                        }
                            , s = this.sceneInfoSub.id;
                        this.has = !0,
                            this.requestUrl(n, i, v(s), !1)
                    }
                },
                getZanCount: function(e, t) {
                    var i = this;
                    if ("preview" === window.type)
                        A()(document).ready(function() {
                            A()("#" + e.in.properties.id).find("span").text("点赞")
                        });
                    else {
                        var n = this;
                        A()(document).ready(function() {
                            var s = A()("#" + e.in.properties.id)
                                , r = i.sceneInfoSub.id
                                , a = m(r);
                            0 !== s.attr("data-flag") && void 0 !== s.attr("data-flag") && n.$http({
                                method: "post",
                                url: a,
                                data: {
                                    oid: n.sceneInfoSub.id,
                                    pageid: t.id,
                                    zanid: e.in.properties.id
                                }
                            }).then(function(e) {
                                s.attr("data-flag", 1),
                                e.data.interAction > 0 && s.find("span").text(e.data.interAction)
                            }).catch(function() {})
                        })
                    }
                },
                submitData: function(e, t, i) {
                    var n = this;
                    if ("preview" === window.type)
                        n.$Message.success("提交成功");
                    else {
                        var s = void 0
                            , r = new URLSearchParams
                            , a = [];
                        r.postid = this.sceneInfoSub.id,
                            r.pageid = t.id;
                        for (var o = void 0, l = 0; l < e.length; l++)
                            if ("input" === e[l].type) {
                                if (s = A()(i.target).parents(".elementCanvas").find("#" + e[l].in.properties.module_id).val(),
                                    "1" === e[l].in.properties.require && ("" === s || void 0 === s))
                                    return n.$Message.error("请补全信息");
                                if (void 0 !== s) {
                                    var c = e[l].in.properties.placeholder;
                                    if ("姓名" === c) {
                                        if (s.length > 15)
                                            return n.$Message.error("姓名过长")
                                    } else if ("手机" === c) {
                                        if (!/^1(3|4|5|7|8)\d{9}$/.test(s))
                                            return n.$Message.error("手机号有误")
                                    } else if ("邮箱" === c) {
                                        if (!/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/.test(s))
                                            return n.$Message.error("邮箱地址有误")
                                    } else if ("文本" === c && s.length > 150)
                                        return n.$Message.error("文本过长");
                                    a.push({
                                        module_id: e[l].in.properties.module_id,
                                        placeholder: s
                                    })
                                }
                                "submit" === e[l].type && (r.ok = e[l].in.properties.ok)
                            } else if ("radio" === e[l].type) {
                                if (o = A()('input:radio[name="' + e[l].in.properties.placeholder + '"]:checked').val(),
                                    "1" === e[l].in.properties.require && ("" === o || void 0 === o))
                                    return n.$Message.error("请补全信息");
                                a.push({
                                    module_id: e[l].in.properties.module_id,
                                    placeholder: e[l].in.properties.placeholder,
                                    value: o
                                })
                            } else if ("checkbox" === e[l].type) {
                                var d = function() {
                                    var t = A()('input:checkbox[name="' + e[l].in.properties.placeholder + '"]:checked')
                                        , i = [];
                                    if (I()(t).forEach(function(e) {
                                            t[e].checked && i.push(t[e].value)
                                        }),
                                        "1" === e[l].in.properties.require && 0 === i.length)
                                        return {
                                            v: n.$Message.error("请补全信息")
                                        };
                                    a.push({
                                        module_id: e[l].in.properties.module_id,
                                        placeholder: e[l].in.properties.placeholder,
                                        value: i
                                    })
                                }();
                                if ("object" === (void 0 === d ? "undefined" : S()(d)))
                                    return d.v
                            } else if ("select" === e[l].type) {
                                if (o = A()("#" + e[l].in.properties.module_id + " option:selected").text(),
                                    "1" === e[l].in.properties.require && void 0 === o)
                                    return n.$Message.error("请补全信息");
                                a.push({
                                    module_id: e[l].in.properties.module_id,
                                    placeholder: e[l].in.properties.placeholder,
                                    value: o
                                })
                            } else if ("rate" === e[l].type) {
                                if (o = e[l].in.properties.value,
                                    "1" === e[l].in.properties.require && 0 === o)
                                    return n.$Message.error("请补全信息");
                                a[e[l].in.properties.module_id] = o
                            }
                        r.content = a;
                        var p = {
                            postid: this.sceneInfoSub.id,
                            content: r.content,
                            pagenum: t.pagenum
                        }
                            , u = x()(p);
                        this.requestUrl(p, r, y(u), !0)
                    }
                    return !0
                },
                inputfocus: function(e) {
                    A()(e.target).nextAll("span").hide()
                },
                inputblur: function(e) {
                    "" === A()(e.target).val() ? A()(e.target).nextAll("span").show() : A()(e.target).nextAll("span").hide()
                },
                getImageSrc: function(e, t, i) {
                    e && -1 !== e.indexOf("huanqing365.com") && (e = e.replace("http://www.huanqing365.com", "https://res.huanqing365.com"));
                    var n = i.crop;
                    void 0 !== n ? (n.left = Math.round(n.left),
                        n.top = Math.round(n.top),
                        n.width = Math.round(n.width),
                        n.height = Math.round(n.height),
                        e += "?x-oss-process=image/crop,x_" + n.left + ",y_" + n.top + ",w_" + n.width + ",h_" + n.height + ",g_nw/quality,q_80") : e += "?x-oss-process=image/resize,m_fixed,h_" + Math.round(Math.round(i.out.css.height) * this.scaleWidth) + ",w_" + Math.round(Math.round(i.out.css.width) * this.scaleWidth);
                    return e
                },
                picClick: function(e) {
                    var t = void 0;
                    1 === e.hasUrl ? (t = e.jumpUrl.indexOf("http://") > -1 || e.jumpUrl.indexOf("https://") > -1 ? e.jumpUrl : "https://" + e.jumpUrl.toString().replace("http://", ""),
                        window.parent.location.href = t) : 1 !== e.hasUrl && 2 === e.hasUrl && (this.scrollIndex = e.jumpPageNumber - 1,
                        this.pageStr = e.jumpPageNumber + "/" + this.pagesData.length,
                        this.swiper.slideTo(this.scrollIndex))
                },
                getText: function(e) {
                    return "<br>" === e[3] ? e[3] : e[3] + "<br>"
                }
            }
        }
            , O = {
            render: function() {
                var e = this
                    , t = e.$createElement
                    , n = e._self._c || t;
                return n("div", {
                    staticClass: "preview"
                }, [n("div", {
                    staticClass: "previewtk"
                }, [n("div", {
                    staticClass: "workwrap"
                }, [n("div", {
                    staticClass: "workcont"
                }, [n("swiper", {
                    ref: "mySwiper",
                    style: "height:" + e.height + "px",
                    attrs: {
                        options: e.swiperOption,
                        id: "my"
                    }
                }, e._l(e.pagesData, function(t, s) {
                    return n("swiper-slide", {
                        key: s,
                        staticStyle: {
                            overflow: "hidden"
                        }
                    }, [n("div", {
                        directives: [{
                            name: "show",
                            rawName: "v-show",
                            value: e.scrollIndex === s,
                            expression: "scrollIndex === index"
                        }],
                        staticClass: "bgCanvas",
                        class: e.isHide(s),
                        style: e.setBgStyle(t)
                    }, [n("div", {
                        staticClass: "elementCanvas",
                        staticStyle: {
                            "transform-origin": "0 0",
                            transform: "scale(0.5)"
                        },
                        style: e.setTop()
                    }, e._l(t.elements, function(r, a) {
                        return n("div", {
                            key: a,
                            class: ["item_wrapper", r.class],
                            staticStyle: {
                                position: "absolute"
                            },
                            style: e.setOutStyle(r.out.css, r.type),
                            attrs: {
                                type: r.type,
                                index: a
                            }
                        }, [n("div", {
                            staticClass: "content",
                            style: e.setNewAni(r.animation, s)
                        }, ["picture" === r.type ? n("div", {
                            staticClass: "img-element"
                        }, [n("div", {
                            staticClass: "wrapper",
                            style: e.setOutImageStyle(r, r.out.css),
                            on: {
                                click: function(t) {
                                    e.picClick(r.in.properties)
                                }
                            }
                        }, [n("img", {
                            staticClass: "img-render render",
                            style: e.setInImageStyle(r, r.out.css),
                            attrs: {
                                src: e.getImageSrc(r.src, r.in.css.width, r)
                            }
                        })])]) : e._e(), e._v(" "), "text" === r.type ? n("div", {
                            staticClass: "text-element",
                            attrs: {
                                id: a
                            }
                        }, [n("div", {
                            staticClass: "wrapper",
                            style: e.setInStyle(r)
                        }, [n("div", {
                            staticClass: "text-render render"
                        }, [n("div", {
                            staticClass: "scaleArea",
                            staticStyle: {
                                height: "100%"
                            }
                        }, [n("div", {
                            staticClass: "vue-edit-area",
                            style: e.setTextStyle(r),
                            attrs: {
                                danyeid: a
                            },
                            domProps: {
                                innerHTML: e._s(r.content.replace(/<(?!br)(([\s\S!br])*?)>(([\s\S])*?)<\/(([\s\S])*?)>/g, function() {
                                    for (var t = [], i = arguments.length; i--; )
                                        t[i] = arguments[i];
                                    return e.getText(t)
                                }))
                            }
                        }, [n("i")])])])])]) : e._e(), e._v(" "), "map" === r.type ? n("div", {
                            staticClass: "map-element"
                        }, [n("div", {
                            staticClass: "wrapper",
                            style: e.setInStyle(r)
                        }, [n("div", {
                            staticClass: "map-render render",
                            style: e.setRenderStyle(r)
                        }, [n("img", {
                            staticStyle: {
                                width: "100%",
                                height: "100%"
                            },
                            attrs: {
                                src: "https://api.map.baidu.com/staticimage/v2?ak=3bmmPVKsuZDMUL2ksuntWLnS5X9VcmMK&width=" + r.in.css.width + "&height=" + r.in.css.height + "&dpiType=ph&markers=" + r.in.properties.address + "|" + r.in.properties.lng + "," + r.in.properties.lat + "&markerStyles=l,,0xff0000&center=" + r.in.properties.address + "&labels=" + r.in.properties.address + "|" + r.in.properties.lng + "," + r.in.properties.lat + "&zoom=17&labelStyles=我在这,1,28,0xffffff,0x1abd9b,1"
                            }
                        }), e._v(" "), n("a", {
                            staticStyle: {
                                width: "110px",
                                height: "50px",
                                "line-height": "50px",
                                background: "rgb(26, 189, 155)",
                                position: "absolute",
                                right: "10px",
                                bottom: "10px",
                                color: "rgb(255, 255, 255)",
                                "text-align": "center",
                                "font-size": "32px",
                                "border-radius": "3px"
                            },
                            on: {
                                click: function(t) {
                                    e.goLocation(r.in.properties)
                                }
                            }
                        }, [e._v("导航")])])])]) : e._e(), e._v(" "), "phone" === r.type ? n("div", [n("div", {
                            staticClass: "wrapper",
                            style: e.setInStyle(r)
                        }, [n("div", {
                            staticClass: "link-button-render render",
                            style: e.setRenderStyle(r)
                        }, [n("div", {
                            staticClass: "text1 link-button-render-text"
                        }, [n("a", {
                            staticClass: "telebtn",
                            style: e.setInStyle(r),
                            on: {
                                click: function(i) {
                                    e.teleClick(r, t)
                                }
                            }
                        }, [n("i", {
                            staticClass: "iconfont icon-bohao",
                            style: e.setBtnStyle(r.in.css)
                        }), e._v("\n                                                            " + e._s(r.content) + "\n                                                        ")])]), e._v(" "), r.isImg ? n("img", {
                            attrs: {
                                src: r.pic.url,
                                alt: ""
                            }
                        }) : e._e()])])]) : e._e(), e._v(" "), "interActionButton" === r.type ? n("div", [n("div", {
                            staticClass: "wrapper",
                            style: e.setInStyle(r)
                        }, [n("div", {
                            staticClass: "link-button-render render",
                            style: e.setRenderStyle(r)
                        }, [n("div", {
                            staticClass: "text1 link-button-render-text"
                        }, [n("a", {
                            staticClass: "zanbtn",
                            class: e.getZanCount(r, t),
                            style: e.setInStyle(r),
                            attrs: {
                                id: r.in.properties.id,
                                "data-flag": "0"
                            },
                            on: {
                                click: function(i) {
                                    e.submitZan(r, t)
                                }
                            }
                        }, [n("i", {
                            staticClass: "iconfont icon-dianzan1",
                            style: e.setBtnStyle(r.in.css)
                        }), e._v(" "), n("span", [e._v(e._s(r.content))])])]), e._v(" "), r.isImg ? n("img", {
                            attrs: {
                                src: r.pic.url,
                                alt: ""
                            }
                        }) : e._e()])])]) : e._e(), e._v(" "), "link" === r.type ? n("div", [n("div", {
                            staticClass: "wrapper",
                            style: e.setInStyle(r, a)
                        }, [n("div", {
                            staticClass: "link-button-render render",
                            style: e.setRenderStyle(r)
                        }, [n("div", {
                            staticClass: "text1 link-button-render-text"
                        }, [n("a", {
                            staticClass: "linkbtn",
                            style: e.setInStyle(r),
                            attrs: {
                                href: e.getUrl(r, t)
                            },
                            on: {
                                click: function(i) {
                                    e.submitZan(r, t)
                                }
                            }
                        }, [e._v("\n                                                            " + e._s(r.content) + "\n                                                        ")])]), e._v(" "), r.isImg ? n("img", {
                            attrs: {
                                src: r.pic.url,
                                alt: ""
                            }
                        }) : e._e()])])]) : e._e(), e._v(" "), "count" === r.type ? n("div", [n("div", {
                            staticClass: "wrapper",
                            style: e.setInStyle(r)
                        }, [n("div", {
                            staticClass: "link-button-render render",
                            style: e.setRenderStyle(r)
                        }, [n("countdownbox", {
                            attrs: {
                                startTime: (new Date).getTime(),
                                endText: r.in.properties.endtip,
                                endTime: parseInt(r.in.properties.deadlineTime),
                                item: r,
                                type: "workarea"
                            }
                        }), e._v(" "), r.isImg ? n("img", {
                            attrs: {
                                src: r.pic.url,
                                alt: ""
                            }
                        }) : e._e()], 1)])]) : e._e(), e._v(" "), "shape" === r.type ? n("div", {
                            staticClass: "shape-element"
                        }, [n("div", {
                            staticClass: "wrapper",
                            style: e.setInStyle(r)
                        }, [n("div", {
                            staticClass: "shape-render render",
                            style: e.setRenderStyle(r)
                        }, [n("div", {
                            staticClass: "svg",
                            domProps: {
                                innerHTML: e._s(e.setShapeHtml(r))
                            }
                        })])])]) : e._e(), e._v(" "), "input" === r.type ? n("div", {
                            staticClass: "forminputbox",
                            style: e.setFormTextSize(r)
                        }, [n("input", {
                            staticStyle: {
                                display: "block",
                                position: "absolute",
                                margin: "0",
                                padding: "0",
                                border: "0"
                            },
                            style: e.setTextStyle1(r),
                            attrs: {
                                type: "text",
                                id: r.in.properties.module_id
                            },
                            on: {
                                focus: e.inputfocus,
                                blur: e.inputblur
                            }
                        }), e._v(" "), n("span", {
                            staticStyle: {
                                position: "relative",
                                "pointer-events": "none",
                                opacity: "0.7",
                                "padding-left": "10px"
                            },
                            style: e.setSpanStyle(r.in.css)
                        }, [e._v(e._s(r.in.properties.placeholder))]), e._v(" "), n("span", {
                            staticStyle: {
                                position: "relative",
                                "pointer-events": "none",
                                color: "red"
                            },
                            style: e.setSpanStyle(r.in.css)
                        }, [e._v("*")])]) : e._e(), e._v(" "), "submit" === r.type ? n("div", {
                            staticClass: "shape-element"
                        }, [n("div", {
                            staticClass: "wrapper",
                            style: e.setInStyle(r)
                        }, [n("div", {
                            staticClass: "shape-render render"
                        }, ["submit" === r.type ? n("div", {
                            style: e.setOutStyle(r.in.css, r.type),
                            on: {
                                click: function(i) {
                                    e.submitData(t.elements, t, i)
                                }
                            }
                        }, [e._v(e._s(r.in.properties.placeholder) + "\n                                                    ")]) : e._e()])])]) : e._e(), e._v(" "), "radio" === r.type ? n("div", {
                            staticClass: "shape-element"
                        }, [n("div", {
                            staticClass: "wrapper"
                        }, [n("div", {
                            staticClass: "shape-render render"
                        }, ["radio" === r.type ? n("div", {
                            staticClass: "radiogroup",
                            staticStyle: {
                                "border-radius": "6px"
                            }
                        }, [n("p", {
                            style: e.setRadioTitle(r, a)
                        }, [e._v("\n                                                            " + e._s(r.in.properties.placeholder) + "\n                                                        ")]), e._v(" "), n("div", {
                            staticClass: "groupwrap"
                        }, [n("ul", {
                            staticClass: "radioOption",
                            staticStyle: {
                                "background-color": "#ffffff",
                                height: "auto"
                            },
                            style: e.setRadioStyle(r, a),
                            attrs: {
                                id: r.in.properties.module_id
                            }
                        }, e._l(r.in.properties.value, function(t, i) {
                            return n("li", {
                                key: i
                            }, [n("input", {
                                attrs: {
                                    type: "radio",
                                    name: r.in.properties.placeholder
                                },
                                domProps: {
                                    value: t
                                }
                            }), e._v(" "), n("span", {
                                staticClass: "readiostyle"
                            }), e._v(" "), n("span", [e._v(e._s(t))])])
                        }))])]) : e._e()])])]) : e._e(), e._v(" "), "checkbox" === r.type ? n("div", {
                            staticClass: "shape-element"
                        }, [n("div", {
                            staticClass: "wrapper"
                        }, [n("div", {
                            staticClass: "shape-render render"
                        }, ["checkbox" === r.type ? n("div", {
                            staticClass: "radiogroup",
                            staticStyle: {
                                "border-radius": "6px"
                            }
                        }, [n("p", {
                            style: e.setRadioTitle(r, a)
                        }, [e._v("\n                                                            " + e._s(r.in.properties.placeholder) + "\n                                                        ")]), e._v(" "), n("div", {
                            staticClass: "groupwrap"
                        }, [n("ul", {
                            staticClass: "checkOption",
                            staticStyle: {
                                "background-color": "#ffffff"
                            },
                            style: e.setRadioStyle(r, a),
                            attrs: {
                                id: r.in.properties.module_id
                            }
                        }, e._l(r.in.properties.value, function(t, s) {
                            return n("li", {
                                key: s
                            }, [n("input", {
                                attrs: {
                                    type: "checkbox",
                                    name: r.in.properties.placeholder
                                },
                                domProps: {
                                    value: t
                                }
                            }), e._v(" "), n("span", {
                                staticClass: "checkstyle"
                            }, [n("img", {
                                attrs: {
                                    src: i("4/gI"),
                                    alt: ""
                                }
                            })]), e._v(" "), n("span", [e._v(e._s(t))])])
                        }))])]) : e._e()])])]) : e._e(), e._v(" "), "select" === r.type ? n("div", {
                            staticClass: "shape-element"
                        }, [n("div", {
                            staticClass: "wrapper"
                        }, [n("div", {
                            staticClass: "shape-render render"
                        }, ["select" === r.type ? n("div", {
                            staticClass: "selectgroup"
                        }, [n("select", {
                            staticStyle: {
                                padding: "10px 10px"
                            },
                            style: e.setRadioStyle(r, a),
                            attrs: {
                                id: r.in.properties.module_id
                            }
                        }, [n("option", {
                            style: e.setOptionStyle(r, a),
                            attrs: {
                                value: ""
                            }
                        }, [e._v(e._s(r.in.properties.placeholder) + "\n                                                            ")]), e._v(" "), e._l(r.in.properties.value, function(t, i) {
                            return n("option", {
                                key: i,
                                style: e.setOptionStyle(r, a),
                                domProps: {
                                    value: t
                                }
                            }, [e._v(e._s(t) + "\n                                                            ")])
                        })], 2)]) : e._e()])])]) : e._e(), e._v(" "), "g" === r.type && 1 !== r.is_del ? n("div", {
                            staticClass: "shape-element"
                        }, [n("div", {
                            staticClass: "wrapper"
                        }, [n("div", {
                            staticClass: "shape-render render"
                        }, [n("div", {
                            staticClass: "ratinggroup",
                            staticStyle: {
                                "border-radius": "8px"
                            },
                            style: e.setRadioStyle(r, a)
                        }, [n("p", [e._v(e._s(r.in.properties.placeholder))]), e._v(" "), n("div", {
                            staticClass: "staricon fl"
                        }, [n("Rate", {
                            staticStyle: {
                                "font-size": "inherit"
                            },
                            model: {
                                value: r.in.properties.value,
                                callback: function(t) {
                                    e.$set(r.in.properties, "value", t)
                                },
                                expression: "ele.in.properties.value"
                            }
                        })], 1)])])])]) : e._e()])])
                    }))])])
                })), e._v(" "), e.is_page ? n("div", {
                    staticClass: "pagecount",
                    style: "bottom: " + (15 + e.top) + "px;"
                }, [e._v("\n                    " + e._s(e.pageStr) + "\n                ")]) : e._e(), e._v(" "), e.sceneInfoSub.music && !e.is_page && e.effect ? n("a", {
                    staticClass: "musicbtn",
                    class: {
                        play: e.isPlay
                    },
                    style: "width:" + 30 * this.scaleWidth + "px;height:" + 30 * this.scaleHeight + "px;top:" + 20 * this.scaleHeight + "px;right:" + 20 * this.scaleWidth + "px;",
                    on: {
                        click: e.playOrPauseMusic
                    }
                }) : e._e(), e._v(" "), e.effect ? n("b") : e._e()], 1)])])])
            },
            staticRenderFns: []
        };
        var R = i("VU/8")(H, O, !1, function(e) {
            i("Fg+R")
        }, "data-v-c047d218", null).exports
            , P = {
            name: "index",
            data: function() {
                return {
                    effect: !1,
                    isIndex: !1
                }
            },
            computed: Object(h.b)(["sceneInfoSub"]),
            components: {
                MainPage: R
            },
            methods: {
                initOriginData: function() {
                    var e = this;
                    this.$http.post(g(window.type, window.code)).then(function(t) {
                        1 === t.data.code ? (e.$store.dispatch("initOriginData", t.data.data),
                        e.effect || (e.isIndex = !0),
                        window.wx && window.wx.ready(function() {
                            setTimeout(function() {
                                document.getElementById("audio2") && document.getElementById("audio2").play()
                            }, 500)
                        }),
                            setTimeout(function() {
                                e.isIndex = !0
                            }, 1500)) : e.$Message.error(t.data.msg)
                    }).catch(function(t) {
                        window.console.log(t),
                            e.$Message.error("网络开小差啦~")
                    })
                },
                canPlay: function() {
                    window.navigator.userAgent.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/) || document.getElementById("audio2") && document.getElementById("audio2").play()
                }
            },
            mounted: function() {
                this.effect = 1 === parseInt(window.effect, 0)
            },
            created: function() {
                this.initOriginData()
            }
        }
            , z = {
            render: function() {
                var e = this
                    , t = e.$createElement
                    , i = e._self._c || t;
                return i("div", {
                    attrs: {
                        id: "main"
                    }
                }, [e.sceneInfoSub.music && e.effect ? i("audio", {
                    attrs: {
                        src: e.sceneInfoSub.music,
                        id: "audio2",
                        loop: "loop",
                        preload: "auto"
                    },
                    on: {
                        canplaythrough: e.canPlay
                    }
                }) : e._e(), e._v(" "), e.isIndex ? e._e() : i("div", {
                    staticClass: "logo db"
                }), e._v(" "), e.isIndex ? i("main-page") : e._e()], 1)
            },
            staticRenderFns: []
        };
        var $ = i("VU/8")(P, z, !1, function(e) {
            i("zxGc")
        }, "data-v-7dfbea8b", null).exports
            , B = i("/ocq");
        u.default.use(B.a);
        var D = new B.a({
            fallback: !1,
            mode: "history",
            routes: [{
                path: "/",
                name: "index",
                component: $
            }]
        })
            , L = function(e) {
            return e.originData
        }
            , q = function(e) {
            return e.originData.pages
        }
            , U = function(e) {
            return e.originData.pages[e.currentPage - 1].pagebg
        }
            , F = function(e) {
            return e.currentPage
        }
            , G = function(e) {
            return e.originData.sceneinfo
        }
            , j = function(e) {
            return e.originData.sceneinfo
        }
            , Z = function(e, t) {
            (0,
                e.commit)("INITORIGINDATA", t)
        }
            , V = function(e, t) {
            (0,
                e.commit)("SELECTPAGE", t)
        }
            , Q = function(e, t) {
            e.originData.pages = t.lists,
                e.originData.sceneinfo = t.sceneinfo
        }
            , Y = function(e, t) {
            e.currentPage = t
        };
        u.default.use(h.a);
        var K = new h.a.Store({
            actions: s,
            getters: n,
            mutations: r,
            state: {
                currentPage: 1,
                originData: {
                    svgColors: {},
                    sceneinfo: {},
                    pages: [{
                        id: 837949,
                        sceneId: 107961,
                        num: 1,
                        name: "",
                        pagebg: {},
                        elements: []
                    }],
                    additional: {}
                }
            },
            strict: !1
        });
        i("VaBq");
        u.default.config.productionTip = !1,
            u.default.use(c.a, {
                size: "small"
            }),
            u.default.use(p.a),
            o.a.defaults.withCredentials = !0,
            u.default.prototype.$http = o.a,
            new u.default({
                el: "#main",
                router: D,
                store: K,
                components: {
                    Main: $
                },
                template: "<Main/>"
            })
    },
    UTRX: function(e, t) {},
    VaBq: function(e, t) {},
    zxGc: function(e, t) {}
}, ["NHnr"]);
