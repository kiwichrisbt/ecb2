// ecb2_admin.js - v1.2 - 16Feb19
//
//      - v1.4 - 22Jun22 - bring colpick & jQuery timepicker addon into this file
//     - v1.3 - 20Jun22 - bug fix - test if 'colpick' method exists before calling it!
//     - v1.2 - 16Feb19 - ecb_repeater added
//                      - began consolidating all js into this file
//     - v1.1 - 11Jul17 - updated for max_number & required_number & updateECB2Placeholder()
//     - v1.0 - 18Apr17 - initial js file
//
//    enables drag-n-drop selection of list items, requires jquery ui sortable
//
//**************************************************************************************************



/*
colpick Color Picker
Copyright 2013 Jose Vargas. Licensed under GPL license. Based on Stefan Petre's Color Picker www.eyecon.ro, dual licensed under the MIT and GPL licenses

For usage and examples: colpick.com/plugin
 */
!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof exports?t(require("jquery")):t(jQuery)}((function(t){var e,i,a,o,c,l,r,n,d,s,p,u,f,h,v,g,k,_,m,b,y,x,w,I,M,C,q,T,S,E,D=(i={showEvent:"click",onShow:function(){},onBeforeShow:function(){},onHide:function(){},onChange:function(){},onSubmit:function(){},colorScheme:"light",color:"3289c7",livePreview:!0,flat:!1,layout:"full",submit:1,submitText:"OK",height:156,polyfill:!1},a=function(e,i){var a=N(e);t(i).data("colpick").fields.eq(1).val(a.r).end().eq(2).val(a.g).end().eq(3).val(a.b).end()},o=function(e,i){t(i).data("colpick").fields.eq(4).val(Math.round(e.h)).end().eq(5).val(Math.round(e.s)).end().eq(6).val(Math.round(e.b)).end()},c=function(e,i){t(i).data("colpick").fields.eq(0).val(z(e))},l=function(e,i){t(i).data("colpick").selector.css("backgroundColor","#"+z({h:e.h,s:100,b:100})),t(i).data("colpick").selectorIndic.css({left:parseInt(t(i).data("colpick").height*e.s/100,10),top:parseInt(t(i).data("colpick").height*(100-e.b)/100,10)})},r=function(e,i){t(i).data("colpick").hue.css("top",parseInt(t(i).data("colpick").height-t(i).data("colpick").height*e.h/360,10))},n=function(e,i){t(i).data("colpick").currentColor.css("backgroundColor","#"+z(e))},d=function(e,i){t(i).data("colpick").newColor.css("backgroundColor","#"+z(e))},s=function(e){var i,n=t(this).parent().parent();this.parentNode.className.indexOf("_hex")>0?(n.data("colpick").color=i=Y(T(this.value)),a(i,n.get(0)),o(i,n.get(0))):this.parentNode.className.indexOf("_hsb")>0?(n.data("colpick").color=i=C({h:parseInt(n.data("colpick").fields.eq(4).val(),10),s:parseInt(n.data("colpick").fields.eq(5).val(),10),b:parseInt(n.data("colpick").fields.eq(6).val(),10)}),a(i,n.get(0)),c(i,n.get(0))):(n.data("colpick").color=i=H(q({r:parseInt(n.data("colpick").fields.eq(1).val(),10),g:parseInt(n.data("colpick").fields.eq(2).val(),10),b:parseInt(n.data("colpick").fields.eq(3).val(),10)})),c(i,n.get(0)),o(i,n.get(0))),l(i,n.get(0)),r(i,n.get(0)),d(i,n.get(0)),n.data("colpick").onChange.apply(n.parent(),[i,z(i),N(i),n.data("colpick").el,0])},p=function(e){t(this).parent().removeClass("colpick_focus")},u=function(){t(this).parent().parent().data("colpick").fields.parent().removeClass("colpick_focus"),t(this).parent().addClass("colpick_focus")},f=function(e){e.preventDefault?e.preventDefault():e.returnValue=!1;var i=t(this).parent().find("input").focus(),a={el:t(this).parent().addClass("colpick_slider"),max:this.parentNode.className.indexOf("_hsb_h")>0?360:this.parentNode.className.indexOf("_hsb")>0?100:255,y:e.pageY,field:i,val:parseInt(i.val(),10),preview:t(this).parent().parent().data("colpick").livePreview};t(document).mouseup(a,v),t(document).mousemove(a,h)},h=function(t){return t.data.field.val(Math.max(0,Math.min(t.data.max,parseInt(t.data.val-t.pageY+t.data.y,10)))),t.data.preview&&s.apply(t.data.field.get(0),[!0]),!1},v=function(e){return s.apply(e.data.field.get(0),[!0]),e.data.el.removeClass("colpick_slider").find("input").focus(),t(document).off("mouseup",v),t(document).off("mousemove",h),!1},g=function(e){e.preventDefault?e.preventDefault():e.returnValue=!1;var i={cal:t(this).parent(),y:t(this).offset().top};t(document).on("mouseup touchend",i,_),t(document).on("mousemove touchmove",i,k);var a="touchstart"==e.type?e.originalEvent.changedTouches[0].pageY:e.pageY;return s.apply(i.cal.data("colpick").fields.eq(4).val(parseInt(360*(i.cal.data("colpick").height-(a-i.y))/i.cal.data("colpick").height,10)).get(0),[i.cal.data("colpick").livePreview]),!1},k=function(t){var e="touchmove"==t.type?t.originalEvent.changedTouches[0].pageY:t.pageY;return s.apply(t.data.cal.data("colpick").fields.eq(4).val(parseInt(360*(t.data.cal.data("colpick").height-Math.max(0,Math.min(t.data.cal.data("colpick").height,e-t.data.y)))/t.data.cal.data("colpick").height,10)).get(0),[t.data.preview]),!1},_=function(e){return a(e.data.cal.data("colpick").color,e.data.cal.get(0)),c(e.data.cal.data("colpick").color,e.data.cal.get(0)),t(document).off("mouseup touchend",_),t(document).off("mousemove touchmove",k),!1},m=function(e){e.preventDefault?e.preventDefault():e.returnValue=!1;var i,a,o={cal:t(this).parent(),pos:t(this).offset()};return o.preview=o.cal.data("colpick").livePreview,t(document).on("mouseup touchend",o,y),t(document).on("mousemove touchmove",o,b),"touchstart"==e.type?(i=e.originalEvent.changedTouches[0].pageX,a=e.originalEvent.changedTouches[0].pageY):(i=e.pageX,a=e.pageY),s.apply(o.cal.data("colpick").fields.eq(6).val(parseInt(100*(o.cal.data("colpick").height-(a-o.pos.top))/o.cal.data("colpick").height,10)).end().eq(5).val(parseInt(100*(i-o.pos.left)/o.cal.data("colpick").height,10)).get(0),[o.preview]),!1},b=function(t){var e,i;return"touchmove"==t.type?(e=t.originalEvent.changedTouches[0].pageX,i=t.originalEvent.changedTouches[0].pageY):(e=t.pageX,i=t.pageY),s.apply(t.data.cal.data("colpick").fields.eq(6).val(parseInt(100*(t.data.cal.data("colpick").height-Math.max(0,Math.min(t.data.cal.data("colpick").height,i-t.data.pos.top)))/t.data.cal.data("colpick").height,10)).end().eq(5).val(parseInt(100*Math.max(0,Math.min(t.data.cal.data("colpick").height,e-t.data.pos.left))/t.data.cal.data("colpick").height,10)).get(0),[t.data.preview]),!1},y=function(e){return a(e.data.cal.data("colpick").color,e.data.cal.get(0)),c(e.data.cal.data("colpick").color,e.data.cal.get(0)),t(document).off("mouseup touchend",y),t(document).off("mousemove touchmove",b),!1},x=function(e){var i=t(this).parent(),a=i.data("colpick").color;i.data("colpick").origColor=a,n(a,i.get(0)),i.data("colpick").onSubmit(a,z(a),N(a),i.data("colpick").el)},w=function(e){e&&e.stopPropagation();var i=t("#"+t(this).data("colpickId"));e&&!i.data("colpick").polyfill&&e.preventDefault(),i.data("colpick").onBeforeShow.apply(this,[i.get(0)]);var a=t(this).offset(),o=a.top+this.offsetHeight,c=a.left,l=M(),r=i.width();c+r>l.l+l.w&&(c-=r),i.css({left:c+"px",top:o+"px"}),0!=i.data("colpick").onShow.apply(this,[i.get(0)])&&i.show(),t("html").mousedown({cal:i},I),i.mousedown((function(t){t.stopPropagation()}))},I=function(e){var i=t("#"+t(this).data("colpickId"));e&&(i=e.data.cal),0!=i.data("colpick").onHide.apply(this,[i.get(0)])&&i.hide(),t("html").off("mousedown",I)},M=function(){var t="CSS1Compat"==document.compatMode;return{l:window.pageXOffset||(t?document.documentElement.scrollLeft:document.body.scrollLeft),w:window.innerWidth||(t?document.documentElement.clientWidth:document.body.clientWidth)}},C=function(t){return{h:Math.min(360,Math.max(0,t.h)),s:Math.min(100,Math.max(0,t.s)),b:Math.min(100,Math.max(0,t.b))}},q=function(t){return{r:Math.min(255,Math.max(0,t.r)),g:Math.min(255,Math.max(0,t.g)),b:Math.min(255,Math.max(0,t.b))}},T=function(t){var e=6-t.length;if(3==e){for(var i=[],a=0;a<e;a++)i.push(t[a]),i.push(t[a]);t=i.join("")}else if(e>0){for(var o=[],c=0;c<e;c++)o.push("0");o.push(t),t=o.join("")}return t},e=0,S=function(){return e+=1},E=function(){var e=t(this).parent(),i=e.data("colpick").origColor;e.data("colpick").color=i,a(i,e.get(0)),c(i,e.get(0)),o(i,e.get(0)),l(i,e.get(0)),r(i,e.get(0)),d(i,e.get(0))},{init:function(e){if("string"==typeof(e=t.extend({},i,e||{})).color)e.color=Y(e.color);else if(null!=e.color.r&&null!=e.color.g&&null!=e.color.b)e.color=H(e.color);else{if(null==e.color.h||null==e.color.s||null==e.color.b)return this;e.color=C(e.color)}return this.each((function(){if(!t(this).data("colpickId")){var i=t.extend({},e);if(i.origColor=e.color,"function"==typeof e.polyfill&&(i.polyfill=e.polyfill(this)),i.input=t(this).is("input"),i.polyfill&&i.input&&"color"===this.type)return;var h="colorpicker_"+S();t(this).data("colpickId",h);var v=t('<div class="colpick"><div class="colpick_color"><div class="colpick_color_overlay1"><div class="colpick_color_overlay2"><div class="colpick_selector_outer"><div class="colpick_selector_inner"></div></div></div></div></div><div class="colpick_hue"><div class="colpick_hue_arrs"><div class="colpick_hue_larr"></div><div class="colpick_hue_rarr"></div></div></div><div class="colpick_new_color"></div><div class="colpick_current_color"></div><div class="colpick_hex_field"><div class="colpick_field_letter">#</div><input type="text" maxlength="6" size="6" /></div><div class="colpick_rgb_r colpick_field"><div class="colpick_field_letter">R</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_rgb_g colpick_field"><div class="colpick_field_letter">G</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_rgb_b colpick_field"><div class="colpick_field_letter">B</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_hsb_h colpick_field"><div class="colpick_field_letter">H</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_hsb_s colpick_field"><div class="colpick_field_letter">S</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_hsb_b colpick_field"><div class="colpick_field_letter">B</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_submit"></div></div>').attr("id",h);v.addClass("colpick_"+i.layout+(i.submit?"":" colpick_"+i.layout+"_ns")),"light"!=i.colorScheme&&v.addClass("colpick_"+i.colorScheme),v.find("div.colpick_submit").html(i.submitText).click(x),i.fields=v.find("input").change(s).blur(p).focus(u),v.find("div.colpick_field_arrs").mousedown(f).end().find("div.colpick_current_color").click(E),i.selector=v.find("div.colpick_color").on("mousedown touchstart",m),i.selectorIndic=i.selector.find("div.colpick_selector_outer"),i.el=this,i.hue=v.find("div.colpick_hue_arrs");var k=i.hue.parent(),_=navigator.userAgent.toLowerCase(),b="Microsoft Internet Explorer"===navigator.appName,y=b?parseFloat(_.match(/msie ([0-9]{1,}[\.0-9]{0,})/)[1]):0,I=["#ff0000","#ff0080","#ff00ff","#8000ff","#0000ff","#0080ff","#00ffff","#00ff80","#00ff00","#80ff00","#ffff00","#ff8000","#ff0000"];if(b&&y<10){var M,C;for(M=0;M<=11;M++)C=t("<div></div>").attr("style","height:8.333333%; filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr="+I[M]+", endColorstr="+I[M+1]+'); -ms-filter: "progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='+I[M]+", endColorstr="+I[M+1]+')";'),k.append(C)}else{var q=I.join(",");k.attr("style","background:-webkit-linear-gradient(top,"+q+"); background: -o-linear-gradient(top,"+q+"); background: -ms-linear-gradient(top,"+q+"); background:-moz-linear-gradient(top,"+q+"); -webkit-linear-gradient(top,"+q+"); background:linear-gradient(to bottom,"+q+"); ")}v.find("div.colpick_hue").on("mousedown touchstart",g),i.newColor=v.find("div.colpick_new_color"),i.currentColor=v.find("div.colpick_current_color"),v.data("colpick",i),a(i.color,v.get(0)),o(i.color,v.get(0)),c(i.color,v.get(0)),r(i.color,v.get(0)),l(i.color,v.get(0)),n(i.color,v.get(0)),d(i.color,v.get(0)),i.flat?(v.appendTo(this).show(),v.css({position:"relative",display:"block"})):(v.appendTo(t(this).parent()),t(this).on(i.showEvent,w),v.css({position:"absolute"}))}}))},showPicker:function(){return this.each((function(){t(this).data("colpickId")&&w.apply(this)}))},hidePicker:function(){return this.each((function(){t(this).data("colpickId")&&I.apply(this)}))},setColor:function(e,i){if(null!=e){if(i=void 0===i?1:i,"string"==typeof e)e=Y(e);else if(null!=e.r&&null!=e.g&&null!=e.b)e=H(e);else{if(null==e.h||null==e.s||null==e.b)return this;e=C(e)}return this.each((function(){if(t(this).data("colpickId")){var s=t("#"+t(this).data("colpickId"));s.data("colpick").color=e,s.data("colpick").origColor=e,a(e,s.get(0)),o(e,s.get(0)),c(e,s.get(0)),r(e,s.get(0)),l(e,s.get(0)),d(e,s.get(0)),s.data("colpick").onChange.apply(s.parent(),[e,z(e),N(e),s.data("colpick").el,1]),i&&n(e,s.get(0))}}))}},destroy:function(e,i){t("#"+t(this).data("colpickId")).remove()}}),P=function(t){return{r:(t=parseInt(t.indexOf("#")>-1?t.substring(1):t,16))>>16,g:(65280&t)>>8,b:255&t}},Y=function(t){return H(P(t))},H=function(t){var e={h:0,s:0,b:0},i=Math.min(t.r,t.g,t.b),a=Math.max(t.r,t.g,t.b),o=a-i;return e.b=a,e.s=0!=a?255*o/a:0,0!=e.s?t.r==a?e.h=(t.g-t.b)/o:t.g==a?e.h=2+(t.b-t.r)/o:e.h=4+(t.r-t.g)/o:e.h=-1,e.h*=60,e.h<0&&(e.h+=360),e.s*=100/255,e.b*=100/255,e},N=function(t){var e={},i=t.h,a=255*t.s/100,o=255*t.b/100;if(0==a)e.r=e.g=e.b=o;else{var c=o,l=(255-a)*o/255,r=i%60*(c-l)/60;360==i&&(i=0),i<60?(e.r=c,e.b=l,e.g=l+r):i<120?(e.g=c,e.b=l,e.r=c-r):i<180?(e.g=c,e.r=l,e.b=l+r):i<240?(e.b=c,e.r=l,e.g=c-r):i<300?(e.b=c,e.g=l,e.r=l+r):i<360?(e.r=c,e.g=l,e.b=c-r):(e.r=0,e.g=0,e.b=0)}return{r:Math.round(e.r),g:Math.round(e.g),b:Math.round(e.b)}},j=function(e){var i=[e.r.toString(16),e.g.toString(16),e.b.toString(16)];return t.each(i,(function(t,e){1==e.length&&(i[t]="0"+e)})),i.join("")},z=function(t){return j(N(t))};t.fn.extend({colpick:D.init,colpickHide:D.hidePicker,colpickShow:D.showPicker,colpickSetColor:D.setColor,colpickDestroy:D.destroy}),t.extend({colpick:{rgbToHex:j,rgbToHsb:H,hsbToHex:z,hsbToRgb:N,hexToHsb:Y,hexToRgb:P}})}));



