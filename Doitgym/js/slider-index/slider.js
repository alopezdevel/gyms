$(document).ready( function() {
        
        // ----- Carousel
            $('#billy_scroller').billy({
                slidePause: 5000,
                // We need custom next/prev buttons for this example. If we used the defaults (#billy_next/#billy_prev), every carousel instance on the page would scroll when they're clicked...
                nextLink: $('#carousel_billy_next'),
                prevLink: $('#carousel_billy_prev'),
            });
            
        // ----- Tabber
            $('#tabber').billy({
                slidePause: 5000,
                indicators: $('ul#tabber_tabs'),
                customIndicators: true,
                autoAnimate: false,
                noAnimation: true
            });
            
});