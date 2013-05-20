--TEST--
elog_filter: mixed
--INI--
date.timezone=Asia/Tokyo
--SKIPIF--
--FILE--
<?php
require 'test.inc';

if (!extension_loaded('elog')) {
    dl('elog.' . PHP_SHLIB_SUFFIX);
}

$log = dirname(__FILE__) . "/tmp_055.log";
ini_set('elog.default_type', 3);
ini_set('elog.default_destination', $log);

echo "\n[ append: elog_filter_add_fileline ]\n";
var_dump(elog_append_filter('elog_filter_add_fileline'));

function fn_1st($val) {
    return $val . "[" . __FUNCTION__ . "]\n";
}

class Test {
    public function me_2nd($val) {
        return $val . "[" . __METHOD__ . "]\n";
    }
    static public function st_me_3rd($val) {
        return $val . "[" . __METHOD__ . "]\n";
    }
}

$closure_4th = function($val) { return $val . "[closure_4th]\n"; };

$test = new Test;

echo "\n[ Filter : append st_me_3rd ]\n";
var_dump(elog_register_filter('st_me_3rd', 'Test::st_me_3rd', EL_FILTER_APPEND));

echo "\n[ Filter : append cj_4th ]\n";
var_dump(elog_register_filter('cj_4th', $closure_4th));
var_dump(elog_append_filter('cj_4th'));

echo "\n[ Filter : prepend me_2nd ]\n";
var_dump(elog_register_filter('me_2nd', array($test, 'me_2nd'), EL_FILTER_PREPEND));

echo "\n[ Filter : prepend fn_1st ]\n";
var_dump(elog_register_filter('fn_1st', 'fn_1st'));
var_dump(elog_prepend_filter('fn_1st'));

echo "\n[ prepend: elog_filter_to_string ]\n";
var_dump(elog_prepend_filter('elog_filter_to_string'));

echo "\n[ append: elog_filter_add_eol ]\n";
var_dump(elog_append_filter('elog_filter_add_eol'));

echo "\n[ Filters: enabled ]\n";
var_dump(elog_get_filter('enabled'));

function test($var, $out) {
    var_dump($var);
    elog($var);
    echo "=== normal ===\n";
    file_dump($out);
    echo "\n";

    elog_err($var);
    echo "=== err ===\n";
    file_dump($out);
    echo "\n";
}

echo "\n[ Test 1 ]\n";
test('dummy', $log);

echo "\n[ Test 2 ]\n";
test(array('dummy'), $log);

echo "\n[ Test 3 ]\n";
$var = new stdClass;
test($var, $log);

?>
--EXPECTF--
[ append: elog_filter_add_fileline ]
bool(true)

[ Filter : append st_me_3rd ]
bool(true)

[ Filter : append cj_4th ]
bool(true)
bool(true)

[ Filter : prepend me_2nd ]
bool(true)

[ Filter : prepend fn_1st ]
bool(true)
bool(true)

[ prepend: elog_filter_to_string ]
bool(true)

[ append: elog_filter_add_eol ]
bool(true)

[ Filters: enabled ]
array(7) {
  [0]=>
  string(21) "elog_filter_to_string"
  [1]=>
  string(6) "fn_1st"
  [2]=>
  string(6) "me_2nd"
  [3]=>
  string(24) "elog_filter_add_fileline"
  [4]=>
  string(9) "st_me_3rd"
  [5]=>
  string(6) "cj_4th"
  [6]=>
  string(19) "elog_filter_add_eol"
}

[ Test 1 ]
string(5) "dummy"
=== normal ===
dummy[fn_1st]
[Test::me_2nd]
elog_file: %s/055.php
elog_line: 57[Test::st_me_3rd]
[closure_4th]

=== err ===
dummy[fn_1st]
[Test::me_2nd]
elog_file: %s/055.php
elog_line: 62[Test::st_me_3rd]
[closure_4th]


[ Test 2 ]
array(1) {
  [0]=>
  string(5) "dummy"
}
=== normal ===
[
  "dummy"
][fn_1st]
[Test::me_2nd]
elog_file: %s/055.php
elog_line: 57[Test::st_me_3rd]
[closure_4th]

=== err ===
[
  "dummy"
][fn_1st]
[Test::me_2nd]
elog_file: %s/055.php
elog_line: 62[Test::st_me_3rd]
[closure_4th]


[ Test 3 ]
object(stdClass)#3 (0) {
}
=== normal ===
stdClass {
}[fn_1st]
[Test::me_2nd]
elog_file: %s/055.php
elog_line: 57[Test::st_me_3rd]
[closure_4th]

=== err ===
stdClass {
}[fn_1st]
[Test::me_2nd]
elog_file: %s/055.php
elog_line: 62[Test::st_me_3rd]
[closure_4th]
