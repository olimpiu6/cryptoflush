//menu toggler
window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

    /**
     * alerts and other stuff
     */
    var dogeCoinInfoMsg = {
        "alert_err":"<div class=\"alert alert-danger alert-dismissible fade show abso\" role=\"alert\">"+
                        "<strong>Error! </strong>{msg}"+
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\Close\">"+
                        "<span aria-hidden=\"true\">&times;</span>"+
                        "</button>"+
                    "</div>",
        "alert_ok":"<div class=\"alert alert-success alert-dismissible fade show abso\" role=\"alert\">"+
                        "<strong>Success! </strong>{msg}"+
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\Close\">"+
                        "<span aria-hidden=\"true\">&times;</span>"+
                        "</button>"+
                    "</div>",
    }

    /**
     * ajax listener
     * attribute data-action is the route to the ajax controller
     * class ajax-action is the class for ajax buttons
     */
    if($('.ajax-action').length){
        $('.ajax-action').each(function(){
            $(this).on('click', function(){
                var url = $(this).attr('data-action');
                var token = $(this).attr('data-token');
                var data = $(this).attr('data-dat');

                $('#loader').fadeIn();
                $.post(dogeCoinNetUrl + "/" + url, {action:url, data:data, token:token}).done(function(data){
                    console.log(data);
                    try{
                        data = JSON.parse(data);
                    }catch(e){
                        console.log(e);
                    }
                    if(data.done){
                        $('body').append(dogeCoinInfoMsg.alert_ok.replace('{msg}', 'Done the job is ;-)'));
                    }else{
                        $('body').append(dogeCoinInfoMsg.alert_err.replace('{msg}', 'Failed i have :-('));
                    } 
                    $('#loader').fadeOut();
                }).fail(function(){
                    $('body').append(dogeCoinInfoMsg.alert_err.replace('{msg}', 'Wrong something went :-o'));
                    $('#loader').fadeOut();
                });
               
            });
            
        });
    }
    
/**
 * process json string and parse it in a html element
 * jsonString to process
 * parentElement the element in wich the json is shown on the screen
 * htmlWapper the html element used to wrap the data 
 * wrapperClass css of the html element that containes the element
 * htmlSeparator html element to separate the hey from value
 */
function parseJsonString(jsonString, parentElement, htmlWrapper, htmlSeparator = '', wrapperClass = ''){
    try{
        //parse json string
        var json = JSON.parse(jsonString);

        //html output to print in page
        var output = '';

        //process json object and buil html output
        for(j in json){
            output += '<' + htmlWrapper + ' class="'+ wrapperClass +'">' +
                        j + '<' + htmlSeparator + '/>' + json[j] + '</' + htmlWrapper + '>';
        }  
        
        //print html output in the parent element
        $(parentElement).append(output);
    }catch(e){
        return false;
    }
}

//parse json inside platform td in coin list
$('.platfr').each(function(){
    var json = $(this).attr('data-platform');
    parseJsonString(json, $(this), 'p', 'br');
});


//end dom event
});