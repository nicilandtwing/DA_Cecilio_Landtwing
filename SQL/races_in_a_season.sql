SELECT
                    rac.raceid, rac.year, rac.name AS 'Grand-Prix',
                    rac.round AS 'Runde',
                    (SELECT CONCAT(d1.forename,' ', d1.surname) FROM drivers d1
                     JOIN results res1 ON d1.driverId = res1.driverId
                     WHERE res1.raceId = rac.raceId AND res1.position = 1) AS 'Rennsieger',
                     (SELECT CONCAT(d1.driverid) FROM drivers d1
                     JOIN results res1 ON d1.driverId = res1.driverId
                     WHERE res1.raceId = rac.raceId AND res1.position = 1) AS 'RennsiegerID',
                    (SELECT CONCAT(d2.forename,' ', d2.surname) FROM drivers d2
                     JOIN results res2 ON d2.driverId = res2.driverId
                     WHERE res2.raceId = rac.raceId AND res2.grid = 1) AS 'Renn-Pole',
                     (SELECT CONCAT(d2.driverid) FROM drivers d2
                     JOIN results res2 ON d2.driverId = res2.driverId
                     WHERE res2.raceId = rac.raceId AND res2.grid = 1) AS 'Renn-PoleID',
                     (SELECT CONCAT(d3.forename,' ', d3.surname) FROM drivers d3
                     JOIN sprintResults spr1 ON spr1.driverId = d3.driverId
                     WHERE spr1.raceId = rac.raceId AND spr1.position = 1) AS 'Sprintsieger',
                     (SELECT CONCAT(d3.driverid) FROM drivers d3
                     JOIN sprintResults spr1 ON spr1.driverId = d3.driverId
                     WHERE spr1.raceId = rac.raceId AND spr1.position = 1) AS 'SprintsiegerID',
                     (SELECT CONCAT(d4.forename,' ', d4.surname) FROM drivers d4
                     JOIN sprintResults spr2 ON spr2.driverId = d4.driverId
                     WHERE spr2.raceId = rac.raceId AND spr2.grid = 1) AS 'Sprint-Pole',
                     (SELECT CONCAT(d4.driverid) FROM drivers d4
                     JOIN sprintResults spr2 ON spr2.driverId = d4.driverId
                     WHERE spr2.raceId = rac.raceId AND spr2.grid = 1) AS 'Sprint-PoleID'
                FROM races rac
                WHERE rac.year = 2021
                ORDER BY rac.round ASC;