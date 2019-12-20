#include "arcsoft_face_sdk.h"
#include "amcomdef.h"
#include "asvloffscreen.h"
#include "merror.h"
#include <iostream>  
#include <string>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
// extern
#include <opencv2/core.hpp>
#include <opencv2/imgproc.hpp>
#include <opencv2/highgui.hpp>

#define APPID "5RromRthBqpK9JCZBS7qJ31gAwKwRCgsAyRKAx86CTXQ"
#define SDKKEY "7PaRMWiGmWJAjKejDHvRk6RgoykNJLmPGi1gSGawVucr"

#define SafeFree(p) { if ((p)) free(p); (p) = NULL; }
#define SafeArrayDelete(p) { if ((p)) delete [] (p); (p) = NULL; } 
#define SafeDelete(p) { if ((p)) delete (p); (p) = NULL; } 

#define NSCALE 15 
#define FACENUM	1

void Getsuffix(char * pixPath, char * suffix){
    int len = 0, i = 0;
    int mark = 0;
    while(pixPath[len++] != '\0');
    len = len - 1;
    for(i=0; i<len; i++){
        if(pixPath[i] == '.')
            mark = i+1;
    }
    for(i=0; i<len-mark; i++){
        suffix[i] = pixPath[i+mark];
    }
    suffix[i] = '\0';
}

void GetWidthHeight(char * picPath, int * width, int * height){
    cv::Mat img = cv::imread(picPath);
    *width = img.cols;
    *height = img.rows;
}

/*
void GetWidthHeight(char * picPath, FILE *fp, int * width, int *height){
    char * suffix = (char*)malloc(sizeof(char)*10);
    Getsuffix(picPath, suffix);
    if(!strcmp("bmp", suffix)){
        fseek(fp, 18L, SEEK_SET);
        fread(width, sizeof(char), 4, fp);
        fseek(fp, 22L, SEEK_SET);
        fread(height, sizeof(char), 4, fp);
    }else if(!strcmp("png", suffix)){
        fseek(fp, 17L, SEEK_SET);
        fread(width, sizeof(char), 4, fp);
        fseek(fp, 21L, SEEK_SET);
        fread(height, sizeof(char), 4, fp);
    }else if(!strcmp("gif", suffix)){
        fseek(fp, 6L, SEEK_SET);
        fread(width, sizeof(char), 4, fp);
        fseek(fp, 8L, SEEK_SET);
        fread(height, sizeof(char), 4, fp);
    }else if(!strcmp("jpg", suffix)){
        fseek(fp, 164L, SEEK_SET);
        fread(width, sizeof(char), 4, fp);
        fseek(fp, 166L, SEEK_SET);
        fread(height, sizeof(char), 4, fp);
    }
}
*/

void Drawline(cv::Mat img, cv::Point start, cv::Point end){
    int thickness = 2;
    int lineType = cv::LINE_8;
    cv::line( img,
        start,
        end,
        cv::Scalar( 0, 0, 0 ),
        thickness,
        lineType );
}

void Drawrectangle(cv::Mat img, int top, int bottom, int left, int right){
    Drawline(img, cv::Point(left, top), cv::Point(right, top));
    Drawline(img, cv::Point(left, bottom), cv::Point(right, bottom));
    Drawline(img, cv::Point(left, top), cv::Point(left, bottom));
    Drawline(img, cv::Point(right, top), cv::Point(right, bottom));
}

void Autocutpic(char * picPath, int width, int height){
    cv::Mat img = cv::imread(picPath);
    width = width - width%4;
    height = height - height%4;
    std::cout << width << " " << height ;
    cv::Mat newimg = img(cv::Rect(0, 0, width, height));
    cv::imwrite(picPath, newimg);
}

