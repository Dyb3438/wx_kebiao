// pages/jw/jw.js
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
        wx.request({
            // 必需
            url: 'http://120.79.221.7/wx_kebiao/captcha',
            success: (res) => {
                console.log(res);
                var temp = {
                    rnd: res.data.rnd,
                    codeImg: res.data.picture
                }
                this.setData(temp);
            },
            fail: (res) => {
                
            },
            complete: (res) => {
                
            }
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

    logIn: function(e) {
        console.log(e.detail.value);
        wx.request({
            // 必需
            url: 'http://120.79.221.7/wx_kebiao/kebiao/loading',
            method: "POST",
            data: e.detail.value,
            header: {
             'Content-Type': 'application/x-www-form-urlencoded'
            },
            success: (res) => {
                console.log(res);
            },
            fail: (res) => {
                
            },
            complete: (res) => {
                
            }
        })
    }
})