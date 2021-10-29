$(document).ready(function () {
    var totalPrice=0;
    var totalTransPrice=0;
    // Adding X-CSRF-TOKEN to the header while sending post request.
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

// Get All posts loading datatable:::::::
getPosts();

//When a change is occured to the datatable this function will be triggered!. 
onDatatbleChange();

//load drivers
getDrivers();

//load stores
getStores();


// Load locations
getLocations();


//if the delete button clicked:
$(document).on("click",".delete",deletePost);


/*While click on update button*/
$(document).on("click",".update",updatePost);

});
// End of document.ready

function getPosts(){
    dataTable=$('#allPostsTable').DataTable({
        // 'serverSide': true,
        "ajax":{ 
            url:"/getPosts",
            "data":function(data){
                var drivers=$("#drivers").val();
                // alert(drivers);
                var stores=$("#stores").val();
                var locations=$("#locations").val();
                var status="all";
                data.drivers=drivers;
                data.stores=stores;
                data.status=status;
                data.locations=locations;
            },
            method:"POST",
            dataSrc: '',
            // success:function(data){
            //  alert(data);
            //   }
        },

        columnDefs: [ 
        {
            "targets": [ 0 ],
            "visible":false
        }
        ],
     
        order: [[ 0, 'asc' ]],
        
        "columns":
        [
            {"data":"",
            "render":function ( data, type, row, meta ) {
             return meta.row+1;
         }},
            {"data":"post_code"},
            {"data":"post_name"},
            {"data":"driver_name"},
            {"data":"store_name"},
            {"data":"location_name"},
            {"data":"address"},
            {"data":"post_phone_number"},
            {"data":"price"}, 
            {"data":"transportation_price"},
            {"data":"created_at"},
            {"data":"status"},
            // {"data":"comment"},
            {"data":"edit"},
            {"data":"delete"},
        ],
         
         "initComplete":function( settings, json){
            // Load styling of status
            statusStyle();

             totalPrice=0;
             totalTransPrice=0;
              // Calculating the total::
                $('td:nth-child(9)').each(function(i, el) {
                    totalPrice=totalPrice + parseFloat($(this).text());
                 
              });
             
              $("#priceTotal").text(totalPrice.toFixed(2) + "د.ع");

              $('td:nth-child(10)').each(function(i, el) {
                totalTransPrice=totalTransPrice + parseFloat($(this).text());
          });
          $("#transPriceTotal").text(totalTransPrice.toFixed(2) + "د.ع");
        },

        "language": {
            "emptyTable":"No Data Found"
        },
    });
}

function onDatatbleChange(){
    $('#allPostsTable').on( 'draw.dt', function () {
        // Load styling of status
         statusStyle();

        totalPrice=0;
        totalTransPrice=0;
        $("th.select-checkbox").removeClass("selected");
        // Calculating the total::
          $('td:nth-child(9)').each(function(i, el) {
              totalPrice=totalPrice + parseFloat($(this).text());
        });
       
        $("#priceTotal").text(totalPrice.toFixed(2) + "د.ع");

        $('td:nth-child(10)').each(function(i, el) {
          totalTransPrice=totalTransPrice + parseFloat($(this).text());
    });
    $("#transPriceTotal").text(totalTransPrice.toFixed(2) + "د.ع");
   } );

}

function getDrivers(){
    //Get All Drivers for multiselect checkbox
    $.ajax({
        url:"/getAllDriverNames",
        method:"GET",
        contentType:"applicatopn/json",
        // data:{"get_id_and_name_users":"yes"},
        success:function(data){
            //  var drivers=$.parseJSON(data);
        // console.log(typeof data);
        console.log(data);
            $.each((data),function(index,value){
                // alert(value.id);
                // console.log(value.id);
                // alert(value);
                var driver_id=value.id;
                var driver_name=value.driver_name;
                var content=`<option value="`+driver_id+`">`+driver_name+`</option`;

                console.log(content);
                $("#drivers").append(content);

            });

        $('#drivers').multiselect({
        selectAllValue: 'multiselect-all',
        includeSelectAllOption: true,
                enableCaseInsensitiveFiltering: true,
                enableFiltering: true,
                maxHeight: '300',
                buttonWidth: '235',
                numberDisplayed: 12,
                nonSelectedText: 'Select Driver',
                onChange :function(option, checked) {
                    // var drivers=$("#drivers").val();
                    // alert(drivers);
                    dataTable.ajax.reload();
                },
                onSelectAll:function () {
                    dataTable.ajax.reload(); 
                    },

                    onDeselectAll:function () {
                        dataTable.ajax.reload();
                    },
        });
            // $("#drivers").multiselect('selectAll',false);
            // $("#drivers").multiselect('updateButtonText');
        },
        error: function(xhr, status, error){
            var errorMessage = xhr. status + ': ' + xhr. statusText;
            alert('Error - ' + errorMessage);
        },
    });

}

