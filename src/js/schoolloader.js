var main = function(){
    $('.arrow-next').click(function(){
        var currentSlide = $('.active-slide');
        var nextSlide = currentSlide.next();

        var currentDot = $('.active-dot');
        var nextDot = currentDot.next();

        if(nextSlide.length === 0){
            nextSlide = $('.slide').first();
        }
        if(nextDot.length === 0){
            nextDot = $('.dot').first();
        }

        currentDot.removeClass('active-dot');
        currentSlide.fadeOut(300).removeClass('active-slide');
        nextDot.addClass('active-dot');
        nextSlide.fadeIn(300).addClass('active-slide');
    });

    $('.arrow-prev').click(function(){
        var currentSlide = $('.active-slide');
        var prevSlide = currentSlide.prev();

        var currentDot = $('.active-dot');
        var prevDot = currentDot.prev();

        if(prevSlide.length === 0){
            prevSlide = $('.slide').last();
        }
        if(prevDot.length === 0){
            prevDot = $('.dot').last();
        }

        currentDot.removeClass('active-dot');
        currentSlide.fadeOut(300).removeClass('active-slide');
        prevDot.addClass('active-dot');
        prevSlide.fadeIn(300).addClass('active-slide');
    });
}

$(document).ready(main);
