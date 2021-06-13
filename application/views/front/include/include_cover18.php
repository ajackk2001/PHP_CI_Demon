<?php if (!$this->session->userdata('over18')): ?>
    <div class="cover18">
        <div class="area18">
            <img src="/assets/images/front/age-limit-sign.png">
            <div class="btn_area">
                <div class="card">
                    <div class="card-body">
                        <h3 style="font-size: 24px;">提醒</h3>
                        <p>本站部分商品可能含有成人內容，你必須年滿18歲才能進入</p>
                        <button onclick=" location.href = 'https://www.google.com/'" type="button" class="btn btn-outline-secondary" style="margin-right: 1rem;">離開</button>
                        <button type="button" id="over18" class="btn btn-primary">我已滿18歲！進入</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
