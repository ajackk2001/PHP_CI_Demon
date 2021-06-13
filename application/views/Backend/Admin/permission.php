<?php defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('Backend/layouts/head');?>
        <?php $this->load->view('Backend/layouts/stylesheet');?>
        <link href="/assets/plugins/jstree/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">
            <?php $this->load->view('Backend/layouts/topbar');?>
            <?php $this->load->view('Backend/layouts/menu');?>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        <?php $this->load->view('Backend/layouts/nav');?>
                        <!-- end row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form name="edit">
                                                <fieldset class="form-group">
                                                    <label for="exampleInputEmail1">管理員類型</label>
                                                    <select name="permission_type" class="form-control">
                                                        <option value="superadmin" <?=(($permission_type=='superadmin')?'selected':'')?>>最大權限</option>
                                                        <option value="manager" <?=(($permission_type=='manager')?'selected':'')?>>一般管理</option>
                                                        <!-- <option value="admin" <?=(($permission_type=='admin')?'selected':'')?>>客服人員</option> -->
                                                    </select>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="adminId">管理員帳號</label>
                                                    <input type="text" name="username" class="form-control" id="adminId" placeholder="管理員帳號" value="<?=$username?>" autocomplete="username">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="adminPW">管理員密碼</label>
                                                    <input type="password" name="password" class="form-control" id="adminPW" placeholder="管理員密碼" autocomplete="new-password">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="adminCheckPW">再次確認密碼</label>
                                                    <input type="password" name="passwords" class="form-control" id="adminCheckPW" placeholder="再次確認密碼" autocomplete="new-password">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="adminName">管理員名稱</label>
                                                    <input type="text" name="name" class="form-control" id="adminName" placeholder="管理員名稱" value="<?=$name?>">
                                                </fieldset>
                                            </form>
                                        </div>
                                        <fieldset class="form-group">
                                            <label for="checkTree2">權限管理</label>
                                            <div class="col-md-6" id="checkTree2">
                                                <?php foreach ($menus as $menu_id => $menu): ?>
                                                    <ul>
                                                        <li data-id="<?=$menu_id?>" data-jstree='{"opened":true<?=(in_array($menu_id, $permission) && count($menu['list'])==0|| ($permission_type=='superadmin' && count($permission)==0))?',"selected":true':''?>}'><?=$menu['modal']->title?>
                                                        <?php foreach ($menu['list'] as $list_id => $list): ?>
                                                            <ul>
                                                                <li data-id="<?=$list->menu_id?>" data-jstree='{"opened":true,"type":"file"<?=(in_array($list->menu_id, $permission))?',"selected":true':''?>}'><?=$list->title?></li>
                                                            </ul>
                                                        <?php endforeach; ?>
                                                        </li>
                                                    </ul>
                                                <?php endforeach; ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="center m-t-30">
                                        <button type="button" class="btn btn-secondary" onclick="history.go(-1)">回上一頁</button>
                                        <button type="button" class="btn btn-primary save">儲存</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                    </div> <!-- container -->

                </div> <!-- content -->
            </div>
            <!-- End content-page -->
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
            <!-- Right Sidebar -->
            <?php $this->load->view('Backend/layouts/right_sidebar');?>
            <!-- /Right-bar -->
            <?php $this->load->view('Backend/layouts/footer');?>
        </div>
        <!-- END wrapper -->
        <?php $this->load->view('Backend/layouts/script');?>
        <script src="/assets/plugins/jstree/jstree.min.js"></script>
        <script src="/assets/pages/jquery.tree.js"></script>
        <script type="text/javascript">
            var update_ajax	=	'/Backend/Admin/AdminUpdate/<?=$id?>';
            $('.save').click(function(){
            	var permission 	=	[];
                var form        =   $('form[name=edit]').serialize();
                $('.jstree-undetermined,.jstree-clicked').each(function(){
                	permission.push($(this).parents('li').data('id'));
                });
                $.ajax({
                    url:update_ajax,
                    type:'POST',
                    dataType:'JSON',
                    data:form+'&permission='+permission,
                    beforeSend: function () { waitingDialog.show(); }
                }).always(function () {
                    waitingDialog.hide();
                }).done(function(result){
                        ResultData2(result);
                });
            });

            $('#checkTree2').jstree({
				'core' : {
					'themes' : {
						'responsive': false
					}
				},
		        'types' : {
		            'default' : {
		                'icon' : 'fa fa-folder'
		            },
		            'file' : {
		                'icon' : 'fa fa-file'
		            }
		        },
		        'plugins' : ['types', 'checkbox']
		    });
            
        </script>
    </body>
</html>