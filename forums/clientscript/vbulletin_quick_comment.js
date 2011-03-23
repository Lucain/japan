/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 4.1.2
|| # ---------------------------------------------------------------- # ||
|| # Copyright �2000-2011 vBulletin Solutions Inc. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| # http://www.vbulletin.com | http://www.vbulletin.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/
function vB_QuickComment(C,A,B){this.repost=false;this.errors_shown=false;this.posting=false;this.submit_str=null;this.lastelement=YAHOO.util.Dom.get("lastcommentdiv");this.returnorder="ASC";this.basiceditor=YAHOO.util.Dom.get(C+"_textarea");this.form=YAHOO.util.Dom.get(C);if(typeof (this.form.allow_ajax_qc)!="undefined"&&this.form.allow_ajax_qc.value==0){this.allow_ajax_qc=false}else{this.allow_ajax_qc=true}if(B=="DESC"){this.returnorder="DESC"}this.minchars=A;YAHOO.util.Event.on("qr_submit","click",this.submit_comment,this,true);YAHOO.util.Event.on("qr_preview","click",this.submit_comment,this,true);YAHOO.util.Event.on("qc_hide_errors","click",this.hide_errors,this,true)}vB_QuickComment.prototype.check_data=function(A){if(typeof (this.form.preview)!="undefined"&&YAHOO.util.Event.getTarget(A)==this.form.preview){minchars=0}else{minchars=this.minchars}return this.prepare_submit(minchars)};vB_QuickComment.prototype.write_editor_contents=function(A){if(typeof (QR_EditorID)!="undefined"){vB_Editor[QR_EditorID].write_editor_contents(A)}else{this.basiceditor.value=A}};vB_QuickComment.prototype.check_focus=function(){if(typeof (QR_EditorID)!="undefined"){vB_Editor[QR_EditorID].check_focus()}else{if(!this.basiceditor.hasfocus){this.basiceditor.focus();if(is_opera){this.basiceditor.focus()}}}};vB_QuickComment.prototype.prepare_submit=function(A){if(typeof (QR_EditorID)!="undefined"){return vB_Editor[QR_EditorID].prepare_submit(0,A)}else{var B=validatemessage(stripcode(this.basiceditor.value,true),0,A);if(B){return B}else{this.check_focus();return false}}};vB_QuickComment.prototype.submit_comment=function(B){var A=YAHOO.util.Dom.get("fb_dopublish");if(A&&A.checked==1){return true}else{if(this.repost==true){return true}else{if(!AJAX_Compatible||!this.allow_ajax_qc){if(!this.check_data(B)){YAHOO.util.Event.stopEvent(B);return false}return true}else{if(this.check_data(B)){if(is_ie&&userAgent.indexOf("msie 5.")!=-1){if(PHP.urlencode(this.form.message.value).indexOf("%u")!=-1){return true}}if(this.posting==true){YAHOO.util.Event.stopEvent(B);return false}else{this.posting=true;setTimeout("quick_comment.posting = false",1000)}if(typeof (this.form.preview)!="undefined"&&YAHOO.util.Event.getTarget(B)==this.form.preview){return true}else{this.submit_str=this.build_submit_string();YAHOO.util.Dom.setStyle("qc_posting_msg","display","");YAHOO.util.Dom.setStyle(document.body,"cursor","wait");this.save(this.form.action,this.submit_str);YAHOO.util.Event.stopEvent(B);return false}}else{YAHOO.util.Event.stopEvent(B);return false}}}}};vB_QuickComment.prototype.build_submit_string=function(){this.submit_str="ajax=1";var A=new vB_Hidden_Form(null);A.add_variables_from_object(this.form);return this.submit_str+="&"+A.build_query_string()};vB_QuickComment.prototype.save=function(){this.repost=false;YAHOO.util.Connect.asyncRequest("POST",this.form.action,{success:this.post_save,failure:this.handle_ajax_error,timeout:vB_Default_Timeout,scope:this},this.submit_str)};vB_QuickComment.prototype.handle_ajax_error=function(A){vBulletin_AJAX_Error_Handler(A);console.log("AJAX Timeout - Submitting form");this.repost=true;fetch_object("qcform").submit()};vB_QuickComment.prototype.post_save=function(F){YAHOO.util.Dom.setStyle(document.body,"cursor","auto");YAHOO.util.Dom.setStyle("qc_posting_msg","display","none");this.posting=false;var E=F.responseXML.getElementsByTagName("message");if(E.length){this.write_editor_contents("");this.form.lastcomment.value=F.responseXML.getElementsByTagName("time")[0].firstChild.nodeValue;this.hide_errors();var D=0;var H=YAHOO.util.Dom.get("message_list");for(var C=0;C<E.length;C++){if(this.returnorder=="ASC"){Comment_Init(H.insertBefore(string_to_node(E[C].firstChild.nodeValue),H.firstChild))}else{Comment_Init(H.appendChild(string_to_node(E[C].firstChild.nodeValue)))}if(E[C].getAttribute("quickedit")){vB_QuickEditor_Watcher.init()}D+=parseInt(E[C].getAttribute("visible"))}if(D>0){var G=YAHOO.util.Dom.get("page_message_count");if(G){G.innerHTML=parseInt(G.innerHTML)+D}var A=YAHOO.util.Dom.get("total_message_count");if(A){A.innerHTML=parseInt(A.innerHTML)+D}}var B=YAHOO.util.Dom.get("qr_submit");if(B){B.blur()}}else{if(!is_saf){this.show_errors(F);return false}this.repost=true;this.form.submit()}};vB_QuickComment.prototype.show_errors=function(D){this.errors_shown=true;var B=YAHOO.util.Dom.get("qc_error_list");while(B.hasChildNodes()){B.removeChild(B.firstChild)}var F=D.responseXML.getElementsByTagName("error");var A=document.createElement("ol");for(var C=0;C<F.length;C++){var E=document.createElement("li");E.innerHTML=F[C].firstChild.nodeValue;A.appendChild(E);console.warn(F[C].firstChild.nodeValue)}B.appendChild(A);YAHOO.util.Dom.removeClass("qc_error_div","hidden");this.check_focus();return false};vB_QuickComment.prototype.hide_errors=function(){console.log("Hiding QC Errors");if(this.errors_shown){this.errors_shown=true;YAHOO.util.Dom.addClass("qc_error_div","hidden");return false}};