<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/weui.css">
  <link rel="stylesheet" href="css/master.css">
  <script src="js/jquery1.9.0.js" charset="utf-8"></script>
  <title>学号绑定</title>
</head>
<body>
  <!-- <form class="" action="index.html" method="post"> -->
    <div class="iconbox">
      
    </div>
    <div class="weui-cell one">
      <div class="weui-cell__bd">
        <input type="text" class="weui-input number" placeholder="学号">
      </div>
    </div>
    <div class="weui-cell two">
      <div class="weui-cell__bd">
        <input type="text" class="weui-input secret" placeholder="智慧交大密码">
      </div>
    </div>
    <span class="reg"></span>
    <div class="weui-btn-area btn">
      <button  class="weui-btn weui-btn_primary" onclick="ajax()">确定</button>
    </div>
<!--   </form> -->
  <script type="text/javascript">
    function ajax(){
      var openid = "{{$user->getId()}}";
      var number = document.querySelector(".number").value;
      var secret = document.querySelector(".secret").value;
      var btn = document.querySelector(".weui-btn");
      $.ajax({
        url:"{{url('/bound')}}",
        type:"post",
        dataType:"json",
        headers:{
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data:{
          user_openid: openid,
          user_number:number,
          user_password:secret,
        },
        success:function(data){
          switch(data.status){
            case 0: alert(data.msg); break;
            case 1: alert(data.msg); break;
            case 2: alert(data.msg); break;
            case 3: alert(data.msg); break;
            case 4: alert(data.msg); break;
          }
        },
        error:function(error) {
          console.log(error.responseText);
          
        },
      });
    }
  </script>



</body>
</html>
