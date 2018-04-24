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
        }, ],
        scheduleTime: ["00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00"],
        class: [{
            "classname": "\u5fae\u79ef\u5206\u2160\uff08\u4e8c\uff09",
            "day": "1",
            "class": [1,2],
            "long": [1,16],
            "teacher": "\u6e29\u65ed\u8f89",
            "classroom": "A2302",
            "single_week": "0"
        }, {
            "classname": "\u5927\u5b66\u82f1\u8bed(\u4e8c)",
            "day": "2",
            "class": [1,2],
            "long": [1,16],
            "teacher": "\u66fe\u51b0\u9896",
            "classroom": "A5506",
            "single_week": "0"
        }, {
            "classname": "\u6982\u7387\u8bba\u4e0e\u6570\u7406\u7edf\u8ba1",
            "day": "3",
            "class": [1,2],
            "long": [1,13],
            "teacher": "\u5218\u5ba3\u4eae",
            "classroom": "A3101",
            "single_week": "0"
        }, {
            "classname": "\u6982\u7387\u8bba\u4e0e\u6570\u7406\u7edf\u8ba1",
            "day": "4",
            "class": [1,2],
            "long": [1,13],
            "teacher": "\u5218\u5ba3\u4eae",
            "classroom": "A3101",
            "single_week": "0"
        }, {
            "classname": "VB\u8bed\u8a00\u7a0b\u5e8f\u8bbe\u8ba1",
            "day": "1",
            "class": [3,4],
            "long": [3,16],
            "teacher": "\u66f9\u6653\u53f6",
            "classroom": "A3407",
            "single_week": "0"
        }, {
            "classname": "\u5927\u5b66\u7269\u7406\u2160(\u4e00)",
            "day": "2",
            "class": [3,4],
            "long": [1,17],
            "teacher": "\u738b\u7434\u60e0",
            "classroom": "A3103",
            "single_week": "0"
        }, {
            "classname": "\u5927\u5b66\u7269\u7406\u2160(\u4e00)",
            "day": "3",
            "class": [3,4],
            "long": [2,16],
            "teacher": "\u738b\u7434\u60e0",
            "classroom": "A3103",
            "single_week": "2"
        }, {
            "classname": "\u5fae\u79ef\u5206\u2160\uff08\u4e8c\uff09",
            "day": "4",
            "class": [3,4],
            "long": [1,16],
            "teacher": "\u6e29\u65ed\u8f89",
            "classroom": "A2302",
            "single_week": "0"
        }, {
            "classname": "\u519b\u4e8b\u7406\u8bba",
            "day": "5",
            "class": [3,4],
            "long": [1,8],
            "teacher": "\u519b\u4e8b\u7406\u8bba",
            "classroom": "A3302",
            "single_week": "0"
        }, {
            "classname": "\u6e38\u6cf3\u666e\u53ca",
            "day": "2",
            "class": [5,6],
            "long": [1,16],
            "teacher": "\u5168\u9f99",
            "classroom": "\u5927\u5b66\u57ce\u6821\u533a\u6e38\u6cf3\u4e2d\u5fc3",
            "single_week": "0"
        }, {
            "classname": "\u5de5\u7a0b\u5236\u56fe(\u4e8c)",
            "day": "3",
            "class": [5,6],
            "long": [1,16],
            "teacher": "\u4ed8\u6c38\u6e05",
            "classroom": "A2105",
            "single_week": "0"
        }, {
            "classname": "VB\u8bed\u8a00\u7a0b\u5e8f\u8bbe\u8ba1",
            "day": "4",
            "class": [5,6],
            "long": [3,16],
            "teacher": "\u66f9\u6653\u53f6",
            "classroom": "A3206",
            "single_week": "0"
        }, {
            "classname": "\u601d\u60f3\u9053\u5fb7\u4fee\u517b\u4e0e\u6cd5\u5f8b\u57fa\u7840",
            "day": "5",
            "class": [5,6],
            "long": [1,12],
            "teacher": "\u674e\u5ca9",
            "classroom": "A3207",
            "single_week": "0"
        }, {
            "classname": "\u601d\u60f3\u9053\u5fb7\u4fee\u517b\u4e0e\u6cd5\u5f8b\u57fa\u7840",
            "day": "5",
            "class": [7],
            "long": [1,12],
            "teacher": "\u674e\u5ca9",
            "classroom": "A3207",
            "single_week": "0"
        }, {
            "classname": "\u5927\u5b66\u7269\u7406\u5b9e\u9a8c(\u4e00)",
            "day": "1",
            "class": [9,10,11],
            "long": [3,15],
            "teacher": "\u5218\u4ed8\u6c38\u7ea2\/\u5218\u96ea\u6885\/\u6881\u5fd7\u5f3a\/\u7530\u4ec1\u7389\/\u5510\u73b2\u4e91\/\u8c22\u6c47\u7ae0\/\u9a6c\u5728\u5149\/\u9ad8\u4e9a\u59ae",
            "classroom": "",
            "single_week": "1"
        }, {
            "classname": "\u5236\u56fe\u4e60\u9898",
            "day": "3",
            "class": [9,10,11],
            "long": [1,16],
            "teacher": "\u4ed8\u6c38\u6e05",
            "classroom": "A1207",
            "single_week": "0"
        }],
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