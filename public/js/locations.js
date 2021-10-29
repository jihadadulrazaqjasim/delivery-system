$(document).ready(function () {
        // Adding X-CSRF-TOKEN to the header while sending post request.
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
   //Reset the form 
    $('#add_button').click(function(){
        // $('#addForm')[0].reset();
        $('#addForm').trigger("reset");

        $('.modal-title').text("Add City");
        // $('#action').val("Add"); 
        $('#operation').val("Add");
        // $('#item_uploaded_photo').html('');
        $("input.required").next().hide();
       }); 



    //loading datatable
    var dataTable=$('#locationTable').DataTable({
        "ajax":{ 
            type:"GET",
            url:"/location/getAllLocations",
            dataSrc: '',
        },

        "columns":
        [
            {"data":"id",
            "render":function ( data, type, row, meta ) {
             return meta.row+1;
         }
         },
            {"data":"location_name"},
            {"data":"edit"},
            {"data":"delete"},
         ],
    });

    //Adding User
   $("#addForm").on("submit",function(e){
       e.preventDefault();
       
       var location_name=$("#location_name").val();

       //If firstname is empty show the error div that i setted to display:none by default.
       location_name==''?$("#location_name").next().show():'';

       $("input.required").keyup(function(){
        $(this).val()==''?$(this).next().show():$(this).next().hide();
       });

       var location_id = $('#location_id').val();
       var operation = $('#operation').val();
       
       var data={location_name,location_id,operation}; 
       if(location_name!=''){
       $.ajax({
           type: "POST",  
           url: "/location",
           data: data,
           success: function (response) {
               console.log(response); 
            //    dataTable.ajax.reload();
            //    $("#locationAddModal").modal('hide');
                $("#addForm")[0].reset();
            location.reload();
           
           },
           error:function(error){
             var response = JSON.parse(error.responseText);  
            //  response.location_name!=''&&response.location_name!=undefined? $("#location_name").next().next().append("<p class='alert alert-danger'>" + response.location_name  + "</p>") :'';
            }
       });
    }
   });
   
   //Get the info into the modal
   $(document).on("click",".update",function(){


    $('#operation').val("Edit");

    $("input.required").keyup(function(){   
        
        $(this).val()==''?$(this).next().show():$(this).next().hide();
       });
       
     location_id=$(this).attr("id");

    // alert(location_id);

    $('#location_id').val(location_id);

    $.ajax({
           url:"location/getSingle/"+location_id, 
           method:"GET",
           dataType:"json",
           success:function(data){
            
           $("#locationAddModal").modal("show");
               $("#location_name").val(data[0]['location_name']);
               
               $(".modal-title").text("Edit City");
               $("#location_id").val(location_id); 
               
           },
       });
   });






    //Delete
    $(document).on("click",".delete",function(){
        if(confirm("Are you sure you want to delete this city?")){
            var location_id=$(this).attr("id");
             $.ajax({
                 url:"location/locationDelete/"+location_id,
                 method:"DELETE",
                 data:{location_id:location_id},
                 success:function(data){
                    //  alert(data);
                     dataTable.ajax.reload();
                 },
             });
        }
    });
});