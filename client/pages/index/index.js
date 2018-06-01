// pages/index/index.js

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
            hasBind: app.globalData.hasBind,
            msg: app.globalData.msg || {},
            userInfo: app.globalData.userInfo,
        })
        // console.log(!this.data.userInfo);
        // console.log(app.globalData)
        app.setDataIndex = obj => {
            this.setData(obj)
        }
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

    onGotUserInfo: function(res) {
        console.log(res);
        app.globalData.userInfo = res.detail.userInfo;
        this.setData({
            userInfo: res.detail.userInfo
        })
        if (this.data.hasBind == 0) {
            wx.navigateTo({
                url: '/pages/jw/jw'
            })
        }
    }
})