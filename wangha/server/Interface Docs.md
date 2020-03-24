# Interface Docs

## Note

下述所有接口均通过HTTP协议进行传输，GET请求会被单独注明，为注明的均为POST请求。

在Interface Detail中，需要注意接口前需要加上 hostname:port

## Interface Detail

### /upload_camera_data

request

```json
{
    "cameraid":1,
    "peoplecount":1,
}
```

response

```
{
    "result":"1"
}
```

result为"1"时表示成功,否则返回失败原因

### /download_camera_data

*GET*

备注：开定时器，频率暂定每3分钟检测一次，如果在这三分钟内，人流量大于 10人/f ，则flag++ 如果flag>10，则warning

request

response

```
body: data
```

此处data格式为 0-2-0-0-4-1-4-3-7-0-0-0-0-...-0

### /get_userinfo_by_roomid

request

```
{
    "roomid":1,
}
```

response

```
{
	"result":"1",
    "userid":1,
    "orderid":1,
    "starttime":date,
    "starttime":date,
    "feature":"data",
}
```

### /get_userinfo_by_prolevel

需要将所有的住户的信息全部返回

request

```
{
    "prolevel":1
}
```

response

```
{
	"result":1,
    {
        "userid":1,
        "starttime":date,
        "endtime":date,
        "feature":"",
    }, ...
}
```

### /get_feature_by_userid

request

```
{
    "userid":1
}
```

response

```
{
	"result":"1",
    "feature":"",
}
```

### /upload_order_info

request

```
{
    "userid":1,
    "roomid":1,
    "money":1,
    "prolevel":1,
    "days":1,
}
```

备注，如果是VIP用户，此处的userid必须非0，如果userid为0,则为普通未注册用户

response

```
{
    "result":"1",
}
```

### /get_available_roomid

request

```
{
    "userid":0,
    "prolevel":1,
}
```

response

```
{
    {
        "roomid":1,
    }, ...
}
```

### /register

request

```
{
    "userid":0,
    "gender":1,
    "age":10,
    "feature":"",
    "roomid":1,
    "prolevel":1,
}
```

reponse

```
{
    "result":"1",
    "userid": 12312312,
}
```

### /add_camera

request

```
{
    "location":"",
}
```

response

```
{
	"cameraid":1,
    "result":"1",
}
```

### /delete_camera

request

```
{
    "cameraid":1,
}
```

response

```
{
    "result":"1",
}
```

### /check_all_camera

GET

request

response

```
{
    {
        "camerid":1,
        "location":"",
    }, ...
}
```

### /add_roomid

request

```
{
    "roomnumber":"",
    "roomtype":""
}
```

response

```
{
    "result":"1",
}
```



