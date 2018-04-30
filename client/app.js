App({
    globalData: {
        hasBind: "0",
        class: wx.getStorageSync("class"),
        month: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
        colors: ["#93E7EA", "#BBEB59", "#CA90F4", "#92CEF4", "#86EDAA", "#F6C664", "#F19896", "#8FAFF8", "#F2A584", "#A791F8", "#F2A2D5", "#F4DF71"],
        week: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25],
    },
    onLaunch: function() {
        wx.login({
            success: (res) => {
                if (res.code) {
                    wx.request({
                        // 必需
                        url: 'http://120.79.221.7/wx_kebiao/login',
                        data: {
                            code: res.code
                        },
                        header: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        success: (res) => {
                            console.log(res);
                            this.globalData.hasBind = res.data.result
                            if (res.data.result == 1) {
                                this.globalData.msg = res.data.return
                            }
                            console.log(this.globalData)
                            if (this.setDataIndex) {
                                this.setDataIndex({
                                    msg: res.data.return,
                                    hasBind: res.data.result
                                })
                            }
                            wx.setStorage({
                                key: 'sessionid',
                                data: res.data.sessionid,
                                success: function(res) {
                                    console.log(res);
                                },
                                fail: function(res) {

                                },
                                complete: function(res) {

                                }
                            })
                        },
                        fail: (res) => {

                        },
                        complete: (res) => {

                        }
                    })
                }
            },
            fail: (res) => {

            },
            complete: (res) => {

            }
        })
        wx.getSetting({
            success: res => {
                if (res.authSetting['scope.userInfo']) {
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
                            this.globalData.userInfo = res.userInfo;
                            if (this.setDataIndex) {
                                this.setDataIndex({
                                    userInfo: res.userInfo
                                })
                            }
                        },
                        fail: (res) => {

                        },
                        complete: (res) => {

                        }
                    })
                }
            }
        })
        var today = new Date();
        if (today.getFullYear() % 4 == 0) {
            this.globalData.month[1] = 29;
        }
        console.log(typeof this.globalData.class)
    },
    setWeek: function(thisWeek) {
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
    },
    addClass: function(newClass) {
        newClass.color = this.globalData.colors[Math.round(11 * Math.random())];
        if (typeof this.globalData.class == "object") {
            var oldClass = this.globalData.class,
                repeat = 0;
            for (var i = oldClass.length - 1; i >= 0; i--) {
                if (newClass.day == oldClass[i].day) {
                    console.log("day");
                    if (!(oldClass[i].long[0] > newClass.long[1] || oldClass[i].long[1] < newClass.long[0])) {
                        console.log("long");
                        if (oldClass[i].single_week == newClass.single_week || newClass.single_week == 0 || oldClass[i].single_week == 0) {
                            console.log("single_week");
                            for (var j = newClass.class.length - 1; j >= 0; j--) {
                                if (oldClass[i].class.indexOf(newClass.class[j]) != -1) {
                                    console.log("class");
                                    repeat++;
                                }
                            }
                        }
                    }
                }
            }
        } else {
            wx.setStorage({
                key: 'class',
                data: [newClass]
            });
            wx.navigateBack();
            return;
        }
        console.log(repeat);
        if (repeat == 0) {
            oldClass.push(newClass);
            wx.setStorage({
                key: 'class',
                data: oldClass
            });
            wx.navigateBack();
        } else {
            wx.showModal({
                title: "警告",
                content: "检测到同时间段有课，是否继续添加？",
                success: function(res) {
                    if (res.confirm) {
                        oldClass.push(newClass);
                        wx.setStorage({
                            key: 'class',
                            data: oldClass
                        });
                        wx.navigateBack();
                    }
                }
            })
        }
    }
})