/*
 * jQuery timepicker addon
 * By: Trent Richardson [http://trentrichardson.com]
 * Version 1.1.1
 * Last Modified: 11/07/2012
 *
 * Copyright 2012 Trent Richardson
 * You may use this project under MIT or GPL licenses.
 * http://trentrichardson.com/Impromptu/GPL-LICENSE.txt
 * http://trentrichardson.com/Impromptu/MIT-LICENSE.txt
 */
(function($){if($.ui.timepicker=$.ui.timepicker||{},!$.ui.timepicker.version){$.extend($.ui,{timepicker:{version:"1.1.1"}}),$.extend(Timepicker.prototype,{$input:null,$altInput:null,$timeObj:null,inst:null,hour_slider:null,minute_slider:null,second_slider:null,millisec_slider:null,timezone_select:null,hour:0,minute:0,second:0,millisec:0,timezone:null,defaultTimezone:"+0000",hourMinOriginal:null,minuteMinOriginal:null,secondMinOriginal:null,millisecMinOriginal:null,hourMaxOriginal:null,minuteMaxOriginal:null,secondMaxOriginal:null,millisecMaxOriginal:null,ampm:"",formattedDate:"",formattedTime:"",formattedDateTime:"",timezoneList:null,units:["hour","minute","second","millisec"],control:null,setDefaults:function(e){return extendRemove(this._defaults,e||{}),this},_newInst:function($input,o){var tp_inst=new Timepicker,inlineSettings={},fns={},overrides,i;for(var attrName in this._defaults)if(this._defaults.hasOwnProperty(attrName)){var attrValue=$input.attr("time:"+attrName);if(attrValue)try{inlineSettings[attrName]=eval(attrValue)}catch(e){inlineSettings[attrName]=attrValue}}for(i in overrides={beforeShow:function(e,t){if($.isFunction(tp_inst._defaults.evnts.beforeShow))return tp_inst._defaults.evnts.beforeShow.call($input[0],e,t,tp_inst)},onChangeMonthYear:function(e,t,i){tp_inst._updateDateTime(i),$.isFunction(tp_inst._defaults.evnts.onChangeMonthYear)&&tp_inst._defaults.evnts.onChangeMonthYear.call($input[0],e,t,i,tp_inst)},onClose:function(e,t){!0===tp_inst.timeDefined&&""!==$input.val()&&tp_inst._updateDateTime(t),$.isFunction(tp_inst._defaults.evnts.onClose)&&tp_inst._defaults.evnts.onClose.call($input[0],e,t,tp_inst)}},overrides)overrides.hasOwnProperty(i)&&(fns[i]=o[i]||null);if(tp_inst._defaults=$.extend({},this._defaults,inlineSettings,o,overrides,{evnts:fns,timepicker:tp_inst}),tp_inst.amNames=$.map(tp_inst._defaults.amNames,(function(e){return e.toUpperCase()})),tp_inst.pmNames=$.map(tp_inst._defaults.pmNames,(function(e){return e.toUpperCase()})),"string"==typeof tp_inst._defaults.controlType?(void 0===$.fn[tp_inst._defaults.controlType]&&(tp_inst._defaults.controlType="select"),tp_inst.control=tp_inst._controls[tp_inst._defaults.controlType]):tp_inst.control=tp_inst._defaults.controlType,null===tp_inst._defaults.timezoneList){var timezoneList=["-1200","-1100","-1000","-0930","-0900","-0800","-0700","-0600","-0500","-0430","-0400","-0330","-0300","-0200","-0100","+0000","+0100","+0200","+0300","+0330","+0400","+0430","+0500","+0530","+0545","+0600","+0630","+0700","+0800","+0845","+0900","+0930","+1000","+1030","+1100","+1130","+1200","+1245","+1300","+1400"];tp_inst._defaults.timezoneIso8601&&(timezoneList=$.map(timezoneList,(function(e){return"+0000"==e?"Z":e.substring(0,3)+":"+e.substring(3)}))),tp_inst._defaults.timezoneList=timezoneList}return tp_inst.timezone=tp_inst._defaults.timezone,tp_inst.hour=tp_inst._defaults.hour,tp_inst.minute=tp_inst._defaults.minute,tp_inst.second=tp_inst._defaults.second,tp_inst.millisec=tp_inst._defaults.millisec,tp_inst.ampm="",tp_inst.$input=$input,o.altField&&(tp_inst.$altInput=$(o.altField).css({cursor:"pointer"}).focus((function(){$input.trigger("focus")}))),0!==tp_inst._defaults.minDate&&0!==tp_inst._defaults.minDateTime||(tp_inst._defaults.minDate=new Date),0!==tp_inst._defaults.maxDate&&0!==tp_inst._defaults.maxDateTime||(tp_inst._defaults.maxDate=new Date),void 0!==tp_inst._defaults.minDate&&tp_inst._defaults.minDate instanceof Date&&(tp_inst._defaults.minDateTime=new Date(tp_inst._defaults.minDate.getTime())),void 0!==tp_inst._defaults.minDateTime&&tp_inst._defaults.minDateTime instanceof Date&&(tp_inst._defaults.minDate=new Date(tp_inst._defaults.minDateTime.getTime())),void 0!==tp_inst._defaults.maxDate&&tp_inst._defaults.maxDate instanceof Date&&(tp_inst._defaults.maxDateTime=new Date(tp_inst._defaults.maxDate.getTime())),void 0!==tp_inst._defaults.maxDateTime&&tp_inst._defaults.maxDateTime instanceof Date&&(tp_inst._defaults.maxDate=new Date(tp_inst._defaults.maxDateTime.getTime())),tp_inst.$input.bind("focus",(function(){tp_inst._onFocus()})),tp_inst},_addTimePicker:function(e){var t=this.$altInput&&this._defaults.altFieldTimeOnly?this.$input.val()+" "+this.$altInput.val():this.$input.val();this.timeDefined=this._parseTime(t),this._limitMinMaxDateTime(e,!1),this._injectTimePicker()},_parseTime:function(e,t){if(this.inst||(this.inst=$.datepicker._getInst(this.$input[0])),t||!this._defaults.timeOnly){var i=$.datepicker._get(this.inst,"dateFormat");try{var s=parseDateTimeInternal(i,this._defaults.timeFormat,e,$.datepicker._getFormatConfig(this.inst),this._defaults);if(!s.timeObj)return!1;$.extend(this,s.timeObj)}catch(t){return $.datepicker.log("Error parsing the date/time string: "+t+"\ndate/time string = "+e+"\ntimeFormat = "+this._defaults.timeFormat+"\ndateFormat = "+i),!1}return!0}var a=$.datepicker.parseTime(this._defaults.timeFormat,e,this._defaults);return!!a&&($.extend(this,a),!0)},_injectTimePicker:function(){var e=this.inst.dpDiv,t=this.inst.settings,i=this,s="",a="",n={},r={},l=null;if(0===e.find("div.ui-timepicker-div").length&&t.showTimepicker){for(var o=' style="display:none;"',u='<div class="ui-timepicker-div'+(t.isRTL?" ui-timepicker-rtl":"")+'"><dl><dt class="ui_tpicker_time_label"'+(t.showTime?"":o)+">"+t.timeText+'</dt><dd class="ui_tpicker_time"'+(t.showTime?"":o)+"></dd>",d=0,m=this.units.length;d<m;d++){if(a=(s=this.units[d]).substr(0,1).toUpperCase()+s.substr(1),n[s]=parseInt(t[s+"Max"]-(t[s+"Max"]-t[s+"Min"])%t["step"+a],10),r[s]=0,u+='<dt class="ui_tpicker_'+s+'_label"'+(t["show"+a]?"":o)+">"+t[s+"Text"]+'</dt><dd class="ui_tpicker_'+s+'"><div class="ui_tpicker_'+s+'_slider"'+(t["show"+a]?"":o)+"></div>",t["show"+a]&&t[s+"Grid"]>0){if(u+='<div style="padding-left: 1px"><table class="ui-tpicker-grid-label"><tr>',"hour"==s)for(var c=t[s+"Min"];c<=n[s];c+=parseInt(t[s+"Grid"],10)){r[s]++;var h=$.datepicker.formatTime(useAmpm(t.pickerTimeFormat||t.timeFormat)?"hht":"HH",{hour:c},t);u+='<td data-for="'+s+'">'+h+"</td>"}else for(var p=t[s+"Min"];p<=n[s];p+=parseInt(t[s+"Grid"],10))r[s]++,u+='<td data-for="'+s+'">'+(p<10?"0":"")+p+"</td>";u+="</tr></table></div>"}u+="</dd>"}u+='<dt class="ui_tpicker_timezone_label"'+(t.showTimezone?"":o)+">"+t.timezoneText+"</dt>",u+='<dd class="ui_tpicker_timezone" '+(t.showTimezone?"":o)+"></dd>";var f=$(u+="</dl></div>");!0===t.timeOnly&&(f.prepend('<div class="ui-widget-header ui-helper-clearfix ui-corner-all"><div class="ui-datepicker-title">'+t.timeOnlyTitle+"</div></div>"),e.find(".ui-datepicker-header, .ui-datepicker-calendar").hide());for(d=0,m=i.units.length;d<m;d++)a=(s=i.units[d]).substr(0,1).toUpperCase()+s.substr(1),i[s+"_slider"]=i.control.create(i,f.find(".ui_tpicker_"+s+"_slider"),s,i[s],t[s+"Min"],n[s],t["step"+a]),t["show"+a]&&t[s+"Grid"]>0&&(l=100*r[s]*t[s+"Grid"]/(n[s]-t[s+"Min"]),f.find(".ui_tpicker_"+s+" table").css({width:l+"%",marginLeft:t.isRTL?"0":l/(-2*r[s])+"%",marginRight:t.isRTL?l/(-2*r[s])+"%":"0",borderCollapse:"collapse"}).find("td").click((function(e){var t=$(this),a=t.html(),n=parseInt(a.replace(/[^0-9]/g),10),r=a.replace(/[^apm]/gi),l=t.data("for");"hour"==l&&(-1!==r.indexOf("p")&&n<12?n+=12:-1!==r.indexOf("a")&&12===n&&(n=0)),i.control.value(i,i[l+"_slider"],s,n),i._onTimeChange(),i._onSelectHandler()})).css({cursor:"pointer",width:100/r[s]+"%",textAlign:"center",overflow:"hidden"}));if(this.timezone_select=f.find(".ui_tpicker_timezone").append("<select></select>").find("select"),$.fn.append.apply(this.timezone_select,$.map(t.timezoneList,(function(e,t){return $("<option />").val("object"==typeof e?e.value:e).text("object"==typeof e?e.label:e)}))),void 0!==this.timezone&&null!==this.timezone&&""!==this.timezone){var _=new Date(this.inst.selectedYear,this.inst.selectedMonth,this.inst.selectedDay,12);$.timepicker.timeZoneOffsetString(_)==this.timezone?selectLocalTimeZone(i):this.timezone_select.val(this.timezone)}else void 0!==this.hour&&null!==this.hour&&""!==this.hour?this.timezone_select.val(t.defaultTimezone):selectLocalTimeZone(i);this.timezone_select.change((function(){i._defaults.useLocalTimezone=!1,i._onTimeChange()}));var g=e.find(".ui-datepicker-buttonpane");if(g.length?g.before(f):e.append(f),this.$timeObj=f.find(".ui_tpicker_time"),null!==this.inst){var v=this.timeDefined;this._onTimeChange(),this.timeDefined=v}if(this._defaults.addSliderAccess){var k=this._defaults.sliderAccessArgs,T=this._defaults.isRTL;k.isRTL=T,setTimeout((function(){if(0===f.find(".ui-slider-access").length){f.find(".ui-slider:visible").sliderAccess(k);var e=f.find(".ui-slider-access:eq(0)").outerWidth(!0);e&&f.find("table:visible").each((function(){var t=$(this),i=t.outerWidth(),s=t.css(T?"marginRight":"marginLeft").toString().replace("%",""),a=i-e,n=s*a/i+"%",r={width:a,marginRight:0,marginLeft:0};r[T?"marginRight":"marginLeft"]=n,t.css(r)}))}}),10)}}},_limitMinMaxDateTime:function(e,t){var i=this._defaults,s=new Date(e.selectedYear,e.selectedMonth,e.selectedDay);if(this._defaults.showTimepicker){if(null!==$.datepicker._get(e,"minDateTime")&&void 0!==$.datepicker._get(e,"minDateTime")&&s){var a=$.datepicker._get(e,"minDateTime"),n=new Date(a.getFullYear(),a.getMonth(),a.getDate(),0,0,0,0);null!==this.hourMinOriginal&&null!==this.minuteMinOriginal&&null!==this.secondMinOriginal&&null!==this.millisecMinOriginal||(this.hourMinOriginal=i.hourMin,this.minuteMinOriginal=i.minuteMin,this.secondMinOriginal=i.secondMin,this.millisecMinOriginal=i.millisecMin),e.settings.timeOnly||n.getTime()==s.getTime()?(this._defaults.hourMin=a.getHours(),this.hour<=this._defaults.hourMin?(this.hour=this._defaults.hourMin,this._defaults.minuteMin=a.getMinutes(),this.minute<=this._defaults.minuteMin?(this.minute=this._defaults.minuteMin,this._defaults.secondMin=a.getSeconds(),this.second<=this._defaults.secondMin?(this.second=this._defaults.secondMin,this._defaults.millisecMin=a.getMilliseconds()):(this.millisec<this._defaults.millisecMin&&(this.millisec=this._defaults.millisecMin),this._defaults.millisecMin=this.millisecMinOriginal)):(this._defaults.secondMin=this.secondMinOriginal,this._defaults.millisecMin=this.millisecMinOriginal)):(this._defaults.minuteMin=this.minuteMinOriginal,this._defaults.secondMin=this.secondMinOriginal,this._defaults.millisecMin=this.millisecMinOriginal)):(this._defaults.hourMin=this.hourMinOriginal,this._defaults.minuteMin=this.minuteMinOriginal,this._defaults.secondMin=this.secondMinOriginal,this._defaults.millisecMin=this.millisecMinOriginal)}if(null!==$.datepicker._get(e,"maxDateTime")&&void 0!==$.datepicker._get(e,"maxDateTime")&&s){var r=$.datepicker._get(e,"maxDateTime"),l=new Date(r.getFullYear(),r.getMonth(),r.getDate(),0,0,0,0);null!==this.hourMaxOriginal&&null!==this.minuteMaxOriginal&&null!==this.secondMaxOriginal||(this.hourMaxOriginal=i.hourMax,this.minuteMaxOriginal=i.minuteMax,this.secondMaxOriginal=i.secondMax,this.millisecMaxOriginal=i.millisecMax),e.settings.timeOnly||l.getTime()==s.getTime()?(this._defaults.hourMax=r.getHours(),this.hour>=this._defaults.hourMax?(this.hour=this._defaults.hourMax,this._defaults.minuteMax=r.getMinutes(),this.minute>=this._defaults.minuteMax?(this.minute=this._defaults.minuteMax,this._defaults.secondMax=r.getSeconds()):this.second>=this._defaults.secondMax?(this.second=this._defaults.secondMax,this._defaults.millisecMax=r.getMilliseconds()):(this.millisec>this._defaults.millisecMax&&(this.millisec=this._defaults.millisecMax),this._defaults.millisecMax=this.millisecMaxOriginal)):(this._defaults.minuteMax=this.minuteMaxOriginal,this._defaults.secondMax=this.secondMaxOriginal,this._defaults.millisecMax=this.millisecMaxOriginal)):(this._defaults.hourMax=this.hourMaxOriginal,this._defaults.minuteMax=this.minuteMaxOriginal,this._defaults.secondMax=this.secondMaxOriginal,this._defaults.millisecMax=this.millisecMaxOriginal)}if(void 0!==t&&!0===t){var o=parseInt(this._defaults.hourMax-(this._defaults.hourMax-this._defaults.hourMin)%this._defaults.stepHour,10),u=parseInt(this._defaults.minuteMax-(this._defaults.minuteMax-this._defaults.minuteMin)%this._defaults.stepMinute,10),d=parseInt(this._defaults.secondMax-(this._defaults.secondMax-this._defaults.secondMin)%this._defaults.stepSecond,10),m=parseInt(this._defaults.millisecMax-(this._defaults.millisecMax-this._defaults.millisecMin)%this._defaults.stepMillisec,10);this.hour_slider&&(this.control.options(this,this.hour_slider,"hour",{min:this._defaults.hourMin,max:o}),this.control.value(this,this.hour_slider,"hour",this.hour)),this.minute_slider&&(this.control.options(this,this.minute_slider,"minute",{min:this._defaults.minuteMin,max:u}),this.control.value(this,this.minute_slider,"minute",this.minute)),this.second_slider&&(this.control.options(this,this.second_slider,"second",{min:this._defaults.secondMin,max:d}),this.control.value(this,this.second_slider,"second",this.second)),this.millisec_slider&&(this.control.options(this,this.millisec_slider,"millisec",{min:this._defaults.millisecMin,max:m}),this.control.value(this,this.millisec_slider,"millisec",this.millisec))}}},_onTimeChange:function(){var e=!!this.hour_slider&&this.control.value(this,this.hour_slider,"hour"),t=!!this.minute_slider&&this.control.value(this,this.minute_slider,"minute"),i=!!this.second_slider&&this.control.value(this,this.second_slider,"second"),s=!!this.millisec_slider&&this.control.value(this,this.millisec_slider,"millisec"),a=!!this.timezone_select&&this.timezone_select.val(),n=this._defaults,r=n.pickerTimeFormat||n.timeFormat,l=n.pickerTimeSuffix||n.timeSuffix;"object"==typeof e&&(e=!1),"object"==typeof t&&(t=!1),"object"==typeof i&&(i=!1),"object"==typeof s&&(s=!1),"object"==typeof a&&(a=!1),!1!==e&&(e=parseInt(e,10)),!1!==t&&(t=parseInt(t,10)),!1!==i&&(i=parseInt(i,10)),!1!==s&&(s=parseInt(s,10));var o=n[e<12?"amNames":"pmNames"][0],u=e!=this.hour||t!=this.minute||i!=this.second||s!=this.millisec||this.ampm.length>0&&e<12!=(-1!==$.inArray(this.ampm.toUpperCase(),this.amNames))||null===this.timezone&&a!=this.defaultTimezone||null!==this.timezone&&a!=this.timezone;u&&(!1!==e&&(this.hour=e),!1!==t&&(this.minute=t),!1!==i&&(this.second=i),!1!==s&&(this.millisec=s),!1!==a&&(this.timezone=a),this.inst||(this.inst=$.datepicker._getInst(this.$input[0])),this._limitMinMaxDateTime(this.inst,!0)),useAmpm(n.timeFormat)&&(this.ampm=o),this.formattedTime=$.datepicker.formatTime(n.timeFormat,this,n),this.$timeObj&&(r===n.timeFormat?this.$timeObj.text(this.formattedTime+l):this.$timeObj.text($.datepicker.formatTime(r,this,n)+l)),this.timeDefined=!0,u&&this._updateDateTime()},_onSelectHandler:function(){var e=this._defaults.onSelect||this.inst.settings.onSelect,t=this.$input?this.$input[0]:null;e&&t&&e.apply(t,[this.formattedDateTime,this])},_updateDateTime:function(e){e=this.inst||e;var t=$.datepicker._daylightSavingAdjust(new Date(e.selectedYear,e.selectedMonth,e.selectedDay)),i=$.datepicker._get(e,"dateFormat"),s=$.datepicker._getFormatConfig(e),a=null!==t&&this.timeDefined;this.formattedDate=$.datepicker.formatDate(i,null===t?new Date:t,s);var n=this.formattedDate;if(!0===this._defaults.timeOnly?n=this.formattedTime:!0!==this._defaults.timeOnly&&(this._defaults.alwaysSetTime||a)&&(n+=this._defaults.separator+this.formattedTime+this._defaults.timeSuffix),this.formattedDateTime=n,this._defaults.showTimepicker)if(this.$altInput&&!0===this._defaults.altFieldTimeOnly)this.$altInput.val(this.formattedTime),this.$input.val(this.formattedDate);else if(this.$altInput){this.$input.val(n);var r="",l=this._defaults.altSeparator?this._defaults.altSeparator:this._defaults.separator,o=this._defaults.altTimeSuffix?this._defaults.altTimeSuffix:this._defaults.timeSuffix;(r=this._defaults.altFormat?$.datepicker.formatDate(this._defaults.altFormat,null===t?new Date:t,s):this.formattedDate)&&(r+=l),this._defaults.altTimeFormat?r+=$.datepicker.formatTime(this._defaults.altTimeFormat,this,this._defaults)+o:r+=this.formattedTime+o,this.$altInput.val(r)}else this.$input.val(n);else this.$input.val(this.formattedDate);this.$input.trigger("change")},_onFocus:function(){if(!this.$input.val()&&this._defaults.defaultValue){this.$input.val(this._defaults.defaultValue);var e=$.datepicker._getInst(this.$input.get(0)),t=$.datepicker._get(e,"timepicker");if(t&&t._defaults.timeOnly&&e.input.val()!=e.lastVal)try{$.datepicker._updateDatepicker(e)}catch(e){$.datepicker.log(e)}}},_controls:{slider:{create:function(e,t,i,s,a,n,r){var l=e._defaults.isRTL;return t.prop("slide",null).slider({orientation:"horizontal",value:l?-1*s:s,min:l?-1*n:a,max:l?-1*a:n,step:r,slide:function(t,s){e.control.value(e,$(this),i,l?-1*s.value:s.value),e._onTimeChange()},stop:function(t,i){e._onSelectHandler()}})},options:function(e,t,i,s,a){if(e._defaults.isRTL){if("string"==typeof s)return"min"==s||"max"==s?void 0!==a?t.slider(s,-1*a):Math.abs(t.slider(s)):t.slider(s);var n=s.min,r=s.max;return s.min=s.max=null,void 0!==n&&(s.max=-1*n),void 0!==r&&(s.min=-1*r),t.slider(s)}return"string"==typeof s&&void 0!==a?t.slider(s,a):t.slider(s)},value:function(e,t,i,s){return e._defaults.isRTL?void 0!==s?t.slider("value",-1*s):Math.abs(t.slider("value")):void 0!==s?t.slider("value",s):t.slider("value")}},select:{create:function(e,t,i,s,a,n,r){for(var l='<select class="ui-timepicker-select" data-unit="'+i+'" data-min="'+a+'" data-max="'+n+'" data-step="'+r+'">',o=(e._defaults.timeFormat.indexOf("t"),a);o<=n;o+=r)l+='<option value="'+o+'"'+(o==s?" selected":"")+">","hour"==i&&useAmpm(e._defaults.pickerTimeFormat||e._defaults.timeFormat)?l+=$.datepicker.formatTime("hh TT",{hour:o},e._defaults):l+="millisec"==i||o>=10?o:"0"+o.toString(),l+="</option>";return l+="</select>",t.children("select").remove(),$(l).appendTo(t).change((function(t){e._onTimeChange(),e._onSelectHandler()})),t},options:function(e,t,i,s,a){var n={},r=t.children("select");if("string"==typeof s){if(void 0===a)return r.data(s);n[s]=a}else n=s;return e.control.create(e,t,r.data("unit"),r.val(),n.min||r.data("min"),n.max||r.data("max"),n.step||r.data("step"))},value:function(e,t,i,s){var a=t.children("select");return void 0!==s?a.val(s):a.val()}}}}),$.fn.extend({timepicker:function(e){e=e||{};var t=Array.prototype.slice.call(arguments);return"object"==typeof e&&(t[0]=$.extend(e,{timeOnly:!0})),$(this).each((function(){$.fn.datetimepicker.apply($(this),t)}))},datetimepicker:function(e){var t=arguments;return"string"==typeof(e=e||{})?"getDate"==e?$.fn.datepicker.apply($(this[0]),t):this.each((function(){var e=$(this);e.datepicker.apply(e,t)})):this.each((function(){var t=$(this);t.datepicker($.timepicker._newInst(t,e)._defaults)}))}}),$.datepicker.parseDateTime=function(e,t,i,s,a){var n=parseDateTimeInternal(e,t,i,s,a);if(n.timeObj){var r=n.timeObj;n.date.setHours(r.hour,r.minute,r.second,r.millisec)}return n.date},$.datepicker.parseTime=function(e,t,i){var s=extendRemove(extendRemove({},$.timepicker._defaults),i||{}),a=function(e,t,i){var s,a="^"+e.toString().replace(/([hH]{1,2}|mm?|ss?|[tT]{1,2}|[lz]|'.*?')/g,(function(e){switch(e.charAt(0).toLowerCase()){case"h":case"m":case"s":return"(\\d?\\d)";case"l":return"(\\d?\\d?\\d)";case"z":return"(z|[-+]\\d\\d:?\\d\\d|\\S+)?";case"t":return t=i.amNames,s=i.pmNames,a=[],t&&$.merge(a,t),s&&$.merge(a,s),"("+(a=$.map(a,(function(e){return e.replace(/[.*+?|()\[\]{}\\]/g,"\\$&")}))).join("|")+")?";default:return"("+e.replace(/\'/g,"").replace(/(\.|\$|\^|\\|\/|\(|\)|\[|\]|\?|\+|\*)/g,(function(e){return"\\"+e}))+")?"}var t,s,a})).replace(/\s/g,"\\s?")+i.timeSuffix+"$",n=function(e){var t=e.toLowerCase().match(/(h{1,2}|m{1,2}|s{1,2}|l{1}|t{1,2}|z|'.*?')/g),i={h:-1,m:-1,s:-1,l:-1,t:-1,z:-1};if(t)for(var s=0;s<t.length;s++)-1==i[t[s].toString().charAt(0)]&&(i[t[s].toString().charAt(0)]=s+1);return i}(e),r="",l={hour:0,minute:0,second:0,millisec:0};if(s=t.match(new RegExp(a,"i"))){if(-1!==n.t&&(void 0===s[n.t]||0===s[n.t].length?(r="",l.ampm=""):(r=-1!==$.inArray(s[n.t].toUpperCase(),i.amNames)?"AM":"PM",l.ampm=i["AM"==r?"amNames":"pmNames"][0])),-1!==n.h&&("AM"==r&&"12"==s[n.h]?l.hour=0:"PM"==r&&"12"!=s[n.h]?l.hour=parseInt(s[n.h],10)+12:l.hour=Number(s[n.h])),-1!==n.m&&(l.minute=Number(s[n.m])),-1!==n.s&&(l.second=Number(s[n.s])),-1!==n.l&&(l.millisec=Number(s[n.l])),-1!==n.z&&void 0!==s[n.z]){var o=s[n.z].toUpperCase();switch(o.length){case 1:o=i.timezoneIso8601?"Z":"+0000";break;case 5:i.timezoneIso8601&&(o="0000"==o.substring(1)?"Z":o.substring(0,3)+":"+o.substring(3));break;case 6:i.timezoneIso8601?"00:00"==o.substring(1)&&(o="Z"):o="Z"==o||"00:00"==o.substring(1)?"+0000":o.replace(/:/,"")}l.timezone=o}return l}return!1};return"function"==typeof s.parse?s.parse(e,t,s):"loose"===s.parse?function(e,t,i){try{var s=new Date("2012-01-01 "+t);return{hour:s.getHours(),minutes:s.getMinutes(),seconds:s.getSeconds(),millisec:s.getMilliseconds(),timezone:$.timepicker.timeZoneOffsetString(s)}}catch(s){try{return a(e,t,i)}catch(i){$.datepicker.log("Unable to parse \ntimeString: "+t+"\ntimeFormat: "+e)}}return!1}(e,t,s):a(e,t,s)},$.datepicker.formatTime=function(e,t,i){i=i||{},i=$.extend({},$.timepicker._defaults,i),t=$.extend({hour:0,minute:0,second:0,millisec:0,timezone:"+0000"},t);var s=e,a=i.amNames[0],n=parseInt(t.hour,10);return n>11&&(a=i.pmNames[0]),s=s.replace(/(?:HH?|hh?|mm?|ss?|[tT]{1,2}|[lz]|('.*?'|".*?"))/g,(function(e){switch(e){case"HH":return("0"+n).slice(-2);case"H":return n;case"hh":return("0"+convert24to12(n)).slice(-2);case"h":return convert24to12(n);case"mm":return("0"+t.minute).slice(-2);case"m":return t.minute;case"ss":return("0"+t.second).slice(-2);case"s":return t.second;case"l":return("00"+t.millisec).slice(-3);case"z":return null===t.timezone?i.defaultTimezone:t.timezone;case"T":return a.charAt(0).toUpperCase();case"TT":return a.toUpperCase();case"t":return a.charAt(0).toLowerCase();case"tt":return a.toLowerCase();default:return e.replace(/\'/g,"")||"'"}})),s=$.trim(s)},$.datepicker._base_selectDate=$.datepicker._selectDate,$.datepicker._selectDate=function(e,t){var i=this._getInst($(e)[0]),s=this._get(i,"timepicker");s?(s._limitMinMaxDateTime(i,!0),i.inline=i.stay_open=!0,this._base_selectDate(e,t),i.inline=i.stay_open=!1,this._notifyChange(i),this._updateDatepicker(i)):this._base_selectDate(e,t)},$.datepicker._base_updateDatepicker=$.datepicker._updateDatepicker,$.datepicker._updateDatepicker=function(e){var t=e.input[0];if(!($.datepicker._curInst&&$.datepicker._curInst!=e&&$.datepicker._datepickerShowing&&$.datepicker._lastInput!=t||"boolean"==typeof e.stay_open&&!1!==e.stay_open)){this._base_updateDatepicker(e);var i=this._get(e,"timepicker");if(i&&(i._addTimePicker(e),i._defaults.useLocalTimezone)){var s=new Date(e.selectedYear,e.selectedMonth,e.selectedDay,12);selectLocalTimeZone(i,s),i._onTimeChange()}}},$.datepicker._base_doKeyPress=$.datepicker._doKeyPress,$.datepicker._doKeyPress=function(e){var t=$.datepicker._getInst(e.target),i=$.datepicker._get(t,"timepicker");if(i&&$.datepicker._get(t,"constrainInput")){var s=useAmpm(i._defaults.timeFormat),a=$.datepicker._possibleChars($.datepicker._get(t,"dateFormat")),n=i._defaults.timeFormat.toString().replace(/[hms]/g,"").replace(/TT/g,s?"APM":"").replace(/Tt/g,s?"AaPpMm":"").replace(/tT/g,s?"AaPpMm":"").replace(/T/g,s?"AP":"").replace(/tt/g,s?"apm":"").replace(/t/g,s?"ap":"")+" "+i._defaults.separator+i._defaults.timeSuffix+(i._defaults.showTimezone?i._defaults.timezoneList.join(""):"")+i._defaults.amNames.join("")+i._defaults.pmNames.join("")+a,r=String.fromCharCode(void 0===e.charCode?e.keyCode:e.charCode);return e.ctrlKey||r<" "||!a||n.indexOf(r)>-1}return $.datepicker._base_doKeyPress(e)},$.datepicker._base_updateAlternate=$.datepicker._updateAlternate,$.datepicker._updateAlternate=function(e){var t=this._get(e,"timepicker");if(t){var i=t._defaults.altField;if(i){t._defaults.altFormat||t._defaults.dateFormat;var s=this._getDate(e),a=$.datepicker._getFormatConfig(e),n="",r=t._defaults.altSeparator?t._defaults.altSeparator:t._defaults.separator,l=t._defaults.altTimeSuffix?t._defaults.altTimeSuffix:t._defaults.timeSuffix,o=null!==t._defaults.altTimeFormat?t._defaults.altTimeFormat:t._defaults.timeFormat;n+=$.datepicker.formatTime(o,t,t._defaults)+l,t._defaults.timeOnly||t._defaults.altFieldTimeOnly||(n=t._defaults.altFormat?$.datepicker.formatDate(t._defaults.altFormat,null===s?new Date:s,a)+r+n:t.formattedDate+r+n),$(i).val(n)}}else $.datepicker._base_updateAlternate(e)},$.datepicker._base_doKeyUp=$.datepicker._doKeyUp,$.datepicker._doKeyUp=function(e){var t=$.datepicker._getInst(e.target),i=$.datepicker._get(t,"timepicker");if(i&&i._defaults.timeOnly&&t.input.val()!=t.lastVal)try{$.datepicker._updateDatepicker(t)}catch(e){$.datepicker.log(e)}return $.datepicker._base_doKeyUp(e)},$.datepicker._base_gotoToday=$.datepicker._gotoToday,$.datepicker._gotoToday=function(e){var t=this._getInst($(e)[0]),i=t.dpDiv;this._base_gotoToday(e);var s=this._get(t,"timepicker");selectLocalTimeZone(s);var a=new Date;this._setTime(t,a),$(".ui-datepicker-today",i).click()},$.datepicker._disableTimepickerDatepicker=function(e){var t=this._getInst(e);if(t){var i=this._get(t,"timepicker");$(e).datepicker("getDate"),i&&(i._defaults.showTimepicker=!1,i._updateDateTime(t))}},$.datepicker._enableTimepickerDatepicker=function(e){var t=this._getInst(e);if(t){var i=this._get(t,"timepicker");$(e).datepicker("getDate"),i&&(i._defaults.showTimepicker=!0,i._addTimePicker(t),i._updateDateTime(t))}},$.datepicker._setTime=function(e,t){var i=this._get(e,"timepicker");if(i){var s=i._defaults;i.hour=t?t.getHours():s.hour,i.minute=t?t.getMinutes():s.minute,i.second=t?t.getSeconds():s.second,i.millisec=t?t.getMilliseconds():s.millisec,i._limitMinMaxDateTime(e,!0),i._onTimeChange(),i._updateDateTime(e)}},$.datepicker._setTimeDatepicker=function(e,t,i){var s=this._getInst(e);if(s){var a,n=this._get(s,"timepicker");if(n)this._setDateFromField(s),t&&("string"==typeof t?(n._parseTime(t,i),(a=new Date).setHours(n.hour,n.minute,n.second,n.millisec)):a=new Date(t.getTime()),"Invalid Date"==a.toString()&&(a=void 0),this._setTime(s,a))}},$.datepicker._base_setDateDatepicker=$.datepicker._setDateDatepicker,$.datepicker._setDateDatepicker=function(e,t){var i=this._getInst(e);if(i){var s=t instanceof Date?new Date(t.getTime()):t;this._updateDatepicker(i),this._base_setDateDatepicker.apply(this,arguments),this._setTimeDatepicker(e,s,!0)}},$.datepicker._base_getDateDatepicker=$.datepicker._getDateDatepicker,$.datepicker._getDateDatepicker=function(e,t){var i=this._getInst(e);if(i){var s=this._get(i,"timepicker");if(s){void 0===i.lastVal&&this._setDateFromField(i,t);var a=this._getDate(i);return a&&s._parseTime($(e).val(),s.timeOnly)&&a.setHours(s.hour,s.minute,s.second,s.millisec),a}return this._base_getDateDatepicker(e,t)}},$.datepicker._base_parseDate=$.datepicker.parseDate,$.datepicker.parseDate=function(e,t,i){var s;try{s=this._base_parseDate(e,t,i)}catch(a){s=this._base_parseDate(e,t.substring(0,t.length-(a.length-a.indexOf(":")-2)),i),$.datepicker.log("Error parsing the date string: "+a+"\ndate string = "+t+"\ndate format = "+e)}return s},$.datepicker._base_formatDate=$.datepicker._formatDate,$.datepicker._formatDate=function(e,t,i,s){var a=this._get(e,"timepicker");return a?(a._updateDateTime(e),a.$input.val()):this._base_formatDate(e)},$.datepicker._base_optionDatepicker=$.datepicker._optionDatepicker,$.datepicker._optionDatepicker=function(e,t,i){var s,a=this._getInst(e);if(!a)return null;var n=this._get(a,"timepicker");if(n){var r,l=null,o=null,u=null,d=n._defaults.evnts,m={};if("string"==typeof t){if("minDate"===t||"minDateTime"===t)l=i;else if("maxDate"===t||"maxDateTime"===t)o=i;else if("onSelect"===t)u=i;else if(d.hasOwnProperty(t)){if(void 0===i)return d[t];m[t]=i,s={}}}else if("object"==typeof t)for(r in t.minDate?l=t.minDate:t.minDateTime?l=t.minDateTime:t.maxDate?o=t.maxDate:t.maxDateTime&&(o=t.maxDateTime),d)d.hasOwnProperty(r)&&t[r]&&(m[r]=t[r]);for(r in m)m.hasOwnProperty(r)&&(d[r]=m[r],s||(s=$.extend({},t)),delete s[r]);if(s&&isEmptyObject(s))return;l?(l=0===l?new Date:new Date(l),n._defaults.minDate=l,n._defaults.minDateTime=l):o?(o=0===o?new Date:new Date(o),n._defaults.maxDate=o,n._defaults.maxDateTime=o):u&&(n._defaults.onSelect=u)}return void 0===i?this._base_optionDatepicker.call($.datepicker,e,t):this._base_optionDatepicker.call($.datepicker,e,s||t,i)};var isEmptyObject=function(e){var t;for(t in e)if(e.hasOwnProperty(e))return!1;return!0},extendRemove=function(e,t){for(var i in $.extend(e,t),t)null!==t[i]&&void 0!==t[i]||(e[i]=t[i]);return e},useAmpm=function(e){return-1!==e.indexOf("t")&&-1!==e.indexOf("h")},convert24to12=function(e){return e>12&&(e-=12),0==e&&(e=12),String(e)},splitDateTime=function(e,t,i,s){try{var a=s&&s.separator?s.separator:$.timepicker._defaults.separator,n=(s&&s.timeFormat?s.timeFormat:$.timepicker._defaults.timeFormat).split(a).length,r=t.split(a),l=r.length;if(l>1)return[r.splice(0,l-n).join(a),r.splice(0,n).join(a)]}catch(i){if($.datepicker.log("Could not split the date from the time. Please check the following datetimepicker options\nthrown error: "+i+"\ndateTimeString"+t+"\ndateFormat = "+e+"\nseparator = "+s.separator+"\ntimeFormat = "+s.timeFormat),i.indexOf(":")>=0){var o=t.length-(i.length-i.indexOf(":")-2);t.substring(o);return[$.trim(t.substring(0,o)),$.trim(t.substring(o))]}throw i}return[t,""]},parseDateTimeInternal=function(e,t,i,s,a){var n,r=splitDateTime(e,i,s,a);if(n=$.datepicker._base_parseDate(e,r[0],s),""!==r[1]){var l=r[1],o=$.datepicker.parseTime(t,l,a);if(null===o)throw"Wrong time format";return{date:n,timeObj:o}}return{date:n}},selectLocalTimeZone=function(e,t){if(e&&e.timezone_select){e._defaults.useLocalTimezone=!0;var i=void 0!==t?t:new Date,s=$.timepicker.timeZoneOffsetString(i);e._defaults.timezoneIso8601&&(s=s.substring(0,3)+":"+s.substring(3)),e.timezone_select.val(s)}};$.timepicker=new Timepicker,$.timepicker.timeZoneOffsetString=function(e){var t=-1*e.getTimezoneOffset(),i=t%60;return(t>=0?"+":"-")+("0"+(101*((t-i)/60)).toString()).substr(-2)+("0"+(101*i).toString()).substr(-2)},$.timepicker.timeRange=function(e,t,i){return $.timepicker.handleRange("timepicker",e,t,i)},$.timepicker.dateTimeRange=function(e,t,i){$.timepicker.dateRange(e,t,i,"datetimepicker")},$.timepicker.dateRange=function(e,t,i,s){s=s||"datepicker",$.timepicker.handleRange(s,e,t,i)},$.timepicker.handleRange=function(e,t,i,s){function a(e,s,a){s.val()&&new Date(t.val())>new Date(i.val())&&s.val(a)}function n(t,i,s){if($(t).val()){var a=$(t)[e].call($(t),"getDate");a.getTime&&$(i)[e].call($(i),"option",s,a)}}return $.fn[e].call(t,$.extend({onClose:function(e,t){a(this,i,e)},onSelect:function(e){n(this,i,"minDate")}},s,s.start)),$.fn[e].call(i,$.extend({onClose:function(e,i){a(this,t,e)},onSelect:function(e){n(this,t,"maxDate")}},s,s.end)),"timepicker"!=e&&s.reformat&&$([t,i]).each((function(){var t=$(this)[e].call($(this),"option","dateFormat"),i=new Date($(this).val());$(this).val()&&i&&$(this).val($.datepicker.formatDate(t,i))})),a(t,i,t.val()),n(t,i,"minDate"),n(i,t,"maxDate"),$([t.get(0),i.get(0)])},$.timepicker.version="1.1.1"}function Timepicker(){this.regional=[],this.regional[""]={currentText:"Now",closeText:"Done",amNames:["AM","A"],pmNames:["PM","P"],timeFormat:"HH:mm",timeSuffix:"",timeOnlyTitle:"Choose Time",timeText:"Time",hourText:"Hour",minuteText:"Minute",secondText:"Second",millisecText:"Millisecond",timezoneText:"Time Zone",isRTL:!1},this._defaults={showButtonPanel:!0,timeOnly:!1,showHour:!0,showMinute:!0,showSecond:!1,showMillisec:!1,showTimezone:!1,showTime:!0,stepHour:1,stepMinute:1,stepSecond:1,stepMillisec:1,hour:0,minute:0,second:0,millisec:0,timezone:null,useLocalTimezone:!1,defaultTimezone:"+0000",hourMin:0,minuteMin:0,secondMin:0,millisecMin:0,hourMax:23,minuteMax:59,secondMax:59,millisecMax:999,minDateTime:null,maxDateTime:null,onSelect:null,hourGrid:0,minuteGrid:0,secondGrid:0,millisecGrid:0,alwaysSetTime:!0,separator:" ",altFieldTimeOnly:!0,altTimeFormat:null,altSeparator:null,altTimeSuffix:null,pickerTimeFormat:null,pickerTimeSuffix:null,showTimepicker:!0,timezoneIso8601:!1,timezoneList:null,addSliderAccess:!1,sliderAccessArgs:null,controlType:"slider",defaultValue:null,parse:"strict"},$.extend(this._defaults,this.regional[""])}})(jQuery);



$(function() {

    // *** Add smooth scrolling to all .smooth-scroll links
    $("a.smooth-scroll").on('click', function(event) {
        if (this.hash !== "") {
            event.preventDefault();
            var offset = 0;
            var hash = this.hash;
            var newUrl = window.location.protocol + "//" + window.location.host +
                            window.location.pathname + hash;
            headerHeight = $('header.sticky-top').height();
            $('html, body').animate({scrollTop: $(hash).offset().top - headerHeight - offset}, 800);
            // history.pushState({}, '', newUrl);
        }
    });


    // ecb_file_selector
    $('.ecb_file_selector_select select').change( function() {
        var imgtag = $(this).parent().next();
        imgtag.attr('src', imgtag.data('uploadsurl')+'/'+$(this).val());
    });



   // ecb_multiple_select
   $('.ecb_multiple_select select').change(function() {
      var selectedValues = $(this).val() ? $(this).val().join(',') : '';
      $(this).siblings('.ecb_select_input').val( selectedValues );
      // then update summary text - if it exists
      var $selectSummary = $(this).siblings('.ecb_select_summary');
      if ( $selectSummary.length>0 ) {
         var selectedText = $(this).children('option:selected').map(function() {
               return $(this).text();
            }).get().join(', ');
         $(this).siblings('.ecb_select_summary').val( selectedText );
         var $summaryText = $(this).siblings('.ecb_select_summary').children('.ecb_select_text');
         if ( selectedText=='' ) {
            $selectSummary.children('.ecb_select_text').html( $summaryText.data('empty') );
         } else {
            $selectSummary.children('.ecb_select_text').html( selectedText );
         }
      }
   });

   // ecb_compact - show & hide the full select & update summary text
   $('.ecb_compact .ecb_select_edit').click( function(e) {
      e.preventDefault();
      $(this).closest('.ecb_compact').toggleClass('show');
   });



   // ecb_repeater
   $('.ecb_repeater').on('change', '.repeater-field', function(e) {
      update_repeater( $($(this).data('repeater')) );
   });

   $('.ecb_repeater').on('click', '.ecb2-repeater-add', function(e) {
      e.preventDefault();
      var $fieldWrapper = $(this).closest('.repeater-wrapper');
      $fieldWrapper.clone().insertAfter( $fieldWrapper ).find('.repeater-field').val('');
      update_repeater( $($(this).data('repeater')) );
   });
   $('.ecb_repeater').on('click', '.ecb2-repeater-remove', function(e) {
      e.preventDefault();
      var $fieldWrapper = $(this).closest('.repeater-wrapper'),
          $repeater = $($(this).data('repeater'))
      $fieldWrapper.remove();
      update_repeater( $repeater );
   });



   function update_repeater( $repeater ) {
      var $parent = $( $repeater.data('parent') ),
          $fields = [];
      $repeater.find('.repeater-field').each(function(i){
         $fields.push( $(this).val() );
      })
      $parent.val( $fields.join('||') );
   }



   // sortable lists
   $('ul.sortable-ecb2-list').each(function() {
        var $parent = $(this).closest('.ecb2-cb');
        var $selected = $parent.find('ul.selected-items');
        $(this).sortable({
            connectWith: $selected,
            delay: 150,
            revert: 300,
            placeholder: 'ui-state-highlight',
            items: 'li:not(.no-sort)',
            helper: function(event, ui) {
                if (!ui.hasClass('selected')) {
                    ui.addClass('selected')
                        .siblings()
                        .removeClass('selected');
                }
                var elements = ui.parent()
                    .children('.selected')
                    .clone(),
                    helper = $('<li/>');
                ui.data('multidrag', elements).siblings('.selected').remove();
                return helper.append(elements);
            },
            stop: function(event, ui) {
                var elements = ui.item.data('multidrag');
                var $ulSelected = $(ui.item).parent();
                ui.item.after(elements).remove();
                updateECB2CBInput($ulSelected);
            },
            receive: function(event, ui) {
                var elements = ui.item.data('multidrag');
                if ($(this).data('max-number') && $(this).children().length - 1 > $(this).data('max-number')) {
                    $(ui.sender).sortable('cancel');
                } else {
                    updateECB2Placeholder($(this));
                    $(elements).removeClass('selected ui-state-hover')
                        .find('.sortable-remove').removeClass('hidden');
                }
            }
        });
    });

    // remove from selected list - by dragging back to available
    $('ul.selected-items').each(function() {
        var $parent = $(this).closest('.ecb2-cb');
        var $available = $parent.find('ul.available-items');
        $(this).sortable({
            connectWith: $available,
            delay: 150,
            revert: 300,
            placeholder: 'ui-state-highlight',
            stop: function(event, ui) {
                var $ulSelected = $(ui.item).closest('.ecb2-cb').find('.selected-items');
                $(ui.item).removeClass('selected')
                $(ui.item).children('.sortable-remove').addClass('hidden');
                updateECB2CBInput($ulSelected);
                updateECB2Placeholder($ulSelected);
            }
        });
    });

    // remove from selected list - by clicking remove icon
    $(document).on('click', '#selected-items .sortable-remove', function(e) {
        e.preventDefault();
        var $ulSelected = $(this).closest('ul.selected-items');
        var $ulAvailable = $(this).closest('.ecb2-cb').find('.available-items');
        $(this).addClass('hidden')
            .parent('li').removeClass('no-sort')
            .appendTo($ulAvailable);
        updateECB2CBInput($ulSelected);
        updateECB2Placeholder($ulSelected);
    });

    function updateECB2CBInput($ulSelected) {
        var $allSelected = $ulSelected.children('li:not(.placeholder)');
        var $targetInput = $('#' + $ulSelected.data('cmsms-cb-input'));
        var selectedStr = '';
        var requiredNumber = $ulSelected.data('required-number');
        if (requiredNumber && $allSelected.length != requiredNumber) {
            $targetInput.val(''); // set to empty

        } else {
            $allSelected.each(function() {
                if (selectedStr == '') {
                    selectedStr = $(this).data('cmsms-item-id');
                } else {
                    selectedStr = selectedStr + ',' + $(this).data('cmsms-item-id');
                }
            });
            $targetInput.val(selectedStr);
        }
    }

    function updateECB2Placeholder($ulSelected) {
        var requiredNumber = $ulSelected.data('required-number');
        var numberSelected = $ulSelected.children().length - 1; // exclude placeholder
        if ((!requiredNumber && numberSelected > 0) || (requiredNumber > 0 && numberSelected == requiredNumber)) {
            $ulSelected.children('.placeholder').addClass('hidden');
        } else {
            $ulSelected.children('.placeholder').removeClass('hidden');
        }


    }



    // datepicker & timepicker functions    
    $('.timepicker').each(function() {
        $(this).timepicker( {
            timeFormat: $(this).data('time-format')
        });
    });

    $('.datepicker').each(function() {
        $(this).datepicker( {
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: $(this).data('date-format'),
            changeMonth: $(this).data('change-month'),
            changeYear: $(this).data('change-year'),
            yearRange: $(this).data('year-range')
        });
    });

    $('.datetimepicker').each(function() {
        $(this).datetimepicker( {
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: $(this).data('date-format'),
            timeFormat: $(this).data('time-format'),
            changeMonth: $(this).data('change-month'),
            changeYear: $(this).data('change-year'),
            yearRange: $(this).data('year-range')
        });
    });


    /* color picker - colpick */
    $('.colorpicker').colpick({
        colorScheme: 'dark',
        submit : false,
        onChange:function(hsb,hex,rgb,el) {
            var hash = $(el).data('no-hash') ? '' : '#'; 
            $(el).val(hash+hex).css('border-right', '30px solid #'+hex);
        },
        onBeforeShow: function() {
            $(this).colpickSetColor(this.value);
        }
    })
    .on('keyup', function() {
        if (this.value=='') {
            $(this).css('border-right', '1px solid #aaa');
        } else {
            $(this).colpickSetColor(this.value);
        }
    })
    .each(function(){
        if (this.value!='') {
            $(this).css('border-right', '30px solid #'+this.value.replaceAll('#', ''));
        } 
    });



});