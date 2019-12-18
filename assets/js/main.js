
$(document).ready(function(){ 
    let menu = {
        header: 0,
        info: 20,
        content: 40,
        testi: 60,
        gallery: 80
    };
    $('.section').each(function eachElement(){
        let $this = $(this);
        let position = $this.position();
        let end = position.top + $this.height();
        let id = $this.attr('id');
        // $('body').append('<div class="patok" style="top:'+position.top+'px">in '+id+'</div>');
        // $('body').append('<div class="patok" style="top:'+end+'px">out '+id+'</div>');
        $('#info').scrollspy({
            min: position.top - 105,
            max: position.top + $this.height(),
            onEnter: function(element, position) {
                // $nav.addClass('fixed');
                $('#menubar div').css('margin-left', menu[id]+'%');
                console.log('masuk '+id);
                // console.log($this);
                // console.log(id);
                // console.log(position);
            },
            onLeave: function(element, position) {
                // $('#navbar').css('position', 'fixed');
                console.log('keluar '+id);
            }
        });
    });
    if(popup>0){
        $('#modal-news').modal('show')
    }
});

// // SMOOTH SCROLL
// $(document).on('click', 'a[href^="#"]', function (event) {
//     event.preventDefault();
//     console.log($('#header-shadow')[0].scrollHeight);
//     $('html, body').animate({
//         scrollTop: $('#header-shadow').height()
//     }, {
//         duration: 1000, 
//         specialEasing: {
//             scrollTop: "easeOutCirc"
//         }
//     });
// });
$('a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top - 100
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });

// NAVBAR
let tl = new TimelineMax({repeat: -1});

tl.to("#header-filter:before", 2, {
    // transformOrigin:'80% 20%',
    // rotation:100,
    // xPercent:-25,
    yPercent:20,
    // scaleX:0.3,
    // scaleY:1.5,
    ease: Back.easeIn.config(1.7)
})
.to("#header-filter:before", 1, {
    // transformOrigin:'80% 20%',
    // rotation:100,
    // xPercent:-25,
    yPercent:0,
    // scaleX:0.3,
    // scaleY:1.5,
    ease: Back.easeOut.config(1.7)
});

$(window).scroll(function () {
    if ($(this).scrollTop()  <= 210 ){
        $("#navbar").removeClass('not-top');
        // $("#header-shadow").css('margin-top', '210px');
    }else{
        $("#navbar").addClass('not-top');
        // $("#header-shadow").css('margin-top', '70px');
        // $("#school-info").slideUp();
    }
});
$("#burgerbar").click(function(){
    $("#navbar").toggleClass('open');
});

// IMAGE SLIDER
let sliderItem = $('.slider-item');
let sliderWidth = sliderItem.width();
// slider
$(window).resize(function() { 
    //call to your function and check the window width
    sliderWidth = sliderItem.width();
});


$('.slider-item:last-child').prependTo('.slider-item-box');

function moveLeft(){
    $('.slider-item:last-child').animate({
        left: + sliderWidth,
        opacity: .1
    }, {
        duration: 1000, 
        specialEasing: {
            left: "easeInOutExpo",
            opacity: "easeInOutExpo"
        }, 
        complete: function(){
            $(this).prependTo('#slider-item-box');
            $(this).css({left:'',opacity:1});
        }
    })
};
function moveRight(){
    $('.slider-item:first-child').css({left: + sliderWidth,opacity: .5})
    .appendTo('#slider-item-box')
    .animate({
        left: 0,
        opacity: 1
    }, {
        duration: 1000, 
        specialEasing: {
            left: "easeInOutExpo",
            opacity: "easeInOutExpo"
        }, 
        complete: function(){
        }
    });
};

$('.control-prev').click(function () {
    moveRight();
});

$('.control-next').click(function () {
    moveLeft();
});

// GALLERY
// let gallery = $("#gallery");
// let galleryItem = $(".gallery-item");
// let galleryBox = $("#gallery-box");
// let galleryCount = galleryItem.length;
// let galleryWidth = galleryItem.width();
// let galleryBoxWidth = galleryCount * galleryWidth;

// galleryBox.css('width', galleryBoxWidth);
// // galleryBox.prepend([
// //     galleryItem.last(),
// //     galleryItem.last().prev()
// // ])
// $(".gallery-item").last().prependTo(galleryBox);
// $(".gallery-item").last().prependTo(galleryBox);

// $("#gallery-box").slick({
// centerMode:true,
//     slidesToShow: 1,
//     slidesToScroll: 1,
//     dots: true,
//     infinite: true,
//     cssEase: 'linear',
//     variableWidth: true,
//     variableHeight: true
// });

$("#testi").slick({
    slidesToShow: 3,
    arrows: false,
    // autoplay: true,
    // autoplaySpeed: 3000,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                arrows: false,
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                arrows: false,
            }
        }
    ]
});
$("#gallery-box").slick({
    centerPadding: '60px',
    slidesToShow: 6,
    // autoplay: true,
    arrows: false,
    // autoplaySpeed: 3000,
    variableWidth: true,
    responsive: [
    {
        breakpoint: 1024,
        settings: {
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
        }
    },
    {
        breakpoint: 768,
        settings: {
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 3
        }
    },
    {
        breakpoint: 480,
        settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
        }
    }
    ]
});

$('#gallery-box').magnificPopup({
    delegate: 'a', // child items selector, by clicking on it popup will open
    type: 'image',
    gallery: {enabled:true}
    // other options
});