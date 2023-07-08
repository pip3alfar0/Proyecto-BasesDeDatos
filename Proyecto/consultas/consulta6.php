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
            <th>Average Hours</th>
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
        $year = isset($_GET['year']) ? $_GET['year'] : '';

        $stmt = $pdo->prepare('SELECT gs.name, gs.year, vg.avg_hours
                              FROM GamesSales gs
                              JOIN hourspergame vg ON gs.name = vg.name
                              WHERE gs.year = :year AND gs.platform=vg.platform
                              ORDER BY vg.avg_hours DESC');
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
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
