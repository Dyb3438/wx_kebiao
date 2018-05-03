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
        if (!this.data.userInfo) {
            wx.getUserInfo({
                success: (res) => {
                    // let userInfo = res.userInfo
                    // let nickName = userInfo.nickName
                    // let avatarUrl = userInfo.avatarUrl
                    // let gender = userInfo.gender // 性别 0：未知、1：男、2：女
                    // let province = userInfo.province
                    // let city = userInfo.city
                    // let country = userInfo.country
                    // let signature = res.signature
                    // let encryptData = res.encryptData
                    this.setData({
                        userInfo: res.userInfo
                    });
                    app.globalData.userInfo = res.userInfo;
                },
                fail: (res) => {

                },
                complete: (res) => {

                }
            })
        }
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

    }
})