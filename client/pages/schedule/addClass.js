// pages/addClass/addClass.js

const app = getApp();

Page({

    /**
     * 页面的初始数据
     */
    data: {
        weekDay: ["周一", "周二", "周三", "周四", "周五", "周六", "周日"],
        week: app.globalData.week,
        startWeek: 1,
        endWeek: 25,
        day: 0,
        classTime: [0, 0],
        single_week: "0",
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        console.log(options);
        var classNum = wx.getStorageSync('classNum') || 12,
            temp = {
                startClass: [],
                endClass: []
            };
        for (var i = 0; i < classNum; i++) {
            temp.startClass.push(i + 1);
            temp.endClass.push("到" + (i + 1));
        }
        if (options.detail) {
            var classMsg = app.globalData.class[parseInt(options.detail)];
            wx.setNavigationBarTitle({
                title: classMsg.classname,
                fail: (res) => {
                    console.log(res)
                },
            })
            temp.classname = classMsg.classname;
            temp.day = parseInt(classMsg.day) - 1;
            temp.classTime = [parseInt(classMsg.class[0]) - 1, parseInt(classMsg.class[classMsg.class.length - 1]) - 1];
            temp.startWeek = parseInt(classMsg.long[0]);
            temp.endWeek = parseInt(classMsg.long[1]);
            temp.teacher = classMsg.teacher;
            temp.classroom = classMsg.classroom;
            temp.single_week = classMsg.single_week;
            temp.color = classMsg.color;
            temp.detail = options.detail;
        }
        this.setData(temp);
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

    initData: function() {
        var temp = {
            classname: this.data.classname || "",
            day: this.data.day + 1,
            class: [],
            long: [this.data.startWeek, this.data.endWeek],
            teacher: this.data.teacher || "",
            classroom: this.data.classroom || "",
            single_week: this.data.single_week || "0",
            color: this.data.color || undefined
        };
        for (var i = this.data.classTime[0]; i <= this.data.classTime[1]; i++) {
            temp.class.push(i + 1 + "");
        }
        return temp;
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
    },

    setClassTime: function(e) {
        var temp = {
            "day": parseInt(e.detail.value[0]),
            classTime: [parseInt(e.detail.value[1]), parseInt(e.detail.value[2])]
        }
        if (temp.classTime[1] < temp.classTime[0]) {
            temp.classTime[1] = temp.classTime[0];
        }
        this.setData(temp);
    },

    dataChange: function(e) {
        var temp = {},
            name = e.target.dataset.name;
        temp[name] = e.detail.value;
        this.setData(temp);
    },

    save: function(e) {
        var temp = this.initData();
        // console.log(temp);
        app.addClass(temp);
        app.updateSchedule({
            class: app.globalData.class
        });
        this.update();
        // console.log(typeof temp);
        // wx.navigateBack();
    },

    change: function() {
        var temp = this.initData();
        app.globalData.class[this.data.detail] = temp;
        wx.setStorage({
            key: 'class',
            data: app.globalData.class,
            success: function(res) {

            },
            fail: function(res) {

            },
            complete: function(res) {

            }
        })
        this.update();
        app.updateSchedule({
            class: app.globalData.class
        });
        wx.navigateBack();
    },

    del: function() {
        wx.showModal({
            title: '',
            content: '确定要删除吗？',
            showCancel: true,
            cancelText: '取消',
            cancelColor: '#000000',
            confirmText: '确定',
            confirmColor: '#3CC51F',
            success: (res) => {
                // res.confirm 为 true 时，表示用户点击了确定按钮
                if (res.confirm) {
                    app.globalData.class.splice(this.data.detail, 1);
                    wx.setStorage({
                        key: 'class',
                        data: app.globalData.class,
                        success: function(res) {

                        },
                        fail: function(res) {

                        },
                        complete: function(res) {

                        }
                    })
                    this.update();
                    app.updateSchedule({
                        class: app.globalData.class
                    });
                    wx.navigateBack();
                }
            },
            fail: (res) => {

            },
            complete: (res) => {

            }
        })
    },

    update: function() {
        console.log(JSON.stringify(app.globalData.class))
        wx.request({
            // 必需
            url: app.globalData.host + 'wx_kebiao/kebiao/manualmodify',
            method: "POST",
            data: {
                class_list: JSON.stringify(app.globalData.class)
            },
            header: {
                'Content-Type': 'application/x-www-form-urlencoded',
                "cookie": "PHPSESSID=" + wx.getStorageSync('sessionid')
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