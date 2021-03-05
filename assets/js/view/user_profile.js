        window.onload = hideErrorMessages();

    function hideErrorMessages(){
        

        $("#erroredit_name").hide();
        $("#erroredit_name2").hide();
        $("#erroredit_email").hide();
        $("#erroredit_email2").hide();
        $("#erroredit_email3").hide();

        
        hide_loading();
    }
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
