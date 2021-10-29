$(document).ready(function () {
    
    
    // Check the selected user type from the popup if store selected then to show some additional fields.
    $("select.user_type").change(function(){
        var selectedUserType = $(this).children("option:selected").val();
        if(selectedUserType=='store'){
            $("#owner_name_parent").show();
            $("#store_address_parent").show();
        }else{
            $("#owner_name_parent").hide();
            $("#store_address_parent").hide(); 
        }
    });


   //Reset the form 
    $('#add_button').click(function(){
        // $('#addForm')[0].reset();
        $('#addForm').trigger("reset");

        $('.modal-title').text("Add User");
        // $('#action').val("Add"); 
        $('#operation').val("Add");
        // $('#item_uploaded_photo').html('');
        $("input.required").next().hide();
       }); 



    //loading datatable
    var dataTable=$('#userTable').DataTable({
        "ajax":{ 
            url:"/getAllUsers", 
            dataSrc: '',
            // data:{"get_all_users":"true"},
            // method:"POST",
           
        },
        // "ordering": true,
        //  "columnDefs":{
        //         "target":[5,6],
        //         "orderable":false
        //     },

        "columns":
        [
            {"data":"id",
            "render":function ( data, type, row, meta ) {
             return meta.row+1;
         }
     },
            {"data":"name"},
            {"data":"username"},
            {"data":"user_type"},
            {"data":"edit"},
            {"data":"delete"},
         ],

    });
    //Adding User
   $("#addForm").on("submit",function(e){
       e.preventDefault();


       var name=$("#name").val();
       var username=$("#username").val();
       var password=$("#password").val();
       var password_confirm=$("#password_confirm").val();
       var phone_number=$("#phone_number").val();
       var user_type=$("#user_type").val();
       

       //If firstname is empty show the error div that i setted to display:none by default.
       name==''?$("#name").next().show():'';
       username==''?$("#username").next().show():'';
       password==''?$("#password").next().show():'';
       password_confirm==''?$("#password_confirm").next().show():'';
       phone_number==''?$("#phone_number").next().show():'';
       user_type==''?$("#user_type").next().show():'';
       
       
       $("input.required").keyup(function(){
        $(this).val()==''?$(this).next().show():$(this).next().hide();
       });
        
       if(name!=''&&username!=''&&password!=''&&password_confirm!=''&&phone_number!=''&&user_type!=''){
       $.ajax({
           type: "POST",  
           url: "/user",
           data: $("#addForm").serialize(),
           success: function (response) {
               console.log(response); 
               $("#addForm")[0].reset();
               $("#userAddModal").modal('hide');
            //    dataTable.DataTable().ajax.reload();
            //    $('#userTable').DataTable().ajax.reload(); 
            //    alert("Data saveed");
            location.reload();
            // alert(response.name);
            // $('#userTable').DataTable().ajax.reload();
           },
           
           error:function(error){
             var response = JSON.parse(error.responseText);
             
             response.username!=''&&response.username!=undefined? $("#username").next().next().append("<p class='alert alert-danger'>" + response.username  + "</p>") :'';
             response.password !=''&&response.password!=undefined?   $("#password").next().next().append("<p class='alert alert-danger'>" + response.password  + "</p>"):''
             response.user_type!=''&&response.user_type!=undefined?  $("#user_type").next().next().append("<p class='alert alert-danger'>" + response.user_type  + "</p>"):''
             response.phone_number!=''&&response.phone_number!=undefined?$("#phone_number").next().next().append("<p class='alert alert-danger'>" + response.phone_number  + "</p>"):'';
             

        // var errorString = '<ul>';
        // $.each( response, function( key, value) {
            // errorString += '<li class="alert alert-danger">' + value + '</li>';
            // $("#email").next().next().append
        // });
        // errorString += '</ul>';
           
    //   $("#errors").append(errorString);
    // alert(errorString);
    }
       });

    }
    
   });
   
   //Get the info into the modal

   $(document).on("click",".update",function(){

    var selectedUserType = $("#user_type").children("option:selected").val();
    
    if(selectedUserType=='store'){
        $("#owner_name_parent").show();
        $("#store_address_parent").show();
    }else{
        $("#owner_name_parent").hide();
        $("#store_address_parent").hide();
    }


    $('#operation').val("Edit");

    $("input.required").keyup(function(){
        
        $(this).val()==''?$(this).next().show():$(this).next().hide();
       });
       
    var user_id=$(this).attr("id");

    $('#user_id').val(user_id);

    $.ajax({
           url:"user/getSingle", 
           method:"GET",
           data:{user_id:user_id},
           dataType:"json",
           success:function(data){

            // alert(data.)
            $("#username").val(data[0]['username']);
            $("#phone_number").val(data[0]['phone_number']);
            $("#user_type").val(data[0]['user_type']); 
            $("#name").val(data[0]['name']);
            $("#user_type").change();
    
            var user_type=data[0]['user_type'];
             if(user_type=='store'){
                $("#store_address").val(data[0]['address']);
                $("#owner_name").val(data[0]['owner_name']);      
            }
    
            $("#userAddModal").modal("show");

               $(".modal-title").text("Edit User");
               $("#user_id").val(user_id);
               
           },
       });
   });



    //Delete

    
    $(document).on("click",".delete",function(){
        if(confirm("Are you sure you want to delete this user?")){
            var user_id=$(this).attr("id");
             $.ajax({
                 url:"user/userDelete",
                 method:"get",
                 data:{user_id:user_id},
                 success:function(data){
                    //  alert(data);
                     dataTable.ajax.reload();
                 },
             });
        }
    });
});