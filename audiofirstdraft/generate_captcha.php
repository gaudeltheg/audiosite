<?php
session_start();

$alpla = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9), ['!', '@', '#', '$', '%', '^', '&', '*', '+']);
$captcha = '';
for ($i = 0; $i < 6; $i++) {
    $captcha .= $alpla[array_rand($alpla)];
}

$_SESSION['captcha'] = $captcha;
echo $captcha;
?>
