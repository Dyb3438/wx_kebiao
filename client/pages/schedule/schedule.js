// pages/schedule/schedule.js

const app = getApp();

Page({

    /**
     * 页面的初始数据
     */
    data: {
        thisWeek: 1,
        semester: "大一 第2学期",
        month: 1,
        date: [{
            "date": 0,
            "day": "周一"
        }, {
            "date": 0,
            "day": "周二"
        }, {
            "date": 0,
            "day": "周三"
        }, {
            "date": 0,
            "day": "周四"
        }, {
            "date": 0,
            "day": "周五"
        }, {
            "date": 0,
            "day": "周六"
        }, {
            "date": 0,
            "day": "周日"
        }, ]
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        var page = this;
        initTime(page);
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

function setWeek(thisWeek) {
    var today = new Date(),
        temp = {
            year: today.getFullYear(),
            month: today.getMonth(),
            timeWeek: Math.floor((today.getTime() - 316800000) / 604800000),
            week: thisWeek
        };
    wx.setStorage({
        key: 'setWeekTime',
        data: temp
    });
    return temp;
}

function initTime(page) {
    var today = new Date(),
        temp = {},
        firstDay = today.getDate() - today.getDay() + 1,
        setWeekTime = wx.getStorageSync("setWeekTime") || setWeek(1);
    console.log(setWeekTime);
    temp.thisWeek = setWeekTime.week + (Math.floor((today.getTime() - 316800000) / 604800000) - setWeekTime.timeWeek);
    temp.month = today.getMonth() + 1;
    for (var i = 0; i <= 6; i++) {
        var tempName = "date[" + i + "].date";
        temp[tempName] = firstDay;
        firstDay++;
    }
    page.setData(temp);
}