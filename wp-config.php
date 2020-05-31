<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //

if ( file_exists(dirname(__FILE__) . '/local.php') ){
	/** Имя базы данных для WordPress */
	define( 'DB_NAME', 'wpbs' );

	/** Имя пользователя MySQL */
	define( 'DB_USER', 'root' );

	/** Пароль к базе данных MySQL */
	define( 'DB_PASSWORD', '' );

	/** Имя сервера MySQL */
	define( 'DB_HOST', 'localhost' );
}else {

	/** Имя базы данных для WordPress */
	define( 'DB_NAME', 'wpbs' );

	/** Имя пользователя MySQL */
	define( 'DB_USER', 'root' );

	/** Пароль к базе данных MySQL */
	define( 'DB_PASSWORD', '' );

	/** Имя сервера MySQL */
	define( 'DB_HOST', 'localhost' );
}

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '^HmTSt8@LDQJ:(o)/=nq@.L-]%|MkO=j^Xr.:l]K9J48Ok]-:M#MIj9pW|Lc,;h`' );
define( 'SECURE_AUTH_KEY',  '>m7S|_J<qjRt{Z9uBPMFm$ %svmeeipf![uU@W@zp.3*#2t.xh0R8WZv6nw&7o<3' );
define( 'LOGGED_IN_KEY',    'o=rz ;7`]:T9ZEeP]9WMKh>5^Eu)l[u|g!Xdw0NY8JQGI4K=a`-98tF.C>jE tkG' );
define( 'NONCE_KEY',        'V!d#RW[~GyN.zC}aatE0S5P}h hf&5;o6ua;+lJrF|]h{%Ekn`eh8hb|)/xCp0w%' );
define( 'AUTH_SALT',        'q.:NC!;&9q$<!-IpSzh?hEbw>hhx_1_vZhFw~IUyn@QzFaIeZkhE)t3y;eSlJR5Q' );
define( 'SECURE_AUTH_SALT', '}LIW5i!m[KXX-|`RDs8uM-=BvNU=$&cW/oI@iYznd:j5&:fnz-Fy!0lM#&8e6 ~D' );
define( 'LOGGED_IN_SALT',   '(9X(+hAeSL?+-m+:.Y8U]iM#dP c};b3q.!ipqx$v5f@]O_)tTSU[/_0wHF;x+!I' );
define( 'NONCE_SALT',       'lnJ&a;|bIZyfk9j!%ft5`fg=L]b^k-#YyEii[.;&S|BpdH26pu_Si^l}u$wMwz<a' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
