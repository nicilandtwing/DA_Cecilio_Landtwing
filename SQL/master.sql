/* == ALLGEMEIN == */
/* Momentane Fahrer-Team Kombination */
CREATE OR REPLACE VIEW v_current_driver_teams AS
SELECT dri.driverid, dri.forename, dri.surname, con.name AS constructor_name
FROM drivers dri
INNER JOIN results res ON dri.driverId = res.driverId
INNER JOIN constructors con ON res.constructorId = con.constructorId
INNER JOIN races rac ON res.raceId = rac.raceId
WHERE rac.year = (SELECT MAX(year) FROM races)
GROUP BY dri.driverId;

/* == STARTSEITE == */
/* Name, Strecke und Ortschaft des letzten Rennens */
CREATE OR REPLACE VIEW v_latest_race AS
SELECT rac.name as racename, rac.year, cir.name as circuitname, cir.location
FROM races rac
INNER JOIN circuits cir ON cir.circuitId = rac.circuitId
WHERE rac.raceId = (SELECT MAX(raceId) FROM results);

/* Resultat des letzten Rennens */
CREATE OR REPLACE VIEW v_latest_race_result AS
SELECT rac.name AS Rennname, res.position AS Position, dri.forename AS Fahrervorname, dri.surname AS Fahrernachname, vcur.constructor_name, res.time, sta.status, res.grid
FROM races rac
INNER JOIN results res ON res.raceId = rac.raceId
INNER JOIN drivers dri ON dri.driverId = res.driverId
INNER JOIN v_current_driver_teams vcur ON vcur.driverId = dri.driverId
INNER JOIN status sta on res.statusId = sta.statusId
WHERE res.raceId = (SELECT MAX(raceId) FROM results)
GROUP BY dri.driverid
ORDER BY 
	CASE 
     WHEN res.position IS NULL THEN 1
     ELSE 0
    END,
    res.position;

/* Momentane Fahrer Rangliste */
CREATE OR REPLACE VIEW v_current_drivers_position AS
SELECT dri.forename, dri.surname, drs.position, drs.points, drs.wins, vcur.constructor_name
FROM driverStandings drs
INNER JOIN drivers dri ON dri.driverId = drs.driverId
INNER JOIN v_current_driver_teams vcur ON vcur.driverId = dri.driverId
WHERE drs.raceId = (SELECT MAX(raceId) FROM driverStandings)
GROUP BY dri.driverId
ORDER BY drs.position;

/* Momentane Team Rangliste */
CREATE OR REPLACE VIEW v_current_constructors_position AS
SELECT cos.position, cos.points, con.name as conname, cos.wins
FROM constructors con
INNER JOIN constructorStandings cos ON cos.constructorId = con.constructorId
WHERE cos.raceId = (SELECT MAX(raceId) FROM constructorStandings)
GROUP BY con.constructorID
ORDER BY cos.position;

/* == SAISON UNTERSEITE ==  */
/* Auflistung aller Saisons mit Weltmeistern */
CREATE OR REPLACE VIEW v_seasons_with_world_champions AS
SELECT last_race_of_year, year, dri.forename, dri.surname, drs.points AS drspoints, con.name, cos.points AS cospoints, dri.driverId
        FROM (SELECT races.year AS year, max(races.raceid) AS last_race_of_year FROM races GROUP BY year ORDER BY year DESC) sub
        INNER JOIN driverStandings drs ON drs.raceid = last_race_of_year
        INNER JOIN drivers dri ON drs.driverId = dri.driverId
        LEFT JOIN constructorstandings cos ON cos.raceid = last_race_of_year
        LEFT JOIN constructors con ON cos.constructorId = con.constructorId
        WHERE drs.position = 1
        AND (cos.position = 1 OR cos.position IS NULL)
        GROUP BY year
        ORDER BY year DESC;

/* Indexe für schnelleres Laden der Rennen */
ALTER TABLE `races` ADD INDEX (`year`,`round`);
ALTER TABLE `results` ADD INDEX (`position`,`raceId`);
ALTER TABLE `results` ADD INDEX (`grid`,`raceId`);