function getStores(){
    $.ajax({
        url:"/getAllStoreNames",
        method:"GET",
        contentType:"applicatopn/json",
        success:function(data){
        console.log(data);
            $.each((data),function(index,value){
                var store_id=value.id;
                var store_name=value.store_name;
                var content=`<option value="`+store_id+`">`+store_name+`</option`;
                $("#stores").append(content);
            });
    
        $('#stores').multiselect({
        selectAllValue: 'multiselect-all',
        includeSelectAllOption: true,
                enableCaseInsensitiveFiltering: true,
                enableFiltering: true,
                maxHeight: '300',
                buttonWidth: '235',
                numberDisplayed: 1,
                nonSelectedText: 'Select Store',
                onChange :function(option, checked) {
                    // dataTable.draw();
                    dataTable.ajax.reload();
                },
                onSelectAll:function () {
                    dataTable.ajax.reload();
                    },
        });
        // $("#stores").multiselect('selectAll',false);
        // $("#stores").multiselect('updateButtonText');
        },
    
        error: function(xhr, status, error){
            var errorMessage = xhr. status + ': ' + xhr. statusText;
            alert('Error - ' + errorMessage);
        },
    });
    
}


function getLocations(){
    //Get All Drivers for multiselect checkbox
    $.ajax({
        url:"/getAllLocationNames",
        method:"GET",
        contentType:"applicatopn/json",
        success:function(data){
    
        console.log(data);
            $.each((data),function(index,value){
                var location_id=value.id;
                var location_name=value.location_name;
                var content=`<option value="`+location_id+`">`+location_name+`</option>`;
    
                console.log(content);
                $("#locations").append(content);
            });
    
        //When items select dropdown changed..
        $('#locations').multiselect({
        selectAllValue: 'multiselect-all',
        includeSelectAllOption: true,
                enableCaseInsensitiveFiltering: true,
                enableFiltering: true,
                maxHeight: '300',
                buttonWidth: '235',
                numberDisplayed: 12,
                nonSelectedText: 'Select Location',
                onChange :function(option, checked) {
                    dataTable.ajax.reload();
                },
                onSelectAll:function () {
                    dataTable.ajax.reload();
                    },
    
                    onDeselectAll:function () {
                        dataTable.ajax.reload();
                    },
        });
            // $("#locations").multiselect('selectAll',false);
            // $("#locations").multiselect('updateButtonText');
        },
        error: function(xhr, status, error){
            var errorMessage = xhr. status + ': ' + xhr. statusText;
            alert('Error - ' + errorMessage);
        },
    });
    }


function deletePost(){
var post_id =$(this).attr("id");
//Show modal only if some rows selected 
        $("#deleteConfirmationModal").modal({show:true});
    // Check if the yes button clicked then to change the status of the selected posts.
    $("#yes").on('click', function (e) {       
        $.ajax({
            type: "DELETE",
            url: "/post/"+ post_id,
            // data: user_id,
            // dataType: "JSON/application",
            success: function (response){
                $("#deleteConfirmationModal").modal('hide');
                dataTable.ajax.reload();
            }
            }); 
    });
}


