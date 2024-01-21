# 接口
## 通过POST方法发送数据文件
post的json格式类似于
```json
{
  "loran_latitude": ,
  "loran_longitude": 116.4074,
  "beidou_latitude": 40,
  "beidou_longitude": 120,
  "time": "2024-01-20T12:34:56"
}
```
文件发送的键值为"file",文件名称为location.json

## 城市数据
```json
[
  {
    "city":"北京",
    "latitude" : 525,
    "longitude" : 253
  },
  {
    :
  }
]
```

## 任务
1. 实现地图图标方向旋转 完成
2. 将代码放到github上，并和大家做好协同工作 完成
3. 写好注释和各种文档 进行时
4. 开一个给大家调试使用的账号，最低权限，同时调试好服务器的账号 完成
5. 完成对于界面功能的要求 稍后
