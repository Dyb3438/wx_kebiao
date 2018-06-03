// pages/jw/jw.js

const app = getApp();

Page({

    /**
     * 页面的初始数据
     */
    data: {
        do: 0,
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        console.log(options);
        if (options.do == 1) {
            if (app.globalData.hasBind == 0) {
                wx.showToast({
                    title: '请先绑定学号',
                    icon: 'none', // "success", "loading", "none"
                    duration: 1500,
                    mask: false,
                })
                setTimeout(function() {
                    wx.navigateBack({
                        delta: 1
                    })
                }, 1500);
                return;
            }
            this.setData({
                do: 1,
                xuehao: app.globalData.msg.xuehao
            });
            wx.setNavigationBarTitle({
                title: '获取课表',
                fail: (res) => {
                    console.log(res)
                },
            })
        }
        this.changeCode();
    },

    /**
     * 生命周期函数--监听页面初次渲染完成
     */
    onReady: function() {

    },

    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function() {

    },

    /**
     * 生命周期函数--监听页面隐藏
     */
    onHide: function() {

    },

    /**
     * 生命周期函数--监听页面卸载
     */
    onUnload: function() {

    },

    /**
     * 页面相关事件处理函数--监听用户下拉动作
     */
    onPullDownRefresh: function() {

    },

    /**
     * 页面上拉触底事件的处理函数
     */
    onReachBottom: function() {

    },

    /**
     * 用户点击右上角分享
     */
    onShareAppMessage: function() {

    },

    logIn: function(e) {
        console.log(e.detail.value);
        wx.showLoading({
            title: '课表获取中',
            mask: false,
        })
        wx.request({
            // 必需
            url: app.globalData.host + 'wx_kebiao/kebiao/loading',
            method: "POST",
            data: e.detail.value,
            header: {
                'Content-Type': 'application/x-www-form-urlencoded',
                "cookie": "PHPSESSID=" + wx.getStorageSync('sessionid')
            },
            success: (res) => {
                console.log(res);
                if (res.data.result == 1) {
                    if (res.data.kebiao != "") {
                        // app.addClass(res.data.kebiao);
                        var newClass = res.data.kebiao;
                        for (var i = newClass.length - 1; i >= 0; i--) {
                            newClass[i].color = app.globalData.colors[Math.round(11 * Math.random())];
                        }
                        wx.setStorage({
                            key: 'class',
                            data: newClass
                        });
                        app.globalData.class = newClass;
                        app.updateSchedule({
                            week: app.globalData.week,
                            classNum: wx.getStorageSync('classNum') || 12,
                            onlyThisWeek: wx.getStorageSync('onlyThisWeek'),
                            scheduleTime: wx.getStorageSync('classTime') || ["00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00"],
                            class: app.globalData.class,
                        });
                    }
                    app.setWeek(parseInt(res.data.week));
                    if (e.detail.value.do != 1) {
                        app.login();
                    }
                    app.initScheduleTime();
                    wx.hideLoading();
                    wx.navigateBack({
                        delta: 1
                    })
                } else if (res.data.result == 0) {
                    wx.showToast({
                        title: res.data.msg,
                        icon: 'none', // "success", "loading", "none"
                        duration: 1500,
                        mask: false,
                    })
                }
            },
            fail: (res) => {
                console.log(res);
            },
        })
    },

    changeCode: function() {
        wx.request({
            // 必需
            url: app.globalData.host + 'wx_kebiao/captcha',
            header: {
                'Content-Type': 'application/x-www-form-urlencoded',
                "cookie": "PHPSESSID=" + wx.getStorageSync('sessionid')
            },
            success: (res) => {
                console.log(res);
                var temp = {
                    rnd: res.data.rnd,
                    codeImg: res.data.picture
                }
                this.setData(temp);
            },
            fail: (res) => {
                console.log(res);
            },
        })
    },

    dowhat: function(e) {
        console.log(e.detail);
        e.detail.value ? this.setData({
            do: 2
        }) : this.setData({
            do: 0
        });
    }
})