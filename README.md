# Owl Admin 的 DDNS 扩展

### Owl Admin DDNS  Extension

### 可以提供一个ddns服务器，通过阿里云或者腾讯云的SDK来提供解析


## 准备条件

* [ ]  拥有一个域名
* [ ]  使用阿里云或腾讯云的DNS解析服务（免费）
* [ ]  获取云平台的API访问秘钥
* [ ]  已安装好Owl Admin

## 安装

方式一：composer

```bash
composer require itinysun/ddns
```

方式二：下载zip包

https://github.com/Itinysun/ddns/releases

安装后需要owl后台扩展中启用即可


## 使用


首先按照表单添加域名和秘钥信息

> 拥有管理员身份的用户可以看到所有记录，其它用户只能看到和维护自己的

查看记录详情，会显示一个url 链接，将该链接填写到群晖的dns服务中。不需要账户和密码（随便写）

> 请注意，该URL本身即包含秘钥（token）,所以请不要泄露。
> 编辑的时候，秘钥字段是有掩码的避免泄露，如果不想修改那就不动秘钥字段即可
