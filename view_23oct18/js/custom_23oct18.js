$(window).on('load', function (e) {
    $('.div1').width($('table').width());
    $('.div2').width($('table').width());
});
$(document).ready(function() {

    $("select.selectrole").change(function() {
        var roleid=$(this).val();
        if(roleid == 1){
            $(".hide-manager").hide();
            $(".hide-team").hide();
            $(".hide-domain").hide();
        }
        if (roleid == 2) {
            $(".hide-manager").hide();
            $(".hide-team").hide();
            $(".hide-domain").show();
        }
        if(roleid == 3){
            $(".hide-manager").hide();
            $(".hide-team").show();
            $(".hide-domain").show();
        }
        if(roleid == 4){
            $(".hide-manager").show();
            $(".hide-team").show();
            $(".hide-domain").show();
        }
    });


    /* ----------------------------------------------  calendar -----------------------------------------------*/
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        defaultDate: '2018-09-12',
        editable: true,
        eventLimit: true,
        selectable: true,
      //  events: events_array,
        events: {
            url: 'get_events.php',
        },
      /*  eventClick:  function(event, jsEvent, view) {
          /!*  $('#modalTitle').html(event.title);
            $('#modalBody').html(event.description);
            $('#eventUrl').attr('href',event.url);
            $('#fullCalModal').modal();*!/
        }*/
        eventRender: function (event, element) {
            element.attr('href', 'javascript:void(0);');
            element.click(function() {
                $("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
                //$("#endTime").html(moment(event.end).format('MMM Do h:mm A'));
                $("#eventInfo").html(event.description);
                $("#eventId").html(event.assigned_by);
                $("#eventLink").attr('href', event.url);
                $("#eventContent").dialog({ modal: true, title: event.title, width:400});
            });
        }
    });
/* ----------------------------------------------   contacts-details -----------------------------------------------*/
    $('#note').summernote();
    $('#sendemail').summernote();
    $('#task').summernote();
    $('#schedule').summernote();
    var date = new Date();
    $('.task_datetime').datetimepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: date,
        minView: 2
    });
    $('.filter_datetime').datetimepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        minView: 2
    });
    $('.nextfollowupdatepicker').datetimepicker({
        startDate: date
    });
    $('#openinvoice').click(function() {
        var myleadId = $(this).val();
        // console.log(myleadId);
        $(".modal-body #leadid").val( myleadId );
    });
    $("#create_invoice").click(function () {
        var leadid=$('#leadid').val();
        var name=$("#name").val();
        var address=$("#address").val();
        var paid_amount=$("#paid_amount").val();
        var amount=$("#amount").val();
        var purchase_order=$("#purchase_order").val();
         var temptype=$("#temptype").val();
        $.ajax({
            type: "GET",
            url: 'ajax.php',
            data: ({leadid:leadid,name:name,address:address,paid_amount:paid_amount,amount: amount,
                purchase_order:purchase_order,temptype:temptype}),
            success: function(result){
               // alert("Created Successfully")
                window.location.reload();
            }
        });
    });

    $('#openeditinvoice').click(function() {
        var myleadId = $(this).val();
         //console.log(myleadId);
        $(".modal-body #editleadid").val( myleadId );
    });
    $("#edit_invoice").click(function () {
        var invoiceid=$(this).val();
        var editleadid =$('#editleadid').val();
        var editname=$("#editname").val();
        var editaddress=$("#editaddress").val();
        var editpaid_amount=$("#editpaid_amount").val();
        var editamount=$("#editamount").val();
        var editpurchase_order=$("#editpurchase_order").val();
        var edittemptype=$("#edittemptype").val();
        //console.log(editleadid);
        $.ajax({
            type: "GET",
            url: 'ajax.php',
            data: ({invoiceid:invoiceid,editleadid:editleadid,editname:editname,editaddress:editaddress,editpaid_amount:editpaid_amount,editamount: editamount,
                editpurchase_order:editpurchase_order,edittemptype:edittemptype}),
            success: function(result){
                alert("updated Successfully");
            }
        });
    });
    /*  -------------------------------------------------  contacts-pageee---------------------------------------------*/
    $('.wrapper1').on('scroll', function (e) {
        $('.wrapper2').scrollLeft($('.wrapper1').scrollLeft());
    });
    $('.wrapper2').on('scroll', function (e) {
        $('.wrapper1').scrollLeft($('.wrapper2').scrollLeft());
    });
     $(".checklead").click(function() {
       $(".hide-buttons").toggle();
    });

 /*  ------------------------------------------------- contacts-filters action---------------------------------------------*/
