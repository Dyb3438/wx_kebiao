// pages/jw/jw.js

const app = getApp();

Page({

    /**
     * 页面的初始数据
     */
    data: {
        do: 0
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
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
        wx.request({
            // 必需
            url: 'http://120.79.221.7/wx_kebiao/kebiao/loading',
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
                    }
                    app.setWeek(parseInt(res.data.week));
                }
            },
            fail: (res) => {
                console.log(res);
            },
            complete: (res) => {

            }
        })
    },

    changeCode: function() {
        wx.request({
            // 必需
            url: 'http://120.79.221.7/wx_kebiao/captcha',
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
            complete: (res) => {

            }
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