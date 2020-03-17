#include <iostream>
#include <cstdlib>
#include "opencv2/core.hpp"
#include "opencv2/highgui.hpp"
#include "opencv2/imgproc/imgproc.hpp"

#include <vector>
#include <fstream>
#include <string>

using namespace std;
using namespace cv;

void opencvRGB2NV21(string infile, char* outfile){
    Mat Img = cv::imread(infile);
    int buflen = (int)(Img.rows * Img.cols * 3 / 2);
    unsigned char* pYuvBuf = new unsigned char[buflen];
    Mat OpencvYUV;
    FILE* fout = fopen(outfile, "wb");
    cvtColor(Img, OpencvYUV, CV_BGR2YUV_YV12);
    memcpy(pYuvBuf, OpencvYUV.data, buflen*sizeof(unsigned char));
    fwrite(pYuvBuf, buflen*sizeof(unsigned char), 1, fout);
    fclose(fout);
}

void RGB2NV21(string infile, char* outfile){
	cv::Mat Img = cv::imread(infile);
	FILE  *fp = fopen(outfile, "wb");

	if (Img.empty()){
		std::cout << "empty!check your image";
		return;
	}
	int cols = Img.cols;
	int rows = Img.rows;
 
	int Yindex = 0;
	int UVindex = rows * cols;
 
	unsigned char* yuvbuff = new unsigned char[int(1.5 * rows * cols)];
 
	cv::Mat OpencvYUV;
	cv::Mat OpencvImg;
	cv::cvtColor(Img, OpencvYUV, CV_BGR2YUV_YV12);
	
	int UVRow{ 0 };
	for (int i=0;i<rows;i++){
		for (int j=0;j<cols;j++){
			int B = Img.at<cv::Vec3b>(i, j)[0];
			int G = Img.at<cv::Vec3b>(i, j)[1];
			int R = Img.at<cv::Vec3b>(i, j)[2];
 
			//计算Y的值
			int Y = (77 * R + 150 * G + 29 * B) >> 8;
			yuvbuff[Yindex++] = (Y < 0) ? 0 : ((Y > 255) ? 255 : Y);
			//计算U、V的值，进行2x2的采样
			if (i%2==0&&(j)%2==0)
			{
				int U = ((-44 * R - 87 * G + 131 * B) >> 8) + 128;
				int V = ((131 * R - 110 * G - 21 * B) >> 8) + 128;
				yuvbuff[UVindex++] = (V < 0) ? 0 : ((V > 255) ? 255 : V);
				yuvbuff[UVindex++] = (U < 0) ? 0 : ((U > 255) ? 255 : U);
			}
		}
	}
    for (int i=0;i< 1.5 * rows * cols;i++){
	    fwrite(&yuvbuff[i], 1, 1, fp);
    }
    fclose(fp);
    std::cout << "write to file ok!" << std::endl;
    std::cout << "srcImg: " << "rows:" << Img.rows << "cols:" << Img.cols << std::endl;
}

int main(){
    //RGB2NV21(INPUTFILE, OUTPUTFILE);
    RGB2NV21("1.jpg", "direct.yuv");
    opencvRGB2NV21("1.jpg", "opencv.yuv");
}

