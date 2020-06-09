$ ().ready (function () {
  try {
    getWeixinInfo ($ ('#getwxJS').attr ('wid'), $ ('#getwxJS').attr ('gid'));
  } catch (e) {
    console.error(e)
  }
});

function getWeixinInfo (id, gid) {
  
  var hasNoId = typeof id == 'undefined' || $.trim (id).length == 0;
  
  var url = new URL(location.href + '/get.php');
  if (!hasNoId) {
    url.searchParams.append('wid', id);
  }
  if (typeof gid === 'string' &&  $.trim (gid).length) {
    url.searchParams.append ('gid', gid);
  }

  $.get (url.toString(), null, function (data) {
    var jsonData;
    try {
      jsonData = JSON.parse (data);
      if (jsonData.code == 0) {
        var wxNum = jsonData.data.wxNum;
        /*
             在你的html中自定义一个元素，id为wxNumTextContainer。
             调用getwx.js后，将会在指定容器内显示并统计该微信号码
             */
        $ ('.wxNumTextContainer').html (wxNum);
        if (hasNoId) {
          doAnalysis (jsonData.data.wxId);
        }
      } else {
        console.warn(jsonData.msg || jsonData)
      }
    } catch (e) {
      console.error (jsonData);
    }
  });
}

function doAnalysis (id) {
  $.get ('/get.php?wid=' + id, null, function (data) {
    var jsonData = JSON.parse (data);
    console.log (jsonData.code == 0 ? '有效统计' : '无效统计');
  });
}
