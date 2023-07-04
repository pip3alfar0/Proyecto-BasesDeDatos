/* Consulta de ventas globales por género:
¿Cuál es el total de ventas globales para el género [género]? */
SELECT Genre, SUM(Global_Sales)
FROM GamesSales
GROUP BY Genre;

/*
Consulta de juegos más populares de un editor:
¿Cuáles son los juegos más populares publicados por [Publisher]? */
SELECT Rank, Name, Global_Sales
FROM GamesSales
WHERE publisher LIKE 'nintendo'
FETCH FIRST 5 ROWS ONLY;

/*
Consulta de horas de juego por usuario y género:
¿Cuántas horas ha jugado el usuario [UserID] en juegos del género [género]?*/
SELECT Hours
FROM UserBehavior
WHERE Game LIKE 'spore';

/*
Consulta que juegos tiene el menor tiempo de juego por usuario y mayor cantidad de ventas:
¿Cuál es el juego que tiene menos tiempo de juego que [Hours] y mayor cantidad de ventas que [Global\_Sales]?*/
SELECT Name, Hours, Global_Sales
FROM UserBehavior
WHERE Behavior = "purchase" AND Hours < ;

/*
Consulta que juegos tiene el mayor tiempo de juego por usuario y menor cantidad de ventas:
¿Cuál es el juego que tiene mayor tiempo de juego que [Hours] y menor cantidad de ventas que [Global\_Sales]?*/
SELECT Name, Hours, Global_Sales
FROM UserBehavior
WHERE Behavior = "purchase" AND Hours > ;

/*
Consulta cuál es el país de publisher que tiene más ventas:
¿Cuál es el país de [Publisher] con mayor ventas?*/
SELECT Global_Sales
FROM {
    SELECT Country, SUM(Global_Sales)
    FROM Games_Sales, Publisher
    WHERE Country = " "
    }
WHERE Publisher = " ";