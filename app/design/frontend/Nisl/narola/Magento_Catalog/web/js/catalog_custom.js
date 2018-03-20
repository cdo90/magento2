$(document).ready(function(){
	 jQuery('input[type="checkbox"]').click(function(){
			var attrval =  JSON.parse(jQuery(this).attr('data-post'));
			var action = attrval['action'];
			var data = attrval['data'];
			var formkey = data['uenc'];
			var productid = data['product'];
			
			if(jQuery(this).prop("checked") == true){
               jQuery.ajax({
                    type: "post", 	
                    url: action, 	
                    data: {'product':productid},
					success: function (json) {//On Successful service call
						location.reload();	
                    },
                    error: function (e) {
						alert('fail');
					}	// When Service call fails
                });
            }
            else if(jQuery(this).prop("checked") == false){
                alert("Checkbox is unchecked.");
            }
        });
});
