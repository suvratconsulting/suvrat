$(document).ready(function () {

 
// $loading.ajaxStart(function () {
//     $loading.show();
//   }).ajaxStop(function () {
//     $loading.hide();
//   });

//   $("#loadingDiv").hide();
	var heightwin = $(window).innerHeight();
	$(".main_sctn").css("height",heightwin);

	$(".vacancy .jobtitle span").click(function() {
	  $(this).parent().siblings(".jobdesc").slideToggle();
	});

	// $('nav li a,.btn-oval').click(function (e) {
	// 	// e.preventDefault();
	// 	$('html, body').animate({
	// 		scrollTop: $($(this.hash)).offset().top - 100
	// 	}, 1000);
	// 	if ($(window).width() < 768) {
	// 		$('.hdr_cntnr nav').slideToggle();
	// 		$('.hamburg_menu').toggleClass("active");
	// 	}
	// });
  $("nav li a,.btn-oval").on('click', 'a[href^="#"]', function(e) {
    // target element id
      var id = $(this).attr('href');

      // target element
      var $id = $(id);
      if ($id.length === 0) {
          return;
      }

      // prevent standard hash navigation (avoid blinking in IE)
      e.preventDefault();

      // top position relative to the document
      var pos = $(id).offset().top - 60;

      // animated top scrolling
      $('body, html').animate({scrollTop: pos});

  });


	$('.logo').click(function() {
		console.log("check");
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
        || location.hostname == this.hostname) {

        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
           if (target.length) {
             $('html,body').animate({
                 scrollTop: target.offset().top
            }, 1000);
            return false;
        }
    }
});

    $(".hamburg_menu").click(function () {
    	$('.hdr_cntnr nav').slideToggle();
    	$('.hamburg_menu').toggleClass("active");
    });


    $('.arrowdown .arrow').click(function(){
    	$('html, body').animate({scrollTop: $(this).parents('section').next().offset().top-82 }, 1000);
    });
	
	
	// var animateTime = 300;
    animate_once = function () {
   
		var $square = $(".caretDown");        
        $square.animate({
            bottom: "+=10"
        }, 300);
        $square.animate({
            bottom: "-=10"
        }, 300)
    };
    //animate_once();
    animate_thrice = function () {
        var animation = setInterval(animate_once, 600);
        setInterval( function() {clearInterval(animation)}, 1800)
    };
    setInterval(animate_thrice, 4800);


    // Cache selectors
var lastId,
    topMenu = $("#top-menu"),
    topMenuHeight = $("header").outerHeight() + 10,
    // All list items
    menuItems = topMenu.find("a"),
    // Anchors corresponding to menu items
    scrollItems = menuItems.map(function(){
      var item = $($(this).attr("href"));
      if (item.length) { return item; }
    });

// Bind click handler to menu items
// so we can get a fancy scroll animation
menuItems.click(function(e){
  var href = $(this).attr("href"),
      offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight+1;
  $('html, body').stop().animate({ 
      scrollTop: offsetTop
  }, 300);
  e.preventDefault();
});

// Bind to scroll
$(window).scroll(function(){
   // Get container scroll position
   var fromTop = $(this).scrollTop()+topMenuHeight;
   
   // Get id of current scroll item
   var cur = scrollItems.map(function(){
     if ($(this).offset().top < fromTop)
       return this;
   });
   // Get the id of the current element
   cur = cur[cur.length-1];
   var id = cur && cur.length ? cur[0].id : "";
   
   if (lastId !== id) {
       lastId = id;
       // Set/remove active class
       menuItems
         .parent().removeClass("active")
         .end().filter("[href='#"+id+"']").parent().addClass("active");
   }                   
});


});

// $(window).scroll(function() {
//     var hegt = $(".main_sctn").height();
//     var windscroll = $(window).scrollTop();
//     if (windscroll >= hegt) {
//         $('nav').addClass('fixed');
//         $('.wrapper section').each(function(i) {
//             if ($(this).position().top <= windscroll - 20) {
//                 $('nav a.active').removeClass('active');
//                 $('nav a').eq(i).addClass('active');
//                  $('nav a.careers').removeClass('active');
//             }
//         });

//     } else {

//         $('nav').removeClass('fixed');
//         $('nav a.active').removeClass('active');
//         // $('nav a:first').addClass('active');
//     }

// }).scroll();




