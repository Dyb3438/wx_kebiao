// pages/addClass/addClass.js

const app = getApp();

Page({

    /**
     * 页面的初始数据
     */
    data: {
        week: app.globalData.week,
        startWeek: 1,
        endWeek: 25,
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

    setWeek: function(e) {
        var temp = {
            startWeek: parseInt(e.detail.value[0]) + 1,
            endWeek: parseInt(e.detail.value[1]) + 1
        }
        if (temp.endWeek < temp.startWeek) {
            temp.endWeek = temp.startWeek;
        }
        this.setData(temp);
    }
})