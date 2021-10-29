$(document).ready(function(){
    $("#driversTable").DataTable({

        "ajax":{ 
            url:"/getAllDrivers",
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
            {"data":"driver_name"},
            // {"data":"username"},
            {"data":"phone_number"},
            {"data":"more"},
         ],
        
    });

});
