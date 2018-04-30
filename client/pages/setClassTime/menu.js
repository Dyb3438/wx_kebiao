// pages/setClassTime/menu.js
Page({

    /**
     * 页面的初始数据
     */
    data: {
        classNum: wx.getStorageSync('classNum') || 12
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {

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

    changeNum: function(e) {
        var num = parseInt(e.detail.value);
        wx.setStorage({
            key: 'classNum',
            data: num + 1,
            success: function(res) {

            },
            fail: function(res) {

            },
            complete: function(res) {

            }
        })

        var classTime = wx.getStorageSync('classTime') || ["00:00"],
            temp = [];
        for (var i = 0; i <= num; i++) {
            temp[i] = classTime[i] || "00:00";
        }
        wx.setStorage({
            key: 'classTime',
            data: temp,
            success: function(res) {

            },
            fail: function(res) {

            },
            complete: function(res) {

            }
        })
    }
})