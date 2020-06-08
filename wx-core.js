$().ready(function(){
    getWeixinInfo();
});

function getWeixinInfo(id){
    var hasNoId = typeof id == 'undefined' || $.trim(id).length == 0;
    $.get(hasNoId ? 'http://weixin.hujiakang.com/get.php' : 'http://weixin.hujiakang.com/get.php?wid='+id,null,function(data){
        var jsonData = JSON.parse(data);
        if(jsonData.code == 0){
            var wxNum = jsonData.data.wxNum;
            /*
             在你的html中自定义一个元素，id为wxNumTextContainer。
             调用getwx.js后，将会在指定容器内显示并统计该微信号码
             */
            $(".wxNumTextContainer").html(wxNum);
            if(hasNoId){
                doAnalysis(jsonData.data.wxId);
            }
        }else{
            console.log(jsonData.msg);
        }
    });
}

function doAnalysis(id){
    $.get('http://weixin.hujiakang.com/get.php?wid='+id,null,function(data){
        var jsonData = JSON.parse(data);
        console.log(jsonData.code == 0 ? '有效统计' : '无效统计');
    });
}
