<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!--设置兼容模式为 IE 最新版本-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!--设置视口宽度和初始缩放比例-->

    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css"><!--Element前端CSS样式-->
    <script src="https://unpkg.com/element-ui/lib/index.js"></script><!--引入Element前端CSS样式-->

    <!--百度地图前置-->
    <script src="//mapopen.bj.bcebos.com/github/BMapGLLib/TrackAnimation/src/TrackAnimation.min.js"></script>
    <script type="text/javascript" src="//api.map.baidu.com/api?type=webgl&v=1.0&ak=Pe9q3gCTHIOGKgseMROgh9WHZTTCNBaM"></script>     <!--密钥-->
    <link href="//mapopen.cdn.bcebos.com/github/BMapGLLib/DrawingManager/src/DrawingManager.min.css" rel="stylesheet">              <!--调用一些库（图片，样式等）-->
    <script type="text/javascript" src="//mapopen.cdn.bcebos.com/github/BMapGLLib/DrawingManager/src/DrawingManager.min.js"></script>

    <title>loranMaps</title>

    <style>
        /*搜索框显示补丁*/
        .tangram-suggestion-main{
            z-index:99999999;
        }
        /* 全屏地图 css*/
        html, body, #allmap{
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
            overflow: hidden;
            position: absolute;
            z-index: 1;
        }
        /* 侧边栏 CSS*/
        * {
            margin: 0;
            padding: 0;
        }
        /*黑紫色主题，使用时把上面的白色主题注释掉，启用下面的css代码*/
        :root {
            --color-bg: #e7e7e7;
            --color-menu-bg: #232324;
            --font-color-mi: #c9cdd4;
            --font-color-mi-hover: #a649d1;
            --color-bg-mi-hover: #303030;
            --border-radius-mi: 2px;
            --transition-menu-time: 0.2s;
            --color-line-bg: #333333;
        }
        .menu-box {         /*侧边栏整体*/
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;   /*菜单栏字体*/
            letter-spacing: 0.5px;                                                                                   /*菜单栏字体*/
            font-weight: 600;                                                                                        /*菜单栏字体*/

            position: absolute;                                                                                 /*与z_index为一组*/
            z-index: 1000;                                                                                  /*让侧边栏浮在地图上面*/

            width: fit-content;
            min-height: 100vh;

            /* 菜单栏的上、右、下、左padding （调整左右就行）*/
            padding-top: 6px;
            padding-right: 8px;
            padding-bottom: 6px;
            padding-left: 8px;

            box-sizing: border-box;
            background-color: var(--color-menu-bg); /*菜单栏颜色*/
        }
        .menu-box input[type='checkbox'] {
            display: none;                      /*让小勾选框消失*/
        }

        .menu-box>label {
            position: absolute;
            top: 48%;
            right: 0;
            transform: translateX(50%);
            width: 20px;
            height: 20px;
            border-radius: 20px;
            box-shadow: 0px 0px 4px 0px #000;
            background-color: var(--color-menu-bg);
            color: var(--font-color-mi);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }


        .menu-box>label>i {
            font-weight: 900;
            text-indent: -3px;
            font-size: 20px;
            transition: transform var(--transition-menu-time);
            transform: rotate(0deg);
        }


        .menu-box>label:hover {
            box-shadow: 0px 0px 2px 0px #000;
            color: var(--font-color-mi-hover);
        }


        .menu-box>input#menu-btn:checked+label>i {
            transform: rotate(180deg);
        }


        .menu {
            font-size: 18px;
            width: 220px;
            min-height: 100%;
            cursor: pointer;
            overflow: hidden;
            transition: width var(--transition-menu-time);
            color: var(--font-color-mi);
        }


        .menu-box>input#menu-btn:checked~.menu {
            width: 0;
        }


        .menu-title {
            text-align: center;
            margin-bottom: 10px;
        }


        .menu-item>label{
            position: relative;
            width: 100%;
            height: 100px;
            border-radius: var(--border-radius-mi);
            display: flex;
            align-items: center;
        }


        .menu-item>label:hover {
            color: var(--font-color-mi-hover);
        }


        .menu-item>label>i:first-child {
            flex: none;
            margin-right: 6px;
            font-size: 24px;
        }


        .menu-item>label>span {
            flex: 1;
        }


        .menu-item>label>i:last-child {
            flex: none;
            font-size: 20px;
            font-weight: 900;
            transform: rotate(0deg);
            transition: transform var(--transition-menu-time);
        }


        .menu-item>input:checked+label>i:last-child {
            transform: rotate(180deg);
        }


        .menu-content {
            height: 0;
            overflow: hidden;
            transition: height var(--transition-menu-time);
            display: flex;
            flex-wrap: wrap;
            background-color: var(--color-menu-bg);
        }
         /* 菜单夹下选项个数，若 n 项，就 n * 40px */
         .menu-item>input#menu-item1:checked~.menu-content {
            height: calc(2 * 40px);
        }


        .menu-item>input#menu-item2:checked~.menu-content {
            height: calc(5 * 40px);
        }


        .menu-item>input#menu-item3:checked~.menu-content {
            height: calc(4 * 40px);
        }


        .menu-content>span {
            width: 100%;
            text-indent: 20px;
            line-height: 40px;
            border-radius: var(--border-radius-mi);
        }


        .menu-content>span:hover {
            background-color: var(--color-bg-mi-hover);
            color: var(--font-color-mi-hover);
        }


        .set-line {
            margin: 20px 0 10px 0;
            width: 100%;
            height: 2px;
            background-color: var(--color-line-bg);
        }


        @font-face {                                                        /*在此调用了同目录下的iconfont.ttf文件*/
            font-family: "iconfont"; /* Project id  */
            src: url('iconfont.ttf?t=1636282499752') format('truetype');    /*iconfont.ttf里面是一些图标*/
        }


        .iconfont {
            font-family: "iconfont" !important;
            font-size: 16px;
            font-style: normal;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }


        .icon-down:before {
            content: "\e7ad";
        }


        .icon-a-01-shujuzhongxin:before {   /*小房子图标*/
            content: "\e609";
        }


        .icon-a-02-kechengguanli:before {   /*小标签图标*/
            content: "\e60a";
        }


        .icon-a-04-zixunfabu:before {     /*纸张图标*/
            content: "\e60b";
        }


        .icon-a-08-shezhi:before {      /*设置图标：小齿轮*/
            content: "\e60c";
        }


        .icon-yemianfanhui:before {     /*侧边栏向左收缩向右展开的小按钮的样式*/
            content: "\e601";
        }
        .menu-content>span img {
            margin-left: 10px;           /* 左边距为 10 像素，调整图片与文字之间的间距 */
            margin-top: 10px;             /* 上边距为 5 像素，调整图片相对于文字向下的偏移 */
            width: 20px;                 /* 图片宽度为 20 像素 */
            height: 20px;                /* 图片高度为 20 像素 */
        }
    </style>
