App({
    globalData: {
        month: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
        colors: ["#93E7EA", "#BBEB59", "#CA90F4", "#92CEF4", "#86EDAA", "#F6C664", "#F19896", "#8FAFF8", "#F2A584", "#A791F8", "#F2A2D5", "#F4DF71"]
    },
    onLaunch: function() {
        wx.login({
            success: (res) => {
                if (res.code) {
                    wx.request({
                        // 必需
                        url: 'http://120.79.221.7/wx_kebiao/login',
                        data: {
                            code:res.code
                        },
                        header: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        success: (res) => {
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
        var today = new Date();
        if (today.getFullYear() % 4 == 0) {
            this.globalData.month[1] = 29;
        }
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
        if (typeof newClass == "Object") {
            newClass.color = this.globalData.colors[Math.round(11 * Math.random())];
            if (wx.getStorageSync("class")) {
                var oldClass = wx.getStorageSync("class"),
                    repeat = 0;
                for (var i = oldClass.length - 1; i >= 0; i--) {
                    if (newClass.day == oldClass[i].day) {
                        if (oldClass[i].long[0] < newClass.long[0] && oldClass[i].long[1] > newClass.long[0] || oldClass[i].long[0] < newClass.long[1] && oldClass[i].long[1] > newClass.long[1]) {
                            if (oldClass[i].single_week == newClass.single_week || newClass.single_week == 0 || oldClass[i].single_week == 0) {
                                for (var i = newClass.class.length - 1; i >= 0; i--) {
                                    if (oldClass[i].class.indexOf(newClass.class[i]) != -1) {
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
                return;
            }
            if (repeat != 0) {
                oldClass.push(newClass);
                wx.setStorage({
                    key: 'class',
                    data: oldClass
                });
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
                        }
                    }
                })
            }
        } else {
            for (var i = newClass.length - 1; i >= 0; i--) {
                newClass[i].color =  this.globalData.colors[Math.round(11 * Math.random())];
            }
            wx.setStorage({
                key: 'class',
                data: newClass
            });
        }
    }
})