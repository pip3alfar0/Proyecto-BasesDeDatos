<!DOCTYPE html>
<html>
<head>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
</head>
<body>
    <?php
    echo "<table>";
    echo "<tr>
            <th>Name</th>
            <th>Year</th>
            <th>Global Sales</th>
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

    try {
        $pdo = new PDO('pgsql:host=localhost;port=5432;dbname=cc3201;user=webuser;password=contrasena');
        $startYear = isset($_GET['start_year']) ? $_GET['start_year'] : '';
        $endYear = isset($_GET['end_year']) ? $_GET['end_year'] : '';

        $stmt = $pdo->prepare('SELECT DISTINCT name, year, global_sales
                               FROM userbehavior ub
                               JOIN gamessales gs ON gs.name = ub.game AND ub.platform = gs.platform AND ub.gameyear = gs.year
                               WHERE behavior = \'purchase\' AND year >= :start_year AND year <= :end_year
                               AND ub.game NOT IN
                                   (SELECT DISTINCT game
                                    FROM userbehavior
                                    WHERE behavior = \'play\')
                               ORDER BY global_sales DESC');

        $stmt->bindParam(':start_year', $startYear, PDO::PARAM_INT);
        $stmt->bindParam(':end_year', $endYear, PDO::PARAM_INT);
        $stmt->execute();
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
