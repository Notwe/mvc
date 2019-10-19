$(function() {
    $('form').submit(
		function(event){
            event.preventDefault();
    		$.ajax ({
    			url: $(this).attr('action'),
    			type: $(this).attr('method'),
    			data: $(this).serialize(),
    			success: function (data) {
                    if(!data){
                        $(function (){window.location.reload()});
                    }
                    $('.clyde_message > a').remove();
                    $('.clyde_message > li').remove();
                    if(data){
                        data = jQuery.parseJSON(data);
                    	if(data.length > 0){
                    	    for (var i = 0; i < data.length; i++){
                                $(".clyde_message").append(
                    		    "<li class=clyde_message_info ><b>"+data[i]+"</b></li>"
                    		    );

                    		}
                    	}
                    }
    			}
    		});
		}
	);
});
