$(document).ready(function () {
    var totalPrice=0;
    var totalTransPrice=0;
    // Adding X-CSRF-TOKEN to the header while sending post request.
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Get All posts:::::::
    //loading datatable
    var dataTable=$('#deliveredPostsTable').DataTable({
        // 'serverSide': true,
        "ajax":{ 
            url:"/getPosts",
            "data":function(data){
                var drivers=$("#drivers").val();
                // alert(drivers);
                var stores=$("#stores").val();
                var status="delivered";
                data.drivers=drivers;
                data.stores=stores;
                data.status=status;
            },
            method:"POST",
            dataSrc: '',
            // success:function(data){
            //  alert(data);
            //   }
        },
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            data: null,
            defaultContent: '',
        },
        {
            "targets": [ 1 ],
            "visible":true
        }
        ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]],

        "columns":
        [
            {"data":"",
            // "render":function ( data, type, row, meta ) {
            //  return meta.row+1;
        //  }
           },
            {"data":"id"},
            {"data":"post_code"},
            {"data":"post_name"},
            {"data":"driver.driver_name"},
            {"data":"store.store_name"},
            {"data":"location.location_name"},
            {"data":"address"},
            {"data":"price"},
            {"data":"transportation_price"},
            {"data":"created_at"},
            {"data":"status"},
        ],
         
         "initComplete":function( settings, json){
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

    //When a change is occured to the datatable this function will be triggered!.
    $('#deliveredPostsTable').on( 'draw.dt', function () {
         totalPrice=0;
         totalTransPrice=0;
         dataTable.rows().deselect();
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
    
    //Default
        $("#checked-square").hide();
        $("#blank-square").show();

    dataTable.on("click", "th.select-checkbox", function() {
        if ($("th.select-checkbox").hasClass("selected")) {
            dataTable.rows().deselect();
            $("#checked-square").hide();
            $("#blank-square").show();
            $("th.select-checkbox").removeClass("selected");
        } else {
            dataTable.rows().select();
            $("th.select-checkbox").addClass("selected");
            $("#checked-square").show();
            $("#blank-square").hide();
        }
    }).on("select deselect", function() {
        ("Some selection or deselection going on")
        if (dataTable.rows({
                selected: true
            }).count() !== dataTable.rows().count()) {
            $("th.select-checkbox").removeClass("selected");
            $("#checked-square").hide();
            $("#blank-square").show();
        } else {
            $("th.select-checkbox").addClass("selected");
            $("#checked-square").show();
            $("#blank-square").hide();
        }
    });


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

        //When items select dropdown changed..
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



//Get All Stores for multiselect checkbox
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

    // When items select dropdown changed..
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



   //if the accept button clicked to show the deliverConfirmationModal :
   $("#payBackLink").on('click', function (e) {
    e.preventDefault();
 //    alert(totalPrice);
    //Show modal only if some rows selected
    if(dataTable.rows({selected: true}).count()>0){
         $("#deliverConfirmationModal").modal({show:true});

        // Check if the yes button clicked then to change the status of the selected posts.
        $("#yes").on('click', function (e) {
            // $("#deliverConfirmationModal").modal({show:false}); 

    // Set the status
    var status="delivered";
    var newStatus="done";

    // Get the selected postIDs
    var selectedPostIDs=[]; 
     $('td:first-child').each(function() {
        if($(this).parent().hasClass("selected")){
            selectedPostIDs.push ($(this).next().text());
    }
    });
    
    // Prepare the data array
    var data={status,newStatus,selectedPostIDs};

   console.log(data); 

    $.ajax({
        type: "POST",
        url: "/changePostStatus", 
        data: data,
        // dataType: "JSON/application",
        success: function (response){
            // $("#selectDriverModal").modal('hide'); 
            // $("#selectDriverForm")[0].reset();
            // $("#driverName").attr("href","http://127.0.0.1:8000/driver/"+driver_id+"/posts");
            // $("#driverName").text(driverSelected);
            //  selectedPostIDs=[]; 

            //  console.log(response);
            // $("#successModal").modal('show');
            // dataTable.draw();
            location.reload();
        }

        });
        // End of ajax request
            
        });
        // End of yes button

     }
    //End of check if any rows selected
 });
// End of payBack Link 


});
// End of document.ready