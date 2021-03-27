

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><?=$title?></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <?php if($this->session->flashdata('success')):?>
                <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong><?php echo $this->session->flashdata('success'); ?></strong>
                </div>
            <?php elseif($this->session->flashdata('error')):?>
                <div class="alert alert-warning">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong><?php echo $this->session->flashdata('error'); ?></strong>
                </div>
            <?php endif;?>
            <div class="row">
                <div class="col-lg-12">      
                    <table class="table table-striped table-bordered table-hover" id="dataTables-user-list">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Created Date</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($employee_list  as $row): 
                                   
                                ?>
                            <tr>
                                <td><?php echo $row->first_name; ?></td> 
                                <td><?php echo $row->last_name; ?></td>
                                <td><?php echo $row->email; ?></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->created_date; ?></td>
                                
                                
                                
                                <td>
                                    <a class="btn btn-primary" id="user-edit"  onclick="edit_employee_popup('<?=$row->first_name?>','<?=$row->last_name?>','<?=$row->email?>','<?=$row->employee_id?>','<?=$row->company_id?>');" data-toggle="modal" data-target="#editUser"> EDIT </a>
                                    
                                    <a class="btn btn-danger" id="user-delete" onclick="deactivate_emp_confirmation('<?=$row->email?>','<?=$row->employee_id?>');" data-toggle="modal" data-target="#deactivateConfirm"> DELETE </a>
                                    
                                </td>

                            </tr>
                            <?php endforeach; ?>
                            
                        </tbody>
                    </table>

                    <div class="col-lg-12" style="position:fixed;bottom: 5%;left: 88%; width: 150px;text-align: center;border-radius: 100%;">
                        <img class="add_user" src="<?=base_url()?>assets/images/add.png" data-toggle="modal" data-target="#addRole" />
                    </div>

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>



        <!-- Modal -->
        <div class="modal fade" id="deactivateConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-red">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">DELETE CONFIRMATION</h4>
                    </div>
                    <div class="modal-body">
                        <label>You are going to delete user <label id="user-email" style="color:blue;"></label>.</label><br/>
                        <label>Click <b>Yes</b> to continue.</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a id="deactivateYesButton" class="btn btn-danger" >Yes</a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!-- Modal -->
        <div class="modal fade" id="resetConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-red">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">RESET CONFIRMATION</h4>
                    </div>
                    <div class="modal-body">
                        <label>You are going to reset user <label id="reset-user-email" style="color:blue;"></label>'s password.</label><br/>
                        <label>Tempolary password will be sent to this email.</label><br/>
                        <label>Click <b>Yes</b> to continue.</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a id="resetYesButton" class="btn btn-warning" >Yes</a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->




        <div class="modal fade" id="addRole" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-blue">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">ADD NEW EMPLOYEE</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>First Name</label> &nbsp;&nbsp;
                                    <label class="error" id="error_firstname"> field is required.</label>
                                    <label class="error" id="error_firstname2"> name must be alphanumeric.</label>
                                    <input class="form-control" id="first_name" placeholder="First Name" name="first_name" type="text" autofocus>
                                </div> 
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Last Name</label> &nbsp;&nbsp;
                                    <label class="error" id="error_lastname"> field is required.</label>
                                    <label class="error" id="error_lastname2"> name must be alphanumeric.</label>                                 
                                    <input class="form-control" id="last_name" placeholder="Last Name" name="last_name" type="text" autofocus>
                                </div> 
                            </div>
                      </div>
                      <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Email</label> &nbsp;&nbsp;
                                    <label class="error" id="error_email"> field is required.</label>
                                    <label class="error" id="error_email2"> email has already exist.</label>
                                    <label class="error" id="error_email3"> invalid email adress.</label>
                                    <input class="form-control" id="email" placeholder="E-mail" name="email" type="email" autofocus>
                                </div> 
                            </div>
                            <div class="col-lg-6">
                             <div class="form-group">
                                    <label>Company</label>&nbsp;&nbsp;
                                    <label class="error" id="error_company"> field is required.</label>
                                    <select name="company_id" id="company_id" class=" form-control">
                                        <option value="0" selected="selected">-- SELECT COMPANY --</option>
                                        <?php foreach($company_list as $list){  ?>
                                        <option value="<?=$list->id?>"><?=$list->name?></option>
                                        <?php } ?>                                      
                                    </select>
                                </div>
                             </div>
                      </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                        <button id="newEmployeeSubmit" type="button" class="btn btn-primary">ADD</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


        <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-blue">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">UPDATE EMPLOYEE DETAILS</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden"  id="edit-employee-id" value=""/>
                       
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Name</label> &nbsp;&nbsp;
                                    <label class="error" id="edit-error_firstname"> field is required.</label>
                                    <label class="error" id="edit-error_firstname2"> name must be alphanumeric.</label>
                                    <input class="form-control" id="edit-firstname" placeholder="Name" name="edit-firstname" type="text" autofocus>
                                </div> 
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Last Name</label> &nbsp;&nbsp;
                                    <label class="error" id="edit-error_lastname"> field is required.</label>
                                    <label class="error" id="edit-error_lastname2"> name must be alphanumeric.</label>                                 
                                    <input class="form-control" id="edit_last_name" placeholder="Last Name" name="edit_last_name" type="text" autofocus>
                                </div> 
                            </div>
                      </div>
                      <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Email</label> &nbsp;&nbsp;
                                    <label class="error" id="edit-error_email"> field is required.</label>
                                    <label class="error" id="edit-error_email2"> email has already exist.</label>
                                    <label class="error" id="edit-error_email3"> invalid email adress.</label>
                                    <input class="form-control" id="edit-email" placeholder="E-mail" name="edit-email" type="edit-email" autofocus>
                                </div> 
                            </div>
                            <div class="col-lg-6">
                             <div class="form-group">
                                    <label>Company</label>&nbsp;&nbsp;
                                    <label class="error" id="edit-error_company"> field is required.</label>
                                    <select name="edit_company_id" id="edit_company_id" class="form-control" >
                                        <option value="0" selected="selected">-- SELECT COMPANY --</option>
                                         <option value="1">User</option>
                                    </select>                                   
                                </div>
                             </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                        <button id="editEmployeeSubmit" type="button" class="btn btn-primary">UPDATE</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
       
        <!-- /#page-wrapper -->
        <?php $this->load->view('frame/footer_view')?>
        <script type="text/javascript">
            var companylist = '<?php echo json_encode($company_list); ?>';
        </script>
        <script src="<?=base_url()?>assets/js/view/employee_list.js"></script>