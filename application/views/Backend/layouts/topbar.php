<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <a href="/Backend/Dashboard" class="logo">
            <i class="fa  fa-user icon-c-logo"></i>
            <span>您好 ! <?=$this->session->userdata('Manager')->name?></span></a>
    </div>

    <nav class="navbar-custom">

        <ul class="list-inline float-right mb-0">
            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link arrow-none waves-light waves-effect" target="_blank" href="/" title="查看前台">
                    <i class="zmdi zmdi zmdi-eye noti-icon"></i>
                </a>
            </li>
            <?php if(in_array(9, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <i class="zmdi zmdi-account-circle noti-icon"></i>
                    <!-- <span class="noti-icon-badge"></span> -->
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-lg" aria-labelledby="Preview">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <!-- <h5><small><span class="label label-danger pull-xs-right"><?=count($this->record)?></span>登入紀錄</small></h5> -->
                        <h5><small></span>登入紀錄</small></h5>
                    </div>
                    <?php foreach ($this->record as $key => $data): ?>
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-info"><i class="icon-user"></i></div>
                            <p class="notify-details"><?=$data->name?>-登入管理系統<small class="text-muted"><?=$data->create_time?></small></p>
                            <p class="notify-details"><small class="text-muted">IP : <?=$data->ip?></small></p>
                        </a>    
                    <?php endforeach; ?>
                    <!-- All-->
                    <a href="/Backend/Admin/LoginRecord" class="text-center dropdown-item notify-item notify-all">全部紀錄</a>
                </div>
            </li>
            <?php endif; ?>
            <?php if(in_array(79, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link waves-effect waves-light right-bar-toggle" href="javascript:void(0);">
                    <i class="zmdi zmdi-format-subject noti-icon"></i>
                </a>
            </li>
            <?php endif; ?>
            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                     <i class="fa fa-gear noti-icon"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">
                    <a href="javascript:void(0);" class="dropdown-item notify-item" data-toggle="modal" data-target="#changepassword">
                        <i class="zmdi zmdi zmdi-key"></i> <span>修改密碼</span>
                    </a>
                    <?php if($this->issuper):?>
                    <a href="/Backend/Admin" class="dropdown-item notify-item">
                        <i class="zmdi zmdi-settings"></i> <span>管理設定</span>
                    </a>
                    <?php endif;?>
                    <a href="/Backend/Logout" class="dropdown-item notify-item">
                        <i class="zmdi zmdi-power"></i> <span>登出</span>
                    </a>
                </div>
            </li>
        </ul>
        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left waves-light waves-effect">
                    <i class="zmdi zmdi-menu"></i>
                </button>
            </li>
            <!-- <li class="hidden-mobile app-search">
                <form role="search" class="">
                    <input type="text" placeholder="Search..." class="form-control">
                    <a href=""><i class="fa fa-search"></i></a>
                </form>
            </li> -->
        </ul>
    </nav>
</div>
<!-- Modal -->
<div class="modal fade bd-example-modal-sm" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">修改密碼</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <form class="changePass" name="changePass" enctype="multipart/form-data">
                <div class="modal-body">
                    <fieldset class="form-group">
                        <label for="oldpw">舊密碼</label>
                        <input type="password" class="form-control" name="oldpw" id="oldpw" placeholder="Password" autocomplete="current-password">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="newpw">新密碼</label>
                        <input type="password" class="form-control" name="newpw" id="newpw" placeholder="Password" autocomplete="new-password">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="confirmpw">確認新密碼</label>
                        <input type="password" class="form-control" name="confirmpw" id="confirmpw" placeholder="Password" autocomplete="new-password">
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary changePassClose" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">送出</button>
                </div>
            </form>
        </div>
    </div>
</div>