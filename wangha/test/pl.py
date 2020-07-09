# _*_ coding: utf-8 _*_

import numpy as np
import matplotlib
import matplotlib.pyplot as plt
import matplotlib.font_manager as fm

# 解决中文乱码问题
myfont = fm.FontProperties(fname="/usr/share/fonts/truetype/myfonts/simsun.ttc", size=14)
matplotlib.rcParams["axes.unicode_minus"] = False

def simple_plot():
    """
    simple plot
    """
    # 生成画布
    plt.figure(figsize=(12, 6), dpi=80)

    # 打开交互模式
    plt.ion()

    y1 = np.random.randint(1, 6, 50).T
    y2 = np.random.randint(4, 7, 80).T
    y3 = np.random.randint(1, 2, 15).T
    y4 = np.random.randint(3, 8, 50).T
    y5 = np.random.randint(2, 4, 20).T
    y6 = np.random.randint(10, 18, 60).T
    y7 = np.random.randint(1, 15, 1000).T
    y = np.hstack((y1,y2,y3,y4,y5,y6,y7))
    x = np.linspace(1687, 1687+2560, 2560, endpoint=True)
    # 循环
    for index in range(100):
        # 清除原有图像
        plt.cla()

        # 设定标题等
        plt.title("楼道人数监控", fontproperties=myfont)
        plt.grid(True)

        # 生成测试数据
        # y = np.randint(1, 14)
        # x = np.linspace(-np.pi + 0.1*index, np.pi+0.1*index, 256, endpoint=True)
        y_cos= y[index:index+255]
        if(index%15 == 0):
            print("近期平均人数：%.2f" % np.mean(y[index+240:index+249]))
            print("不安全指数：%.1f" % np.median(y[index+240:index+254]))


        # 设置X轴
        plt.xlabel("时间", fontproperties=myfont)
        plt.xlim(1680+index, 1680+index+264)
        plt.xticks(np.linspace(1680+index, 1680+index+264, 12, endpoint=True))

        # 设置Y轴
        plt.ylabel("人数", fontproperties=myfont)
        plt.ylim(0, 20)
        plt.yticks(np.linspace(0, 20, 11, endpoint=True))

        # 画两条曲线
        plt.plot(x[index:index+255], y_cos, "b--", linewidth=2.0, label="二楼")

        # 设置图例位置,loc可以为[upper, lower, left, right, center]
        plt.legend(loc="upper left", prop=myfont, shadow=True)

        # 暂停
        plt.pause(0.1)

    # 关闭交互模式
    plt.ioff()

    # 图形显示
    plt.show()
    return
simple_plot()

