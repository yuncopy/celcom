#### 创建软链接 
- 在public资源目录下执行 
```
ln -s ../../resources/ ./
```

- 回调通知
- http://192.168.4.9:8811/callback/charged/1.00/+60195330779/338630/SUBS20171211165612369995


#### 游戏类型
```
['id' =>'1','name'  =>'大型游戏'],
['id' =>'2','name'  =>'中文游戏'],
['id' =>'3','name'  =>'独家发布'],
['id' =>'4','name'  =>'破解游戏'],
['id' =>'5','name'  =>'支持手柄'],
['id' =>'6','name'  =>'休闲益智'],
['id' =>'7','name'  =>'动作射击'],
['id' =>'8','name'  =>'体育竞技'],
['id' =>'9','name'  =>'角色扮演'],
['id' =>'10','name'  =>'网络游戏'],
['id' =>'11','name'  =>'赛车竞速'],
['id' =>'12','name'  =>'策略塔防'],
['id' =>'13','name'  =>'模拟经营']

```

#### 权限设计

- 使用二进制管理
- 参考资料
> http://code.mixmedia.com/resource-permission-rule/
> http://php.net/manual/zh/language.operators.bitwise.php