define("function-widget-1:faceSearch/start.js",function(i,e,t){t.exports={start:function(i,e){var t,s;if(s="object"==typeof e&&e.filesList?e.filesList.length>0?e.filesList:[e.filesList]:i.list.getSelected(),s.length&&s.length>1)return void i.ui.tip({mode:"caution",msg:"只需选择一张图片哦~"});if(t=s[0],!t.fs_id)throw new Error("the fs_id of file is must!");window.open("/disk/facesearch?fsid="+t.fs_id)}}});