$(document).ready(function () {
    

    // Get posts count in each status
    
    $.ajax({
        type: "GET",
        url: "post/getCounts",

        dataType: "json",
        success: function (response) {

            $("#newPostsCount").text(response.new);
            $("#onWayPostsCount").text(response.onTheWay);
            $("#deliveredPostsCount").text(response.delivered);
            $("#refusedPostsCount").text(response.refused);

            
        },

        error:function(error){

            var response = JSON.parse(error.responseText);


            console.log(response);
            
        }

    });
    
});