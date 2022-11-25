$(document).ready(function() {
    $('#1').hide();
    $('#2').hide();
    $('#3').hide();
    $('#4').hide();
    $('#5').hide();
    $('#6').hide();
    $('#7').hide();
    $('#8').hide();
    $('#9').hide();
    $('#10').hide();
    $('#11').hide();
    $('#12').hide();
    $('#13').hide();
    $('#14').hide();
    $('.filter-close').click(function() {
        $(this).closest('.close-input').hide();
        $(this).closest("div.close-input").find("input[name='filter-control']").val('');
        $(this).closest("div.close-input").find("select[name='filter-control']").val('');
       // $("#company").val(" ");
    });
    $("select.selectfilter").change(function(){
        var checkvalue=$('#filtervalue').val();
        if(checkvalue == 1){
            $('#1').show();
        }
        if(checkvalue == 2){
            $('#2').show();
        }
        if(checkvalue == 3){
            $('#3').show();
        }
        if(checkvalue == 4){
            $('#4').show();
        }
        if(checkvalue == 5){
            $('#5').show();
        }
        if(checkvalue == 6){
            $('#6').show();
        }
        if(checkvalue == 7){
            $('#7').show();
        }
        if(checkvalue == 8){
            $('#8').show();
        }
        if(checkvalue == 9){
            $('#9').show();
        }
        if(checkvalue == 10){
            $('#10').show();
        }
        if(checkvalue == 11){
            $('#11').show();
        }
        if(checkvalue == 12){
            $('#12').show();
        }
       if(checkvalue == 13){
            $('#13').show();
        }
        if(checkvalue == 14){
             $('#14').show();
        }
    });
    $('#searchleads').click(function() {
        var filterleads=$("#filterleads").val();
        var page = $("#search_page").val();
        var company=$("#company").val();
        var country=$("#country").val();
        var jobtitle=$("#jobtitle").val();
        var department=$("#department").val();
        var phone=$("#phone").val();
        var reportcode=$("#reportcode").val();
        var status=$("#status").val();
        var stages=$("#stages").val();
        var createdf=$("#createdf").val();
        var createdt=$("#createdt").val();
        var nextfollowup=$("#nextfollowup").val();
        var channel=$("#channel").val();
        var assignid=$("#assignid").val();
          var assignedf=$("#assignedf").val();
          var assignedt=$("#assignedt").val();
          var last_activityf=$("#last_activityf").val();
           var last_activityt=$("#last_activityt").val();
        /*console.log(assignedf);
         console.log(assignedt);
         console.log(last_activityf);
         console.log(last_activityt); */
       $.ajax({
            type: "POST",
            url: 'ajax_all_contacts.php',
            data: ({filterleads:filterleads,page:page,country: country,department:department,stages:stages,
                     createdf:createdf,createdt:createdt,phone:phone,jobtitle:jobtitle,company:company,reportcode:reportcode,
                     status:status,nextfollowup:nextfollowup,channel:channel,associateid:assignid,
                     assignedf:assignedf,assignedt:assignedt,last_activityf:last_activityf,last_activityt:last_activityt}),
                    success: function(result){
                  //console.log(result);
                    $("#removefilter").show();
					$("#excel_download").show();
                    $("#filter-leads").html(result);
            }
        });
    });
    $('#filter_mycontacts').click(function() {
        var filterleads=$("#filterleads").val();
        var page = $("#search_page").val();

        var company=$("#company").val();
        var country=$("#country").val();
        var jobtitle=$("#jobtitle").val();
        var department=$("#department").val();
        var phone=$("#phone").val();
        var reportcode=$("#reportcode").val();
        var status=$("#status").val();
        var stages=$("#stages").val();
        var createdf=$("#createdf").val();
        var createdt=$("#createdt").val();
        var nextfollowup=$("#nextfollowup").val();
        var channel=$("#channel").val();
        var assignid=$("#assignid").val();
           // console.log(createdf);
            //  console.log(createdt);
           /*console.log(company);
           console.log(country);
           console.log(jobtitle);
           console.log(phone);
           console.log(department);
           console.log(reportcode);
           console.log(status);
           console.log(stages);*/

        $.ajax({
            type: "POST",
            url: 'ajax_my_contacts.php',
            data: ({filterleads:filterleads,page:page,country: country,department:department,stages:stages,
                createdf:createdf,createdt:createdt,phone:phone,
                jobtitle:jobtitle,company:company,reportcode:reportcode,status:status,
                nextfollowup:nextfollowup,channel:channel,associateid:assignid}),
               success: function(result){
               // console.log(result);
                   $("#removefilter").show();
                $("#filter-leads").html(result);
            }
        });
    });
    $('#removefilter').click(function() {
        var removeFilter = "filterunset";
        var val =$(this).val();
        $.ajax({
            type: "POST",
            url: 'ajax.php',
            data: ({removeFilter:removeFilter}),
            success: function(result){

                if(val != 1) {
                    window.location.href = "my_contacts.php";
                }else{
                    window.location.href = "contacts.php";
                }
            }
        });

    });
	
	$('#remove_invoicefilter').click(function() {
		var removeFilter = "filterunset";
		$.ajax({
			type: "POST",
			url: 'ajax.php',
			data: ({removeFilter:removeFilter}),
			success: function(result){
			window.location.reload();
			}
		});
	});
	
    $("#search_lead").on("keyup", function() {
        var value = $(this).val();
        var page = $("#search_page").val();
        $.ajax({
            type: "POST",
            url: 'ajax_all_contacts.php',
            data: ({name: value,page:page}),
            success: function(result){
               // console.log(result);
                $("#removefilter").show();
                $("#filter-leads").html(result);
            }
        });
    });
    $("#search_mycontacts").on("keyup", function() {
        var value = $(this).val();
        var page = $("#search_page").val();
        $.ajax({
            type: "POST",
            url: 'ajax_my_contacts.php',
            data: ({myname: value,page:page}),
            success: function(result){
                //console.log(result);
                $("#removefilter").show();
                $("#filter-leads").html(result);
            }
        });
    });
    $("#search_pending").on("keyup", function() {
        var value = $(this).val();
        var page = $("#search_page").val();
        $.ajax({
            type: "POST",
            url: 'ajax_pending_contacts.php',
            data: ({name: value,page:page}),
            success: function(result){
                //console.log(result);
                $("#filter-leads").html(result);
            }
        });
    });
});
