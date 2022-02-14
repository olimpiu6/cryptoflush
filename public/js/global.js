/**
 * document ready for jsuery based plugins
 * ex: datatable
 */

$(document).ready(function(){
    // btc exchange list data tables
    if($('#btc_rates_list').length){
        $('#btc_rates_list').DataTable({
            "pageLength": 100,
            "search":false,
            "paging":false,
            "searching":false,
            "bInfo" : false
        });
    }

    /**
     * market data table --data table
     */
    if($('#coin_price_list').length){
        $('#coin_price_list').DataTable({
            "pageLength": 100,
            "search":false,
            "paging":false,
            "searching":false,
            "bInfo" : false
        });
    }

    /**
     * default data table class, reusable for each data table 
     */
    if($('.data-t').length){
        $('.data-t').DataTable({
            "pageLength": 100,
            "search":false,
            "paging":false,
            "searching":false,
            "bInfo" : false
        });
    }
});



/**
 * color code percentage change in prices, market cap, etc
 * class 'change_perc' as identifier, if < 0 color red, if > 0 color green
 */
if($('.change_perc').length){
    $('.change_perc').each(function(){
        var val = parseFloat($(this).text());
        //generate css class for each element
        var css_class = val < 0 ? 'text-danger' : 'text-success';

        //add css class to each element
        $(this).addClass(css_class);
    });
}

