$(document).ready(function () {
    function changeActive(i){
        $('.section').removeClass('active lower upper')
            .eq(i).addClass('active');

        $('#nav-menu li').removeClass('active');

    }
    function sectionClass(){
        let activeSection = $(".active");
        let section = $('.section');
        let activeIndex = section.index(activeSection)
        // console.log(activeIndex);
        
        section.each(function(index){
            if(index < activeIndex){
                $(this).animate({
                        // top:'-'+$(this).height(),
                        top: -500,
                        opacity: 0
                    }, 1000, "easeOutQuart", function() {
                        //callback
                    });
            }else if(index > activeIndex){
                $(this).animate({
                        // top:'-'+$(this).height(),
                        top: 200,
                        opacity: 0
                    }, 400, "easeOutQuart", function() {
                        //callback
                    });
                
            }else{
                $(this).addClass('active')
                    .animate({
                        top:0,
                        opacity: 1
                    }, 1000, "easeOutQuart", function() {
                        //callback
                    });
            }
        });
    }

    sectionClass();
    $('#nav-menu li').click(function(){
        if(!$(this).hasClass('active')){
            let menuIndex = $('#nav-menu li').index($(this));
            $('.section').removeClass('hidden');
            // $('.active, .lower, .upper').stop();
            changeActive(menuIndex);
            sectionClass();
            $(this).addClass('active');
        }
    })

    $('#submit-btn').click(function(){
        $('#form-reg').submit();
    });

    $('#submit-login-btn').click(function(){
        $('#form-login').submit();
    });

    if($('.reg_validation').length>0){
        $('#modal-ppdb').modal();
    }
    if($('.login_validation').length>0){
        $('#modal-login').modal();
    }
    if($('#modal-alert .modal-body h3').length>0){
        $('#modal-alert').modal();
    }

    // $('#modal-login').on('hide.bs.modal', function(e){
    //     $('.login-validation').remove();
    // });
});