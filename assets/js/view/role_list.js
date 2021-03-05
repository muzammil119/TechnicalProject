    
    window.onload = hideErrorMessages();

    function hideErrorMessages(){
        $("#error_email").hide();
        $("#error_email2").hide();
        $("#error_email3").hide();
        $("#error_role").hide();
        $("#error_role2").hide();
        $("#error_role").hide();
        $("#edit-error_email").hide();
        $("#edit-error_email2").hide();
        $("#edit-error_email3").hide();
        $("#edit-error_name").hide();
        $("#edit-error_name2").hide();
        $("#edit-error_role").hide();
        $("#edit_role").hide();
        $("#edit_role2").hide();
        $("#edit_status_role").hide();
        
        hide_loading();
    }

    $(document).ready( function () {

        //$('#dataTables-user-log').DataTable();
        $('#dataTables-user-list').DataTable({
            "bFilter": true,
            "paging":   false,
            //"iDisplayLength": 20,
            "order": [[ 0, "asc" ]]
            //"bDestroy": true,
        });
     } );

    function edit_role_popup(role_name,id,status){
        $( "#edit-role-name" ).val(role_name);
        $( "#edit-role-id" ).val(id);
        if(status == 1)
           roleOption =  "<option value='1' selected>Active</option><option value='2'>Inactive</option>";
        else
            roleOption = "<option value='1' >Active</option><option value='2' selected>Inactive</option>"
            
        $( "#role-status" ).html(roleOption);

        $('#editRoleSubmit').attr("onclick","update_role_details("+id+")");
    }

    function deactivate_role_confirmation(email,id){
        $( "#user-email" ).html(email);
        $('#deactivateYesButton').attr("onclick","deactivate_role_submit('"+email+"',"+id+")");
    }

    function reset_confirmation(email,id){
        $( "#reset-user-email" ).html(email);
        $('#resetYesButton').attr("onclick","reset_submit('"+email+"',"+id+")");
    }

    function deactivate_role_submit(email,id){
        show_loading();
            $.ajax({
            url: $("#base-url").val()+"admin/deactivate_user/"+email+"/"+id,
            cache: false,
            success: function (result) {
                var result = $.parseJSON(result);
                if(result.status=='success'){
                    location.reload();
                }
                else{
                    alert("Oops there is something wrong!");
                }
            },
            error: ajax_error_handling
        });
    }

    function reset_submit(email,id){
        show_loading();
            $.ajax({
            url: $("#base-url").val()+"admin/reset_user_password/"+email+"/"+id,
            cache: false,
            success: function (result) {
                var result = $.parseJSON(result);
                if(result.status=='success'){
                    location.reload();
                }
                else{
                    alert("Oops there is something wrong!");
                }
            },
            error: ajax_error_handling
        });
    }

    function update_role_details(id){
        hideErrorMessages();
        show_loading();
        var i=0;
        var role_name = $('#edit-role-name').val();
        var role_status = $('#role-status').val();
        if(role_name == ""){
            $("#edit-error_name").show();
            i++;
        }
        else if (!role_name.match(/^[A-Za-z0-9\s]+$/)) {
            $("#edit-error_name2").show();
            i++;
        }

        if(i == 0){
            $.ajax({
                url: $("#base-url").val()+"admin/update_role_details/",
                traditional: true,
                type: "post",
                dataType: "text",
                data: {role_name:role_name, id:id, role_status:role_status},
                success: function (result) {

                    var result = $.parseJSON(result);
                    if(result.status=='success'){
                        location.reload();
                    }
                    else{
                        alert("Oops there is something wrong!");
                    }
                },
                error: ajax_error_handling
            });
        }
    }






    $( "#newRoleSubmit" ).click(function() {
        hideErrorMessages();
        show_loading();
        var i=0;
        
        var role_name = $('#add-role-name').val();

        if(role_name == ""){
            $("#error_name").show();
            i++;
        }
        else if (!role_name.match(/^[A-Za-z0-9\s]+$/)) {
            $("#error_name2").show();
            i++;
        }


        if(i == 0){
            $.ajax({
                url: $("#base-url").val() + "admin/add_role",
                traditional: true,
                type: "post",
                dataType: "text",
                data: {role_name:role_name},
                success: function (result) {
                    var result = $.parseJSON(result);
                    if(result.status=='success'){
                        location.reload();
                    }
                    else if(result.status=='exist'){
                        $("#error_email2").show();
                        hide_loading();
                    }
                    else{
                        alert("Oops there is something wrong!");
                    }
                  
                },
                error: ajax_error_handling
            });
        }else{
            hide_loading();
        }
            
    });


