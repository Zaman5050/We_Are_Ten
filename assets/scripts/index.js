function resize(){
    if(window.innerWidth < '768'){
    
        const anchor=document.querySelectorAll(".anchor-tags")
        anchor.forEach((item)=>{
            item.removeAttribute("href")
        })
    }
}
resize();

var openbtns = document.querySelectorAll('.openbtn');
    const navbar = document.querySelector('.navbar');
    const body = document.body;
    openbtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            this.classList.toggle('active');
            navbar.classList.toggle('active');
            body.classList.toggle('over-flow-body')
        });

});

var splide = new Splide( '.splide' );
splide.mount();

var splide = new Splide( '.reviews-slider' );
splide.mount();

var splides = new Splide( '.slide-two', {
    perPage: 3,
    focus  : 0,
    omitEnd: true,
    breakpoints: {
        768: {
            perPage: 1,
        },
    }
    } );

splides.mount();

var splides = new Splide( '.brands-slider', {
    perPage: 4,
    focus  : 0,
    omitEnd: true,
    breakpoints: {
        768: {
            perPage: 2,
        },
        425:{
            perPage:1,
        }
    }
    } );
splides.mount();

var splideQ = new Splide( '.featured-work-sllider', {
    perPage: 4,
    perMove: 1,
    breakpoints: {
        768: {
            perPage: 2,
        },
        425:{
            perPage:1,
        }
    }
    } );

    splideQ.mount();

var splide = new Splide( '.reviews-slider' );
splide.mount();


 