</head>
<body>
    <!--菜单栏-->
    <div class="menu-box">

        <input type="checkbox" id="menu-btn">  <!--菜单栏的展开与收回-->
        <label for="menu-btn"><i class="iconfont icon-yemianfanhui"></i></label>  <!--向左收缩向右展开的小按钮-->
        <div class="menu">
                
            <!--菜单栏文字-->
            <div class="menu-title">

                <h1>菜单</MENU></h1>

            </div>
            <!--第一个菜单夹 : 坐标显示-->
            <div class="menu-item">

                <input type="checkbox" id="menu-item1">  <!--菜单夹的展开与收回,在index.css中注释掉.menu-box input[type='checkbox'] 就可以明白-->

                <label for="menu-item1">                 <!--标签内容-->
                    <i class="menu-item-icon iconfont icon-a-02-kechengguanli"></i>  <!--房子图标-->

                    <span style="font-size: 22px;">导航定位</span>                            <!--菜单夹文字-->

                    <i class="menu-item-last iconfont icon-down"></i>  <!--向上和向下的小箭头-->
                </label>
                <div class="menu-content">
                    <span onclick="loran_display()">
                        跟随罗兰
                        <img src="./icon/picture1.jpg" alt="北斗定位图片">
                    </span>
                    <span onclick="beidou_display()">
                        跟随北斗
                        <img src="./icon/picture2.jpg" alt="北斗定位图片">
                    </span>
                </div>
            </div>
            <div class="menu-item">

                <input type="checkbox" id="menu-item2">  <!--菜单夹的展开与收回,在index.css中注释掉.menu-box input[type='checkbox'] 就可以明白-->

                <label for="menu-item2">                 <!--标签内容-->
                    <i class="menu-item-icon iconfont icon-a-02-kechengguanli"></i>  <!--房子图标-->

                    <span style="font-size: 22px;">轨迹绘制</span>                            <!--菜单夹文字-->

                    <i class="menu-item-last iconfont icon-down"></i>  <!--向上和向下的小箭头-->
                </label>
                <div class="menu-content">
                    <div>
                        <input type="text" id="intervalTimeInput" size="20" style="width:150px; height: 25px;" placeholder="输入间隔时间/50ms">
                        <button onclick="inputIntervalTime()" style="height: 30px;">确定</button>
                    </div>
                    <span onclick="loranDraw()">
                        罗兰轨迹绘制(蓝)
                    </span>
                    <span onclick="beidouDraw()">
                        北斗轨迹绘制(红)
                    </span>
                    <span onclick="stopDraw()">
                        暂停绘制
                    </span>
                    <span onclick="clearTrajectory()">
                        清除轨迹
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- 全屏地图 -->
    <div id="allmap"></div>
    <!-- 城市跳转 -->
    <div id="r-result" style="position: fixed; top: 10px; right: 10px; z-index: 1000;">
        <input type="text" id="suggestId" size="20" style="width:150px; height: 25px;" placeholder="请输入城市坐标">
        <button onclick="locateCity()" style="height: 30px;">定位</button>
    </div>
    <div id="searchResultPanel" style="position: fixed; top: 50px; right: 10px; border: 1px solid #C0C0C0; width: 150px; height: auto; display: none; z-index: 999;">
    <script>
        //旋转定位类
        class Rad{
            constructor(loranRad,beidouRad){
                this.changeCount = 0;
                this.loranRad = loranRad;//图片自带的初始旋转角度
                this.beidouRad = beidouRad;
                this.frontLoranPoints = new BMapGL.Point(0,0);
                this.frontBeidouPoints = new BMapGL.Point(0,0);
                this.currentLoranPoints = new BMapGL.Point(1,1);
                this.currentBeidouPoints = new BMapGL.Point(1,1);
            }
            iteration(loranPoints,BeidouPoints){
                this.frontLoranPoints = this.currentLoranPoints;
                this.frontBeidouPoints = this.currentBeidouPoints;
                this.currentLoranPoints = loranPoints;
                this.currentBeidouPoints = BeidouPoints;              
            }
            // 计算两点之间的旋转角度与地图的旋转角度之和
            loranDirectionAngle(map) {
                var angleBetweenPoints = getAngleBetweenPoints(this.frontLoranPoints,this.currentLoranPoints);
                var mapRotation = 0;
                mapRotation = map.getHeading();
                return angleBetweenPoints + mapRotation + this.loranRad;
            }
            beidouDirectionAngle(map){
                var angleBetweenPoints = getAngleBetweenPoints(this.frontBeidouPoints,this.currentBeidouPoints);
                var mapRotation = 0;
                mapRotation = map.getHeading();
                return angleBetweenPoints + mapRotation + this.beidouRad;
            }
            changeDirection(map,loranMarker,beidouMarker,loranPoints,BeidouPoints){
                if(this.changeCount<10){
                    this.changeCount +=1;
                }
                if(this.changeCount >= 10){
                    this.changeCount = 0;
                    this.iteration(loranPoints,BeidouPoints);
                    var loranRad = this.loranDirectionAngle(map);
                    var beidouRad = this.beidouDirectionAngle(map);
                    loranMarker.setRotation(loranRad);
                    beidouMarker.setRotation(beidouRad);
                }
            }
        }
    </script>
    <script>
        //全局变量的创建

        var map = new BMapGL.Map("allmap");// 创建地图
        var start = true;//使用百度自带定位的关闭标志
        var marker; // 将标记声明在外面，以便在后续代码中访问
        var initialZoom = 17;//默认的放缩等级
        var currentlZoom;//当前的放缩等级
        var countTime = 0;//地图中心更新时间
        var updateCenter = 1;
        //坐标时间信息
        var loranLatitude, loranLongitude, beidouLatitude, beidouLongitude, nowTime;
        //loran北斗图标的显示与否
        var loranDisplay = true;
        var beidouDisplay = false;
        //图标的方向角度
        let direction = new Rad(0,140);
        //轨迹记录时间间隔
        var intervalTime = 0;
        var currentTime = 0;
        var loranRecordSignal = false;
        var beidouRecordSignal = false;
        var loranTrajectoryPoints = []; //用来存储需要记录的轨迹点
        var beidouTrajectoryPoints = [];
        var trajectoryPolylineLoran; //loran轨迹
        var trajectoryPolylineBeidou //北斗轨迹
    </script>
    <script>
        //主要地图与功能的实现

        //地图的初始化、图标的添加
        var geolocation = new BMapGL.Geolocation();
        geolocation.getCurrentPosition(function(r) {
            if (this.getStatus() == BMAP_STATUS_SUCCESS && start) {
                start = false;
                map.centerAndZoom(r.point,initialZoom);
                map.enableScrollWheelZoom(true,initialZoom);
                // 创建自定义图标
                var loranIcon = new BMapGL.Icon('./icon/picture1.jpg', new BMapGL.Size(30, 30));
                var beidouIcon = new BMapGL.Icon('./icon/picture2.jpg', new BMapGL.Size(32, 32));
                // 创建标记并添加到地图
                loranMarker = new BMapGL.Marker(r.point,{ icon: loranIcon });
                beidouMarker = new BMapGL.Marker(r.point,{ icon: beidouIcon });
                map.addOverlay(loranMarker);
                map.addOverlay(beidouMarker);
            }
        });

        //设置定时器，每隔一定时间刷新地图位置
        setInterval(function() {
            // 发起请求获取 JSON 数据
            map.addEventListener("zoomend", function () {
                // 在放缩结束后检查放缩级别
                var currentlZoom = map.getZoom();
            });
            fetch('get_location.php')
                .then(response => response.json())
                .then(data => {
                    // 获取新的坐标时间信息
                    loranLatitude = data.loran_latitude;
                    loranLongitude = data.loran_longitude;
                    beidouLatitude = data.beidou_latitude;
                    beidouLongitude = data.beidou_longitude;
                    nowTime = data.time;
                    
                    var loranPoint = new BMapGL.Point(loranLongitude, loranLatitude);
                    var beidouPoint = new BMapGL.Point(beidouLongitude, beidouLatitude);
                    // 使用百度地图的动画效果移动标记到新的坐标位置
                    direction.changeDirection(map,loranMarker,beidouMarker,loranPoint,beidouPoint);
                    loranMarker.setPosition(loranPoint);
                    beidouMarker.setPosition(beidouPoint);
                    //鼠标在地图上按下，这个时候由用户自主拖动界面不在跟随
                    map.addEventListener("mousedown", function (e) {
                        loranDisplay = false;
                        beidouDisplay = false;
                    });
                    //对于按下定位后的处理
                    countTime+=1;
                    if(countTime === updateCenter){
                        countTime = 0;
                        if(loranDisplay){
                            map.panTo(loranPoint);
                        }
                        if(beidouDisplay){
                            map.panTo(beidouPoint);
                        }
                    }
                    if(loranRecordSignal){
                        addLoranPoints();
                        drawLoranTrajectory();
                    }
                    if(beidouRecordSignal){
                        addBeidouPoints();
                        drawBeidouTrajectory();
                    }
                })
                .catch(error => console.error('Error:', error));
        }, 50);
    </script>
    <script type="text/javascript">
        // 搜索功能
        function G(id) {
            return document.getElementById(id);
        }
        var ac = new BMapGL.Autocomplete(    //建立一个自动完成的对象
            {"input" : "suggestId"
            ,"location" : map
        });
        ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
        var str = "";
            var _value = e.fromitem.value;
            var value = "";
            if (e.fromitem.index > -1) {
                value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
            }    
            str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
            
            value = "";
            if (e.toitem.index > -1) {
                _value = e.toitem.value;
                value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
            }    
            str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
            G("searchResultPanel").innerHTML = str;
        });

        var myValue;
        ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
        var _value = e.item.value;
            myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
            G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
            
            setPlace();
        });

        function setPlace(){
            //map.clearOverlays();    //清除地图上所有覆盖物
            function myFun(){
                var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
                map.centerAndZoom(pp, initialZoom-3);
            }
            var local = new BMapGL.LocalSearch(map, { //智能搜索
            onSearchComplete: myFun
            });
            local.search(myValue);
        }
        function locateCity() {
            // 获取输入框中的城市名称
            var cityInput = G("suggestId").value;
            // 如果城市名称为空，可以在这里添加一些提示或默认行为
            if (!cityInput.trim()) {
                alert("请输入城市名称");
                return;
            }

            // 使用百度地图的自动完成功能获取城市坐标
            var myGeo = new BMapGL.Geocoder();
            myGeo.getPoint(cityInput, function(point) {
                if (point) {
                    // 将地图定位到城市位置
                    map.centerAndZoom(point,initialZoom-3);
                } else {
                    alert("无法定位到该城市");
                }
            }, "城市名称");
        }
    </script>
    <script>
        //与定位，角度计算相关的函数

        //loran定位
        function loran_display(){
            var loranPoint = new BMapGL.Point(loranLongitude, loranLatitude);
            currentlZoom = initialZoom;
            map.centerAndZoom(loranPoint,currentlZoom);
            loranDisplay = true;
            beidouDisplay = false;
        }
        //北斗定位
        function beidou_display(){
            var beidouPoint = new BMapGL.Point(beidouLongitude, beidouLatitude);
            currentlZoom = initialZoom;
            map.centerAndZoom(beidouPoint,currentlZoom);
            loranDisplay = false;
            beidouDisplay = true;
        }
        //两点之间的角度计算
        function getAngleBetweenPoints(point1, point2) {
            var lat1 = point1.lat;
            var lng1 = point1.lng;
            var lat2 = point2.lat;
            var lng2 = point2.lng;
            var deltaY = lat2 - lat1;
            var deltaX = lng2 - lng1;
            // 使用 Math.atan2 计算方向角度
            var angle = Math.atan2(deltaX, deltaY) * (180 / Math.PI);
            return angle;
        }
    </script>
    <script>
        //轨迹绘制相关函数

        function drawLoranTrajectory() {
            // 创建轨迹线覆盖物
            trajectoryPolylineLoran = new BMapGL.Polyline(
                loranTrajectoryPoints.map(point => new BMapGL.Point(point.loranLongitude, point.loranLatitude)),
                { strokeColor: "blue", strokeWeight: 3, strokeOpacity: 0.5 }
            );

            // 添加轨迹线到地图
            map.addOverlay(trajectoryPolylineLoran);
        }
        function drawBeidouTrajectory() {
            // 创建轨迹线覆盖物
            trajectoryPolylineBeidou = new BMapGL.Polyline(
                beidouTrajectoryPoints.map(point => new BMapGL.Point(point.beidouLongitude, point.beidouLatitude)),
                { strokeColor: "red", strokeWeight: 3, strokeOpacity: 0.5 }
            );
            // 添加轨迹线到地图
            map.addOverlay(trajectoryPolylineBeidou);
        }
        function inputIntervalTime() {
            //记录间隔时间获取

            // 获取输入框的值
            var intervalTimeValue = document.getElementById('intervalTimeInput').value;

            // 将输入的字符串转换为整数
            var intervalTimeNumber = parseInt(intervalTimeValue, 10);

            // 检查是否成功转换为数字
            if (!isNaN(intervalTimeNumber)) {
                // 在这里可以使用 intervalTimeNumber 进行后续处理
                intervalTime = intervalTimeNumber;
                console.log('输入的间隔时间为:', intervalTimeNumber);
            } else {
                // 如果转换失败，可以进行适当的错误处理
                console.error('无效的输入，不是一个数字');
            }
        }
        function loranDraw(){
            //开始记录
            // map.removeOverlay(trajectoryPolylineLoran);            
            if(intervalTime!==0)loranRecordSignal = true;
        }
        function beidouDraw(){
            // map.removeOverlay(trajectoryPolylineBeidou);
            //开始记录
            if(intervalTime!==0)beidouRecordSignal = true;
        }
        function stopDraw(){
            loranTrajectoryPoints = [];
            beidouTrajectoryPoints = [];
            loranRecordSignal = false;
            beidouRecordSignal = false;
        }
        function addLoranPoints(){
            if(currentTime < intervalTime){
                currentTime +=1;
            }
            else{
                currentTime = 0;
                loranTrajectoryPoints.push({
                    loranLatitude: loranLatitude,
                    loranLongitude: loranLongitude
                });
            }
        }
        function addBeidouPoints(){
            if(currentTime < intervalTime){
                currentTime +=1;
            }
            else{
                currentTime = 0;
                beidouTrajectoryPoints.push({
                    beidouLatitude: beidouLatitude,
                    beidouLongitude: beidouLongitude,
                });
            }
        }
        function clearTrajectory(){
            //清除轨迹

            // 获取地图上的所有覆盖物
            var overlays = map.getOverlays();
            // 遍历覆盖物，找到类型为 Polyline 的覆盖物并移除
            for (var i = 0; i < overlays.length; i++) {
                if (overlays[i] instanceof BMapGL.Polyline) {
                    map.removeOverlay(overlays[i]);
                }
            }
            loranRecordSignal = false;
            beidouRecordSignal = false;
            loranTrajectoryPoints = [];//清空列表
            beidouTrajectoryPoints = [];
        }
    </script>
</body>
</html>