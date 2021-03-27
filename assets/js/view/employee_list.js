    
    window.onload = hideErrorMessages();

    function hideErrorMessages(){
        $("#error_email").hide();
        $("#error_email2").hide();
        $("#error_email3").hide();
        $("#error_firstname").hide();
        $("#error_firstname2").hide();
        $("#error_lastname").hide();
        $("#error_lastname2").hide();
        $("#error_company").hide();

        $("#edit-error_firstname").hide();
        $("#edit-error_firstname2").hide();
        $("#edit-error_lastname").hide();
        $("#edit-error_lastname2").hide();
        $("#edit-error_email").hide();
        $("#edit-error_email2").hide();
        $("#edit-error_email3").hide();
        $("#edit-error_company").hide();
        
        
        hide_loading();
    }

    $(document).ready( function () {

        //$('#dataTables-user-log').DataTable();
        $('#dataTables-user-list').DataTable({
            "bFilter": true,
            "paging":   true,
            "iDisplayLength": 10,
            "order": [[ 0, "asc" ]]
            //"bDestroy": true,
        });
     } );

    function edit_employee_popup(first_name,last_name,email,id,company_id){
        $( "#edit-firstname" ).val(first_name);
        $( "#edit_last_name" ).val(last_name);
        $( "#edit-email" ).val(email);        
        $( "#edit-employee-id" ).val(id);
        $('#edit_company_id').empty();
        console.log(companylist)
        var company_status = JSON.parse(companylist);

        var select_role = company_id.substr(0,1).toUpperCase()+company_id.substr(1);

        var myselect2 = $('<select>');
        for (var i = 0; i < company_status.length; i++) {
            if(select_role==company_status[i].id)
                 myselect2.append($('<option selected></option>').val(company_status[i].id).html(company_status[i].name));
            else
                 myselect2.append($('<option ></option>').val(company_status[i].id).html(company_status[i].name));
           
        }
        $('#edit_company_id').append(myselect2.html());

        $('#editEmployeeSubmit').attr("onclick","update_employee_details("+id+")");
    }

    function deactivate_emp_confirmation(email,id){
        $( "#user-email" ).html(email);
        $('#deactivateYesButton').attr("onclick","deactivate_emp_submit('"+email+"',"+id+")");
    }

    function reset_confirmation(email,id){
        $( "#reset-user-email" ).html(email);
        $('#resetYesButton').attr("onclick","reset_submit('"+email+"',"+id+")");
    }

    function deactivate_emp_submit(email,id){
        show_loading();
            $.ajax({
            url: $("#base-url").val()+"admin/delete_employee/"+email+"/"+id,
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

    function update_employee_details(id){
        hideErrorMessages();
        show_loading();
        var i=0;
        var first_name = $('#edit-firstname').val();
        var last_name = $('#edit_last_name').val();
        var email = $('#edit-email').val();
        var company_id = $('#edit_company_id').val();
        
        if(first_name == ""){
            $("#edit-error_firstname").show();
            i++;
        }
        else if (!first_name.match(/^[A-Za-z0-9\s]+$/)) {
            $("#edit-error_firstname2").show();
            i++;
        }
        if(last_name == ""){
            $("#edit-error_lastname").show();
            i++;
        }
        else if (!last_name.match(/^[A-Za-z0-9\s]+$/)) {
            $("#edit-error_lastname2").show();
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

        if(company_id == 0){
            $("#edit-error_company").show();
            i++;
        } 

        if(i == 0){
            $.ajax({
                url: $("#base-url").val()+"admin/update_employee_details/",
                traditional: true,
                type: "post",
                dataType: "text",
                data: {first_name:first_name, id:id, last_name:last_name,email:email,company_id:company_id},
                success: function (result) {

                    var result = $.parseJSON(result);
                    if(result.status=='success'){
                        location.reload();
                    }else if(result.status=='exist'){
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






    $( "#newEmployeeSubmit" ).click(function() {
        hideErrorMessages();
        show_loading();
        var i=0;
        
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var email = $('#email').val();
        var company_id = $('#company_id').val();

        if(first_name == ""){
            $("#error_firstname").show();
            i++;
        }
        else if (!first_name.match(/^[A-Za-z0-9\s]+$/)) {
            $("#error_firstname2").show();
            i++;
        }
        if(last_name == ""){
            $("#error_lastname").show();
            i++;
        }
        else if (!last_name.match(/^[A-Za-z0-9\s]+$/)) {
            $("#error_lastname2").show();
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

        if(company_id == 0){
            $("#error_company").show();
            i++;
        }      


        if(i == 0){
            $.ajax({
                url: $("#base-url").val() + "admin/add_employee",
                traditional: true,
                type: "post",
                dataType: "text",
                data: {first_name:first_name,last_name:last_name,email:email,company_id:company_id},
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


