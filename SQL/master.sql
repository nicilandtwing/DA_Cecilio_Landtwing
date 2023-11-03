/* == ALLGEMEIN == */
/* Auflistung aller Saisons mit Weltmeistern */
CREATE OR REPLACE VIEW v_seasons_with_world_champions AS
SELECT last_race_of_year, year,  CONCAT(dri.forename, ' ', dri.surname) AS driver_name, drs.points AS drspoints, con.name as constructor_name,
cos.points AS constructor_points, dri.driverId, con.constructorId, dri.nationality as driver_nationality, con.nationality as
constructor_nationality
FROM (SELECT races.year AS year, max(races.raceid) AS last_race_of_year FROM races GROUP BY year ORDER BY year DESC) sub
INNER JOIN driverStandings drs ON drs.raceid = last_race_of_year
INNER JOIN drivers dri ON drs.driverId = dri.driverId
LEFT JOIN constructorStandings cos ON cos.raceid = last_race_of_year
LEFT JOIN constructors con ON cos.constructorId = con.constructorId
WHERE drs.position = 1
AND (cos.position = 1 OR cos.position IS NULL)
GROUP BY year
ORDER BY year DESC;

/* Auflistung aller Renniege aller Teams*/
CREATE OR REPLACE VIEW v_constructorwinners AS
SELECT con.name AS constructor_name, count(con.constructorId) AS constructor_wins, con.constructorId
FROM races rac
INNER JOIN results res ON rac.raceId = res.raceId
INNER JOIN constructors con ON res.constructorId = con.constructorId
WHERE res.position = 1
GROUP BY con.constructorId
ORDER BY rac.date DESC;

/* Momentane Fahrer-Team Kombination */
CREATE OR REPLACE VIEW v_current_driver_teams AS
SELECT dri.driverid, CONCAT(dri.forename, ' ', dri.surname) AS driver_name, con.name AS constructor_name, con.nationality as constructor_nationality, con.constructorId AS constructor_id
FROM drivers dri
INNER JOIN results res ON dri.driverId = res.driverId
INNER JOIN constructors con ON res.constructorId = con.constructorId
INNER JOIN races rac ON res.raceId = rac.raceId
WHERE rac.year = (SELECT MAX(year) FROM races)
GROUP BY dri.driverId;

/* Alle Rennsieger inklusive Anzahl Siege */
CREATE OR REPLACE VIEW v_all_time_racewinners AS
SELECT CONCAT(dri.forename, ' ', dri.surname) AS driver_name, dri.driverId, count(dri.driverId) AS racewins
FROM races rac
INNER JOIN results res ON rac.raceId = res.raceId
INNER JOIN drivers dri ON res.driverId = dri.driverId
WHERE res.position = 1
GROUP BY dri.driverid
ORDER BY rac.date DESC;

/* View für Fahrer Detail Modale */
CREATE OR REPLACE VIEW v_driver_modal_details AS
SELECT dri.driverid, CONCAT(dri.forename, ' ', dri.surname) AS driver_name, count(vwcd.driverid) as driver_worldchampions, vatrw.racewins,
dri.nationality as driver_nationality
FROM drivers dri
LEFT OUTER JOIN v_seasons_with_world_champions vwcd on dri.driverId = vwcd.driverid
LEFT OUTER JOIN v_all_time_racewinners vatrw on dri.driverId = vatrw.driverId
GROUP BY dri.driverId;

/* View für Team Detail Modale */
CREATE OR REPLACE VIEW v_constructor_modal_details AS
SELECT con.constructorId, con.name AS constructor_name, count(vwcd.constructorId) as constructor_worldchampions, vcw.constructor_wins, con.nationality AS constructor_nationality
FROM constructors con
LEFT OUTER JOIN v_seasons_with_world_champions vwcd on con.constructorId = vwcd.constructorId
LEFT OUTER JOIN v_constructorwinners vcw on con.constructorId = vcw.constructorId
group by con.name;


/* == STARTSEITE == */
/* Name, Strecke und Ortschaft des letzten Rennens */
CREATE OR REPLACE VIEW v_latest_race AS
SELECT rac.name as race_name, rac.year, cir.name as circuit_name, cir.location AS circuit_location
FROM races rac
INNER JOIN circuits cir ON cir.circuitId = rac.circuitId
WHERE rac.raceId = (SELECT MAX(raceId) FROM results);