function updatePost(){
// Get id of the post which is appended to the id attr of update button
var post_id=$(this).attr("id");

// Get the single post info to be updated.
    $.ajax({
        type: "GET",
        url: "/post/getSingle/"+post_id,
        dataType: "json",
        success: function (response){
        //    console.log(response);
            //If successfull to show modal edit
            $("#editModal").modal('show');
            $("#updateForm")[0].reset();
            $('#driver').empty();
            $("#store").empty();
            $("#location").empty();

            // Get the data.
            var driver_id=response[0]['driver_id'];
            var store_id=response[0]['store_id'];
            var store_name = response[0]['store']['store_name'];

            var location_id = response[0]['location_id'];

            var post_code=response[0]['post_code'];
            var post_name=response[0]['post_name'];
            var address=response[0]['address'];
            var phone=response[0]['post_phone_number'];
            var price=response[0]['price'];
            var transPrice=response[0]['transportation_price'];
            var date=response[0]['created_at'];
            var status=response[0]['status'];
            var comment=response[0]['comment'];

            // alert(date);

            // Set into the fields of the modal
            $("#post_code").val(post_code);
            $("#post_name").val(post_name);
            $("#address").val(address);
            $("#post_phone_number").val(phone);
            $("#price").val(price);
            $("#transportation_price").val(transPrice);
            $("#post_created_date").val(date);
            $("#status").val(status);
            $("#comment").val(comment);
            
            
            // Get the values of each driver from id of multiselect and append it to the id of the driver dropdown
            $("#drivers > option").each(function() {
                var content=`<option value="`+this.value+`">`+this.text+`</option>`;
                $("#driver").append(content);
            });
            // Select the id that pulled get from database
            $("#driver").val(driver_id);
            $("#driver").change();

                var content=`<option value="`+store_id+`">`+store_name+`</option>`;
                $("#store").append(content);
                $("#store").change();
            

            // Do the same for location
            $("#locations > option").each(function() {
            var content=`<option value="`+this.value+`">`+this.text+`</option>`;
            $("#location").append(content);
            });
            // Select the id that pulled get from database
            $("#location").val(location_id);
            $("#location").change();



            // If the data pulled successfully and the save button inside the modal clicked 
            //then to call the function
            $(document).on("click","#save",{'param': post_id}, function(event){
                formSubmitted(event.data.param);
           });
        }
    });



    //Add class targetRow to the tr
    // $(this).parent(3).addClass("targetRow");

    //Only the row with the targetRow class/
    // dataTable.rows('.targetRow').every( function ( rowIdx, tableLoop, rowLoop ) {
        
    //     var cell = dataTable.cell({ row: rowIdx, column: 9 }).node();
    //     var post_code = dataTable.cell({ row: rowIdx, column: 1 }).data();
    //     var post_name = dataTable.cell({ row: rowIdx, column: 2 }).data();
    //     var driver = dataTable.cell({ row: rowIdx, column: 3 }).data();
    //     var store = dataTable.cell({ row: rowIdx, column: 4 }).data();
    //     var location = dataTable.cell({ row: rowIdx, column: 5 }).data();
    //     var address = dataTable.cell({ row: rowIdx, column: 6 }).data();
    //     var price = dataTable.cell({ row: rowIdx, column: 7 }).data();
    //     var transportation_price= dataTable.cell({ row: rowIdx, column: 8 }).data();
    //     // var comment =
    //     var entered_date=dataTable.cell({ row: rowIdx, column: 9 }).data();
    //     var status=dataTable.cell({ row: rowIdx, column: 10 }).data();


        // console.log(post_code);
     

        // if(status=="delivered"){
        //     $(cell).addClass('text text-info');
        // }
       
        // if(status=="refused"){
        //     $(cell).addClass('text text-danger');
        // }

        // if(status=="done"){
        //     $(cell).addClass('text text-success');
        // }

        // if(status=="new"){
        //     $(cell).addClass('text text-primary');
        // }

    // });

    //Remove the class directly after you get data, so that it's not interfere with the upcoming clicks
    // $(this).parent().parent().parent().removeClass("targetRow");




}


function formSubmitted(post_id){
   
    // e.preventDefault();

    $.ajax({
        type: "PUT",
        url: "/post/"+post_id,
        data: $("#updateForm").serialize(),
        // dataType: "dataType",
        success: function (response) {
            console.log(response); 
            $("#updateForm")[0].reset();
            $("#editModal").modal('hide');
            // dataTable.DataTable().ajax.reload();
            dataTable.ajax.reload();
        },
        
        error:function(error){
            var response = JSON.parse(error.responseText);
            response.post_code!=''&&response.post_code!=undefined ? $("#post_code").next().append("<p class='alert alert-danger'>" + response.post_code  + "</p>") :'';
        }
        });
   
    
}

function statusStyle(){
    // alert("Dasd");
    dataTable.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
        var cell = dataTable.cell({ row: rowIdx, column: 11 }).node();
        
        var cellData = dataTable.cell({ row: rowIdx, column: 11 }).data();
         
        console.log(cellData);

        if(cellData=="new"){
            $(cell).css('background-color','#FEFAC2');
        }

        if(cellData=="on the way"){
            $(cell).css('background-color','#FFE919');
        }

        if(cellData=="delivered"){
            $(cell).css('background-color','#81CB9E');
        }

        if(cellData=="done"){
            $(cell).css('background-color','#00A64F');
        }
       
        if(cellData=="refused"){
            $(cell).css('background-color','#DA475B');
        }

    });
}