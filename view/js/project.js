$(document).ready(function() {
    $('#datatable').DataTable({
      "ordering": false
    });
      $('.del_address').click(function(){
         var value=$(this).val();
        //console.log(value);
        alert("Are you sure to delete this address?");
          $.ajax({
              type: "POST",
              url: 'ajax/project_ajax.php',
              data: ({del_address: value}),
              success: function(result){
              //console.log(result);
                window.location.reload();
              }
            });
       });
     $('.del_project').click(function(){
           var value=$(this).val();
           //console.log(value);
           alert("Are you sure to delete this Task?");
           $.ajax({
              type: "POST",
              url: 'ajax/project_ajax.php',
              data: ({del_task: value}),
              success: function(result){
              //console.log(result);
               window.location.reload();
              }
           });
      });
    $('#remove_proj_filter').click(function() {
          var removeFilter = "filterunset";
          var val =$(this).val();
          $.ajax({
              type: "POST",
              url: 'ajax.php',
              data: ({removeFilter:removeFilter}),
              success: function(result){
                 // console.log(result);
                 window.location.reload();
              }
          });
    });
    $("#update_details").click(function(){
        var selectCategory = $("#selectCategory").val();
        var selectProject = $("#selectProject").val();
        var status=$("#status").val();
        var rating = $("#rating").val();
        var assigned_to = $("#selectemployee").val();
        var exp_deadline = $("#exp_deadline").val();
        var description = $("#description").val();
        var task_id = $("#task_id").val();
          // console.log(description);
         $.ajax({
             type: "POST",
             url: 'ajax/project_ajax.php',
             data: ({selectCategory: selectCategory,selectProject:selectProject,status:status,rating:rating,
             assigned_to:assigned_to,exp_deadline:exp_deadline,description:description,task_id:task_id}),
             success: function(result){
                // console.log(result);
             alert("Updated Successfully");
             window.location.reload();
             }
         });
     });
   $("#save_comments").click(function(){
        var comments = $("#comments").val();
        var updatetask_id = $("#task_id").val();
          //console.log(updatetask_id);
         $.ajax({
             type: "POST",
             url: 'ajax/project_ajax.php',
             data: ({comments:comments,updatetask_id:updatetask_id}),
             success: function(result){
                 //console.log(result);
               alert("Updated Successfully");
             window.location.reload();
             }
         });
   });
   $("#user_commnets").click(function(){
       var user_status = $("#user_status").val();
       var req_deadline = $("#req_deadline").val();
       var user_comments = $("#user_comments").val();
       var user_task_id = $("#task_id").val();
        //console.log(user_status);
       $.ajax({
              type: "POST",
              url: 'ajax/project_ajax.php',
              data: ({user_status:user_status,req_deadline:req_deadline,user_comments:user_comments,user_task_id:user_task_id}),
              success: function(result){
                  //console.log(result);
                alert("Updated Successfully");
              window.location.reload();
              }
          });
       });
  $("#project_filter").click(function(){
        var filterProjects="1";
        var FCategory = $("#fcategory").val();
        var Fproject = $("#Fproject").val();
        var ass_fromdate = $("#ass_from_date").val();
        var ass_todate = $("#ass_to_date").val();
        var proj_status = $("#proj_status").val();
        var exp_fromdate = $("#exp_from_date").val();
         var exp_todate = $("#exp_to_date").val();
        $.ajax({
             type: "POST",
             url: 'ajax/ajax_project_filter.php',
             data: ({filterProjects:filterProjects,FCategory: FCategory,Fproject:Fproject,ass_fromdate:ass_fromdate,
             ass_todate:ass_todate,proj_status:proj_status,exp_fromdate:exp_fromdate,exp_todate:exp_todate}),
             success: function(result){
             //console.log(result);
              $("#remove_proj_filter").show();
             $("#filter-projects").html(result);
             }
        });
   });
  $("#emp_project_filter").click(function(){
           var filterMyProjects="1";
           var FCategory = $("#fcategory").val();
           var Fproject = $("#Fproject").val();
           var ass_fromdate = $("#ass_from_date").val();
           var ass_todate = $("#ass_to_date").val();
           var proj_status = $("#proj_status").val();
           var exp_fromdate = $("#exp_from_date").val();
           var exp_todate = $("#exp_to_date").val();
           $.ajax({
                type: "POST",
                url: 'ajax/ajax_my_project_filter.php',
                data: ({filterMyProjects:filterMyProjects,FCategory: FCategory,Fproject:Fproject,
                ass_fromdate:ass_fromdate,ass_todate:ass_todate,proj_status:proj_status,exp_fromdate:exp_fromdate,
                exp_todate:exp_todate}),
                success: function(result){
                //console.log(result);
                 $("#remove_proj_filter").show();
                $("#filter-projects").html(result);
                }
           });
   });

});
