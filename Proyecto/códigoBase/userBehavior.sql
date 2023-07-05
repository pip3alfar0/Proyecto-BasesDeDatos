CREATE TABLE UserBehavior (
    userid INTEGER,
    game VARCHAR(255),
    platform VARCHAR(255),
    behavior VARCHAR(255),
    hours FLOAT,
    PRIMARY KEY (userid, game, platform, year, behavior),
    FOREIGN KEY (game, platform, year) REFERENCES GamesSales(name, platform, year)
);