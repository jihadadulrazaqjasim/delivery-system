$(document).ready(function(){
    $("#storesTable").DataTable({

        "ajax":{
            url:"/getAllStores",
            dataSrc: '',
            // data:{"get_all_users":"true"}, 
            // method:"POST",

        },
        // "ordering": true,
        "paging":   true,
        "ordering": true,
        "info":     true,
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
            {"data":"store_name", 
          
            },
            {"data":"phone_number"},
            {"data":"debt_to_store",
            "render":function ( data, type, row, meta ) {
                return data +" د.ع";
            }
        },
            {"data":"more"},
         ],
        
    });

});