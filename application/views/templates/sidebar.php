<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="<?php echo base_url(); ?>assets/images/user.png" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php $username = $this->session->userdata('username');
            echo ucwords($username);?></div>
            <div class="email"><?php echo $this->session->userdata('email');?></div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="<?php echo site_url('dashboard/change_password/'.$username);?>"><i class="material-icons">account_circle</i>Change Password</a></li>
                    <li><a href="<?php echo site_url('dashboard/logout');?>"><i class="material-icons">input</i>Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active"></li>
            <?php
            $level = $this->session->userdata('level');
            if ($level == "admin"){ ?>
                <li class="">
                    <a href="<?php echo base_url(); ?>dashboard">
                    <i class="material-icons">home</i>
                    <span>Dashboard</span>
                    </a>
                </li>
                <li class="">
                    <a href="<?php echo base_url(); ?>lampu">
                    <i class="material-icons">wb_incandescent</i>
                    <span>Lampu</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>ac">
                    <i class="material-icons">ac_unit</i>
                    <span>AC</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>admin">
                    <i class="material-icons">account_box</i>
                    <span>Administrator</span>
                    </a>
                </li>
                <?php } else { ?>
                <li class="">
                    <a href="<?php echo base_url(); ?>dashboard">
                    <i class="material-icons">home</i>
                    <span>Dashboard</span>
                    </a>
                </li>
                <li class="">
                    <a href="<?php echo base_url(); ?>lampu">
                    <i class="material-icons">wb_incandescent</i>
                    <span>Lampu</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>ac">
                    <i class="material-icons">ac_unit</i>
                    <span>AC</span>
                    </a>
                </li>
            <?php } ?>   
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
        &copy; 2017 <a href="javascript:void(0);">User - Smart Home</a>.
        </div>
        <div class="version">
            <b>Version: </b> 0.1
        </div>
    </div>
    <!-- #Footer -->
</aside>