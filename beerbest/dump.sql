INSERT INTO beers (name, type, price)
VALUES ('Red Hops Elixir', 'IPA (India Pale Ale)', '12.50'),
       ('Midnight Velvet Porter', 'Stout', '8.99'),
       ('Citrus Zest Saison', 'Pilsner', '10.75'),
       ('Mountain Peak IPA', 'Wheat Beer', '12.33'),
       ('Amber Twilight Ale', 'Amber Ale', '9.90'),
       ('Midnight Velvet Porter', 'Porter', '11.50'),
       ('Harvest Wheat Whispers', 'Wheat Beer', '8.50'),
       ('Bavarian Bliss Bock', 'Bock', '13.50'),
       ('Mystic Oak Amber Ale', 'Amber Ale', '12.25'),
       ('Tropical Breeze Lager', 'Lager', '10.50'),
       ('Enchanted Abbey Tripel', 'Belgian Tripel', '15.75'),
       ('Frosted Raspberry Wheat', 'Wheat Beer', '9.00'),
       ('Velvet Vanilla Cream Ale', 'Cream Ale', '11.00'),
       ('Golden Hops Elixir', 'IPA', '12.80'),
       ('Cherry Blossom Euphoria', 'Sour Beer', '14.20')
;

update beers set created_at = now(), updated_at = now();

INSERT INTO locations
(beer_id, longitude, latitude)
VALUES (1, -46.64728805, -23.55137198),
       (2, -46.64807381, -23.54852348),
       (3, -46.64282353, -23.55356562), -- nosso ponto de ref
       (4, -46.65257404, -23.55536634),
       (5, -46.65975299, -23.56089930),
       (6, -46.64010910, -23.54557669),
       (7, -46.65761002, -23.54335017),
       (8, -46.63653748, -23.56224158),
       (9, -46.62803704, -23.56862540),
       (10, -46.65560992, -23.57317574),
       (11, -46.64054246, -23.57822871),
       (12, -46.68337956, -23.56481794),
       (13, -46.68602382, -23.54429521),
       (14, -46.65223599, -23.56444091),
       (15, -46.64071875, -23.56664921)
;

update locations set created_at = now(), updated_at = now();

SELECT * FROM beers;
SELECT * FROM locations;

SELECT
    b.name,
    l.longitude,
    l.latitude
FROM locations l
    INNER JOIN beers b
        on b.id = l.beer_id
WHERE 6371 * 2 * ASIN(
    SQRT(
        POW(SIN((RADIANS(-23.54963413268389) - RADIANS(l.latitude)) / 2), 2) +
        COS(RADIANS(-23.54963413268389)) * COS(RADIANS(l.latitude)) *
        POW(SIN((RADIANS(-46.65019806906653) - RADIANS(l.longitude)) / 2), 2)
    )
) <= 1; -- raio de 1km
