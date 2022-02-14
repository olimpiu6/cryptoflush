/**
 * document ready for jsuery based plugins
 * ex: datatable
 */


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

/**
 * tables sparkline, market data table
 */
if($('.csparkline').length){
    $('.csparkline').each(function(){
        //get id if chart
        var chart_id = $(this).attr('id');
        var chart_data = [];
        var chart_color = '';

        //loop js_sparkline object to get the data needed for each chart
        for(var i = 0; i < js_sparline.length; i++){
            if(js_sparline[i].id == chart_id){
                //get one value per day, too many values == linear chart
                for(var j = 0; j < js_sparline[i].sparkline_in_7d.price.length; j+=20){
                    chart_data.push(js_sparline[i].sparkline_in_7d.price[j]);
                }
                //chart_data = js_sparline[i].sparkline_in_7d.price;
                chart_color = js_sparline[i].price_change_24h < 0 ? "#dc3545" : "#28a745";
                break;
            }
        }

        var ctx = document.getElementById(chart_id).getContext('2d');
        var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [1,2,3,4,5,6,7],
            datasets: [
            {
                data: chart_data
            }
            ]
        },
        options: {
            responsive: false,
            legend: {
            display: false
            },
            elements: {
            line: {
                borderColor: chart_color,
                borderWidth: 1
            },
            point: {
                radius: 0
            }
            },
            tooltips: {
            enabled: false
            },
            scales: {
            yAxes: [
                {
                display: false
                }
            ],
            xAxes: [
                {
                display: false
                }
            ]
            }
        }
        });
        chart_data = [];
        chart_color = '';

    });
}