jQuery(document).ready(function(){
    
    // todoFormBtn
    jQuery(document).on('click','#todoFormBtn', function(){
        var form_show = jQuery(this).attr('data-form-show');
        if(form_show == 'false'){
            jQuery("#todoFormCont").show();
            jQuery("#todoFormBtn .fa").removeClass('fa-plus').addClass('fa-minus');
            jQuery(this).attr('data-form-show','true');
        } else {
            jQuery("#todoFormCont").hide();
            jQuery("#todoFormBtn .fa").removeClass('fa-minus').addClass('fa-plus');
            jQuery(this).attr('data-form-show','false');
        }
    });
    
    // todoForm      
    jQuery("#todoForm").submit(function(e) {
        //
//        var type = jQuery("#type").val();
//        var title = jQuery("#title").val();
        // 
        var reqUrl = '/add-task';
        var reqData = 'type='+type+'&title='+title;
        // alert(reqUrl+' - '+reqData); 
        if(title==''){
            jQuery("#title").css("border-color", "red");;
            return false;
        } else {
            jQuery.ajax({
                type: "POST",
                url: reqUrl,
                data: reqData,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    
                },
                complete: function () {
                    
                },
                success: function (response) {
                    var status = response.status;
                    var message = response.message;
                    if (status == 1) {
                        var data = response.data;
                        var user_task = data.user_task;
                        var html = '';
                        if(user_task != ''){
                            // jQuery.each(user_task, function(key,value) {
                                console.log('id => '+user_task.id+' title'+user_task.title);
                                html += '<li id="user-task-'+user_task.id+'">';
                                html += '<div class="form-group">';
                                    html += '<label>'+user_task.title+'</label>';
                                    html += '<a href="javascript:void(0)" class="delete-user-task" id='+user_task.id+'>';
                                    html += '<i class="fa fa-trash" aria-hidden="true"></i>';
                                    html += '</a>';
                                html += '</div>';
                                html += '<p class="time">&nbsp;</p>';
                                html += '</li>';
                            // });
                        } else {
                            html += '';
                        }
                        jQuery("#title").val('');
                        jQuery("#todoFormCont").after(html);
                        jQuery("#todoNoTaskCont").hide();
                    } else {
                        // 
                        var message = response.message;
                        jQuery("#todoFormAlert").html(message).addClass('alert-danger').fadeIn('slow');
                        setTimeout(function() { jQuery("#todoFormAlert").hide().html('').removeClass('alert-danger'); }, 10000);
                        return false;
                    }
                }
            });
        }
        return false;
    });
    
    // wipFormBtn
    jQuery(document).on('click','#wipFormBtn', function(){
        var form_show = jQuery(this).attr('data-form-show');
        if(form_show == 'false'){
            jQuery("#wipFormCont").show();
            jQuery("#wipFormBtn .fa").removeClass('fa-plus').addClass('fa-minus');
            jQuery(this).attr('data-form-show','true');
        } else {
            jQuery("#wipFormCont").hide();
            jQuery("#wipFormBtn .fa").removeClass('fa-minus').addClass('fa-plus');
            jQuery(this).attr('data-form-show','false');
        }
    });
    
    // wipForm      
    jQuery("#wipForm").submit(function(e) {
        //
//        var type = jQuery("#wipForm #type").val();
//        var title = jQuery("#wipForm #title").val();
        // 
        var reqUrl = '/add-task';
        var reqData = 'type='+type+'&title='+title;
        // alert(reqUrl+' - '+reqData); 
        if(title==''){
            jQuery("#wipForm #title").css("border-color", "red");;
            return false;
        } else {
            jQuery.ajax({
                type: "POST",
                url: reqUrl,
                data: reqData,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    
                },
                complete: function () {
                    
                },
                success: function (response) {
                    var status = response.status;
                    var message = response.message;
                    if (status == 1) {
                        var data = response.data;
                        var user_task = data.user_task;
                        var html = '';
                        if(user_task != ''){
                            // jQuery.each(user_task, function(key,value) {
                                console.log('id => '+user_task.id+' title'+user_task.title);
                                html += '<li id="user-task-'+user_task.id+'">';
                                html += '<div class="form-group">';
                                    html += '<label>'+user_task.title+'</label>';
                                    html += '<a href="javascript:void(0)" class="delete-user-task" id='+user_task.id+'>';
                                    html += '<i class="fa fa-trash" aria-hidden="true"></i>';
                                    html += '</a>';
                                html += '</div>';
                                html += '<p class="time">&nbsp;</p>';
                                html += '</li>';
                            // });
                        } else {
                            html += '';
                        }
                        jQuery("#wipForm #title").val('');
                        jQuery("#wipFormCont").after(html);
                        jQuery("#wipNoTaskCont").hide();
                    } else {
                        // 
                        var message = response.message;
                        jQuery("#wipFormAlert").html(message).addClass('alert-danger').fadeIn('slow');
                        setTimeout(function() { jQuery("#wipFormAlert").hide().html('').removeClass('alert-danger'); }, 10000);
                        return false;
                    }
                }
            });
        }
        return false;
    });
    
    // completedFormBtn
    jQuery(document).on('click','#completedFormBtn', function(){
        var form_show = jQuery(this).attr('data-form-show');
        if(form_show == 'false'){
            jQuery("#completedFormCont").show();
            jQuery("#completedFormBtn .fa").removeClass('fa-plus').addClass('fa-minus');
            jQuery(this).attr('data-form-show','true');
        } else {
            jQuery("#completedFormCont").hide();
            jQuery("#completedFormBtn .fa").removeClass('fa-minus').addClass('fa-plus');
            jQuery(this).attr('data-form-show','false');
        }
    });
    
    // completedForm      
    jQuery("#completedForm").submit(function(e) {
        //
//        var type = jQuery("#completedForm #type").val();
//        var title = jQuery("#completedForm #title").val();
        // 
        var reqUrl = '/add-task';
        var reqData = 'type='+type+'&title='+title;
        // alert(reqUrl+' - '+reqData); 
        if(title==''){
            jQuery("#completedForm #title").css("border-color", "red");;
            return false;
        } else {
            jQuery.ajax({
                type: "POST",
                url: reqUrl,
                data: reqData,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    
                },
                complete: function () {
                    
                },
                success: function (response) {
                    var status = response.status;
                    var message = response.message;
                    if (status == 1) {
                        var data = response.data;
                        var user_task = data.user_task;
                        var html = '';
                        if(user_task != ''){
                            // jQuery.each(user_task, function(key,value) {
                                console.log('id => '+user_task.id+' title'+user_task.title);
                                html += '<li id="user-task-'+user_task.id+'">';
                                html += '<div class="form-group">';
                                    html += '<label>'+user_task.title+'</label>';
                                    html += '<a href="javascript:void(0)" class="delete-user-task" id='+user_task.id+'>';
                                    html += '<i class="fa fa-trash" aria-hidden="true"></i>';
                                    html += '</a>';
                                html += '</div>';
                                html += '<p class="time">&nbsp;</p>';
                                html += '</li>';
                            // });
                        } else {
                            html += '';
                        }
                        jQuery("#completedForm #title").val('');
                        jQuery("#completedFormCont").after(html);
                        jQuery("#completedNoTaskCont").hide();
                    } else {
                        // 
                        var message = response.message;
                        jQuery("#completedFormAlert").html(message).addClass('alert-danger').fadeIn('slow');
                        setTimeout(function() { jQuery("#completedFormAlert").hide().html('').removeClass('alert-danger'); }, 10000);
                        return false;
                    }
                }
            });
        }
        return false;
    });
    
    // delete-user-task
    // completedFormBtn
    jQuery(document).on('click','.delete-user-task', function(){
        var user_task_id = jQuery(this).attr('id');
        
        if(user_task_id != ''){
            var reqUrl = '/delete-task';
            var reqData = 'user_task_id='+user_task_id;
            // alert(reqUrl+' - '+reqData); // return false;
            jQuery.ajax({
                type: "POST",
                url: reqUrl,
                data: reqData,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    
                },
                complete: function () {
                    
                },
                success: function (response) {
                    var status = response.status;
                    var message = response.message;
                    if (status == 1) {
                        var rowId = 'user-task-'+user_task_id;
                        jQuery("#"+rowId).remove();
                    } else {
                        // 
                        var message = response.message;
                        alert(message); return false;
                    }
                }
            });
        }
        
    });
    
});