$('#footer').prepend($('#gallery'));
$(document).ready(function(){ 
    if(popup>0){
        $('#modal-news').modal('show')
    }
});


AOS.init({
    // Global settings:
    disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
    startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
    initClassName: 'aos-init', // class applied after initialization
    animatedClassName: 'aos-animate', // class applied on animation
    useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
    disableMutationObserver: false, // disables automatic mutations' detections (advanced)
    debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
    throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)
    
  
    // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
    offset: 120, // offset (in px) from the original trigger point
    delay: 0, // values from 0 to 3000, with step 50ms
    duration: 400, // values from 0 to 3000, with step 50ms
    easing: 'ease', // default easing for AOS animations
    once: false, // whether animation should happen only once - while scrolling down
    mirror: false, // whether elements should animate out while scrolling past them
    anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation
});

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
    yPercent:20,
    ease: Back.easeIn.config(1.7)
})
.to("#header-filter:before", 1, {
    yPercent:0,
    ease: Back.easeOut.config(1.7)
});

$(window).scroll(function () {
    if ($(this).scrollTop()  <= 210 ){
        $("#navbar").removeClass('not-top');
    }else{
        $("#navbar").addClass('not-top');
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
setInterval(moveLeft, 5000);

$("#testi").slick({
    slidesToShow: 3,
    arrows: false,
    autoplay: true,
    autoplaySpeed: 3000,
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
    autoplay: true,
    arrows: false,
    autoplaySpeed: 3000,
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