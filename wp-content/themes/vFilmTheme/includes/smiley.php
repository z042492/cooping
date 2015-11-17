
<script type="text/javascript">
/* <![CDATA[ */
    function grin(tag) {
        var myField;
        tag = ' ' + tag + ' ';
        if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
            myField = document.getElementById('comment');
        } else {
            return false;
        }
        if (document.selection) {
            myField.focus();
            sel = document.selection.createRange();
            sel.text = tag;
            myField.focus();
        }
        else if (myField.selectionStart || myField.selectionStart == '0') {
            var startPos = myField.selectionStart;
            var endPos = myField.selectionEnd;
            var cursorPos = endPos;
            myField.value = myField.value.substring(0, startPos)
                          + tag
                          + myField.value.substring(endPos, myField.value.length);
            cursorPos += tag.length;
            myField.focus();
            myField.selectionStart = cursorPos;
            myField.selectionEnd = cursorPos;
        }
        else {
            myField.value += tag;
            myField.focus();
        }
    }
/* ]]> */
</script>
<a href="javascript:grin(':bobo_bulini:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_bulini.gif" alt="不理你。" /></a>
<a href="javascript:grin(':bobo_buyaoa:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_buyaoa.gif" alt="不要啊！" /></a>
<a href="javascript:grin(':bobo_chifan:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_chifan.gif" alt="吃饭。" /></a>
<a href="javascript:grin(':bobo_chijing:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_chijing.gif" alt="吃惊。" /></a>
<a href="javascript:grin(':bobo_chixigua:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_chixigua.gif" alt="吃西瓜。" /></a>
<a href="javascript:grin(':bobo_feiwen:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_feiwen.gif" alt="飞吻！" /></a>
<a href="javascript:grin(':bobo_gongxi:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_gongxi.gif" alt="恭喜！" /></a>
<a href="javascript:grin(':bobo_hi:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_hi.gif" alt="Hi" /></a>
<a href="javascript:grin(':bobo_jiujie:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_jiujie.gif" alt="纠结！" /></a>
<a href="javascript:grin(':bobo_mobai:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_mobai.gif" alt="膜拜！" /></a>
<a href="javascript:grin(':bobo_ok:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_ok.gif" alt="OK" /></a>
<a href="javascript:grin(':bobo_paomeiyan:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_paomeiyan.gif" alt="抛媚眼。" /></a>
<a href="javascript:grin(':bobo_paopaotang:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_paopaotang.gif" alt="泡泡糖。" /></a>
<a href="javascript:grin(':bobo_paoqian:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_paoqian.gif" alt="抛钱。" /></a>
<a href="javascript:grin(':bobo_ren:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_ren.gif" alt="忍！" /></a>
<a href="javascript:grin(':bobo_shengmenqi:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_shengmenqi.gif" alt="生闷气！" /></a>
<a href="javascript:grin(':bobo_tiaopi:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_tiaopi.gif" alt="调皮。" /></a>
<a href="javascript:grin(':bobo_toukan:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_toukan.gif" alt="偷看。" /></a>
<a href="javascript:grin(':bobo_weiqu:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_weiqu.gif" alt="委屈。" /></a>
<a href="javascript:grin(':bobo_xianhua:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_xianhua.gif" alt="献花。" /></a>
<a href="javascript:grin(':bobo_yiwen:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_yiwen.gif" alt="疑问？" /></a>
<a href="javascript:grin(':bobo_zhuakuang:')"><img src="<?php bloginfo('template_directory'); ?>/img/bobo/bobo_zhuakuang.gif" alt="抓狂！" /></a>
<br />
