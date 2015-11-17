<?php
/**
 * WordPress基础配置文件。
 *
 * 这个文件被安装程序用于自动生成wp-config.php配置文件，
 * 您可以不使用网站，您需要手动复制这个文件，
 * 并重命名为“wp-config.php”，然后填入相关信息。
 *
 * 本文件包含以下配置选项：
 *
 * * MySQL设置
 * * 密钥
 * * 数据库表名前缀
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress数据库的名称 */
define('DB_NAME', 'wp');

/** MySQL数据库用户名 */
define('DB_USER', 'root');

/** MySQL数据库密码 */
define('DB_PASSWORD', 'root');

/** MySQL主机 */
define('DB_HOST', 'localhost');

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

/**#@+
 * 身份认证密钥与盐。
 *
 * 修改为任意独一无二的字串！
 * 或者直接访问{@link https://api.wordpress.org/secret-key/1.1/salt/
 * WordPress.org密钥生成服务}
 * 任何修改都会导致所有cookies失效，所有用户将必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'c<>!?6S!_~|<5}O|1=.<dbWd1;-/|REvo|FYq^-gUSh-o5N+;4yLtg/gDrck$a0G');
define('SECURE_AUTH_KEY',  'nD=C.N{pyx>Rh-8Z2|G-D60#-N4W=&>-MBjix7|ioB#3<sdh`FYFYPy}ivo0`mSB');
define('LOGGED_IN_KEY',    'i$g3%wS@r|(f|WAoewxg=z?-p-zNC+Z{|bfXO5#6%~5Y|n|k_ERt>[q$,Ra<g@QC');
define('NONCE_KEY',        '~gg/R=R+>SWzKh5?)r=S18q|3>O?n^Z}!@(OrE?ty}#bC+pK3Qox3<wOQ,Ew>fiD');
define('AUTH_SALT',        'U#Z1Fy;+^axoX(y~=/Gv!_2-%%jU7YFi=h-76>d)dyt`D{+I-}I0AoX?hema1{4%');
define('SECURE_AUTH_SALT', '=nn!_Q$8+nb5V?VB-APGrdDrFXQ[/VED`,oYz_{]l{z<?!?N3SU |#S+s+-7[-.q');
define('LOGGED_IN_SALT',   '+0hr1)}rTi2<Vw?E&xv3[a(~%0ii=7hZ{wdg3O|CF%+Xmb{/*L5AM+(M}WNPnZcn');
define('NONCE_SALT',       '02+z]M@l1V/-#J~*`5z}`ZQNW&KjklK#kI:b0!x-vH6U}#rPhcaMG,i@-Tpis;C*');

/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个WordPress的需求，请为每个WordPress设置
 * 不同的数据表前缀。前缀名只能为数字、字母加下划线。
 */
$table_prefix  = 'wp_';

/**
 * 开发者专用：WordPress调试模式。
 *
 * 将这个值改为true，WordPress将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用WP_DEBUG。
 *
 * 要获取其他能用于调试的信息，请访问Codex。
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/**
 * zh_CN本地化设置：启用ICP备案号显示
 *
 * 可在设置→常规中修改。
 * 如需禁用，请移除或注释掉本行。
 */
define('WP_ZH_CN_ICP_NUM', true);

/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress目录的绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 设置WordPress变量和包含文件。 */
require_once(ABSPATH . 'wp-settings.php');
