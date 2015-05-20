USE PHPadvClassSpring2015;

CREATE TABLE IF NOT EXISTS signup (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email varchar(150) COLLATE utf8_unicode_ci NOT NULL UNIQUE KEY,
    password varchar(60) COLLATE utf8_unicode_ci NOT NULL,
    created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    active tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;
