ArcFace 2.2 SDK Linux_x64版本

ASFTestDemo使用说明：
1.Demo运行环境：
	Linux_x64系统；
	GLIBC 2.17及以上；
	GLIBCXX 3.4.19及以上；
	GCC 4.8.2及以上；
	cmake编译工具；

2.执行过程：
	a).将ASFTestDemo工程拷贝在Linux系统下；
	b).需要将SDK包目录下中“lib”文件夹中的两个.so文件拷贝到/ASFTestDemo/linux_so文件目录下；
	c).建议将SDK包目录下中“inc”文件夹中的.h文件替换掉/ASFTestDemo/inc下的文件；
	d).下载SDK时，将从官网中获取的APPId/SDKKey/Activekey更新到samplecode.cpp文件中；
	e).在ASFTestDemo目录下新建一个build文件夹；（把需要检测的照片放在该目录下，下面生成的一些编译文件也会生成在build目录下）
	f).进入到/ASFTestDemo/build文件目录下,执行“cmake ..”命令，找到上一级的CMakeLists.txt文件编译，文件生成在build文件夹目录下；
	g).在/ASFTestDemo/build路径下执行“make”命令，生成可执行文件；
	h).在/ASFTestDemo/build路径下执行“./arcsoft_face_engine_test”命令,运行程序；

3.注意事项：
	a).该demo使用的是图片的裸数据作为接口调用的示例，图片保存在/ASFTestDemo/build路径下；
	b).图片宽度需要满足4的倍数，YUYV/I420/NV21/NV12/DEPTH_U16/GRAY格式的图片高度为2的倍数，BGR24格式的图片高度不限制；
	c).jpg等格式推荐使用opencv进行数据读取；
	
