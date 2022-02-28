/**
 * format number 
 */
function numberFormat(num, digits = 2){
    if(typeof num == 'number'){
        try{
            num = num > 1 ? new Intl.NumberFormat('en-US', { maximumSignificantDigits: digits }).format(num) : num;
        }catch(err){
            console.log('aiii');
        }
    }
    
    return num;
}

function numberFormatNegat(num, digits = 2){
    if(typeof num == 'number'){
        try{
            num = new Intl.NumberFormat('en-US', { maximumSignificantDigits: digits }).format(num);
        }catch(err){
            console.log('aiii');
        }
    }
    
    return num;
}
/**
 * market data from jason data stored in data base
 * decodes json an fill html el with all the data
 */
(function mrkt_data_frm_json(){
    if($('#market_chart_data').length){
        //build array wit correct data from json object cr_market_data
        var data = [];
        data[0] = typeof cr_market_data.current_price != 'undefined' ? numberFormat(cr_market_data.current_price) : '';
        data[1] = typeof cr_market_data.price_change_percentage_24h != 'undefined' ? 
                  numberFormat(cr_market_data.price_change_percentage_24h) : '';
        data[2] = typeof cr_market_data.high_24h != 'undefined' ? numberFormat(cr_market_data.high_24h) : '';
        data[3] = typeof cr_market_data.low_24h != 'undefined' ? numberFormat(cr_market_data.low_24h) : '';
        data[4] = typeof cr_market_data.price_change_24h != 'undefined' ? numberFormat(cr_market_data.price_change_24h) : '';
        data[5] = typeof cr_market_data.price_change_percentage_24h != 'undefined' ? 
                  numberFormat(cr_market_data.price_change_percentage_24h) : '';
        data[6] = typeof cr_market_data.circulating_supply != 'undefined' ? numberFormat(cr_market_data.circulating_supply) : '';
        data[7] = typeof cr_market_data.max_supply != 'undefined' ? numberFormat(cr_market_data.max_supply) : '';
        data[8] = typeof cr_market_data.market_cap != 'undefined' ? numberFormat(cr_market_data.market_cap) : '';
        data[9] = typeof cr_market_data.fully_diluted_valuation != 'undefined' ? 
                  numberFormat(cr_market_data.fully_diluted_valuation) : '';
        data[10] = typeof cr_market_data.total_volume != 'undefined' ? numberFormat(cr_market_data.total_volume) : '';

        data[11] = typeof cr_market_data.price_change_percentage_1h_in_currency != 'undefined' ? 
                   numberFormatNegat(cr_market_data.price_change_percentage_1h_in_currency) : '';
        data[12] = typeof cr_market_data.price_change_percentage_24h != 'undefined' ? 
                   numberFormatNegat(cr_market_data.price_change_percentage_24h) : '';
        data[13] = typeof cr_market_data.price_change_percentage_7d_in_currency != 'undefined' ? 
                   numberFormatNegat(cr_market_data.price_change_percentage_7d_in_currency) : '';
        data[14] = typeof cr_market_data.price_change_percentage_30d_in_currency != 'undefined' ? 
                   numberFormatNegat(cr_market_data.price_change_percentage_30d_in_currency) : '';
        data[15] = typeof cr_market_data.price_change_percentage_1y_in_currency != 'undefined' ? 
                   numberFormatNegat(cr_market_data.price_change_percentage_1y_in_currency) : '';

        
                  
        $('#cr_coin-price').html('$ '+ data[0]);
        $('#cr_24h').html('$ '+ data[2]);
        $('#cr_24l').html('$ '+ data[3]);
        $('#cr_cirsupply').html(data[6]);
        $('#cr_totsupply').html(data[7]);
        $('#cr_marketcap').html('$ '+ data[8]);
        $('#cr_dilutval').html('$ '+ data[9]);
        $('#cr_day-vol').html('$' + data[10]);

        $('#ch1h').html('% ' + data[11]);
        $('#ch241h').html('% ' + data[12]);
        $('#ch7d').html('% ' + data[13]);
        $('#ch30d').html('% ' + data[14]);
        $('#ch1y').html('% ' + data[15]);


        
        //change color of percentage change label
        if(data[1] > 0){
            $('#cr_day-change').removeClass('text-danger').addClass('text-success').html('+' + data[1]+'%');
            $('#cr_24change').removeClass('text-danger').addClass('text-success').html('$ '+ data[4]);
            $('#cr_24prchange').removeClass('text-danger').addClass('text-success').html('% '+ data[5]);
        }else if(data[1] < 0){
            $('#cr_day-change').removeClass('text-success').addClass('text-danger').html(data[1].toFixed(2)+'%');
            $('#cr_24change').removeClass('text-success').addClass('text-danger').html('$ '+ data[4].toFixed(2));
            $('#cr_24prchange').removeClass('text-success').addClass('text-danger').html('% '+ data[5].toFixed(2));
        }else{
            $('#cr_day-change').removeClass('text-success').removeClass('text-danger').html(data[1].toFixed(2)+'%');
            $('#cr_24change').removeClass('text-success').removeClass('text-danger').html('$ '+ data[4].toFixed(2));
            $('#cr_24prchange').removeClass('text-success').removeClass('text-danger').html('% '+ data[5].toFixed(2));
        }
        
    }

    //coin info data
    if($('#ci_description').length){
        var ci_description = coin_info[0].description.en != 'undefined' ? coin_info[0].description.en : '';
        $('#ci_description').html(ci_description);
    }
})();
