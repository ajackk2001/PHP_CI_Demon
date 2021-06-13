//!!!!限不限長寬
//moremore 是否多張 true 是 false否
//width   -寬
//height  -高
function fileuploader(id,moremore,width=null,height=null,maxWidth=null,maxHeight=null,imgExtensions=['jpg', 'jpeg', 'png', 'gif']){
  var ratio_str = (width!=null && height!=null)? width+':'+height:null;

  $('input[name="'+id+'"').fileuploader({
    changeInput: ' ',
    extensions: imgExtensions,
    theme: 'thumbnails',
    enableApi: true,
    addMore: moremore,
    thumbnails: {
      // 使用者加入圖片時，thumbnail 會顯示圖片
      // 這個事件就是顯示圖片時會被觸發的
      onImageLoaded: function(item, listEl, parentEl, newInputEl, inputEl) {
        // preload 伺服器圖片
        // 已經上傳過的圖片應已經符合要求，因此不處理
        if(item.data.is_sized)
          return;

        
        if ( ratio_str === null)
          return;
        
        //限制最小長寬
        if(item.reader.width < width || item.reader.height < height){
         swal({
           text:'圖檔 寬度需大於 '+width+'px, 高度需大於 '+height+'px',
           type:'warning'
         })
         item.remove();
         return;
        }

        // 已經符合長寬比
        if(Math.abs(item.reader.width/item.reader.height - width/height) <= 0.001){
          /**** 命名 ***/
          item.data.is_sized = true;
          return;
        }

        // 直接進入編輯 (讓使用者裁切成我們要的大小)
        item.popup.open(); //多圖註解
      },
      // 大部份抄預設的，只有 cancel 改掉
      // cancel 可能表示使用者沒有裁切，因此直接刪除要上傳的圖
      // 要注意不能只寫 cancel 事件，其他功能會是未定義
      popup: {
        onShow: function(item){
          item.editor.cropper();
          item.popup.html.on('click', '[data-action="prev"]', function(e) {
            item.popup.move('prev');
          }).on('click', '[data-action="next"]', function(e) {
            item.popup.move('next');
          }).on('click', '[data-action="crop"]', function(e) {
            if (item.editor)
              item.editor.cropper();
          }).on('click', '[data-action="rotate-cw"]', function(e) {
            if (item.editor)
              item.editor.rotate();
          }).on('click', '[data-action="remove"]', function(e) {
            item.popup.close();
            item.remove();
          }).on('click', '[data-action="cancel"]', function(e) {
            item.popup.close();
            if(item.data && item.data.is_sized !== true)
              item.remove();
          }).on('click', '[data-action="save"]', function(e) {
            if (item.editor)
              item.editor.save();
            if (item.popup.close)
              item.popup.close();
          });

          if(item.data && item.data.is_sized === true){
            $('[data-action="next"]').hide();
            $('[data-action="rotate-cw"]').hide();
            $('[data-action="remove"]').hide();

            $('.fileuploader-cropper-area').removeClass('fileuploader-cropper-area');
          }

          $('[data-action="crop"]').hide(); //裁切按鈕隱藏,變成一打開編輯圖片(修圖工具)時就顯示裁切框
          $('[data-action="cancel"]').hide(); //因按取消按鈕擇會刪除圖檔，為了不要跟刪除鈕混淆視聽，所以隱藏 
        },
      },
      box: '<div class="fileuploader-items">' +
      '<ul class="fileuploader-items-list">' +
      '<li class="fileuploader-thumbnails-input" id="'+id+'-input" ><div class="fileuploader-thumbnails-input-inner"><i>+</i></div></li>' +
      '</ul>' +
      '</div>',
      item: '<li class="fileuploader-item file-has-popup">' +
      '<div class="fileuploader-item-inner">' +
      '<div class="type-holder">${extension}</div>' +
      '<div class="actions-holder">' +
      '<a class="fileuploader-action fileuploader-action-sort" title="${captions.sort}"><i></i></a>' +
      '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' +
      '</div>' +
      '<div class="thumbnail-holder">' +
      '${image}' +
      '<span class="fileuploader-action-popup"></span>' +
      '</div>' +
      '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
      '<div class="progress-holder">${progressBar}</div>' +
      '</div>' +
      '</li>',
      item2: '<li class="fileuploader-item file-has-popup">' +
      '<div class="fileuploader-item-inner">' +
      '<div class="type-holder">${extension}</div>' +
      '<div class="actions-holder">' +
      '<a href="${file}" class="fileuploader-action fileuploader-action-download" title="${captions.download}" download><i></i></a>' +
      '<a class="fileuploader-action fileuploader-action-sort" title="${captions.sort}"><i></i></a>' +
      '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' +
      '</div>' +
      '<div class="thumbnail-holder">' +
      '${image}' +
      '<span class="fileuploader-action-popup"></span>' +
      '</div>' +
      '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
      '<div class="progress-holder">${progressBar}</div>' +
      '</div>' +
      '</li>',
      startImageRenderer: true,
      canvasImage: false,
      _selectors: {
        list: '.fileuploader-items-list',
        item: '.fileuploader-item',
        start: '.fileuploader-action-start',
        retry: '.fileuploader-action-retry',
        remove: '.fileuploader-action-remove'
      },
      onItemShow: function(item, listEl, parentEl, newInputEl, inputEl) {
        var plusInput = listEl.find('.fileuploader-thumbnails-input'),
          api = $.fileuploader.getInstance(inputEl.get(0));

        plusInput.insertAfter(item.html)[api.getOptions().limit && api.getFiles().length >= api.getOptions().limit ? 'hide' : 'show']();

        if(item.format == 'image') {
          item.html.find('.fileuploader-item-icon').hide();
        }
      }
    },
    dragDrop: {
      //container: '.fileuploader-thumbnails-input'
      container: '#'+id+'-input'
    },
    sorter: {
      selectorExclude: null,
      placeholder: null,
      scrollContainer: window,
      onSort: function(list, listEl, parentEl, newInputEl, inputEl) {
                var api = $.fileuploader.getInstance(inputEl.get(0)),
                    fileList = api.getFileList(),
                    _list = [];
                
                $.each(fileList, function(i, item) {
                    _list.push({
                        name: item.name,
                        index: item.index
                    });
                });
                
      }
    },
    afterRender: function(listEl, parentEl, newInputEl, inputEl) {
      var plusInput = listEl.find('.fileuploader-thumbnails-input'),
        api = $.fileuploader.getInstance(inputEl.get(0));

      plusInput.on('click', function() {
        api.open();
      });
    },
    onRemove: function(item, listEl, parentEl, newInputEl, inputEl) {
      var plusInput = listEl.find('.fileuploader-thumbnails-input'),
        api = $.fileuploader.getInstance(inputEl.get(0));

      if (api.getOptions().limit && api.getChoosedFiles().length - 1 < api.getOptions().limit)
        plusInput.show();
    },
    // 編輯器的選項
    // 參考 image-editor
    editor: {
      // editor cropper
      cropper: {
        // cropper ratio
        // example: null
        // example: '1:1'
        // example: '16:9'
        // you can also write your own
        // 長寬比
        ratio: ratio_str,

        // cropper minWidth in pixels
        // size is adjusted with the image natural width
        // 最小寬度
        minWidth: width,

        // cropper minHeight in pixels
        // size is adjusted with the image natural height
        // 最小高度
        minHeight: height,

        // show cropper grid
        // 裁切的框框內要不要有輔助對齊用九宮格
        showGrid: true
      },

      // editor on save quality (0 - 100)
      // only for client-side resizing
      // 儲存後畫質
      quality: 100,

      // editor on save maxWidth in pixels
      // only for client-side resizing
      // 儲存後最大寬度
      maxWidth: (maxWidth == null)? width:maxWidth,

      // editor on save maxHeight in pixels
      // only for client-size resizing
      // 儲存後最大高度
      maxHeight: (maxHeight == null)? height:maxHeight,
    },
    beforeShow: function(item, listEl, parentEl, newInputEl, inputEl) {
      // check image size and ratio?
      //alert(item.reader.width, item.reader.height);
    },
    // 這邊可以用 php 帶入資料
    files: null,
    // 翻譯成中文你懂的
    captions: {
      confirm: '確定',
      cancel: '取消',
      name: '檔名',
      type: '類型',
      size: '大小',
      dimensions: '寬高',
      duration: 'Duration',
      crop: '裁切',
      rotate: '旋轉',
      sort: '排序',
      download: '下載',
      remove: '刪除',
      drop: '拖移',
      removeConfirmation: '確定要刪除檔案嗎?',
      button: "選擇檔案",
      feedback: "選擇檔案上傳",
      feedback2: "檔案已選取",
      errors: {
        filesLimit: "只允許 ${limit} 格式上傳.",
        filesType: "只能上傳 ${extensions} 檔案",
        filesSize: "${name} 檔案太大! 檔案上傳上限為 ${maxSize} MB.",
        filesSizeAll: "您選擇的檔案過大! 檔案上傳上限為 ${maxSize} MB."
      }
    },
    // 這下面是給 ajax 上傳用的
    /*
    // while using upload option, please set
    // startImageRenderer: false
    // for a better effect
      upload: {
          url: './php/upload_file.php',
          data: null,
          type: 'POST',
          enctype: 'multipart/form-data',
          start: true,
          synchron: true,
          beforeSend: null,
          onSuccess: function(data, item) {
              item.html.find('.fileuploader-action-remove').addClass('fileuploader-action-success');


              setTimeout(function() {
                  item.html.find('.progress-holder').hide();
                  item.renderThumbnail();

                  item.html.find('.fileuploader-action-popup, .fileuploader-item-image').show();
              }, 400);
          },
          onError: function(item) {
              item.html.find('.progress-holder, .fileuploader-action-popup, .fileuploader-item-image').hide();
          },
          onProgress: function(data, item) {
              var progressBar = item.html.find('.progress-holder');

              if(progressBar.length > 0) {
                  progressBar.show();
                  progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
              }

              item.html.find('.fileuploader-action-popup, .fileuploader-item-image').hide();
          }
      },
      onRemove: function(item) {
          $.post('php/upload_remove.php', {
              file: item.name
          });
      }
     */
  });
  $('.fileuploader-theme-thumbnails').css({"background-color":"#fafbfd00","padding":"0px","margin":"16px 0"});

}