<div class="side-bar right-bar">
    <div class="nicescroll">
        <ul class="nav nav-pills nav-justified text-xs-center">
            <!-- <li class="nav-item">
                <a href="#loginhistory"  class="nav-link active" data-toggle="tab" aria-expanded="false">
                    登入記錄
                </a>
            </li> -->
            <li class="nav-item">
                <a href="#actionhistory" class="nav-link active" data-toggle="tab" aria-expanded="true">
                    操作記錄
                </a>
            </li>
        </ul>

        <div class="tab-content">
            
            <?php if(in_array(79, $this->session->userdata('Manager')->menu_permission)||$this->issuper): ?>
            <div class="tab-pane fade  active show" id="actionhistory">
                <div class="timeline-2">
                    <?php foreach ($this->operation_record as $k => $record): ?>
                        <div class="time-item">
                            <div class="item-info">
                                <small class="text-muted"><?=$record->name.'-'.$record->date_add?></small>
                                <p><strong><?=$record->action?></strong></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-block btn-sm btn-info" onclick="location.href='/Backend/Operation/Record'">全部紀錄</button>
            </div>
            <?php endif; ?>
        </div>
    </div> <!-- end nicescroll -->
</div>