$(document).ready(function () {
   table= $("#singleDriverTable").DataTable({
    order: [[ 6, 'desc']],
    
    columnDefs: [  {
    
        "targets": [ 0 ],
        "visible":false
    }
    ],

    "initComplete":function( settings, json){
        // Load styling of status
    //   statusStyle();

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
    },
    });
    
     //When a change is occured to the datatable this function will be triggered!. 
     $('#singleDriverTable').on( 'draw.dt', function () { 
        totalPrice=0;
        totalTransPrice=0;
        // dataTable.rows().deselect();
        // $("th.select-checkbox").removeClass("selected");
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

    table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
        var cell = table.cell({ row: rowIdx, column: 10 }).node();
        
        var cellData = table.cell({ row: rowIdx, column: 10 }).data();
         
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

});

