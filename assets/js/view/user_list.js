    
    window.onload = hideErrorMessages();

    function hideErrorMessages(){
        $("#error_email").hide();
        $("#error_email2").hide();
        $("#error_email3").hide();
        $("#error_name").hide();
        $("#error_name2").hide();
        $("#error_role").hide();
        $("#edit-error_email").hide();
        $("#edit-error_email2").hide();
        $("#edit-error_email3").hide();
        $("#edit-error_name").hide();
        $("#edit-error_name2").hide();
        $("#edit-error_role").hide();
        $("#edit-error_pass").hide();

        $("#erroredit_name").hide();
        $("#erroredit_name2").hide();
        $("#erroredit_email").hide();
        $("#erroredit_email2").hide();
        $("#erroredit_email3").hide();
        $("#edit-error_status").hide();


        
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

    function edit_user_popup(email,id,name,role,status){
        $( "#edit-email" ).val(email);
        $( "#edit-user-id" ).val(id);
        $( "#edit-name" ).val(name);
        $('#edit-role').empty();
        var role_status = JSON.parse(roles);

        var select_role = role.substr(0,1).toUpperCase()+role.substr(1);
        var myselect2 = $('<select>');
        for (var i = 0; i < role_status.length; i++) {
            if(select_role==role_status[i].role_name)
                 myselect2.append($('<option selected></option>').val(role_status[i].role_name).html(role_status[i].role_name));
            else
                 myselect2.append($('<option ></option>').val(role_status[i].role_name).html(role_status[i].role_name));
           
        }
        $('#edit-role').append(myselect2.html());
        
        if(status == 1)
           statsOption =  "<option value='1' selected>Active</option><option value='2'>Inactive</option>";
        else
            statsOption = "<option value='1' >Active</option><option value='2' selected>Inactive</option>"
            
        $( "#edit-status" ).html(statsOption);

        $('#editUserSubmit').attr("onclick","update_user_details("+id+")");
    }

    function deactivate_confirmation(email,id){
        $( "#user-email" ).html(email);
        $('#deactivateYesButton').attr("onclick","deactivate_submit('"+email+"',"+id+")");
    }

    function reset_confirmation(email,id){
        $( "#reset-user-email" ).html(email);
        $('#resetYesButton').attr("onclick","reset_submit('"+email+"',"+id+")");
    }

    function deactivate_submit(email,id){
        //show_loading();
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

    function update_user_details(id){
        hideErrorMessages();
        show_loading();
        var i=0;
        var name = $('#edit-name').val().trim();
        var email = $('#edit-email').val().trim();
        var role = $('#edit-role').val();
        var newPassword = $('#edit-newPassword').val();
        var status = $('#edit-status').val();


        if(name == ""){
            $("#edit-error_name").show();
            i++;
        }
        else if (!name.match(/^[A-Za-z0-9\s]+$/)) {
            $("#edit-error_name2").show();
            i++;
        }

        if(email == ""){
            $("#edit-error_email").show();
            i++;
        }
        else if (!email.match(/^[\w -._]+@[\-0-9a-zA-Z_.]+?\.[a-zA-Z]{2,3}$/)) {
            $("#edit-error_email3").show();
            i++;
        }

        if(role == 0){
            $("#edit-error_role").show();
            i++;
        }
        

        if(i == 0){
            $.ajax({
                url: $("#base-url").val()+"admin/update_user_details/",
                traditional: true,
                type: "post",
                dataType: "text",
                data: {email: email, id:id, name:name, role:role, newPassword:newPassword, status:status},
                success: function (result) {
                    var result = $.parseJSON(result);
                    if(result.status=='success'){
                        location.reload();
                    }
                    else if(result.status=='exist'){
                        $("#edit-error_email2").show();
                        hide_loading();
                    }
                    else{
                        alert("Oops there is something wrong!");
                    }
                },
                error: ajax_error_handling
            });
        }
    }






    $( "#newUserSubmit" ).click(function() {
        hideErrorMessages();
        show_loading();
        var i=0;
        var name = $('#name').val().trim();
        var email = $('#email').val().trim();
        var role = $('#role').val().trim();
        var newPassword = $('#create-newPassword').val().trim();

        if(name == ""){
            $("#error_name").show();
            i++;
        }
        else if (!name.match(/^[A-Za-z0-9\s]+$/)) {
            $("#error_name2").show();
            i++;
        }

        if(email == ""){
            $("#error_email").show();
            i++;
        }
        else if (!email.match(/^[\w -._]+@[\-0-9a-zA-Z_.]+?\.[a-zA-Z]{2,3}$/)) {
            $("#error_email3").show();
            i++;
        }

        if(role == 0){
            $("#error_role").show();
            i++;
        }
        if(newPassword == ""){
            $("#edit-error_pass").show();
            i++;
        }

        if(i == 0){
            $.ajax({
                url: $("#base-url").val() + "admin/add_user",
                traditional: true,
                type: "post",
                dataType: "text",
                data: {email:email, role:role, name:name, newPassword:newPassword},
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

    function update_user(){
        hideErrorMessages();
        show_loading();
        var i=0;
        var name = $('#profile-name').val().trim();
        var email = $('#profile-email').val().trim();
        var id  = $('#profile-role-id').val().trim();
        

        if(name == ""){
            $("#edit-error_name").show();
            i++;
        }
        else if (!name.match(/^[A-Za-z0-9\s]+$/)) {
            $("#edit-error_name2").show();
            i++;
        }

        if(email == ""){
            $("#edit-error_email").show();
            i++;
        }
        else if (!email.match(/^[\w -._]+@[\-0-9a-zA-Z_.]+?\.[a-zA-Z]{2,3}$/)) {
            $("#edit-error_email3").show();
            i++;
        }

        

        if(i == 0){
            $.ajax({
                url: $("#base-url").val()+"authentication/update_user/",
                traditional: true,
                type: "post",
                dataType: "text",
                data: {email: email, name:name, id:id},
                success: function (result) {
                    var result = $.parseJSON(result);
                    if(result.status=='success'){
                        location.reload();
                    }
                    else if(result.status=='exist'){
                        $("#edit-error_email2").show();
                        hide_loading();
                    }
                    else{
                        alert("Oops there is something wrong!");
                    }
                },
                error: ajax_error_handling
            });
        }
    }

