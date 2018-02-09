这是最近编写的一个用于管理`kvm`虚拟池，基于`libvirt`的`composer`工具包。**`Github`**项目地址：[`https://github.com/Pengfei-Gao/php-libvirt`](https://github.com/Pengfei-Gao/php-libvirt)，使用说明如下：
<hr>

###### 一、安装libvirt-php类库：
安装方式有很多，你可以直接下载官方的`release`版本，但是我们在这个主要说明从源代码安装的方式，第一步，使用`git`拷贝一个副本：
```bash
git clone git://libvirt.org/libvirt-php
```
接下来从源代码编译安装，我们可以使用`./configure --help`来查看编译选项，当然了一般来说使用默认的就可以了：
```bash
./configure
make
make install
```
在编译完成后会生成`libvirt-php.so`这个文件，在大多数情况下，`make`脚本会帮我们完成扩展的配置，我们可以使用：
```bash
php -m | grep libvirt
```
来查看安装是否成功，如果安装失败，那么你可以需要手动做出一些配置：
```
extension=libvirt-php.so
```
安装完成后就可以正常使用这个库了。

###### 二、使用说明
打开终端，在你的项目目录里面安装包文件：
```bash
composer require lps/libvirt
```
如果你使用了`laravel`、`yii`之类的已经集成`composer`完整功能的框架，那么你可以在你的框架里面直接根据命名空间引入类库，如果你使用的框架没有引入`composer`(譬如`yaf`).
你可能需要在框架的入口处引入类库：
```bash
include __DIR__."/vendor/autoload.php";
```
实例化`libvirt`类库：
```php
use Lps\Libvirt;
$libvirt = new Libvirt();
```
查看主机上的所有虚拟机：
```php
$res = $libvirt->listDomains();
var_dump($res);
```
获取连接主机的`uri`:
```php
$libvirt->getUri();
```
创建/删除一个大小为500M，名为`test`,格式为`raw`的系统磁盘镜像：
```php
$libvirt->createImage("test",500,raw);
$libvirt->deleteImage('test');
```
管理虚拟机：
```php
use Lps\Domain;
use Lps\Libvirt;

//创建虚拟机
$res = $libvirt->createDomain( $name, $arch, $memMB, $maxmemMB, $vcpus, $iso_image, $disks, $networks, $flags);
$domain = new Domain($res);
//为虚拟机设置内存为1G：
$domain->setMemory(1024);
//关机
$domain->shutdown();
```
