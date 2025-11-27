<?php
$knihy = [
    [
        "nazev" => "Pán prstenů spol prstenu",
        "autor" => "J. R. R. Tolkien",
        "rok" => 1960,
        "kategorie" => "fantasy"
    ],

    [
        "nazev" => "Harry Potter a kámen mudrců",
        "autor" => "J. K. Rowling",
        "rok" => 2000,
        "kategorie" => "fantasy"
    ],

    [
        "nazev" => "1984",
        "autor" => "George Orwell",
        "rok" => 1946,
        "kategorie" => "sci-fi"
    ],

    [
        "nazev" => "gg",
        "autor" => "Pepa",
        "rok" => 1999,
        "kategorie" => "krimi"
    ],
];

function obsahuje($text, $hledat) {
    $text = strtolower($text); //prevod na mala pismena


    $hledat = strtolower($hledat);

    $pomoc1 = strlen($text); 
    $pomoc2 = strlen($hledat);

    if ($pomoc2 == 0)
    {
        return true;
    } 

    for ($i = 0; $i <= $pomoc1 - $pomoc2; $i++)
    {
        $shoda = true;
        for ($j = 0; $j < $pomoc2; $j++) {

            if ($text[$i + $j] != $hledat[$j])
             {
                $shoda = false;
                break;
            }
        }
        if ($shoda)
        {
            return true;
        } 
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nazev = trim($_POST["nazev"]);

    $autor = trim($_POST["autor"]) ;

    $rok = trim($_POST["rok"]);
    $kategorie = trim($_POST["kategorie"]);

    if ($nazev !== "" && $autor !== "" && $rok !== "" && $kategorie !== "")  // nenastane ale radsi
    {
        $knihy[] = ["nazev"=>$nazev,"autor"=>$autor,"rok"=>$rok,"kategorie"=>$kategorie];
    }
}

$hledat = isset($_GET["hledat"]) ? trim($_GET["hledat"]) : "";
$filtrKategorie = isset($_GET["kategorie"]) ? trim($_GET["kategorie"]) : "";

$vyfiltrovaneKnihy = [];


foreach ($knihy as $k) 
{
    $kontrola = true;
    if ($hledat !== "")
    {
        $t = $k["nazev"]." ".$k["autor"];
        if (!obsahuje($t, $hledat))
        {
            $kontrola = false;
        } 
    }
    if ($filtrKategorie !== "" && $k["kategorie"] !== $filtrKategorie)
    {
        $kontrola = false;
    }
    if ($kontrola)
    {
        $vyfiltrovaneKnihy[] = $k;
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Katalog</title>
</head>
<body>

<h1>Katalog knih</h1>

<form method="get">
    <p>
        Hledat:
        <input type="text" name="hledat" value="<?php echo htmlspecialchars($hledat); ?>">
    </p>
    <p>
        Kategorie:
        <select name="kategorie">
            <option value="">vsechno</option>
            <option value="fantasy" <?php if ($filtrKategorie==="fantasy") echo "vyhledano: "; ?>>fantasy</option>
            <option value="sci-fi" <?php if ($filtrKategorie==="sci-fi") echo "vyhledano: "; ?>>sci-fi</option>
            <option value="krimi" <?php if ($filtrKategorie==="krimi") echo "vyhledano: "; ?>>krimi</option>
            
        </select>
    </p>
    <p>
        <button type="submit">Filtrovat</button>
    </p>
</form>

<table>
    <tr>
        <th>Název</th>
        <th>Autor</th>
        <th>Rok</th>
        <th>Kategorie</th>
    </tr>
    <?php foreach ($vyfiltrovaneKnihy as $k): ?>
        <tr>
            <td><?php echo htmlspecialchars($k["nazev"]); ?></td>
            <td><?php echo htmlspecialchars($k["autor"]); ?></td>
            <td><?php echo htmlspecialchars($k["rok"]); ?></td>
            <td><?php echo htmlspecialchars($k["kategorie"]); ?></td>
        </tr>
    <?php endforeach; ?>
    <?php if (count($vyfiltrovaneKnihy) == 0): ?>
        <tr>
            <td>Nic nenalezeno</td>
        </tr>
    <?php endif; ?>
</table>

<h2>Přidat knihu</h2>

<form method="post">
    <p>
        Název:
        <input type="text" name="nazev">
    </p>
    <p>
        Autor:
        <input type="text" name="autor">
    </p>
    <p>
        Rok:
        <input type="number" name="rok">
    </p>
    <p>
        Kategorie:
        <input type="text" name="kategorie">
    </p>
    <p>
        <button type="submit">Přidat</button>
    </p>
</form>

</body>
</html>
