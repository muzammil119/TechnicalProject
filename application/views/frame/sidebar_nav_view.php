            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <?php echo '<p class="welcome"><b> <text style="font-size:150%;">&#9786</text> <i>Welcome </i>' . $this->session->userdata('name') . "!</b></p>"; ?>
                        </li>
                        <li>
                            <a href="<?=base_url()?>"><i class="fa fa-home fa-fw"></i> Dashboard</a>
                        </li>
                        <?php if($this->session->userdata('role') == 'Admin'): ?>
                           <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> Menu<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li> <a href="<?=base_url('admin/company_list')?>">&raquo; Company List</a> </li>
                                <li> <a href="<?=base_url('admin/employee_list')?>">&raquo; Employee List</a> </li>
                                
                            </ul>
                            
                        </li>
                        <?php endif; ?>
                        
                        <li><a href="#" data-toggle="modal" data-target="#editprofileModal"><i class="fa fa-refresh fa-fw"></i> Edit Profile</a></li>

                        <li><a href="#" data-toggle="modal" data-target="#changePasswordModal"><i class="fa fa-refresh fa-fw"></i> Change Password</a></li>
                        <li class="divider"></li>
                        <li><a href="<?=base_url();?>authentication/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                        
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        