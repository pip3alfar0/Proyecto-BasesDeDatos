<!DOCTYPE html>
<html>
<head>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
</head>
<body>
    <?php
    echo "<table>";
    echo "<tr>
            <th>Género</th>
            <th>Total de horas</th>
            <th>Ventas globales totales</th>
            <th>Ventas en Europa</th>
            <th>Ventas en América del Norte</th>
            <th>Ventas en Japón</th>
            <th>Otras ventas</th>
          </tr>";

    class TableRows extends RecursiveIteratorIterator {
        function __construct($it) {
            parent::__construct($it, self::LEAVES_ONLY);
        }
        function current() {
            return "<td>" . parent::current(). "</td>";
        }
        function beginChildren() {
            echo "<tr>";
        }
        function endChildren() {
            echo "</tr>" . "\n";
        }
    }
	// Obtener el género seleccionado del formulario
    $genero = isset($_GET['genero']) ? $_GET['genero'] : '';
    try {
        $pdo = new PDO('pgsql:
                       host=localhost;
                       port=5432;
                       dbname=cc3201;
                       user=webuser;
                       password=contrasena');
        $variable1 = $_GET['genero'];
        $stmt = $pdo->prepare('SELECT gs.genre,
                        SUM(ub.hours) AS total_hours,
                        SUM(gs.global_sales) AS total_global_sales,
                        SUM(gs.eu_sales) AS total_eu_sales,
                        SUM(gs.na_sales) AS total_na_sales,
                        SUM(gs.jp_sales) AS total_jp_sales,
                        SUM(gs.other_sales) AS total_other_sales
                      FROM userbehavior ub
                      INNER JOIN gamessales gs ON ub.game = gs.name AND ub.platform = gs.platform
                      WHERE ub.behavior = \'play\'
                        AND gs.genre = :valor1
                      GROUP BY gs.genre
                      ORDER BY total_hours DESC');
        $stmt->execute(['valor1' => $variable1]);
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
            echo $v;
        }
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

    echo "</table>";
    ?>
</body>
</html>
