--TEST--
elog_filter_add_level
--INI--
--SKIPIF--
--FILE--
<?php
require 'test.inc';


$log = dirname(__FILE__) . "/tmp_052.log";
ini_set('elog.default_type', 3);
ini_set('elog.default_destination', $log);

echo "[ append: elog_filter_add_level ]\n";
var_dump(elog_append_filter('elog_filter_add_level'));

function test($out) {
    elog("normal-dummy");
    echo "=== normal ===\n";
    file_dump($out);

    elog_emerg("emerg-dummy");
    echo "=== emerg ===\n";
    file_dump($out);

    elog_alert("alert-dummy");
    echo "=== alert ===\n";
    file_dump($out);

    elog_crit("crit-dummy");
    echo "=== crit ===\n";
    file_dump($out);

    elog_err("err-dummy");
    echo "=== err ===\n";
    file_dump($out);

    elog_warning("warning-dummy");
    echo "=== warning ===\n";
    file_dump($out);

    elog_notice("notice-dummy");
    echo "=== notice ===\n";
    file_dump($out);

    elog_info("info-dummy");
    echo "=== info ===\n";
    file_dump($out);

    elog_debug("debug-dummy");
    echo "=== debug ===\n";
    file_dump($out);
}

echo "\n[ Test 1 ]\n";
test($log);

echo "\n[ Test 2 ]\n";
ini_set('elog.level', 'alert');
echo "elog.level: ", ini_get('elog.level'), "\n";
test($log);

echo "\n[ Test 3 ]\n";
ini_set('elog.level', 'notice');
echo "elog.level: ", ini_get('elog.level'), "\n";
test($log);

?>
--EXPECTF--
[ append: elog_filter_add_level ]
bool(true)

[ Test 1 ]
=== normal ===
normal-dummy
=== emerg ===
emerg-dummy
level: EMERGE
=== alert ===
alert-dummy
level: ALERT
=== crit ===
crit-dummy
level: CRIT
=== err ===
err-dummy
level: ERR
=== warning ===
warning-dummy
level: WARNING
=== notice ===
notice-dummy
level: NOTICE
=== info ===
info-dummy
level: INFO
=== debug ===
debug-dummy
level: DEBUG

[ Test 2 ]
elog.level: alert
=== normal ===
normal-dummy
=== emerg ===
emerg-dummy
level: EMERGE
=== alert ===
alert-dummy
level: ALERT
=== crit ===
=== err ===
=== warning ===
=== notice ===
=== info ===
=== debug ===

[ Test 3 ]
elog.level: notice
=== normal ===
normal-dummy
=== emerg ===
emerg-dummy
level: EMERGE
=== alert ===
alert-dummy
level: ALERT
=== crit ===
crit-dummy
level: CRIT
=== err ===
err-dummy
level: ERR
=== warning ===
warning-dummy
level: WARNING
=== notice ===
notice-dummy
level: NOTICE
=== info ===
=== debug ===
