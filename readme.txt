创建一个购物车

实现以下功能：
1. 在线出售商品的数据库
2. 一个在线产品目录，按商品种类分类
3. 一个能记录用户打算购买商品的购物车
4. 结账脚本，处理付款和运送细节
5. 一个管理界面

解决方案的组成：（项目的需求）
1. 我们要记录他们选中的物品以便此后购买
2. 当用户完成购买，要合计他们的订单，获取运送商品细节，并处理付款
3. 管理界面：添加、编辑图书和目录

该应用程序由三个主要代码模块组成：
1. 目录
2. 购物车和订单处理（我们将此二者捆绑在一起是因为它们之间的联系非常紧密）
3. 管理

实现购物车
点击"View Cart"或"Add Cart"链接，show_cart.php脚本将显示我们要访问的页面。
如果不使用任何参数来调用show_cart.php，将看到购物车的内容；
如果用一个ISBN作为参数，该ISBN对应的物品将被添加到购物车中。

实现一个管理界面
http://localhost/Book-o-Rama/login.php