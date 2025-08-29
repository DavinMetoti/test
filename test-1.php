<?php
    class Solution {

        /**
         * Memeriksa apakah tanda kurung dalam string valid
         * @param string $s - String tanda kurung
         * @return bool - Jika true valid, jika false tidak.
         */

        function isValid($s) {
            $stack = [];
            $map = [
                ')' => '(',
                '}' => '{',
                ']' => '['
            ];

            for ($i = 0; $i < strlen($s); $i++) {
                $char = $s[$i];

                    if (array_key_exists($char, $map)) {
                    $topElement = array_pop($stack);
                    if ($topElement !== $map[$char]) {
                        return false;
                    }
                } else {
                    array_push($stack, $char);
                }
            }

            return empty($stack);
        }
    };

    // ================ Contoh Pemanggilan Output Yang Diharapkan ===============
    $solution = new Solution();

    var_dump($solution->isValid("()"));             // true
    var_dump($solution->isValid("()[]{}"));         // true
    var_dump($solution->isValid("(]"));             // false
    var_dump($solution->isValid("([])"));           // true
    var_dump($solution->isValid("([)]"));           // false
    var_dump($solution->isValid("{[]}"));           // true
    var_dump($solution->isValid(""));               // true tapi minimal input satu karakter
    var_dump($solution->isValid("((("));            // false
    var_dump($solution->isValid(")))"));            // false
    var_dump($solution->isValid("([{}])"));         // true