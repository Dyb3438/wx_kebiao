// pages/setClassTime/set.js

const app = getApp();

Page({

    /**
     * 页面的初始数据
     */
    data: {

    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        this.setData({
            temp: wx.getStorageSync('classTime') || ["00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00"],
        })
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

    setTime: function(e) {
        console.log(e)
        var name = "temp[" + e.target.dataset.index + "]",
            temp = {};
        temp[name] = e.detail.value;
        this.setData(temp);
    },

    save: function() {
        wx.setStorage({
            key: 'classTime',
            data: this.data.temp,
            success: function(res) {

            },
            fail: function(res) {

            },
            complete: function(res) {

            }
        })
        app.updateSchedule({
            scheduleTime: this.data.temp
        })
        wx.navigateBack({
            delta: 1
        })
    }
})