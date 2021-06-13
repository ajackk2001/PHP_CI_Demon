<!DOCTYPE html>
<html lang="zh-TW">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>資料傳輸中</title>
  <link rel="stylesheet" href="<?=version('style/front/css/all.min.css')?>">
</head>

<body>

  <div class="data-loading">
	<?php //兩種交易傳輸標題 ?>
	<div class="title mb-3"><?=$title?></div>
	<!-- <div class="title mb-3">回傳交易結果</div> -->
	<p class="iconloading"></p>
    <p class="mt-3"><i class="iconfont icon-Info"></i>資訊傳輸中................請稍後!!</p>
  </div>
  <form action="<?=$url?>" method="post" id="form">
    <?php if ($form): ?>
      <?php foreach ($form as $key => $value): ?>
      <input type="hidden" name="<?=$key?>" value='<?=$value?>' />
      <?php endforeach ?>
    <?php endif ?>
  </form>
  <script type="text/javascript">document.getElementById("form").submit();</script>

</body>

</html>