$("#search").on("keyup", function() {
        var value = $(this).val();
        $.ajax({
            type: "GET",
            url: 'ajax_lead.php',
            data: ({name: value}),
            success: function(result){
                //console.log(result);
                $("#filter-leads").html(result);
            }
        });
 });
$("#search_mycontacts").on("keyup", function() {
        var value = $(this).val();
        $.ajax({
            type: "GET",
            url: 'ajax_lead.php',
            data: ({myname: value}),
            success: function(result){
                //console.log(result);
                $("#filter-leads").html(result);
            }
        });
    });
$("#search_pending").on("keyup", function() {
        var value = $(this).val();
        $.ajax({
            type: "GET",
            url: 'ajax_contact.php',
            data: ({name: value}),
            success: function(result){
                //console.log(result);
                $("#filter-leads").html(result);
            }
        });
    });
$("select.selecttype").change(function(){
    var checkvalue=$('#filtercontacts').val();
   // $("#filter-leads").load("ajax_lead.php?status=" + checkvalue);
    $.ajax({
        type: "GET",
        url: 'ajax_lead.php',
        data: ({status:checkvalue}),
        success: function(result){
            //console.log(result);
             $("#filter-leads").html(result);
        }
    });
});
    $("select.selectstage").change(function(){
        var stagevalue=$('#filterstages').val();
        // $("#filter-leads").load("ajax_lead.php?status=" + checkvalue);
        $.ajax({
            type: "GET",
            url: 'ajax_lead.php',
            data: ({stage:stagevalue}),
            success: function(result){
                //console.log(result);
                $("#filter-leads").html(result);
            }
        });
    });
/*  -------------------------------------------------  contacts-filters-END  ---------------------------------------------*/

 $('.openassign').click(function() {
    var myBookId = $(this).data('id');
    console.log(myBookId);
    $(".modal-body #bookId").val( myBookId );
});
$('#assign').click(function() {
    var leadid= $("#bookId").val();
    var associateid=$("#assoiateId").val();
    $.ajax({
        type: "GET",
        url: 'ajax.php',
        data: ({leadid: leadid,associateid:associateid}),
        success: function(result){
           // console.log(result);
            alert("updated successfully");
            window.location.reload();
        }
    });
});
$('.accept').click(function() {
    var leadid=$(this).val();
    var status='1';
    Updatestatus(leadid,status);
});
$('.openreject').click(function() {
    var myleadId = $(this).val();
   // console.log(myleadId);
    $(".modal-body #leadid").val( myleadId );
});
$('#reject').click(function() {
    var leadid=$('#leadid').val();
    var status='2';
    var rejectnote=$("#comment").val();
    Updatestatus(leadid,status,rejectnote);
});
function Updatestatus(leadid,status,note) {
    $.ajax({
        type: "GET",
        url: 'ajax.php',
        data: ({leadid: leadid,status:status,rejectnote:note}),
        success: function(result){
            alert("updated successfully");
            window.location.reload();
        }
    });
}
/*  -------------------------------------------------  Taskssssssss--assign---------------------------------------------*/
 $("select.tasktype").change(function(){
        var taskvalue=$('#tasktype').val();
       // console.log(taskvalue);
        $.ajax({
            type: "GET",
            url: 'ajax_task.php',
            data: ({status:taskvalue}),
            success: function(result){
               // console.log(result);
                 $("#filter-tasks").html(result);
            }
        });
    });
 $('.openremarks').click(function() {
        var taskid = $(this).val();
        console.log(taskid);
        $(".modal-body #taskid").val( taskid );
    });
    $('#remark').click(function() {
      var taskid=$("#taskid").val();
      var remarks=$("#text_remark").val();
      var status=$("#status").val();
       $.ajax({
            type: "GET",
            url: 'ajax.php',
            data: ({taskid: taskid,status:status,remarks:remarks}),
            success: function(result){
                alert("updated successfully");
                window.location.reload();
            }
        });
    });
});