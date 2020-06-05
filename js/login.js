$().ready(function(){

  $("#loginForm").submit(function(e){
    e.preventDefault();

    var inputName = $.trim($('#inputEmail').val());
    var inputPassword = $.trim($('#inputPassword').val());
    var params = {uname:inputName,passd:inputPassword};

    $.post('/utils/user.php',params,function(data){
      var jsonData = JSON.parse(eval(data));
      if(jsonData.code == 0){
        window.location.href = '/manager.php';
      }else{
        layer.msg(jsonData.msg, {
          time: 5000,
          btn: ['知道了','怎么可能']
        });
      }
    });

  });

});