/* Resultat des letzten Rennens */
CREATE OR REPLACE VIEW v_latest_race_result AS
SELECT rac.name AS race_name, res.position AS position, CONCAT(dri.forename, ' ', dri.surname) AS driver_name,
dri.nationality AS driver_nationality, dri.driverid, vcur.constructor_name, vcur.constructor_id, vcur.constructor_nationality, res.time, sta.status, res.grid
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
SELECT CONCAT(dri.forename, ' ', dri.surname) AS driver_name, drs.position, drs.points, drs.wins, vcur.constructor_id, vcur.constructor_name, vcur.constructor_nationality, dri.nationality AS driver_nationality, dri.driverid
FROM driverStandings drs
INNER JOIN drivers dri ON dri.driverId = drs.driverId
INNER JOIN v_current_driver_teams vcur ON vcur.driverId = dri.driverId
WHERE drs.raceId = (SELECT MAX(raceId) FROM driverStandings)
GROUP BY dri.driverId
ORDER BY drs.position;

/* Momentane Team Rangliste */
CREATE OR REPLACE VIEW v_current_constructors_position AS
SELECT cos.position,con.constructorid, con.name as constructor_name, con.nationality AS constructor_nationality, cos.points, cos.wins
FROM constructors con
INNER JOIN constructorStandings cos ON cos.constructorId = con.constructorId
WHERE cos.raceId = (SELECT MAX(raceId) FROM constructorStandings)
GROUP BY con.constructorID
ORDER BY cos.position;

/* == SAISON UNTERSEITE == */
/* verwenden der bereits vorhandenen "v_seasons_with_world_champions" */


/* Indexe für schnelleres Laden der Rennen */
ALTER TABLE `races` ADD INDEX (`year`,`round`);
ALTER TABLE `results` ADD INDEX (`position`,`raceId`);
ALTER TABLE `results` ADD INDEX (`grid`,`raceId`);

/* == Fahrer UNTERSEITE == */
/*Racewinners from drivers currently driving in F1*/
CREATE OR REPLACE VIEW v_racewinners AS
SELECT  CONCAT(dri.forename, ' ', dri.surname) AS driver_name, dri.driverId, count(vcdt.driverId) AS racewins
FROM races rac
INNER JOIN results res ON rac.raceId = res.raceId
INNER JOIN drivers dri ON res.driverId = dri.driverId
INNER JOIN v_current_driver_teams vcdt ON dri.driverId = vcdt.driverId
WHERE res.position = 1
GROUP BY vcdt.driverId
ORDER BY rac.date DESC;


/* Auflistung aktuelle Fahrer mit Rennsiegen und Weltmeisterschaften*/
CREATE OR REPLACE VIEW v_current_driver_teams_wins AS
SELECT dri.driverid,  CONCAT(dri.forename, ' ', dri.surname) AS driver_name, vcdt.constructor_name AS constructor_name, count(vwcd.driverid) as
driver_worldchampions, vrw.racewins, dri.url, dri.nationality as driver_nationality, vcdt.constructor_nationality
FROM drivers dri
LEFT OUTER JOIN v_seasons_with_world_champions vwcd on dri.driverId = vwcd.driverid
LEFT OUTER JOIN v_racewinners vrw on dri.driverId = vrw.driverId
INNER JOIN v_current_driver_teams vcdt ON dri.driverId = vcdt.driverId
GROUP BY dri.driverId;


/* == Teams UNTERSEITE == */
/* Auflistung der aktuellen Konstruktoren */
CREATE OR REPLACE VIEW v_current_teams AS
SELECT con.name AS constructor_name, con.constructorid
FROM constructors con
INNER JOIN results res ON con.constructorId = res.constructorId
INNER JOIN races rac ON res.raceId = rac.raceId
WHERE rac.year = (SELECT MAX(year) FROM races)
GROUP BY con.constructorId;

/* Auflistung aktuelle Konstruktoren mit Rennsiegen und Weltmeisterschaften*/
CREATE OR REPLACE VIEW v_current_teams_wins AS
SELECT con.name, count(vwcd.constructorId) as constructor_worldchampions, vcw.constructor_wins AS constructor_wins, con.nationality AS constructor_nationality, con.url
FROM constructors con
LEFT OUTER JOIN v_seasons_with_world_champions vwcd on con.constructorId = vwcd.constructorId
LEFT OUTER JOIN v_constructorwinners vcw on con.constructorId = vcw.constructorId
INNER JOIN v_current_teams vct on con.constructorId = vct.constructorId
group by con.name;