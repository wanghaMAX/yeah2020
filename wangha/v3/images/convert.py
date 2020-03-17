#!/usr/bin/env python3  
import cv2  
import numpy as np  
import glob  

def convert_fhq(h, w, msg):  
    img_y=np.fromstring(msg[:h*w],dtype='uint8').reshape((h,w)).astype('int32')  
    img_u=np.fromstring(msg[h*w:h*w+h*w//2:2],dtype='uint8').reshape((h//2,w//2)).astype('int32')  
    img_v=np.fromstring(msg[h*w+1:h*w+h*w//2:2],dtype='uint8').reshape((h//2,w//2)).astype('int32')  
    ruv=((359*(img_v-128))>>8)  
    guv=-1*((88*(img_u-128)+183*(img_v-128))>>8)  
    buv=((454*(img_u-128))>>8)  
    ruv=np.repeat(np.repeat(ruv,2,axis=0),2,axis=1)  
    guv=np.repeat(np.repeat(guv,2,axis=0),2,axis=1)  
    buv=np.repeat(np.repeat(buv,2,axis=0),2,axis=1)  
    img_r=(img_y+ruv).clip(0,255).astype('uint8')  
    img_g=(img_y+guv).clip(0,255).astype('uint8')  
    img_b=(img_y+buv).clip(0,255).astype('uint8')  
    img=np.dstack([img_b[:,:,None],img_g[:,:,None],img_r[:,:,None]])  
    img=img.transpose((1,0,2))[::-1].copy()  
    #img = cv2.resize(img,(0,0),fx=0.25,fy=0.25)  
    return img[:,:,::-1].copy()  
  
  
h, w = 480, 640
  
for i in glob.glob('*.NV21'):
    img = convert_fhq(h, w, open(i, 'rb').read())  
    cv2.imwrite(i + '.png', img)
