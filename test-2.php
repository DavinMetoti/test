<?php

/**
 * Memisahkan string "nama-job,nama-job" menjadi array.
 * @param string $str
 * @return array
 */
function splitJobCharacters($str) {
    $result = [];
    $pairs = explode(',', $str);
    foreach ($pairs as $pair) {
        $split = explode('-', $pair);
        foreach ($split as $item) {
            $result[] = $item;
        }
    }
    return $result;
}

/**
 * Membalikkan string job (posisi ganjil: 1, 3, 5, ...)
 * @param array $arr
 * @return array
 */
function reverseJobCharacters($arr) {
    $result = [];
    for ($i = 0; $i < count($arr); $i++) {
        if ($i % 2 == 1) {
            $result[] = strrev($arr[$i]);
        } else {
            $result[] = $arr[$i];
        }
    }
    return $result;
}

/**
 * Mendekripsi setiap huruf job ke huruf sebelumnya (a->z, b->a, dst)
 * @param array $arr
 * @return array
 */
function decryptJobCharacters($arr) {
    $result = [];
    for ($i = 0; $i < count($arr); $i++) {
        if ($i % 2 == 1) {
            $decrypted = '';
            for ($j = 0; $j < strlen($arr[$i]); $j++) {
                $ch = $arr[$i][$j];
                if ($ch >= 'a' && $ch <= 'z') {
                    $decrypted .= ($ch == 'a') ? 'z' : chr(ord($ch) - 1);
                } else if ($ch >= 'A' && $ch <= 'Z') {
                    $decrypted .= ($ch == 'A') ? 'Z' : chr(ord($ch) - 1);
                } else {
                    $decrypted .= $ch;
                }
            }
            $result[] = $decrypted;
        } else {
            $result[] = $arr[$i];
        }
    }
    return $result;
}

/**
 * Mengelompokkan data menjadi array 2 dimensi: [[nama, job], ...]
 * @param array $arr
 * @return array
 */
function makingDreamTeam($arr) {
    $result = [];
    for ($i = 0; $i < count($arr); $i += 2) {
        if (isset($arr[$i+1])) {
            $result[] = [$arr[$i], $arr[$i+1]];
        }
    }
    return $result;
}

/**
 * Fungsi utama yang menggabungkan semua proses.
 * @param string $str
 * @return string
 */
function startUpMatchMaking($str) {
    $split = splitJobCharacters($str);
    $reversed = reverseJobCharacters($split);
    $decrypted = decryptJobCharacters($reversed);
    $team = makingDreamTeam($decrypted);
    if (count($team) < 3) {
        return 'Minimum 3 members in the team';
    }
    $jobs = array_map(function($member) { return $member[1]; }, $team);
    $required = ['hustler', 'hipster', 'hacker'];
    $found = 0;
    foreach ($required as $job) {
        if (in_array($job, $jobs)) {
            $found++;
        }
    }
    if ($found === 3) {
        return 'Match your Dream Start-Up Team';
    } else {
        return 'The job composition in the team is not suitable';
    }
}

// --- CONTOH PEMANGGILAN ---
echo startUpMatchMaking('idaz-sfmutvi,anggara-sfutqji,fika-sfldbi') . "\n";
// Match your Dream Start-Up Team

echo startUpMatchMaking('eko-sfldbi,fajrin-sfmutvi,abdullah-sfutqji,anggara-sfutqji') . "\n";
// Match your Dream Start-Up Team

echo startUpMatchMaking('abdullah-sfldbi,fajrin-sfmutvi,samir-sfldbi,eko-sfmutvi,basil-sfmutvi') . "\n";
// The job composition in the team is not suitable

echo startUpMatchMaking('samir-sfmutvi,basil-sfutqji,eko-sfmutvi') . "\n";
// The job composition in the team is not suitable

echo startUpMatchMaking('samir-sfmutvi,basil-sfutqji') . "\n";
// Minimum 3 members in the team