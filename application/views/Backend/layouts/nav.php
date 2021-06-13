<div class="row">
    <div class="col-xl-12">
        <div class="page-title-box">
            <h4 class="page-title float-left"><?=@$this->current->title?></h4>
            <ol class="breadcrumb float-right">
                <!-- <li class="breadcrumb-item"><a href="/Backend/Dashboard">後台管理首頁</a></li> -->
                <?php foreach ($this->nav as $k => $v):?>
                    <li class="breadcrumb-item">
                    <?php if($v->url != "javascript:void(0);"):?>
                        <a href="<?=$v->url?>"><?=$v->title?></a>
                    <?php else: ?>
                        <?=$v->title?>
                    <?php endif; ?>
                    </li>
                <?php endforeach;?>
                <?php if(isset($this->current->title)): ?>
                    <li class="breadcrumb-item active"><?=$this->current->title?></li>
                <?php endif; ?>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>