$(document).ready(function () {
    var totalPrice=0;
    var totalTransPrice=0;
    
    // Adding X-CSRF-TOKEN to the header while sending post request.
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Get All posts:::
    //Loading datatable
     dataTable=$('#postsTable').DataTable({ 
        "ajax":{ 
            url:"/getPosts",
            data:{"status":"new"},
            method:"POST",
            dataSrc: '',
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
            // {"data":"driver.driver_name"},
            {"data":"store.store_name"},
            {"data":"location.location_name"},
            {"data":"address"},
            {"data":"price"},
            {"data":"transportation_price"},
            {"data":"created_at",
         "render":function ( data, type, row, meta ) {
             return data;
         }
        },
            {"data":"status"}, 
         ],
         
         "initComplete":function( settings, json){
            // Load statusStyles
            // statusStyle();

            totalPrice=0;
             totalTransPrice=0;
              // Calculating the total::
                $('td:nth-child(8)').each(function(i, el) {
                    totalPrice=totalPrice + parseFloat($(this).text());
                 
              });
             
              $("#priceTotal").text(totalPrice.toFixed(2) + "د.ع");

              $('td:nth-child(9)').each(function(i, el) {
                totalTransPrice=totalTransPrice + parseFloat($(this).text()); 
          });
          $("#transPriceTotal").text(totalTransPrice.toFixed(2) + "د.ع");
        }
    });
    
    //When a change is occured to the datatable this function will be triggered!.
    $('#postsTable').on( 'draw.dt', function () {

        // Load statusStyles
        // statusStyle();

         totalPrice=0;
         totalTransPrice=0;
         dataTable.rows().deselect();
         $("th.select-checkbox").removeClass("selected");
         // Calculating the total::
           $('td:nth-child(8)').each(function(i, el) {
               totalPrice=totalPrice + parseFloat($(this).text());
            
         });
        
         $("#priceTotal").text(totalPrice.toFixed(2) + "د.ع");

         $('td:nth-child(9)').each(function(i, el) {
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
    
   //if the next button clicked to show the modal to select driver:
   $("#nextButton").on('click', function (e) {
       e.preventDefault();
    //    alert(totalPrice);
       //Show modal only if some rows selected
       if(dataTable.rows({selected: true}).count()>0){
            $("#selectDriverModal").modal({show:true});
        }

       //Get All Drivers
       $.ajax({
        url:"/getAllDriverNames",
        method:"GET",
        contentType:"applicatopn/json",
        // data:{"get_id_and_name_users":"yes"},
        success:function(data){
            //  var users=$.parseJSON(data);

            //  alert(users);

            $.each(data,function(index,value){
                var user_id=value.id;
                var driver_name=value.driver_name;
                
                var content=`<option value="`+user_id+`">`+driver_name+`</option`;
                $("#drivers").append(content);
                
            });

        // When items select dropdown changed..
        $('#drivers').multiselect({
        selectAllValue: 'multiselect-all',
        // includeSelectAllOption: true,
                enableCaseInsensitiveFiltering: true,
                enableFiltering: true,
                maxHeight: '300',
                buttonWidth: '235',
                numberDisplayed: 2,
                // nonSelectedText: 'Select Driver',
                onChange :function(option, checked) {
                    // dataTable.draw();
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

   });

/*While driver selected and submitted, we have to change the status of the post and 
assign the post to the driver selected*/

//Hide successModalByDefault
$("#successModal").modal('hide');

$("#selectDriverForm").on("submit", function (e) {
    e.preventDefault();
    
    // Get the value of the select box
    var driver_id=$("#drivers").val();
    var driverSelected=$("#drivers option:selected").text();
    var status="new";

    var selectedPostIDs=[]; 
     $('td:first-child').each(function() {
        if($(this).parent().hasClass("selected")){
            selectedPostIDs.push ($(this).next().text());
    }
    });

var data={driver_id, status,selectedPostIDs};

   console.log(data);

    $.ajax({
        type: "POST",
        url: "/changePostStatus", 
        data: data,
        // dataType: "JSON/application",
        success: function (response){
            $("#selectDriverModal").modal('hide'); 
            $("#selectDriverForm")[0].reset();
            $("#driverName").attr("href","http://127.0.0.1:8000/driver/"+driver_id+"/posts");
            $("#driverName").text(driverSelected);

            $("#successModal").modal('show');
            dataTable.ajax.reload();
        }
    });
    
    //Clear form an refresh the datatable.

});

});


function statusStyle(){
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