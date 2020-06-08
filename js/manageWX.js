$ ().ready (function () {
  $ ('#addWXBtn').click (function (e) {
    e.preventDefault ();

    layer.prompt ({title: '输入微信号，并确认', formType: 0}, function (wxNum, index) {
      layer.close (index);
      layer.prompt ({title: '复制可用的二维码图片网址，并确认', formType: 2}, function (
        wxQRCodeUrl,
        index
      ) {
        layer.close (index);
        addWeixinData (wxNum, wxQRCodeUrl);
      });
    });
  });

  $ ('#addOptBtn').click (function (e) {
    e.preventDefault ();
    layer.prompt ({title: '输入用户组名称', formType: 0}, function (
      wxGroupName,
      index
    ) {
      layer.close (index);
      addWeixinGroup (wxGroupName);
    });
  });

  $ ('#loginOutBtn').click (function (e) {
    e.preventDefault ();
    layer.confirm (
      '确定要退出登录？',
      {
        btn: ['点错了', '确定了'],
      },
      function () {
        layer.msg ('没事别瞎点嘛~', {icon: 5});
      },
      function () {
        window.location.href = '/utils/loginOut.php';
      }
    );
  });
});

function addWeixinData (wxNum, wxQRCodeUrl) {
  $.post (
    '/utils/manageDao.php',
    {type: 0, id: wxNum, url: wxQRCodeUrl},
    function (data) {
      var jsonData = JSON.parse (data);
      if (jsonData.code == 0) {
        window.location.reload ();
      } else {
        layer.msg (jsonData.msg, {icon: 5});
      }
    }
  );
}

function addWeixinGroup (name) {
  $.post ('/utils/manageDao.php', {type: -1, name: name}, function (data) {
    var jsonData = JSON.parse (data);
    if (jsonData.code == 0) {
      window.location.reload ();
    } else {
      layer.msg (jsonData.msg, {icon: 5});
    }
  });
}

function stateChange (wid, state) {
  var currentState = parseInt (state) == 0 ? 1 : 0;
  $.post (
    '/utils/manageDao.php',
    {type: 1, id: wid, state: currentState},
    function (data) {
      var jsonData = JSON.parse (data);
      if (jsonData.code == 0) {
        window.location.reload ();
      } else {
        layer.msg (jsonData.msg, {icon: 5});
      }
    }
  );
}

function deleteWX (wid) {
  layer.confirm (
    '你十分确定要删除这条记录？',
    {
      btn: ['容朕想想', '确定删除'],
    },
    function () {
      layer.msg ('删除失败', {icon: 5});
    },
    function () {
      $.post ('/utils/manageDao.php', {type: 2, id: wid}, function (data) {
        var jsonData = JSON.parse (data);
        if (jsonData.code == 0) {
          layer.msg ('删除成功', {icon: 1});
          window.location.reload ();
        } else {
          layer.msg (jsonData.msg, {icon: 5});
        }
      });
    }
  );
}
