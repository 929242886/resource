define("disk-system:widget/plugin/header/view/header.tpl.js",function(e,d,r){r.exports='<div node-type="module" class="module-header"><!-- header fragment --><div node-type="module-header-wrapper" style="height: 49px; background-color: #252525;"><!-- loading header ... --></div><!-- /header fragment --></div>'});
;define("disk-system:widget/plugin/header/header.js",function(e,a,t){var r,n=e("base:widget/libs/jquerypacket.js"),o=e("system-core:context/context.js").instanceForSystem,s=e("system-core:system/baseService/message/message.js"),d=e("disk-system:widget/plugin/header/view/header.tpl.js"),i={mod:"div.module-header",wrapper:'div[node-type~="module-header-wrapper"]'},c=function(e){e.html(d),void 0===r&&(r=n(i.mod)),u()},m=function(e,a){var t=null,r=document.getElementsByTagName("head")[0];t=document.createElement("script"),t.type="text/javascript",t.src=e,"function"==typeof a&&(window.attachEvent?t.onreadystatechange=function(){var e=t.readyState;("loaded"===e||"complete"===e)&&(t.onreadystatechange=null,a())}:t.onload=a),r.appendChild(t)},u=function(){window.$=window.jQuery=n;var e="https:"==document.location.protocol?" https://":"http://",a=e+"yun.baidu.com/ppres/static/thirdparty/header/module_header.js",a="/ppres/static/thirdparty/header/module_header.js",t=function(){var e={mods:["NAVS","AD","PERSONAL_INFO","NOTICE","DOWNLOAD","MORE"],navCurrent:"网盘",searchBoxPlaceHold:"搜索你的文件",vip:yunData.ISVIP,svip:yunData.ISSVIP,nickName:yunData.MYNAME,isLogin:yunData.LOGINSTATUS},a=o.pageInfo.currentPage;"disk-home"===a&&e.mods.push("SEARCH_BOX");var t=o.tools.baseService.getParam("frm");"hao123"==t&&(e.unionLogo=["hao123"]),"bbn"==t&&(e.unionLogo=["unicom"]);var n=new yunHeader.Header(e);"disk-home"===a&&(n.listen("searchFormSubmit",function(e){e=e.trim(),s.trigger("header-search",e)}),s.listen("header-search-val",function(e){n.setSearchFormValue(e)})),r.find(i.wrapper).empty().append(n.$el)};m(a,t),"hao123-iframe"===o.tools.baseService.getParam("frm")&&r.hide()};t.exports={renderAndInit:c}});
;define("disk-system:widget/plugin/header/start.js",function(e,t,n){var i=e("disk-system:widget/plugin/header/header.js"),s={start:function(e,t){i.renderAndInit(t.$container)}};n.exports=s});
;define("disk-system:widget/plugin/header/util/context.js",function(t,e,n){var o={context:null},i={getContext:function(){return o.context},setContext:function(t){o.context=t}};n.exports=i});