int main()
{
    //get the width and height of picture. 
    unsigned int OffSet = 0;
	//激活SDK
	/*
    MRESULT res = ASFOnlineActivation(APPID, SDKKEY);
	if (MOK != res && MERR_ASF_ALREADY_ACTIVATED != res)
		printf("ASFOnlineActivation fail: %d\n", res);
	else
		printf("ASFOnlineActivation sucess: %d\n", res);
    */
	//初始化引擎
    MRESULT res = { 0 };
	MHandle handle = NULL;
	MInt32 mask = ASF_FACE_DETECT | ASF_FACERECOGNITION | ASF_AGE | ASF_GENDER | ASF_FACE3DANGLE | ASF_LIVENESS | ASF_IR_LIVENESS;
	res = ASFInitEngine(ASF_DETECT_MODE_IMAGE, ASF_OP_0_ONLY, NSCALE, FACENUM, mask, &handle);
	if (res != MOK)
		printf("ALInitEngine fail: %d\n", res);
	else
		printf("ALInitEngine sucess: %d\n", res);
	
	char* picPath1 = "hahaha.png";
	int Width1 = 0, Height1 = 0;
    GetWidthHeight(picPath1, &Width1, &Height1);

    if(Height1%4 != 0 || Width1%4 != 0){
        Autocutpic(picPath1, Width1, Height1);
        GetWidthHeight(picPath1, &Width1, &Height1);
    }

	int Format1 = ASVL_PAF_RGB24_B8G8R8;	//图像数据为RGB24颜色格式
	FILE* fp1 = fopen(picPath1, "rb");
	MUInt8* imageData1 = (MUInt8*)malloc(Height1*Width1*3);
	
	char* picPath2 = "./hahaha.bmp";
	int Width2 = 0, Height2 = 0;
    GetWidthHeight(picPath2, &Width2, &Height2);

    if(Height2%4 != 0 || Width2%4 != 0){
        Autocutpic(picPath2, Width2, Height2);
        GetWidthHeight(picPath2, &Width2, &Height2);
    }

	int Format2 = ASVL_PAF_RGB24_B8G8R8;	//图像数据为RGB24颜色格式
	FILE* fp2 = fopen(picPath2, "rb");
    MUInt8* imageData2 = (MUInt8*)malloc(Height2*Width2*3);

	char* picPath3 = "./hahaha.bmp";
	int Width3 = 0, Height3 = 0;
	int Format3 = ASVL_PAF_GRAY;	//用于红外活体检测
//只读NV21前2/3的数据为灰度数据
	FILE* fp3 = fopen(picPath3, "rb");
	GetWidthHeight(picPath3, &Width3, &Height3);
    if(Height3%4 != 0 || Width3%4 != 0){
        Autocutpic(picPath3, Width3, Height3);
        GetWidthHeight(picPath3, &Width3, &Height3);
    }
    MUInt8* imageData3 = (MUInt8*)malloc(Height2*Width2);	

	if (fp1 && fp2 && fp3)
	{
		fread(imageData1, 1, Height1*Width1*3, fp1);		//读BGR裸数据
		fclose(fp1);
		fread(imageData2, 1, Height2*Width2*3, fp2);		//读BGR裸数据
		fclose(fp2);
		fread(imageData3, 1, Height3*Width3, fp3);//读NV21前2/3的数据,用于红外活体检测
		fclose(fp3);
		
		// 人脸检测
		ASF_MultiFaceInfo detectedFaces1 = { 0 };
		ASF_SingleFaceInfo SingleDetectedFaces = { 0 };
		ASF_FaceFeature feature1 = { 0 };
		ASF_FaceFeature copyfeature1 = { 0 };
		res = ASFDetectFaces(handle, Width1, Height1, Format1, imageData1, &detectedFaces1);
		if (res != MOK)
			printf("%s ASFDetectFaces fail: %d\n", picPath1, res);
		else
		{
			printf("%s ASFDetectFaces sucess: %d\n", picPath1, res);
			SingleDetectedFaces.faceRect.left = detectedFaces1.faceRect[0].left;
			SingleDetectedFaces.faceRect.top = detectedFaces1.faceRect[0].top;
			SingleDetectedFaces.faceRect.right = detectedFaces1.faceRect[0].right;
			SingleDetectedFaces.faceRect.bottom = detectedFaces1.faceRect[0].bottom;
			SingleDetectedFaces.faceOrient = detectedFaces1.faceOrient[0];
            printf("left:%d, top:%d, right:%d, bottom:%d. \n",
                    SingleDetectedFaces.faceRect.left, SingleDetectedFaces.faceRect.top, 
                    SingleDetectedFaces.faceRect.right, SingleDetectedFaces.faceRect.bottom);
            // out to file
            if(SingleDetectedFaces.faceRect.top != 0 && SingleDetectedFaces.faceRect.bottom != 0){
                cv::Mat mat = cv::imread(picPath1);
                Drawrectangle(mat, SingleDetectedFaces.faceRect.top, SingleDetectedFaces.faceRect.bottom, SingleDetectedFaces.faceRect.left, SingleDetectedFaces.faceRect.right);
                cv::imwrite("out.bmp", mat);
            }
		}
		
		// 单人脸特征提取
		res = ASFFaceFeatureExtract(handle, Width1, Height1, Format1, imageData1, &SingleDetectedFaces, &feature1);
		if (res != MOK)
			printf("%s ASFFaceFeatureExtract fail: %d\n", picPath1, res);
		else
		{
			printf("%s ASFFaceFeatureExtract sucess: %d\n", picPath1, res);
			//拷贝feature，否则第二次进行特征提取，会覆盖第一次特征提取的数据，导致比对的结果为1
			copyfeature1.featureSize = feature1.featureSize;
			copyfeature1.feature = (MByte *)malloc(feature1.featureSize);
			memset(copyfeature1.feature, 0, feature1.featureSize);
			memcpy(copyfeature1.feature, feature1.feature, feature1.featureSize);
		}
		
		ASF_MultiFaceInfo detectedFaces2 = { 0 };
		ASF_FaceFeature feature2 = { 0 };
		res = ASFDetectFaces(handle, Width2, Height2, Format2, imageData2, &detectedFaces2);
		if (res != MOK)
			printf("%s ASFDetectFaces fail: %d\n", picPath2, res);
		else
		{
			printf("%s ASFDetectFaces sucess: %d\n", picPath2, res);
			SingleDetectedFaces.faceRect.left = detectedFaces2.faceRect[0].left;
			SingleDetectedFaces.faceRect.top = detectedFaces2.faceRect[0].top;
			SingleDetectedFaces.faceRect.right = detectedFaces2.faceRect[0].right;
			SingleDetectedFaces.faceRect.bottom = detectedFaces2.faceRect[0].bottom;
			SingleDetectedFaces.faceOrient = detectedFaces2.faceOrient[0];
		}

		res = ASFFaceFeatureExtract(handle, Width2, Height2, Format2, imageData2, &SingleDetectedFaces, &feature2);
		if (res != MOK)
			printf("%s ASFFaceFeatureExtract fail: %d\n", picPath2, res);
		else
			printf("%s ASFFaceFeatureExtract sucess: %d\n", picPath2, res);

		// 单人脸特征比对
		MFloat confidenceLevel;
		res = ASFFaceFeatureCompare(handle, &copyfeature1, &feature2, &confidenceLevel);
		if (res != MOK)
			printf("ASFFaceFeatureCompare fail: %d\n", res);
		else
			printf("ASFFaceFeatureCompare sucess: %lf\n", confidenceLevel);
		
		//设置活体置信度 SDK内部默认值为 IR：0.7  RGB：0.75（无特殊需要，可以不设置）
		ASF_LivenessThreshold threshold = { 0 };
		threshold.thresholdmodel_BGR = 0.75;
		threshold.thresholdmodel_IR = 0.7;
		res = ASFSetLivenessParam(handle, &threshold);
		if (res != MOK)
			printf("ASFSetLivenessParam fail: %d\n", res);
		else
			printf("ASFSetLivenessParam sucess: %d\n", res);

		// 人脸信息检测
		MInt32 lastMask = ASF_AGE | ASF_GENDER | ASF_FACE3DANGLE | ASF_LIVENESS;
		res = ASFProcess(handle, Width2, Height2, Format2, imageData2, &detectedFaces2, lastMask);
		if (res != MOK)
			printf("ASFProcess fail: %d\n", res);
		else
			printf("ASFProcess sucess: %d\n", res);

		// 获取年龄
		ASF_AgeInfo ageInfo = { 0 };
		res = ASFGetAge(handle, &ageInfo);
		if (res != MOK)
			printf("%s ASFGetAge fail: %d\n", picPath2, res);
		else
			printf("%s ASFGetAge sucess: %d First face age: %d\n", picPath2, res, ageInfo);

		// 获取性别
		ASF_GenderInfo genderInfo = { 0 };
		res = ASFGetGender(handle, &genderInfo);
		if (res != MOK)
			printf("%s ASFGetGender fail: %d\n", picPath2, res);
		else
			printf("%s ASFGetGender sucess: %d First face gender: %d\n", picPath2, res, genderInfo.genderArray);

		// 获取3D角度
		ASF_Face3DAngle angleInfo = { 0 };
		res = ASFGetFace3DAngle(handle, &angleInfo);
		if (res != MOK)
			printf("%s ASFGetFace3DAngle fail: %d\n", picPath2, res);
		else
			printf("%s ASFGetFace3DAngle sucess: %d First face 3dAngle: roll: %lf yaw: %lf pitch: %lf\n", picPath2, res, angleInfo.roll, angleInfo.yaw, angleInfo.pitch);
		
		//获取活体信息
		ASF_LivenessInfo rgbLivenessInfo = { 0 };
		res = ASFGetLivenessScore(handle, &rgbLivenessInfo);
		if (res != MOK)
			printf("ASFGetLivenessScore fail: %d\n", res);
		else
			printf("ASFGetLivenessScore sucess: %d\n", rgbLivenessInfo.isLive);
		
		
		//**************进行IR活体检测********************
		printf("\n**********IR LIVENESS*************\n");
		
		ASF_MultiFaceInfo	detectedFaces3 = { 0 };
		//以GRAY图像为例进行红外活体检测
		res = ASFDetectFaces(handle, Width3, Height3, Format3, imageData3, &detectedFaces3);
		if (res != MOK)
			printf("ASFDetectFaces fail: %d\n", res);
		else
			printf("Face num: %d\n", detectedFaces3.faceNum);
		
		//IR图像活体检测
		MInt32 processIRMask = ASF_IR_LIVENESS;
		res = ASFProcess_IR(handle, Width3, Height3, ASVL_PAF_GRAY, imageData3, &detectedFaces3, processIRMask);
		if (res != MOK)
			printf("ASFProcess_IR fail: %d\n", res);
		else
			printf("ASFProcess_IR sucess: %d\n", res);
		
		//获取IR活体信息
		ASF_LivenessInfo irLivenessInfo = { 0 };
		res = ASFGetLivenessScore_IR(handle, &irLivenessInfo);
		if (res != MOK)
			printf("ASFGetLivenessScore_IR fail: %d\n", res);
		else
			printf("IR Liveness: %d\n", irLivenessInfo.isLive);
		
		
		SafeFree(copyfeature1.feature);		//释放内存
		SafeArrayDelete(imageData1);
		SafeArrayDelete(imageData2);
		SafeArrayDelete(imageData3);
		
		//获取版本信息
		const ASF_VERSION* pVersionInfo = ASFGetVersion(handle);
        printf("versioninfo: %s\n", pVersionInfo->Version);

		//反初始化
		res = ASFUninitEngine(handle);
		if (res != MOK)
			printf("ALUninitEngine fail: %d\n", res);
		else
			printf("ALUninitEngine sucess: %d\n", res);
	}
	else{
		printf("No pictures found.\n");
	}

	getchar();
    return 0;
}
