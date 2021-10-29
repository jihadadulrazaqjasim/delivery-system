$(document).ready(function () {
    // Adding X-CSRF-TOKEN to the header while sending post request.
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

// Load necessary data from server using ajax

// Load stores
getStores();

// Load drivers
getDrivers();

// Load Locations
getLocations();

//By default to set the
$("#save_post").addClass("no-click");
$("#cancel").addClass("no-click");
$(".no-click").css("pointer-events","none");
var defaultTableContent=`<tr id='addr0' style="display:none;">
<td style="width:5%">1</td>
<td style="width:10%"><input type="text" required name='post_code[]'  class="form-control post_code"></td>
<td style="width:20%"><input required type="text" min="1" name='post_name[]'  class="form-control post_name" ></td>
<td style="width:20%"><input type="text" required name='address[]'  class="form-control address"></td>
<td style="width:10%"><input type="text" name='post_phone_number[]'  class="form-control post_phone_number"></td>
<td style="width:10%"><input type="number" required name='price[]'  class="form-control price" step="0.00" min="0"></td>
<td style="width:10%"><input type="number" name='transportation_price[]' required  class="form-control transportation_price" step="0.00" min="0"></td>
<td style="width:15%"><textarea name='comment[]'  class="form-control comment"></textarea></td>

<td hidden><input type="hidden" name='id[]' class="id"></td>
    </tr>
    <tr id='addr1'></tr>`;


// While click on add new row button
$("#add_new_row").click(add_new_row);

// While ctrl and enter also to trigger add_new_row.
$(document).on('keypress',function(e) {
    if(e.ctrlKey&&e.which==13){
        add_new_row();
        e.preventDefault();   
    }
});

//Prevent enter from submitting the form
$(document).on('keypress',function(e) {
    if(e.keyCode==13||e.which==13){
        e.preventDefault();
    }
});

//While click on delte last row button
$("#delete_last_row").on("click",delete_last_row);

    // While ctrl space to delete the last row
    $(document).on('keydown',function(e) {
        if((e.ctrlKey &&(e.which==32 || e.keyCode==32))){
            delete_last_row(e);
            e.preventDefault();
        }
    });

// While change in body of table then to calculate the totals.
$('#tab_logic tbody').on('keyup change',function(){
    calc();
});

// If cancel button is clicked thent to reset the table
$(document).on("click","#cancel",function(event){
    
    $(".no-click").css("pointer-events","none");

    //Clear the body of the table.
    $('#tab_logic tbody').html(defaultTableContent);

      $("#totalPrice").val('');
      $("#totalTransPrice").val('');
});

// If save button is clicked:
$(document).on("click","#save_post",function(event){
    event.preventDefault();

   //Declare the arrays to hold the form inputs
    var post_code = new Array();
    var post_name=new Array();
    var address=new Array();
    var price=new Array();
    var transportation_price=new Array();
    var comment=new Array();
    var post_phone_number=new Array();

    var location=new Array();
    var driver=new Array();



    var store;

    // location=$("#locations").val();
    // driver=$("#drivers").val();
    store=$("#stores").val();

    console.log(store);

    // Get the form inputs and set into the arrays
    $('#tab_logic tbody tr').not('#addr0').not(':last-child').each(function(i, el) {
    // alert ( $(this).attr ('id' ) );
    post_code[i]=$(this).find('.post_code').val();
    post_name[i]=$(this).find('.post_name').val();

    driver[i]=$(this).find('.driver').val();
    location[i]=$(this).find('.location').val();
    
    address[i]=$(this).find('.address').val();
    price[i]=$(this).find('.price').val();
    transportation_price[i]=$(this).find('.transportation_price').val();
    comment[i]=$(this).find('.comment').val();
    post_phone_number[i]=$(this).find('.post_phone_number').val();

    // alert("product: "+product[i]+", qty:"+qty[i]+", price"+price[i]+", total: "+total[i]+", invoiceTot: "+invoiceTotal)
    });
    
    var mydata={"post_code" : post_code,"post_name":post_name,
    "address":address,"post_phone_number":post_phone_number,"price":price,"transportation_price":transportation_price,
    "comment":comment,"location":location,"driver":driver,"store":store,
    "totalPrice":totalPrice};

    // console.log(mydata);

    //  Make the ajax request to save the data
    $.ajax({
        type: "POST",
        url: "/post",
        data: mydata,
        dataType: "json",
        success: function (response) {
        //Clear the body of the table.
        $('#tab_logic tbody').html(defaultTableContent);
            // alert(response);

        //Make the pointer not clickable.
        $(".no-click").css("pointer-events","none");

        // Reset totals fields
        $("#totalPrice").val('');
        $("#totalTransPrice").val('');
        }
    });
    
});

});

function getStores(){
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
            var content=`<option value="`+store_id+`">`+store_name+`</option>`;
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
                // dataTable.ajax.reload();
            },
            onSelectAll:function () {
                // dataTable.ajax.reload();
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


function getDrivers(){
//Get All Drivers for multiselect checkbox
   $.ajax({
    url:"/getAllDriverNames",
    method:"GET",
    contentType:"applicatopn/json",
    success:function(data){
    console.log(data);
    allContentDriver='';
        $.each((data),function(index,value){
            var driver_id=value.id;
            var driver_name=value.driver_name;
            var content=`<option value="`+driver_id+`">`+driver_name+`</option>`; 

            allContentDriver = allContentDriver + content;
        });

        $(".driver").append(allContentDriver);
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
    allContentLocation='';
    $.each((data),function(index,value){
        var location_id=value.id;
        var location_name=value.location_name;
        var content=`<option value="`+location_id+`">`+location_name+`</option>`;
       
        allContentLocation = allContentLocation + content;
    });

    $(".location").append(allContentLocation);
   
},
error: function(xhr, status, error){
    var errorMessage = xhr. status + ': ' + xhr. statusText;
    alert('Error - ' + errorMessage);
},
});
}

function add_new_row(event){
event.preventDefault();
$(".no-click").css("pointer-events","auto");

$('#tab_logic tbody tr').each(function(i, element) {
   var html = $(this).html(); 
    if(html=='')
    {
        $('#addr'+i).html($('#addr'+(i-1)).html()).find('td:first-child').html(i);
        //If the next row content was empty so no need to create another empty row.
        if($(this).next().html()!='')
        $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
        return false;
    }
});

// Calculate total everytime a new row inserted.
calc();

}
function delete_last_row(event){
event.preventDefault();

var value=0;
$('#tab_logic tbody tr').each(function(i, element) {
    
    var html = $(this).html();
    if(html!='')
    {
        value++;
    }
});
$("#addr"+(value-1)).not('#addr0').not(':last-child').html('');
// alert("delete");

if(value<=2)
$(".no-click").css("pointer-events","none");

else
$(".no-click").css("pointer-events","auto");

// Calculate total everytime a new row deleted.
calc();
}

function calc()
{
 totalPrice=0;
 totalTransPrice=0;
$('#tab_logic tbody tr').each(function(i, element) {
    var html = $(this).html();
    if(html!='')
    { 
         price = parseFloat($(this).find('.price').val());

        //  alert(price);
        // alert(price);
        if(!Number.isNaN(price)){
        totalPrice += price;
        }

         transportation_price = parseFloat($(this).find('.transportation_price').val());

         if(!Number.isNaN(transportation_price)){
         totalTransPrice+=transportation_price;
         }
    }
});
$("#totalPrice").val(totalPrice)
$("#totalTransPrice").val(totalTransPrice)
}