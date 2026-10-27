<?php
// PHP: Tablice - zadania 1-5
// Uruchom na serwerze z PHP (np. XAMPP): http://localhost/zadania.php

function fmt($x){ return is_float($x) ? number_format($x, 0, '', '') : $x; }
function pokaz($t){ echo implode(" ", array_map('fmt', $t)); }
function naglowek($t){ echo "<h3>$t</h3>"; }
function linia($opis, $wartosc){ echo "<p><b>$opis</b> $wartosc</p>"; }
function pobierz($nazwa, $domyslna){
    return isset($_POST[$nazwa]) && trim($_POST[$nazwa]) !== '' ? $_POST[$nazwa] : $domyslna;
}
function naTablice($tekst){
    $czesci = preg_split('/[\s,;]+/', trim($tekst), -1, PREG_SPLIT_NO_EMPTY);
    $t = array();
    foreach($czesci as $c){ $t[] = $c + 0; }
    return $t;
}

$wejscie2 = pobierz('liczby', '5 3 9 12 3 7 33 8 1 6');
$wejscie3a = pobierz('litery', 'aBcDeFgHiJ');
$wejscie3b = pobierz('wyraz', 'Programowa');
$wejscieA  = pobierz('a', '10');
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>PHP: Tablice - zadania</title>
<style>body{font-family:sans-serif;max-width:900px;margin:20px auto;padding:0 12px}
h2{border-bottom:2px solid #444;margin-top:40px}code{background:#eee;padding:1px 4px}</style>
</head>
<body>
<h1>PHP: Tablice - zadania</h1>

<form method="post">
  <p>Zad. 2 - liczby (oddzielone spacją): <input name="liczby" size="40" value="<?= htmlspecialchars($wejscie2) ?>"></p>
  <p>Zad. 3.1 - 10 liter (np. aBcDeFgHiJ): <input name="litery" value="<?= htmlspecialchars($wejscie3a) ?>"></p>
  <p>Zad. 3.2 - wyraz 10-literowy: <input name="wyraz" value="<?= htmlspecialchars($wejscie3b) ?>"></p>
  <p>Zad. 4.5 - liczba a: <input name="a" value="<?= htmlspecialchars($wejscieA) ?>"></p>
  <button>Przelicz (losuje też nową tablicę w zad. 4)</button>
</form>

<h2>Zadanie 1</h2>
<?php
$tab1 = array(7,3,1,6,9,5,4,10,2,2);
linia("1.1 Piąta komórka (indeks 4):", $tab1[4]);
$tab1[6] = 12; // siódma komórka ma indeks 6
linia("tab1 po zmianie 7. komórki:", implode(" ", $tab1));

// 1.2 kopia
$tab2 = array();
for($i=0; $i<count($tab1); $i++){ $tab2[$i] = $tab1[$i]; }
linia("1.2 tab2:", implode(" ", $tab2));

// 1.3 sumy
$tab3 = array();
for($i=0; $i<count($tab1); $i++){ $tab3[$i] = $tab1[$i] + $tab2[$i]; }
linia("1.3 tab3 = tab1 + tab2:", implode(" ", $tab3));

// 1.4 odwrotna kolejność
$n = count($tab1);
for($i=0; $i<$n; $i++){ $tab2[$i] = $tab1[$n-1-$i]; }
linia("1.4 tab2 (tab1 od końca):", implode(" ", $tab2));
?>

<h2>Zadanie 2</h2>
<?php
// 2.1 wypełnienie wartościami użytkownika
$t = naTablice($wejscie2);
$n = count($t);
linia("2.1 Tablica:", implode(" ", $t));

if($n > 0){
    // 2.2 min i max
    $min = $t[0]; $max = $t[0];
    for($i=1; $i<$n; $i++){
        if($t[$i] < $min) $min = $t[$i];
        if($t[$i] > $max) $max = $t[$i];
    }
    linia("2.2 Najmniejszy:", "$min, największy: $max");

    // 2.3 średnia
    $suma = 0;
    for($i=0; $i<$n; $i++){ $suma += $t[$i]; }
    linia("2.3 Średnia:", round($suma/$n, 2));

    // 2.4 wystąpienia cyfry 3 (w zapisie wszystkich liczb)
    $trojki = 0;
    for($i=0; $i<$n; $i++){ $trojki += substr_count((string)$t[$i], "3"); }
    linia("2.4 Wystąpień cyfry 3:", $trojki);

    // 2.5 sortowanie bąbelkowe rosnąco (na kopii)
    $s = $t;
    for($i=0; $i<$n-1; $i++){
        for($j=0; $j<$n-1-$i; $j++){
            if($s[$j] > $s[$j+1]){ $tmp = $s[$j]; $s[$j] = $s[$j+1]; $s[$j+1] = $tmp; }
        }
    }
    linia("2.5 Posortowana rosnąco:", implode(" ", $s));

    // 2.6 mediana
    $mediana = ($n % 2 == 1) ? $s[intdiv($n,2)] : ($s[$n/2-1] + $s[$n/2]) / 2;
    linia("2.6 Mediana:", $mediana);

    // 2.7 trzy najmniejsze i największe
    $k = min(3, $n);
    $naj_m = array(); $naj_w = array();
    for($i=0; $i<$k; $i++){ $naj_m[] = $s[$i]; $naj_w[] = $s[$n-1-$i]; }
    linia("2.7 Trzy najmniejsze:", implode(" ", $naj_m));
    linia("Trzy największe:", implode(" ", $naj_w));

    // 2.8 kwadraty
    $kw = $t;
    for($i=0; $i<$n; $i++){ $kw[$i] = $kw[$i] * $kw[$i]; }
    linia("2.8 Kwadraty:", implode(" ", $kw));

    // 2.9 parzyste / nieparzyste (dla liczb całkowitych)
    $parz = 0; $nieparz = 0;
    for($i=0; $i<$n; $i++){
        if($t[$i] % 2 == 0) $parz++; else $nieparz++;
    }
    linia("2.9 Parzystych:", "$parz, nieparzystych: $nieparz");

    // 2.10 podzielne przez 3
    $po3 = 0;
    for($i=0; $i<$n; $i++){ if($t[$i] % 3 == 0) $po3++; }
    linia("2.10 Podzielnych przez 3:", $po3);
}
?>

<h2>Zadanie 3</h2>
<?php
// 3.1 / 3.2 - tablica 10 liter
function dziesiecLiter($tekst){
    $tekst = preg_replace('/\s+/u', '', $tekst);
    $znaki = mb_str_split($tekst);
    if(count($znaki) != 10){
        echo "<p style='color:red'>Podano ".count($znaki)." znaków zamiast 10 - tablica będzie miała inny rozmiar.</p>";
    }
    return array_slice($znaki, 0, 10);
}
$l1 = dziesiecLiter($wejscie3a);
$l2 = dziesiecLiter($wejscie3b);
linia("3.1 Litery użytkownika:", implode(" ", $l1));
linia("3.2 Wyraz w tablicy:", implode(" ", $l2));

// 3.3 zamiana wielkich na małe i odwrotnie
function zamienWielkosc($t){
    for($i=0; $i<count($t); $i++){
        $c = $t[$i];
        $t[$i] = ($c === mb_strtoupper($c)) ? mb_strtolower($c) : mb_strtoupper($c);
    }
    return $t;
}
linia("3.3 Po zamianie wielkości (3.1):", implode(" ", zamienWielkosc($l1)));
linia("Po zamianie wielkości (3.2):", implode(" ", zamienWielkosc($l2)));

// 3.4 losowa kolejność
$los = $l2;
shuffle($los);
linia("3.4 Losowa kolejność:", implode(" ", $los));
?>

<h2>Zadanie 4</h2>
<?php
// Zakres 1-30, żeby w 100 elementach powtórzenia (pkt 4.1 i 4.10) były widoczne
$A = array();
for($i=0; $i<100; $i++){ $A[$i] = rand(1, 30); }
linia("Tablica A:", implode(" ", $A));

// 4.1 największa i ile razy
$max = $A[0];
for($i=1; $i<100; $i++){ if($A[$i] > $max) $max = $A[$i]; }
$ile = 0;
for($i=0; $i<100; $i++){ if($A[$i] == $max) $ile++; }
linia("4.1 Największa:", "$max, występuje $ile razy");

// 4.2 nieparzyste
$w = array();
for($i=0; $i<100; $i++){ if($A[$i] % 2 != 0) $w[] = $A[$i]; }
linia("4.2 Nieparzyste:", implode(" ", $w));

// 4.3 nieparzyste indeksy
$w = array();
for($i=1; $i<100; $i+=2){ $w[] = $A[$i]; }
linia("4.3 Komórki o nieparzystych indeksach:", implode(" ", $w));

// 4.4 przedział <5, 15)
$w = array();
for($i=0; $i<100; $i++){ if($A[$i] >= 5 && $A[$i] < 15) $w[] = $A[$i]; }
linia("4.4 W przedziale &lt;5, 15):", count($w)." liczb: ".implode(" ", $w));

// 4.5 najbliższy a
$a = $wejscieA + 0;
$najblizszy = $A[0];
for($i=1; $i<100; $i++){
    if(abs($A[$i] - $a) < abs($najblizszy - $a)) $najblizszy = $A[$i];
}
linia("4.5 Najbliższy a=$a:", $najblizszy);

// 4.6 poprzednik i następnik minimum
$imin = 0;
for($i=1; $i<100; $i++){ if($A[$i] < $A[$imin]) $imin = $i; }
$pop = ($imin > 0)  ? $A[$imin-1] : "brak (minimum jest pierwsze)";
$nast = ($imin < 99) ? $A[$imin+1] : "brak (minimum jest ostatnie)";
linia("4.6 Minimum ($A[$imin]) na indeksie $imin:", "poprzednik: $pop, następnik: $nast");

// 4.7 elementy > 10 do nowej tablicy
$C = array();
for($i=0; $i<100; $i++){ if($A[$i] > 10) $C[] = $A[$i]; }
linia("4.7 Elementy &gt; 10 (rozmiar ".count($C)."):", implode(" ", $C));

// 4.8 sumy częściowe
$B = array();
$s = 0;
for($i=0; $i<100; $i++){ $s += $A[$i]; $B[$i] = $s; }
linia("4.8 B[i] = suma A[0..i]:", implode(" ", $B));

// 4.9 sortowanie malejąco (kopia, wybór maksimum)
$D = $A;
for($i=0; $i<99; $i++){
    $im = $i;
    for($j=$i+1; $j<100; $j++){ if($D[$j] > $D[$im]) $im = $j; }
    $tmp = $D[$i]; $D[$i] = $D[$im]; $D[$im] = $tmp;
}
linia("4.9 Malejąco:", implode(" ", $D));

// 4.10 elementy występujące co najmniej 3 razy (każdy raz)
$licznik = array();
for($i=0; $i<100; $i++){
    if(!isset($licznik[$A[$i]])) $licznik[$A[$i]] = 0;
    $licznik[$A[$i]]++;
}
$w = array();
foreach($licznik as $wartosc => $krotnosc){
    if($krotnosc >= 3) $w[] = "$wartosc (x$krotnosc)";
}
linia("4.10 Występują min. 3 razy:", implode(", ", $w));
?>

<h2>Zadanie 5</h2>
<p><i>Uwaga: Fibonacci i potęgi 2 dla 100 elementów przekraczają zakres int
(ok. 9,2·10<sup>18</sup>), więc PHP przechodzi na float. Potęgi 2 pozostają dokładne,
a w Fibonaccim końcowe wyrazy są przybliżone.</i></p>
<?php
// 5.1 Fibonacci
$F = array();
for($i=0; $i<100; $i++){
    $F[$i] = ($i < 2) ? 1 : $F[$i-1] + $F[$i-2];
}
echo "<p><b>5.1 Fibonacci:</b> "; pokaz($F); echo "</p>";

// 5.2 potęgi 2: 1, 2, 4, 8, ...
$P = array();
for($i=0; $i<100; $i++){ $P[$i] = pow(2, $i); }
echo "<p><b>5.2 Potęgi 2:</b> "; pokaz($P); echo "</p>";

// 5.3 3, 6, 9, 12, ...
$T3 = array();
for($i=0; $i<100; $i++){ $T3[$i] = 3 * ($i + 1); }
linia("5.3 Ciąg 3, 6, 9...:", implode(" ", $T3));

// 5.4 2, 4, 8, 16, 32, ...
$T4 = array();
for($i=0; $i<100; $i++){ $T4[$i] = pow(2, $i + 1); }
echo "<p><b>5.4 Ciąg 2, 4, 8, 16...:</b> "; pokaz($T4); echo "</p>";
?>
</body>
</html>