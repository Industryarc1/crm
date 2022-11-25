$(document).ready(function() {
    $("#check_all").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
        if($(':checkbox:checked').length > 0){
            $(".hide-buttons").show();
        }else{
            $(".hide-buttons").hide();
        }
    });
    $("#search_account").on("keyup", function() {
        var value = $(this).val();
        var page = $("#search_page").val();
       // console.log(value);
      //  console.log(page);
        $.ajax({
            type: "POST",
            url: 'ajax_all_accounts.php',
            data: ({value: value,page:page}),
            success: function(result){
                  // console.log(result);
                 $("#remove_acc_filter").show();
                $("#filter-accounts").html(result);
            }
        });
    });
    $("#searchaccounts").click(function () {
        var filteraccounts=$("#filteraccounts").val();
        var page = $("#search_page").val();
        var company=$("#company").val();
        var country=$("#country").val();
        var industry=$("#industry").val();
        var from_revenue=$("#from_revenue").val();
        var to_revenue=$("#to_revenue").val();
        var assign_acc=$("#assign_acc").val();
        var assignedf=$("#assignedf").val();
        var assignedt=$("#assignedt").val();
    /*     console.log(assignid);
         console.log(company);
        console.log(country);
        console.log(industry);
        console.log(filteraccounts);
        console.log(assignedf);
        console.log(assignedt);*/
       $.ajax({
            type: "POST",
            url: 'ajax_all_accounts.php',
            data: ({filteraccounts:filteraccounts,page:page,company:company,country:country,industry:industry,
                from_revenue:from_revenue,to_revenue:to_revenue,assignedf:assignedf,assignedt:assignedt,assign_to:assign_acc}),
               success: function(result){
               // console.log(result);
                $("#remove_acc_filter").show();
               $("#filter-accounts").html(result);
            }
        });
    });
    $('#remove_acc_filter').click(function() {
        var removeFilter = "filterunset";
        var val =$(this).val();
        $.ajax({
            type: "POST",
            url: 'ajax.php',
            data: ({removeFilter:removeFilter}),
            success: function(result){
               // console.log(result);
               window.location.href = "accounts.php";
            }
        });

    });
    $('#assign_account').click(function () {
        var accids = [];
        $.each($("input[name='account_ids']:checked"), function() {
            accids.push($(this).val());
        });
        var assign_to = $("#mul_assignedid").val();
        // alert("ids are : " + accids.join(", "));
        $.ajax({
            type: "POST",
            url: 'ajax.php',
            data: ({multiple_accIds: accids, assign_to: assign_to}),
            success: function (result) {
                //console.log(result);
                alert("Updated successfully");
                window.location.reload();
            }
        });
    });
    $('#single_assign').click(function () {
        var accId = $("#accId").val();
        var assign_to = $("#assignedid").val();
        //  console.log(accId);
        //  console.log(assign_to);
        $.ajax({
            type: "POST",
            url: 'ajax.php',
            data: ({accId: accId, assign_to: assign_to}),
            success: function (result) {
                // console.log(result);
                alert("Updated successfully");
                window.location.reload();
            }
        });
    });
	
	$('#save_deal').click(function () {
        var lead_id=$("#lead_id").val();
        var lead_stage_id=$("#lead_Stage").val();
        var deal_amount=$("#deal_value").val();
        var deal_date=$("#deal_date").val();
        var deal_stage=$("#deal_stage").val();
          		console.log(lead_stage_id);
        $.ajax({
            type: "POST",
            url: 'ajax.php',
            data: ({lead_id: lead_id,lead_stage_id:lead_stage_id,deal_amount:deal_amount,deal_date:deal_date,
                deal_stage: deal_stage}),
            success: function (result) {
                console.log(result);
                alert("Updated successfully");
                window.location.reload();
            }
        });

    });
	$('#close_deal').click(function () {
                 var lead_id=$("#lead_id").val();
                 var lead_stage_id=$("#lead_Stage").val();
                 var deal_amount=$("#deal_clz_value").val();
                 var deal_date=$("#deal_clz_date").val();
                 var deal_stage=$("#deal_clz_stage").val();
                 //console.log(deal_amount);
                 $.ajax({
                     type: "POST",
                     url: 'ajax.php',
                     data: ({lead_id: lead_id,lead_stage_id:lead_stage_id,deal_amount:deal_amount,deal_date:deal_date,
                         deal_stage: deal_stage}),
                     success: function (result) {
                         //console.log(result);
                         alert("Updated successfully");
                        window.location.reload();
                     }
                 });

     });
	
    $('#lost_deal').click(function () {
        var lead_id=$("#lead_id").val();
        var lead_stage_id=$("#lead_Stage").val();
        var reason=$("#lost_reason").val();
        /*console.log(lead_id);
        console.log(lead_stage_id);
        console.log(reason);*/
        $.ajax({
            type: "POST",
            url: 'ajax.php',
            data: ({lead_id: lead_id,lead_stage_id:lead_stage_id,reason:reason}),
            success: function (result) {
                 //console.log(result);
                alert("Updated successfully");
                window.location.reload();
            }
        });
    });
	
	$("#change_pipeline").click(function () {
         var Lead_deal_Id=$("#LeadId").val();
         var Deal_Stage=$("#deal_id").val();
         var lost_reason=$("#deal_lost").val();
         if(Deal_Stage == 0){
            if(lost_reason == null){
              alert("Lost reason is mandatory!!!");
              return false;
            }
         }
        //console.log(lost_reason);
       $.ajax({
             type: "POST",
             url: 'ajax.php',
             data: ({Lead_deal_Id: Lead_deal_Id,Deal_Stage:Deal_Stage,lost_reason:lost_reason}),
             success: function (result) {
                    //console.log(result);
                 alert("Updated successfully");
                 window.location.reload();
             }
       });
    });
});
