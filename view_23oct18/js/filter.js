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
    });
    $('#searchleads').click(function() {
        var filterleads='1';
        var company=$("#company").val();
        var country=$("#country").val();
        var jobtitle=$("#jobtitle").val();
        var department=$("#department").val();
        var phone=$("#phone").val();
        var reportcode=$("#reportcode").val();
        var status=$("#status").val();
        var stages=$("#stages").val();
        var created=$("#created").val();
        var nextfollowup=$("#nextfollowup").val();
        var channel=$("#channel").val();
        var assignid=$("#assignid").val();
        /*    console.log(assignid);
          console.log(company);
           console.log(country);
           console.log(jobtitle);
           console.log(phone);
           console.log(department);
           console.log(reportcode);
           console.log(status);
           console.log(stages);
           console.log(fromdate);
           console.log(todate);*/
       $.ajax({
            type: "POST",
            url: 'ajax_lead.php',
            data: ({filterleads:filterleads,country: country,department:department,stages:stages,created:created,phone:phone,
                         jobtitle:jobtitle,company:company,reportcode:reportcode,status:status,
                nextfollowup:nextfollowup,channel:channel,associateid:assignid}),
                success: function(result){
                  //console.log(result);
                $("#filter-leads").html(result);
            }
        });
    });
    $('#removefilter').click(function() {
        window.location.reload();
    });
});