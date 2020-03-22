# About usage

所有在Linux平台代码测试没有问题

## server

你的本地需要首先能够支持php脚本的运行

然后，我此处使用了workerman framework，来实现http server

vendor文件夹下包含了workerman framework所有需要的文件

（windwos平台下如果无法正常运行请移步 <http://doc2.workerman.net/> ）

## client

首先需要去giithub <https://github.com/yhirose/cpp-httplib/releases>中下载release package

然后将源码放到合适的路径下，应该就行了

在Linxu下，我把文件放置到了usr/local/include/httplib/下然后就行了，g++编译方式如下，windows上应该步骤相似

g++ test\_client.cpp -I /usr/local/include/httplib/


