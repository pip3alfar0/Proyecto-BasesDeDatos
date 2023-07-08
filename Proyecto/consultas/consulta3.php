<!DOCTYPE html>
<html>
    <head>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    </head>
<body>
    <?php
echo "<table>";
echo "<tr>
        <th>Publisher</th>
        <th>Total Hours</th>
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
	$variable2 = $_GET['country'];
	$stmt = $pdo->prepare('SELECT gs.publisher, SUM(ub.hours) AS total_hours
                      FROM userbehavior ub
                      JOIN gamessales gs ON ub.game = gs.name AND ub.platform = gs.platform AND ub.gameyear = gs.year
                      JOIN publisher p ON p.name = gs.publisher
                      WHERE p.country = :country
                      GROUP BY gs.publisher
                      ORDER BY total_hours DESC
                      LIMIT 10;');


	$stmt->execute(['country' => $variable2]);
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
