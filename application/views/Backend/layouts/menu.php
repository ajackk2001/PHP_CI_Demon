<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <?php foreach($this->menu as $key => $val):?>
                    <li class="has_sub">
                        <a href="<?=$val['data']->url?>" class="waves-effect"><i class="<?=$val['data']->icon_image?>"></i><span><?=$val['data']->title?></span> <?=isset($val['sub'])?'<span class="menu-arrow"></span>':''?></a>
                        <?php if(isset($val['sub'])):?>
                            <ul class="list-unstyled">
                                <?php foreach($val['sub'] as $k => $v):?>
                                <li><a href="<?=$v->url?>"><?=$v->title?></a></li>
                                <?php endforeach;?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach;?>
            </ul>
            <div class="clearfix"></div>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
</div>
