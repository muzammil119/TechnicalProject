    
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
        $("#edit-error_logo").hide();
        $("#error_website").hide();

        $("#erroredit_name").hide();
        $("#erroredit_name2").hide();
        $("#erroredit_email").hide();
        $("#erroredit_email2").hide();
        $("#erroredit_email3").hide();
        $("#edit-error_website").hide();


        
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

    function edit_company_popup(email,id,name,website){
        $( "#edit-email" ).val(email);
        $( "#company-id" ).val(id);
        $( "#edit-name" ).val(name);
        var logo = $('#com-log').attr('href');

        //$( "#edit-companylogo" ).val(logo);
        $( "#company-editlogo-path" ).val(logo);
        $( "#edit-website" ).val(website);
        $('#editCompanySubmit').attr("onclick","update_company_details("+id+")");
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
            url: $("#base-url").val()+"admin/delete_company/"+email+"/"+id,
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

    function update_company_details(id){
        hideErrorMessages();
        show_loading();
        var i=0;
        var name = $('#edit-name').val().trim();
        var email = $('#edit-email').val().trim();
        var logo = $('#company-editlogo-path').val();
        var website = $('#edit-website').val();
        
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

        if(logo == 0){
            $("#edit-error_logo").show();
            i++;
        }
        if(website == 0){
            $("#edit-error_website").show();
            i++;
        }
        

        if(i == 0){
            $.ajax({
                url: $("#base-url").val()+"admin/update_company_details/",
                traditional: true,
                type: "post",
                dataType: "text",
                data: {email: email, id:id, name:name, logo:logo, website:website},
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






    $( "#newCompanySubmit" ).click(function() {
        hideErrorMessages();
        show_loading();
        var i=0;
        var name = $('#name').val().trim();
        var email = $('#email').val().trim();
        var company_logo = $('#company-logo-path').val();
        var website = $('#create-website').val().trim();

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

        if(company_logo == ""){
            $("#error_role").show();
            i++;
        }
        if(website == ""){
            $("#edit-error_website").show();
            i++;
        }

        if(i == 0){
            $.ajax({
                url: $("#base-url").val() + "admin/add_company",
                traditional: true,
                type: "post",
                dataType: "text",
                data: {email:email, name:name,company_logo:company_logo, website:website},
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

    $(document).ready(function(){
         $(document).on('change', '#company_logo', function(){
          var name = document.getElementById("company_logo").files[0].name;
          var form_data = new FormData();
          var ext = name.split('.').pop().toLowerCase();
          if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
          {
            alert("Invalid Image File");
          }
          var oFReader = new FileReader();
          oFReader.readAsDataURL(document.getElementById("company_logo").files[0]);
          var f = document.getElementById("company_logo").files[0];
          var fsize = f.size||f.fileSize;
          if(fsize > 2000000)
          {
            alert("Image File Size is very big");
          }
          else
          {
           form_data.append("company_logo", document.getElementById('company_logo').files[0]);
               $.ajax({
                    url: $("#base-url").val() + "admin/upload_logo",
                    method:"POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    // beforeSend:function(){
                    //  $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
                    // },   
                    success:function(data)
                    {
                     //var result = $.parseJSON(data);
                     $('#company-logo-path').val(data);
                     $('#company-editlogo-path').val(data);
                    }
               });
          }
         });
    });
    $(document).ready(function(){
         $(document).on('change', '#edit-companylogo', function(){
          var name = document.getElementById("edit-companylogo").files[0].name;
          var form_data = new FormData();
          var ext = name.split('.').pop().toLowerCase();
          if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
          {
            alert("Invalid Image File");
          }
          var oFReader = new FileReader();
          oFReader.readAsDataURL(document.getElementById("edit-companylogo").files[0]);
          var f = document.getElementById("edit-companylogo").files[0];
          var fsize = f.size||f.fileSize;
          if(fsize > 2000000)
          {
            alert("Image File Size is very big");
          }
          else
          {
           form_data.append("company_logo", document.getElementById('edit-companylogo').files[0]);
               $.ajax({
                    url: $("#base-url").val() + "admin/upload_logo",
                    method:"POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    // beforeSend:function(){
                    //  $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
                    // },   
                    success:function(data)
                    {
                     //var result = $.parseJSON(data);
                     
                     $('#company-editlogo-path').val(data);
                    }
               });
          }
         });
    });