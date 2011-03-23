<div class="footer">
	<div class="content">
		<div class="left-col">
			<h1><? echo translate("Join the Relief Effort");?></h1>
			<p>720.675.9609 <span>|</span>  <a href="mailto:marshall@sparkrelief.org">marshall@sparkrelief.org</a></p>
		</div>
		<div class="left-col2">
			<h1><? echo translate("Get Updates From Sparkrelief");?></h1>
            
			<!-- Begin MailChimp Signup Form -->
			<!--[if IE]>
			<style type="text/css" media="screen">
			#mc_embed_signup fieldset {position: relative;}
			#mc_embed_signup legend {position: absolute; top: -1em; left: .2em;}
			</style>
			<![endif]--> 
			<!--[if IE 7]>
			<style type="text/css" media="screen">
			.mc-field-group {overflow:visible;}
			</style>
			<![endif]-->


			<form action="http://Sparkrelief.us2.list-manage1.com/subscribe/post?u=506e142054af814324f95cccc&amp;id=87dcbd7416" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" >

		<input type="text" value="email@domain.com" name="EMAIL" class="text-field" id="mce-EMAIL" onfocus="clearText(this);clearStyle(this);" >
		<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="subscribe-button <? echo translate("subscribe-button-lang");?>" >
		</form>
	</div>

	<div class="left-col3">
		<div class="twitter">
<a href="http://twitter.com/share" class="twitter-share-button" data-text="Help #Japan housing relief efforts" data-count="vertical" data-via="Sparkrelief">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
		</div>
		<div class="facebook">
			<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fquakehousing.com&amp;layout=box_count&amp;show_faces=true&amp;width=60&amp;action=like&amp;font&amp;colorscheme=light&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:60px; height:65px;" allowTransparency="true">
       <meta property="og:image" content="http://quakehousing.com/images/sparkrelief-logo-paypal.png"/> 
			</iframe>
		</div>
	</div>
     

<script  type="text/javascript">
try {
    var jqueryLoaded=jQuery;
    jqueryLoaded=true;
} catch(err) {
    var jqueryLoaded=false;
}
if (!jqueryLoaded) {
    var head= document.getElementsByTagName('head')[0];
    var script= document.createElement('script');
    script.type= 'text/javascript';
    script.src= 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js';
    head.appendChild(script);    
}
</script>
<script type="text/javascript" src="http://downloads.mailchimp.com/js/jquery.form-n-validate.js"></script>

<script type="text/javascript">
var fnames = new Array();var ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';var err_style = '';
try{
    err_style = mc_custom_error_style;
} catch(e){
    err_style = 'margin: 1em 0 0 0; padding: 1em 0.5em 0.5em 0.5em; background: FFEEEE none repeat scroll 0% 0%; font-weight: bold; float: left; z-index: 1; width: 80%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: FF0000;';
}
var head= document.getElementsByTagName('head')[0];
var style= document.createElement('style');
style.type= 'text/css';
if (style.styleSheet) {
  style.styleSheet.cssText = '.mce_inline_error {' + err_style + '}';
} else {
  style.appendChild(document.createTextNode('.mce_inline_error {' + err_style + '}'));
}
head.appendChild(style);
$(document).ready( function($) {
  var options = { errorClass: 'mce_inline_error', errorElement: 'div', onkeyup: function(){}, onfocusout:function(){}, onblur:function(){}  };
  var mce_validator = $("#mc-embedded-subscribe-form").validate(options);
  options = { url: 'http://Sparkrelief.us2.list-manage.com/subscribe/post-json?u=506e142054af814324f95cccc&id=87dcbd7416&c=?', type: 'GET', dataType: 'json', contentType: "application/json; charset=utf-8",
                beforeSubmit: function(){
                    $('#mce_tmp_error_msg').remove();
                    $('.datefield','#mc_embed_signup').each(
                        function(){
                            var txt = 'filled';
                            var fields = new Array();
                            var i = 0;
                            $(':text', this).each(
                                function(){
                                    fields[i] = this;
                                    i++;
                                });
                            $(':hidden', this).each(
                                function(){
                                	if ( fields[0].value=='MM' && fields[1].value=='DD' && fields[2].value=='YYYY' ){
                                		this.value = '';
									} else if ( fields[0].value=='' && fields[1].value=='' && fields[2].value=='' ){
                                		this.value = '';
									} else {
	                                    this.value = fields[0].value+'/'+fields[1].value+'/'+fields[2].value;
	                                }
                                });
                        });
                    return mce_validator.form();
                }, 
                success: mce_success_cb
            };
  $('#mc-embedded-subscribe-form').ajaxForm(options);

});
function mce_success_cb(resp){
    $('#mce-success-response').hide();
    $('#mce-error-response').hide();
    if (resp.result=="success"){
        $('#mce-'+resp.result+'-response').show();
        $('#mce-'+resp.result+'-response').html(resp.msg);
        $('#mc-embedded-subscribe-form').each(function(){
            this.reset();
    	});
    } else {
        var index = -1;
        var msg;
        try {
            var parts = resp.msg.split(' - ',2);
            if (parts[1]==undefined){
                msg = resp.msg;
            } else {
                i = parseInt(parts[0]);
                if (i.toString() == parts[0]){
                    index = parts[0];
                    msg = parts[1];
                } else {
                    index = -1;
                    msg = resp.msg;
                }
            }
        } catch(e){
            index = -1;
            msg = resp.msg;
        }
        try{
            if (index== -1){
                $('#mce-'+resp.result+'-response').show();
                $('#mce-'+resp.result+'-response').html(msg);            
            } else {
                err_id = 'mce_tmp_error_msg';
                html = '<div id="'+err_id+'" style="'+err_style+'"> '+msg+'</div>';
                
                var input_id = '#mc_embed_signup';
                var f = $(input_id);
                if (ftypes[index]=='address'){
                    input_id = '#mce-'+fnames[index]+'-addr1';
                    f = $(input_id).parent().parent().get(0);
                } else if (ftypes[index]=='date'){
                    input_id = '#mce-'+fnames[index]+'-month';
                    f = $(input_id).parent().parent().get(0);
                } else {
                    input_id = '#mce-'+fnames[index];
                    f = $().parent(input_id).get(0);
                }
                if (f){
                    $(f).append(html);
                    $(input_id).focus();
                } else {
                    $('#mce-'+resp.result+'-response').show();
                    $('#mce-'+resp.result+'-response').html(msg);
                }
            }
        } catch(e){
            $('#mce-'+resp.result+'-response').show();
            $('#mce-'+resp.result+'-response').html(msg);
        }
    }
}
</script>
<!--End mc_embed_signup-->
            
		<div class="clear"></div>
		<h2><a href="http://sparkrelief.org" target="_blank"><? echo translate("Your Relief Team");?> <img src="/images/orange-arrow-right.png" /></a></h2>
		<p>© 2011 <? echo translate("Sparkrelief");?>.  <? echo translate("All Rights Reserved");?> - <a href="/PrivacyPolicy/"><? echo translate("Privacy Policy");?></a>  <span>|</span>  <a href="/Disclaimer/"> <? echo translate("Legal Disclaimer");?></a></p>

	</div>
</div>