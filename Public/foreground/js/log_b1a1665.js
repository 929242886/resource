window.logConfigs=[{
  "event": {
    "li[node-type~='list-item']": {
      "eventType": "click",
      "logType": "count",
      "description": "访问类型统计",
      "callback": function (e,$) {
        var type = $(e.target).closest('li').data('key');
        return {
          "name":"leftSideNavigator",
          "sendServerLog": false,
          "value": type
        }
      }
    }
  },
  "ajax": {},
  "mix": {}
},{
    "mix" : {
        "s_imgLoad" : {
            "logType": "time",
            "description" : "小缩略图"
        }
    }
},{
    "event":{
        "a.no-result-download-phone":{
            "eventType":"click",
            "logType":"count",
            "description":"下载引导-手机版下载",
            "callback":function(){
                return {
                    "name":"downloadOfCellphone",
                    "sendServerLog":false,
                    "value":"cellphone"
                }
            }
        },
        "a.no-result-download-ipad":{
            "eventType":"click",
            "logType":"count",
            "description":"下载引导-ipad版下载",
            "callback":function(){
            return {
                    "name":"downloadOfiPad",
                    "sendServerLog":false,
                    "value":"ipad"
                }
            }
        },
        "a.no-result-download-pc":{
            "eventType":"click",
            "logType":"count",
            "description":"下载引导-pc版下载",
            "callback":function(){
                return {
                    "name":"downloadOfPC",
                    "sendServerLog":false,
                    "value":"pc"
                }
            }
        }
    },
    "mix": {
        "listListHover": {
            "logType": "time", 
            "description" : "列表模式列表hover响应时间统计"
        },
        "gridListHover": {
            "logType": "time", 
            "description" : "缩略图模式列表hover响应时间统计"
        },
        "listListSingleSel": {
            "logType": "time", 
            "description" : "列表模式列表单选响应时间统计"
        },
        "gridListSingleSel": {
            "logType": "time", 
            "description" : "缩略图模式列表单选响应时间统计"
        },
        "listListMultiSel": {
            "logType": "time", 
            "description" : "列表模式列表多选响应时间统计"
        },
        "gridListMultiSel": {
            "logType": "time", 
            "description" : "缩略图模式列表多选响应时间统计"
        },
        "listInsertItem": {
            "logType": "time", 
            "description" : "列表插入一条记录的响应时间统计"
        }
    }
},{
    "mix": {
    "chrome-extension": {
      "description": "chrome插件调用次数"
    }
  }
}
,{
    "event" : {

    },
    "ajax" : {
        
    },
    "mix" : {
        "buttonBoxCreate" : {
            "logType": "time", 
            "description" : "buttonBox从创建到展现的时间"
        },
        "buttonClick" : {
            "logType": "count", 
            "description" : "所有的按钮统计"
        }
    }
},{
    "event" : {

    },
    "ajax" : {
        
    },
    "mix" : {
        "buttonCreate" : {
            "logType": "time", 
            "description" : "button从创建到展现的时间"
        },
        "buttonHover" : {
            "logType": "time", 
            "description" : "button状态变化的时间"
        }
    }
},{
    "event" : {

    },
    "ajax" : {

    },
    "mix" : {
        "fileTreeRender" : {
            "logType": "time",
            "description" : "文件目录树渲染时间"
        }
    }
}
,{
    "event" : {

    },
    "ajax" : {

    },
    "mix" : {
        "dialogShow-file" : {
            "logType": "time",
            "description" : "文件列表弹框展现时间"
        }
    }
}
,{
    "mix": {
        "listAllSel": {
            "logType": "time", 
            "description" : "列表全选响应时间统计"
        },
        "listInitTime": {
            "logType": "time", 
            "description" : "列表初始化时间统计"
        },
        "listScrollTime": {
            "logType": "time", 
            "description" : "列表滚动响应时间统计"
        }
    }
},{
    "event" : {

    },
    "ajax" : {

    },
    "mix" : {
        "tipShow" : {
            "logType": "time",
            "description" : "tip展现时间"
        }
    }
}
],"http:"===location.protocol&&(window.onload=function(){if(alog&&testServerTimestamp){var e={};testServerTimestamp>-6e4&&6e4>=testServerTimestamp?e.z_testServerTimestamp="1min":testServerTimestamp>-6e5&&6e5>=testServerTimestamp?e.z_testServerTimestamp="10min":testServerTimestamp>-36e5&&36e5>=testServerTimestamp?e.z_testServerTimestamp="1hour":testServerTimestamp>-864e5&&864e5>=testServerTimestamp?e.z_testServerTimestamp="1day":testServerTimestamp>-6048e5&&6048e5>=testServerTimestamp?e.z_testServerTimestamp="1week":testServerTimestamp>-2592e6&&2592e6>=testServerTimestamp&&(e.z_testServerTimestamp="1month"),alog("cus.fire","dis",e)}});