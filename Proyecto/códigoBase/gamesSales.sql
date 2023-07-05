CREATE TABLE GamesSales (
    rank INTEGER,
    name VARCHAR(255),
    platform VARCHAR(255),
    year INTEGER,
    genre VARCHAR(255),
    publisher VARCHAR(255),
    na_sales FLOAT,
    eu_sales FLOAT,
    jp_sales FLOAT,
    other_sales FLOAT,
    global_sales FLOAT,
    PRIMARY KEY (name, platform, year),
    FOREIGN KEY (publisher) REFERENCES Publisher(name)
);