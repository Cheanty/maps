# 长波导航地图界面开发
---
## 界面实现
初期先通过调用百度地图API完成初始地图的显示,通过服务器前后端实现地图的部分功能
### 界面与功能设计
#### 基础功能说明
1. 实现分别显示loran系统定位图标和北斗系统定位图标跟随坐标移动
2. 实现图标方向与移动方向一致
3. 实现分别聚焦北斗或者loran，同时当拖动地图时随时退出聚焦
4. 给一个输入框用来输入各种城市名，同时当输入的时候会给出一个下拉框提供5个可选选项，如果用户输错将跳转到第一个输入位置
5. 提供一个输入框输入轨迹记录的时间间隔，依据这个时间间隔来记录轨迹，同时画出轨迹
6. 实现导航
### 实现说明
#### `maps.php`
1. 首先通过调用API完成地图的初始化
    ```js
    var map = new BMapGL.Map("allmap");
    ```
2. 刚开始点开界面的时候，可能数据还没有发送，这时直接调用百度API自带的定位坐标将地图中心给视野中心 
    ```js
      pass
    ```
3. 当接受到MATLAB发送过来的信号后应该将定位中心交给loran定位，同时每隔50ms将更新loran坐标和北斗坐标，将图标移动到相应的位置，同时每隔500ms分别计算loran和北斗定位的方向角，实现方向修正
    ```js
      class Rad{
        ...
      }//方向修正类
      setInterval(function(){
        ...
      });//定时器
    ```
#### `upload_file.php`
- 接收发送过来的POST包，同时将信息存储到文件中
  ```PHP
  // 检查是否文件已经存在
  if (file_exists($targetFile)) {
  // 如果存在，删除旧文件
    unlink($targetFile);
    echo "已存在的文件已被替换. ";
  }
  // 处理上传文件
  if (move_uploaded_file($file['tmp_name'], $targetFile)) {
    echo "文件上传成功: " . $targetFile;
  } 
  else {
            echo "文件上传失败";
        }
  ```
#### 其余文件
- `get_location.php` ：读取data文件中的数据
- `data/`：存储各种数据如：北斗loran定位数据、城市坐标数据
- `icon`：图标jpg
- cityData.php ：将城市数据读取到数据库中并提供各种查询接口
### 格式说明
1. POST数据包格式
    ```json
    {
      //使用json文件
      "loran_latitude": ,
      "loran_longitude": 116.4074,
      "beidou_latitude": 40,
      "beidou_longitude": 120,
      "time": "2024-01-20T12:34:56"
    }
    ```
    文件发送的键值为"file",文件名称为location.json

2. 城市数据格式
    ```json
    [
      {
        "city":"北京",
        "latitude" : 525,
        "longitude" : 253
      },
      {
        "city":"北京",
        "latitude" : 525,
        "longitude" : 253
      }
    ]
    ```
    依旧是json文件同时命名为cityData.json
### 服务器相关
账号：share
密码loranmaps
IP不在这里给出
## MATLAB相关接口实现

......
## 任务
如下只是示例额，内容可以更加具体一点，细致一点
### 徐文涛
图标显示移动旋转 已完成
继续完成界面开发
### 金鹏
......
### 郑道祎
......
### 许超淇
......
### 胡哲玮
......
### 注意事项
1. 项目完成后README.md导出一个为pdf
