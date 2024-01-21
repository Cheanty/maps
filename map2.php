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

    <title>增强罗兰系统——北斗地图</title>

    <style>
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
            height: 50px;
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
            height: calc(4 * 40px);
        }


        .menu-item>input#menu-item2:checked~.menu-content {
            height: calc(3 * 40px);
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
                    <i class="menu-item-icon iconfont icon-a-02-kechengguanli""></i>  <!--房子图标-->

                    <span>定位</span>                            <!--菜单夹文字-->

                    <i class="menu-item-last iconfont icon-down"></i>  <!--向上和向下的小箭头-->
                </label>
                <div class="menu-content">
                    <span onclick="beidou_display()">北斗定位</span>
                    <span onclick="loran_display()">罗兰定位</span>
                </div>
            </div>
        </div>
    </div>
    <!-- 全屏地图 -->
    <div id="allmap"></div>
    <script>
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
        // 创建地图，并定位到当前位置
        var map = new BMapGL.Map("allmap");
        var geolocation = new BMapGL.Geolocation();
        var start = true;//使用百度自带定位的关闭标志
        var marker; // 将标记声明在外面，以便在后续代码中访问
        var initialZoom = 18;//默认的放缩等级
        var currentlZoom;//当前的放缩等级
        //坐标时间信息
        var loranLatitude, loranLongitude, beidouLatitude, beidouLongitude, nowTime;
        //用户点击信息
        var loranDisplay = true;
        var beidouDisplay = false;
        //图标的方向角度
        let direction = new Rad(0,140);
        geolocation.getCurrentPosition(function(r) {
            if (this.getStatus() == BMAP_STATUS_SUCCESS && start) {
                start = false;
                map.centerAndZoom(r.point,initialZoom);
                map.enableScrollWheelZoom(true,initialZoom);
                // 创建自定义图标
                var loranIcon = new BMapGL.Icon('./icon/picture1.jpg', new BMapGL.Size(32, 32));
                var beidouIcon = new BMapGL.Icon('./icon/picture2.jpg', new BMapGL.Size(32, 32));
                // 创建标记并添加到地图
                loranMarker = new BMapGL.Marker(r.point,{ icon: loranIcon });
                beidouMarker = new BMapGL.Marker(r.point,{ icon: beidouIcon });
                map.addOverlay(loranMarker);
                map.addOverlay(beidouMarker);
                //显示当前坐标，测试用，可删除
                // var currentLatitude = r.point.lat;
                // var currentLongitude = r.point.lng;
                // alert('当前坐标：' + currentLatitude + ', ' + currentLongitude);
            }
        });

        //设置定时器，每隔一定时间刷新地图位置
        setInterval(function() {
            // 发起请求获取 JSON 数据
            map.addEventListener("zoomend", function () {
                // 在放缩结束后检查放缩级别
                var currentZoom = map.getZoom();
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
                    if(loranDisplay){
                        map.panTo(loranPoint);
                    }
                    if(beidouDisplay){
                        map.panTo(beidouPoint);
                    }
                })
                .catch(error => console.error('Error:', error));
        }, 50);
    </script>
    <script>
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
            var angle = Math.atan2(deltaY, deltaX) * (180 / Math.PI);
            // 调整角度范围为 [0, 360]
            angle = (angle + 360) % 360;
            return angle;
        }
    </script>
</body>
</html>