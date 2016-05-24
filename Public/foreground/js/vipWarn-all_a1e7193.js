define("interface-widget-1:vipWarn/context.js",function(t,e,n){var o={context:null},i=t("interface-widget-1:vipWarn/log.js"),c={getContext:function(){return o.context},setContext:function(t){o.context=t,t&&t.log&&t.log.define(i)}};n.exports=c});
;define("interface-widget-1:vipWarn/log.js",function(){var e={event:{},mix:{"超级会员到期提醒":{logType:"count",description:"到期提醒"}}};return e});
;define("interface-widget-1:vipWarn/start.js",function(n,t,e){var i=n("interface-widget-1:vipWarn/context.js"),r=n("interface-widget-1:vipWarn/vipWarn.js"),a={start:function(n,t){if(i.setContext(n),!t||!t.$container)throw new Error("The $container is null !");r.initAndRender(t.$container)}};e.exports=a});
;define("interface-widget-1:vipWarn/vipWarn.js",function(e,t,i){var n=e("interface-widget-1:vipWarn/context.js"),a=e("base:widget/libs/jquerypacket.js"),o=e("base:widget/libs/underscore.js"),s=window.yunData,r={mod:"div.aside-absolute-container",capacity:'div[node-type~="capacity"]',overdueLink:'a[node-type="overdue-link"]',tips:'div[node-type="overdue-tips"]',tipClose:"i.overdue-close"},d={getTpl:function(e){var t;t=s.ISSVIP?'<em class="overdue-icon overdue-icon-svip" node-type="overdue-icon"></em>':s.ISVIP?'<em class="overdue-icon overdue-icon-vip" node-type="overdue-icon"></em>':'<em class="overdue-icon overdue-icon-novip" node-type="overdue-icon"></em>';var i=['<div node-type="overdue-tips" class="g-clearfix overdue-tips"><div class="overdue-warp">',t,'<span class="overdue-text"><%= title %></span>','<i class="overdue-close" '+(e.isQuota?"":' style="display:none;"')+">×</i>","</div><p>",'<span node-type="overdue-extra" class="overdue-extra"><%= notice %></span>','<a node-type="overdue-link" href="javascript:void(0)" class="pay-button"><%= statusText %></a></p>','<em class="bottom-tip" '+(e.isQuota?"":' style="display:none;"')+"></em>","</div>"];return o.template(i.join(""))(e)},toPayVip:function(e,t){var i=!!d.wholeData.svip;e||(e=i?"svip":"vip"),t||(t="reminder"+(i?"1":"0")),n.getContext().message.callPlugin("网盘收银台@com.baidu.pan",{type:e,from:t}),window.operationADUnderCrown(e+"_"+t)},bindStatistics:function(){var e=a.Callbacks();e.add(function(e){n.getContext().log.send({name:"超级会员到期提醒",value:e})}),window.operationADUnderCrown=function(t){if(null===this||!t)throw new Error("are you kidding me?");e.fire(t)}},isShowQuota:function(e,t){var i=d.wholeData;return"svip"in i&&null!==d.reminderData?(i=i.svip,e=parseFloat(e),t=parseFloat(t),e>t-3e3&&"nextState"in i&&i.leftseconds<432e3?i.leftseconds<86400?"today":"already":!1):!1},init:function(){var e=a.Callbacks();e.add(function(e){d.wholeData=e,d.isCallbacksCalled=!0;var t=e.reminderWithContent;o.isObject(t)&&t.title&&t.notice&&(/过期/.test(t.title)?(t.statusText="立即开通",l.setStateText(l.stateTextList.EXPIRED)):(t.statusText="续费",l.setStateText(l.stateTextList.UNEXPIRED),l.showGuideOfRecyclebin()),d.reminderData=t),d.renderDataToPage()}),window.superMemberTip=function(t){if(null===this||!t)throw new Error("are you kidding me?");e.fire(t)};var t=a.Callbacks();t.add(function(e,t){d.toPayVip(e,t)}),window.callMemberFeeWindow=function(e,i){t.fire(e,i)};var i={isQuota:!0,title:"超级会员即将到期",notice:"超大空间将回收，上传等功能将暂停，文件不删除，赶快续费吧~",statusText:"续费"};d.quotaTipTpl={already:d.getTpl(i)},i.title="超级会员今日到期",d.quotaTipTpl.today=d.getTpl(i),d.bindStatistics()},reminderData:null,wholeData:null,isCallbacksCalled:!1,isOuterCalled:!1,container:null,renderDataToPage:function(){if(this.isCallbacksCalled&&this.isOuterCalled){var e=a(r.mod),t=this.container,i=e.find(r.capacity);if(!i.is(":visible")){var o=this;null===d.reminderData&&n.getContext().message.callPlugin("网盘容量@com.baidu.pan",{showType:"showQuotaTip"});var l=function(){var i=s.QUOTAINFOS.total,n=s.QUOTAINFOS.used;if(i&&n){var c="",u=0,p=d.isShowQuota(i,n);if(p)c="already"===p?d.quotaTipTpl.already:d.quotaTipTpl.today,u=30,window.operationADUnderCrown("quotaBubbleTip");else{if(!o.reminderData)return;c=o.getTpl(o.reminderData),u=d.reminderData.notice.length,window.operationADUnderCrown("permanentExpiredTip")}t.append(c),e.find(r.overdueLink).on("click",function(){d.toPayVip(null,null);var e="clickInPermanentExpiredTip";p&&(e="clickAddInQuotaTip"),window.operationADUnderCrown(e)}),e.find(r.tipClose).on("click",function(){a(this).closest(".overdue-tips").hide()}),u>26&&e.find(r.tips).css("bottom","40px")}else setTimeout(function(){l()},300)};l()}}}};d.init();var l={body:a(document.body),stateText:"",stateTextList:{UNEXPIRED:"您有文件将过期被删",EXPIRED:"您有文件今日过期被删"},setStateText:function(e){this.stateText=e},showGuideOfRecyclebin:function(){a.ajax({url:"/api/recycle/list",type:"get",cache:!0,dataType:"json",success:function(e){e&&0===e.errno&&e.list.length>0&&l.show()}})},show:function(){a('<div class="recyclebin-tip">'+this.stateText+"</div>").appendTo(this.body)}},c={initAndRender:function(e){d.isOuterCalled=!0,d.container=e,d.renderDataToPage()}};i.exports=c});