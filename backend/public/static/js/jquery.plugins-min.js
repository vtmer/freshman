/* This file is minimized */
(function(c) {
  var b = "rollIn fadeIn fadeInUp fadeInDown fadeInLeft fadeInRight fadeInRight bounceIn bounceInDown bounceInUp bounceInLeft bounceInRight rotateInDownLeft rotateInDownRight rotateInUpLeft rotateInUpRight".split(" "),
  d = b.length;
  c.fn.oneByOne = function(a) {
    function e(a) {
      g.slideShow && f();
      l.stop(!0, !0).animate({
        left: -a * j
      },
      g.delay,
      function() {
        a != t && (r = t, q[r] && (!c.browser.msie && !c.browser.opera && q[r]/*.fadeOut()*/, c(".carousel-nav-list li:eq(" + r + ")", n).removeClass("active")), c(".carousel-nav-list li:eq(" + a + ")", n).addClass("active"), "random" != g.easeType.toLowerCase() ? q[a].show().children().each(function(a) {
          if (c(this).hasClass(g.easeType)) {
            c(this).removeClass(g.easeType);
            //c(this).hide()
          }
          c(this).show().addClass("animate" + a + " " + g.easeType)
        }) : (v = b[Math.floor(Math.random() * d)], w[a] = v, q[r] && q[r].children().each(function() {
          if (c(this).hasClass(w[r])) {
            c(this).removeClass(w[r]);
            //c(this).fadeOut("medium")
          }
        }), q[a].show().children().each(function(a) {
          c(this).show().addClass("animate" + a + " " + v)
        })), l.delay(200 * q[a].children().length).queue(function() {
          g.slideShow && h()
        }), p && p.css("cursor", "pointer"), t = a)
      })
    }
    function f() {
      clearInterval(l.data("interval"))
    }
    function h() {
      clearInterval(l.data("interval"));
      slideShowInt = setInterval(function() {
        k()
      },
      g.slideShowDelay);
      l.data("interval", slideShowInt)
    }
    function k() {
      var a = t;
      a++;
      a = a >= m ? 0 : a;
      e(a)
    }
    var g = {
      className: "oneByOne",
      sliderClassName: "oneByOne_item",
      easeType: "fadeInLeft",
      width: $('.carousel').width(),
      height: 420,
      delay: 300,
      tolerance: 0.25,
      enableDrag: !0,
      showArrow: !0,
      showButton: !0,
      slideShow: !1,
      slideShowDelay: 3E3
    };
    a && c.extend(g, a);
    var n, l, t = -1,
    j = g.width,
    s = 0,
    i = !1,
    w = [],
    v,
    q = [],
    m = 0,
    r = 0,
    o,
    p;
    l = this;
    l.wrap('<div class="' + g.className + '"/>');
    n = l.parent();
    n.css("overflow", "hidden");
    l.find("." + g.sliderClassName).each(function(a) {
      //c(this).hide();
      m++;
      c(this).css("left", j * a);
      q[a] = c(this)
    });
    l.bind("touchstart",
    function(a) {
      a.preventDefault();
      a = a.originalEvent.touches[0] || a.originalEvent.changedTouches[0];
      i || (i = !0, this.mouseX = a.pageX);
      o && o.fadeIn();
      p && p.fadeIn();
      return ! 1
    });
    l.bind("touchmove",
    function(a) {
      a.preventDefault();
      a = a.originalEvent.touches[0] || a.originalEvent.changedTouches[0];
      i && (s = a.pageX - this.mouseX, l.css("left", -t * j + s), g.slideShow && f());
      return ! 1
    });
    l.bind("touchend",
    function(a) {
      var b = t;
      a.preventDefault();
      i = !1;
      if (!s) return ! 1;
      var a = parseInt(g.width),
      c = a / 2; 
      - s > c - a * g.tolerance ? (b++, b = b >= m ? m - 1 : b, e(b)) : s > c - a * g.tolerance ? (b--, e(0 > b ? 0 : b)) : (e(b), g.slideShow && h());
      s = 0;
      o && o.delay(400);//.fadeOut();
      p && p.delay(400);//.fadeOut();
      return ! 1
    });
    g.enableDrag && (l.mousedown(function(a) {
      i || (i = !0, this.mouseX = a.pageX);
      return ! 1
    }), l.mousemove(function(a) {
      i && (s = a.pageX - this.mouseX, l.css("left", -t * j + s), g.slideShow && f());
      return ! 1
    }), l.mouseup(function() {
      i = !1;
      var a = t;
      if (!s) return ! 1;
      var b = parseInt(g.width),
      c = b / 2; - s > c - b * g.tolerance ? (a++, a = a >= m ? m - 1 : a, e(a)) : s > c - b * g.tolerance ? (a--, e(0 > a ? 0 : a)) : (e(a), g.slideShow && h());
      s = 0;
      return ! 1
    }), l.mouseleave(function() {
      c(this).mouseup()
    }));
    n.mouseover(function() {
      o && o.fadeIn();
      p && p.fadeIn()
    });
    n.mouseleave(function() {
      //o && o.fadeOut();
     // p && p.fadeOut()
    });
    if (g.showButton) {
      a = c('<div class="carousel-nav"><div class="carousel-nav-list"></div></div>');
      n.append(a);
      o = a.find(".carousel-nav-list");
      for (var u = 0; u < m; u++) o.append('<li class="carousel-nav-item"><a rel="' + u + '">' + "</a></li>").css("cursor", "pointer");
      c(".carousel-nav-list li:eq(" + t + ")", a).addClass("active");
      c(".carousel-nav-list a", a).bind("click",
      function() {
        if (c(this).hasClass("active")) return false;
        var a = c(this).attr("rel");
        e(a)
      })
    }
    g.showArrow && (p = c('<div class="arrowButton"><div class="prevArrow"></div><div class="nextArrow"></div></div>'), n.append(p), c(".nextArrow", p).bind("click",
    function() {
      k()
    }), c(".prevArrow", p).bind("click",
    function() {
      var a = t;
      a--;
      a = a < 0 ? m - 1 : a;
      e(a)
    }));
    //o && o.hide();
    //p && p.hide();
    e(0);
    g.slideShow && (slideShowInt = setInterval(function() {
      k()
    },
    g.slideShowDelay), l.data("interval", slideShowInt));
    return this
  }
})(jQuery); 
