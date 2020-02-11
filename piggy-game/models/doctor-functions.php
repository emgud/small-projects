<?php

    // PHP konstantos
    define( 'DB_PAVADINIMAS',    'hospital12' );
    define( 'DB_TIPAS',          'localhost' );
    define( 'MYSQL_USER_VARDAS', 'root' );
    define( 'MYSQL_USER_PASS',   'root' );
    // 0 isjungta; 1- rodo pagrindiniai; 2- rodo visus pranesimus
    define( 'DEBUG_MODE',   '1' );

    $prisijungimas =  mysqli_connect( DB_TIPAS, MYSQL_USER_VARDAS, MYSQL_USER_PASS, DB_PAVADINIMAS);
    // 1) html/php faile nustatyt meta tag utf-8
    // 2) DB-je nustatyti collation   UTF-8 general_ci arba unicode_ci
    // 3) MYsql lietuviskos kalbos nustaytmas
    mysqli_set_charset($prisijungimas, "UTF8"); // !!! UTF8 be jokio "-"

function getPrisijungimas() {
    // paskelbiu, kad noriu prieiti prie globaliaus kintamojo $prisijungimas
    global $prisijungimas;

    // mysqli_connect( [$host, $user, $password, $database, $Mysql_port, $socket]);
    if ($prisijungimas == false) {
            if (DEBUG_MODE > 0) {
                echo "ERROR: nepavyko prisijungti prie DB !!!! <br>";
                echo  mysqli_connect_error($prisijungimas);
            }
            return NULL;
    } else {
            if (DEBUG_MODE > 1) {
                echo "Pisijungiau prie DB! <br>";
            }
            return $prisijungimas;
    }
}
// getPrisijungimas();  test

// grazina konkretu gydytojo duomenis is DB
// $nr    - norimo gydytojo 'id' is duomenu bazes
// return - grazina array
function getDoctor($nr) {
    // ! visada patestuoti SQL terminale !!
     $manoSQL = "SELECT * FROM doctors WHERE id = '$nr'  ";
     $rezultataiMysqlObjek = mysqli_query(getPrisijungimas(), $manoSQL);
     //test
     // print_r($rezultataiMysqlObjek);
     // is mysqli objekto paimame viena eilute ir paverciam i array
     $rezultataiArray = mysqli_fetch_assoc($rezultataiMysqlObjek);
     //test
     // echo "<hr>";
     // print_r($rezultataiArray);
     return $rezultataiArray;
}
// testuojam
 // $gydytojas1 = getDoctor(2);
 // print_r($gydytojas1);
 // echo "<hr>";

function createDoctor($vard, $pavard) {
    // uzkoduojam renklus:' " <
    $vard =   htmlspecialchars($vard, ENT_QUOTES );
    $pavard = htmlspecialchars($pavard, ENT_QUOTES );

    $manoSQL = "INSERT INTO doctors
                       VALUES(NULL, '$vard', '$pavard')
               ";
    $arPavyko = mysqli_query(getPrisijungimas(), $manoSQL);
    if ($arPavyko == false &&  DEBUG_MODE > 0) {
            echo "ERROR: nepavyko sukurti naujo gydytojo: $vard, $pavard DB-je !!!! <br>";
            echo  mysqli_error(getPrisijungimas()); // neveikia, matyt nes naujas MYSQL serveris
    }
}
// test
// createDoctor('Petras', 'Uzurpatorius');
// createDoctor('Antanas', 'Kalkinas');

// $nr - duomenu bazeje esancio gydytojo numeris
function deleteDoctor($nr) {
    // uzkoduojam renklus:' " <
    $nr =   htmlspecialchars($nr, ENT_QUOTES );

    $manoSQL = "DELETE FROM doctors WHERE id = '$nr'  LIMIT 1 ";
    $arPavyko = mysqli_query(getPrisijungimas(), $manoSQL);
    if ($arPavyko == false &&  DEBUG_MODE > 0) {
            echo "ERROR: nepavyko istrinti: $nr gydytojo DB-je !!!! <br>";
     }
}

function updateDoctor($nr, $vard, $pavard) {
    // uzkoduojam renklus:' " <
    $nr =   htmlspecialchars($nr, ENT_QUOTES );
    $vard =   htmlspecialchars($vard, ENT_QUOTES );
    $pavard =   htmlspecialchars($pavard, ENT_QUOTES );

    $manoSQL = "UPDATE  doctors
                        SET
                            name = '$vard',
                            lname = '$pavard'
                        WHERE id = '$nr'
                        LIMIT 1
                ";
    $arPavyko = mysqli_query(getPrisijungimas(), $manoSQL);
    if ($arPavyko == false &&  DEBUG_MODE > 0) {
            echo "ERROR: nepavyko redaguoti: $nr gydytojo DB-je !!!! <br>";
     }
}
// updateDoctor(2, "Karolis", "Karalaitis");


// grazina konkretu gydytojo duomenis is DB
// $kiekis    - kiek gydytoju paimit? jei nieko nerasysite, tai visus paimsisme
// return - grazina Mysql Objekta
function getDoctors($kiekis = 9999999) {
    // ! visada patestuoti SQL terminale !!
     $manoSQL = "SELECT * FROM doctors  LIMIT $kiekis ";
     $rezultataiMysqlObjek = mysqli_query(getPrisijungimas(), $manoSQL);

     return $rezultataiMysqlObjek;
}
// test
// $visiGydytojai = getDoctors(); // MYSQL objektas
// // print_r( $visiGydytojai ) ;
//
// visu gydytoju isvedimas
// $gyd = mysqli_fetch_assoc($visiGydytojai); // is visu paimame viena
// while ($gyd) {  // false, 0, NULL, ''
//     echo "{$gyd['name']}  {$gyd['lname']} <br>";
//     echo "$gyd[name]  $gyd[lname] <br>";
//     echo $gyd['name'] . " " . $gyd['lname'] . "<br>";
//     // is visu paimame sekanti gydytoja
//     $gyd = mysqli_fetch_assoc($visiGydytojai);
// }
