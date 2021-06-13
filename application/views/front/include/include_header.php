<header>
    <?php if ($this->set->give_away_point==1&&$this->session->userdata('user')): ?>
        <div id="AwardBox" style="display: none;">
            <ul>
                <?php foreach ($this->give_away_log as $k => $v): ?>
                    <li class="day<?=$k+1?>" id="<?=$v->title?>" data-id="<?=$v->id?>" data-date="<?=$v->result_date?>" >
                        <img src="/assets/images/front/btn-tick.png" class="btn-tick" style="<?=$v->status==1?'':'display: none;'?>">
                        <?php if ($v->status==2): ?>
                            <img src="/assets/images/front/btn-close.png" class="btn-tick">
                        <?php endif ?>
                        <img class="click-me" src="/<?=$v->img?>">
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>
    <div class="container-fluid">
        <div id="menubox" class="row">
            <a href="/" class="col-form-label logo" data-scroll><img src="/<?=$this->web_img?>"></a>
            <ul class="col-6 unit-menu">
                <li class="nav-item d-none"> <a class="nav-link" href="/video">視頻</a></li>
                <li class="nav-item"> <a class="nav-link" href="/album">寫真</a></li>
                <?php if (!empty($this->about_theme)): ?>
                    <?php foreach ($this->about_theme as $k => $v): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/album?type_id=<?=$v->type_id?>&category_id=<?=$v->category_id?>"><?=$v->title?></a>
                        </li>
                    <?php endforeach ?>
                <?php endif ?>
                <!-- <li class="nav-item"> <a class="nav-link" href="/typeAlbum">大尺度寫真</a></li> -->
                <li class="nav-item d-none"> <a class="nav-link" href="/special">特別企劃</a></li>
                <li class="nav-item"> <a class="nav-link" href="/models">Girls</a></li>
                <li class="nav-item"> <a class="nav-link" href="/creator">創作者</a></li>
            </ul>
            <div class="member-func">
                <ul>
                    <?php if ($this->set->give_away_point==1&&$this->session->userdata('user')): ?>
                        <li class="nav-item">
                            <a class="nav-link dailySignin" href="#">
                                <i class="far fa-calendar-check"></i>
                            </a>
                        </li>
                    <?php endif ?>
                    <li class="nav-item">
                        <a class="nav-link chat-notify" href="/member/chat">
                            <i class="fas fa-comment-dots chat"></i>
                            <!-- 未讀提示數字 -->
                            <?php if ($this->chat_list_quantitye >0): ?>
                                <span class="badge badge-danger read_num"><?=$this->chat_list_quantitye?></span>
                            <?php endif ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link notify-mobile" href="/notification">
                            <i class="fas fa-bell bee"></i>
                        <?php if ($this->msg_unread_quantitye>0): ?>
                            <!-- 未讀提示數字 -->
                            <span class="badge badge-danger"><?=$this->msg_unread_quantitye?></span>
                         <?php endif ?>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if ($this->session->userdata('user')): ?>
                            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php else: ?>
                            <a class="btn" href="/member/login" role="button">
                        <?php endif ?>
                            <i class="fas fa-user-circle"></i>
                        </a>
                        <?php if ($this->session->userdata('user')): ?>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item name" href="#"><?=$this->session->userdata('user')['nickname'].$this->type_title ?></a>
                                <a href="/member/detail">基本資料</a>
                                <a href="/member/infoEdit">編輯基本資料</a>
                                <a href="/member/collection">最愛收藏</a>
                                <a href="/member/purchasedItem">購買紀錄</a>
                                <a href="/member/pointOrder">訂單記錄</a>
                                <a href="/member/pointRecord">點數紀錄</a>
                                <?php if ($this->session->userdata('user')['type']!=1): ?>
                                    <?php if ($this->session->userdata('user')['type']==2): ?>
                                         <a href="/member/chat_list"><i class="fas fa-award" style="width: 19px;"></i>聊天管理</a>
                                    <?php endif ?>
                                    <a href="/member/productShelf"><i class="fas fa-award" style="width: 19px;"></i>作品上架</a>
                                    <a href="/member/incomeRecord"><i class="fas fa-award" style="width: 19px;"></i>收入紀錄</a>
                                    <a href="/member/exchangeCash"><i class="fas fa-award" style="width: 19px;"></i>收入提領</a>
                                <?php endif ?>
                                <a href="/member/logout">登出</a>
                            </div>
                        <?php endif ?>
                    </li>
                    <li class="nav-item"> <a class="nav-link diamond" href="/pointPlan"><i class="far fa-gem"></i><span id="member_point"><?=$this->points_total?></span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="overlay" id="overlay"> </div>
    <nav class="navbar navbar-inverse" id="navbar" role="navigation">
        <div class="container-fluid">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle button_container" id="toggle"> <span class="top"></span> <span class="middle"></span> <span class="bottom"></span> </button>
            <a href="/" class="navbar-brand brand-logo"><img src="/<?=$this->web_img?>"></a>
            <div id="navbarCollapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right" id="accordion">
                    <?php if ($this->set->give_away_point==1&&$this->session->userdata('user')): ?>
                        <li class="nav-item">
                            <a class="nav-link dailySignin" href="#">
                                <i class="far fa-calendar-check"></i>每日簽到
                            </a>
                        </li>
                    <?php endif ?>
                    <li class="nav-item d-none"> <a class="nav-link" href="/video">視頻</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="/album">寫真</a> </li>
                    <?php if (!empty($this->about_theme)): ?>
                        <?php foreach ($this->about_theme as $k => $v): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/album?type_id=<?=$v->type_id?>&category_id=<?=$v->category_id?>"><?=$v->title?></a>
                            </li>
                        <?php endforeach ?>
                    <?php endif ?>
                    <li class="nav-item"> <a class="nav-link" href="/special">特別企劃</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="/models">Girls</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="/creator">創作者</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="/pointPlan">購買方案</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="/member">會員中心</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/terms">使用條款</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="/privacy">隱私權</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="/contact">聯絡我們</a> </li>
                </ul>
            </div>
            <div class="member-func">
                <ul>
                    <li class="nav-item">
                        <a class="nav-link chat-notify" href="/member/chat">
                            <i class="fas fa-comment-dots chat"></i>
                            <?php if ($this->chat_list_quantitye>0): ?>
                                <!-- 未讀提示數字 -->
                                <span class="badge badge-danger read_num"><?=$this->chat_list_quantitye?></span>
                            <?php endif ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link notify-mobile" href="/notification">
                            <i class="fas fa-bell bee"></i>
                            <!-- 未讀提示數字 -->
                            <?php if ($this->msg_unread_quantitye>0): ?>
                                <span class="badge badge-danger"><?=$this->msg_unread_quantitye?></span>
                            <?php endif ?>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if ($this->session->userdata('user')): ?>
                           <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php else: ?>
                            <a class="btn" href="/member/login" role="button">
                        <?php endif ?>
                            <i class="fas fa-user-circle"></i>
                        </a>
                        <?php if ($this->session->userdata('user')): ?>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item name" href="#"><?=$this->session->userdata('user')['nickname'].$this->type_title ?></a>
                                <a href="/member/detail">基本資料</a>
                                <a href="/member/infoEdit">編輯基本資料</a>
                                <a href="/member/collection">最愛收藏</a>
                                <a href="/member/purchasedItem">購買紀錄</a>
                                <a href="/member/pointOrder">訂單記錄</a>
                                <a href="/member/pointRecord">點數紀錄</a>
                                <?php if ($this->session->userdata('user')['type']!=1): ?>
                                    <?php if ($this->session->userdata('user')['type']==2): ?>
                                        <a href="/member/chat_list"><i class="fas fa-award" style="width: 19px;"></i>聊天管理</a>
                                    <?php endif ?>
                                    <a href="/member/productShelf"><i class="fas fa-award" style="width: 19px;"></i>作品上架</a>
                                    <a href="/member/incomeRecord"><i class="fas fa-award" style="width: 19px;"></i>收入紀錄</a>
                                    <a href="/member/exchangeCash"><i class="fas fa-award" style="width: 19px;"></i>收入提領</a>
                                <?php endif ?>
                                <a href="/member/logout">登出</a>
                            </div>
                        <?php endif ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>