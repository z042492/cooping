jQuery(function(){
    jQuery('#weixinzone>div').hover(function(){
        jQuery('div',this).show();
    },function(){
        jQuery('div',this).hide();
    });
    jQuery('#clients>div').hover(function(){
        jQuery('>img',this).show();
    },function(){
        jQuery('>img',this).hide();
    });
    jQuery('#coder').hover(function(){
        jQuery('#qr_code').show();
    },function(){
        jQuery('#qr_code').hide();
    });
    jQuery('.editer_info .info_btn').click(function(){
        var o=jQuery(this);
        var s=o.attr('data-status');
        var x=o.parent().parent();
        console.log(jQuery('.editer_other',x));
        if(s=='' || s==undefined){
            jQuery('.editer_info .info_btn[data-status="open"]').click();
            jQuery('.editer_other',x).slideDown();
            o.attr('data-status','open');
            if(jQuery('.editer_article',x).html()!='')return;
            var aid= x.attr('data-aid');
            var pid= x.attr('data-pid');
            jQuery.ajax({
                url: '/api/v4author.php?aid='+aid+'&pid='+pid,
                success: function(data){
                    jQuery('.editer_article',x).html(data);
                }
            });
        }else{
            jQuery('.editer_other',x).slideUp();
            o.attr('data-status','');
        }
    });
    jQuery('.evaluating ul li').hover(function(){
            if(jQuery('.t',this).css('left')=='0px')return;
            jQuery('.t').animate({left:-242},'fast');
            jQuery('.t',this).animate({left:0},'fast');
        },function(){
            //jQuery('.t',this).animate({left:-242});
        }
    );
});
var nd=new Date();
var nt=(nd.getYear()+1900)+"-"+(nd.getMonth()+1)+"-"+nd.getDate()+" "+nd.getHours()+":"+nd.getMinutes()+":"+nd.getSeconds();
var dtna=0;
var dtnc=0;
function desktopnotify(){
    jQuery('#desktopnotifyrequest').hide();
    if(window.webkitNotifications){
        if(window.webkitNotifications.checkPermission()==0){
            setInterval(notifyquery,100000);
        }else{
            jQuery('#desktopnotifyrequest').show();
            var dtnb=parseInt(jQuery.cookie('dtnb'));
            if(isNaN(dtnb))dtnb=0;
            if(dtnb<5){
                dtnb++;
                jQuery.cookie('dtnb',dtnb,{expires:3,path:'/'});
                dtna=setInterval(function(){
                    jQuery('#desktopnotifyrequest a').css('color',dtnc%2==0?'#f26428':'#ccc');
                    dtnc++;
                    if(dtnc==10) clearInterval(dtna);
                },500);
            }
        }
    }
}

function hover(id) {
    return  document.getElementById(id);
}

function notifyrequest(){
    window.webkitNotifications.requestPermission(desktopnotify);
}
function notifyquery(){
    jQuery.ajax({
        url:'/notify.php',
        data:{t:nt},
        cache:false,
        success:function(data){
            nt=data['now'];
            for(var key in data['posts']){
                var o = data['posts'][key];
                var u = o['url'];
                var n = window.webkitNotifications.createNotification(
                    '',
                    '',
                    o['title']);
                n.onclick=function(){
                    window.open(u);
                    n.cancel();
                };
                n.replaceId=o['id'];
                n.show();
                setTimeout(function(){n.cancel();}, 10000);
            }
        }
    });
}
function setlastvisit(){
    var lastvisit=new Date(jQuery.cookie('lastvisit'));
    if(lastvisit<new Date(new Date()-86400000))lastvisit=new Date(new Date()-86400000);
    jQuery.cookie('lastvisit',new Date(),{expires:10,path:'/'});
    jQuery('[data-posttime]').each(function(){
        var x=jQuery(this);
        var pt=new Date(x.attr('data-posttime'));
        if(pt>lastvisit){
            x.addClass('newpost');
            jQuery('a',x).click(function(){x.removeClass('newpost');});
        }
    });
}
function toggle_fixed_comment(){
    var x=jQuery('.ds-replybox');
    if(x.css('position')=='fixed'){
        x.css('width','auto');
        x.css('right','');
        x.css('bottom','');
        x.css('position','relative');
    }else{
        x.css('width','650px');
        x.css('right','60px');
        x.css('bottom','5px');
        x.css('position','fixed');
    }
}