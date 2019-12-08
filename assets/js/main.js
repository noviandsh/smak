// SMOOTH SCROLL
$(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

    $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top
    }, {
        duration: 1000, 
        specialEasing: {
            scrollTop: "easeOutCirc"
        }
    });
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
    if ($(this).scrollTop()  <= 0 ){
        $("#navbar").removeClass('not-top');
    }else{
        $("#navbar").addClass('not-top');
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
    slidesToShow: 5,
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