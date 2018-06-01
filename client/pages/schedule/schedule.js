// pages/schedule/schedule.js

const app = getApp();

Page({

    /**
     * 页面的初始数据 
     */
    data: {
        menu: "none",
        thisWeek: 1,
        semesters: ["大一", "大二", "大三", "大四"],
        semesterIndex: wx.getStorageSync('semesterIndex') || [0, 0],
        thisMonth: 0,
        month: 0,
        today: 0,
        week: app.globalData.week,
        weekValue: 0,
        classNum: wx.getStorageSync('classNum') || 12,
        onlyThisWeek: wx.getStorageSync('onlyThisWeek'),
        scheduleTime: wx.getStorageSync('classTime') || ["00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00", "00:00"],
        class: app.globalData.class,
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
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        var page = this;
        initTime(page);
        app.updateSchedule = obj => {
            this.setData(obj);
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

    weekChange: function(e) {
        var temp = {},
            d = parseInt(e.detail.value) - this.data.weekValue,
            firstDay = this.data.date[0].date + (d * 7);
        console.log(typeof e.detail.value);
        temp.weekValue = parseInt(e.detail.value);
        temp.month = this.data.month;
        while (firstDay > app.globalData.month[temp.month] || firstDay < 1) {
            if (firstDay > app.globalData.month[temp.month]) {
                firstDay += -app.globalData.month[temp.month];
                if (temp.month == 11) {
                    temp.month = 0;
                } else {
                    temp.month += 1;
                }
            } else if (firstDay < 1) {
                if (temp.month == 0) {
                    temp.month = 11;
                } else {
                    temp.month += -1;
                }
                firstDay += app.globalData.month[temp.month];
            }
        }
        for (var i = 0; i <= 6; i++) {
            var tempName = "date[" + i + "].date";
            temp[tempName] = firstDay;
            if (firstDay + 1 > app.globalData.month[temp.month]) {
                firstDay = 1;
            } else {
                firstDay++;
            }
        }
        this.setData(temp);
    },

    menuToggle: function() {
        if (this.data.menu == "none") {
            this.setData({
                menu: "flex"
            });
        } else {
            this.setData({
                menu: "none"
            });
        }
    },

    changeSemester: function(e) {
        wx.setStorage({
            key: 'semesterIndex',
            data: e.detail.value,
        })
        this.setData({
            semesterIndex: e.detail.value,
        });
    },

    changeWeek: function(e) {
        var temp = parseInt(e.detail.value) + 1;
        app.setWeek(temp);
        this.setData({
            thisWeek: temp,
            weekValue: (temp - 1)
        });
    },

    addClass: function() {
        wx.showActionSheet({
            itemList: ["教务系统导入", "手动添加课程"],
            success: function(res) {
                console.log(res);
                if (res.tapIndex == 0) {
                    wx.navigateTo({
                        url: '/pages/jw/jw?do=1'
                    })
                } else if (res.tapIndex == 1) {
                    wx.navigateTo({
                        url: '/pages/schedule/addClass'
                    })
                }
            },
            fail: function(res) {
                console.log(res);
            }
        })
    },

    seeClass: function(e) {
        this.setData({
            onlyThisWeek: e.detail.value
        })
        wx.setStorage({
            key: 'onlyThisWeek',
            data: e.detail.value,
            success: function(res) {

            },
            fail: function(res) {

            },
            complete: function(res) {

            }
        })
    },

    changeNum: function(e) {
        var num = parseInt(e.detail.value) + 5;
        wx.setStorage({
            key: 'classNum',
            data: num,
            success: function(res) {

            },
            fail: function(res) {

            },
            complete: function(res) {

            }
        })

        var classTime = wx.getStorageSync('classTime') || ["00:00"],
            temp = [];
        for (var i = 0; i <= num - 1; i++) {
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
        this.setData({
            classNum: num,
            scheduleTime: temp
        })
    },

    seeDetail: function(e) {
        // console.log(e);
        console.log(e.currentTarget.dataset.index);
        wx.navigateTo({
            url: '/pages/schedule/addClass?detail=' + e.currentTarget.dataset.index
        })
    },

    appearPlus: function(e) {
        console.log(e);
    }
})

function initTime(page) {
    var today = new Date(),
        setWeekTime = wx.getStorageSync("setWeekTime") || app.setWeek(1);
    var temp = {
            today: today.getDate(),
            thisWeek: setWeekTime.week + (Math.floor((today.getTime() - 316800000) / 604800000) - setWeekTime.timeWeek),
            thisMonth: today.getMonth(),
            month: today.getMonth(),
        },
        firstDay = today.getDate() - (today.getDay() == 0 ? 7 : today.getDay()) + 1;
    temp.weekValue = temp.thisWeek - 1;
    if (firstDay < 1) {
        if (today.getMonth() == 0) {
            firstDay = app.globalData.month[11] + firstDay;
            temp.month = 11;
        } else {
            firstDay = app.globalData.month[today.getMonth() - 1] + firstDay;
            temp.month += -1;
        }
    }
    console.log(firstDay);
    for (var i = 0; i <= 6; i++) {
        var tempName = "date[" + i + "].date";
        temp[tempName] = firstDay;
        if (firstDay + 1 > app.globalData.month[temp.month]) {
            firstDay = 1;
        } else {
            firstDay++;
        }
    }
    page.setData(temp);
}