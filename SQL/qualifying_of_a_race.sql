SELECT CONCAT(dri.forename, ' ', dri.surname) AS Driver, con.name AS Constructor, qua.q3 AS Q3 from qualifying qua
inner join races rac on qua.raceid = rac.raceid
inner join drivers dri ON dri.driverid = qua.driverid
inner join constructors con on con.constructorId = qua.constructorId
where (rac.raceid = 1020) AND (qua.q3 <> '');

SELECT CONCAT(dri.forename, ' ', dri.surname) AS Driver, con.name AS Constructor, qua.q2 AS Q2 from qualifying qua
inner join races rac on qua.raceid = rac.raceid
inner join drivers dri ON dri.driverid = qua.driverid
inner join constructors con on con.constructorId = qua.constructorId
where (rac.raceid = 1020) AND (qua.q2 <> '');


SELECT CONCAT(dri.forename, ' ', dri.surname) AS Driver, con.name AS Constructor, qua.q1 AS Q1 from qualifying qua
inner join races rac on qua.raceid = rac.raceid
inner join drivers dri ON dri.driverid = qua.driverid
inner join constructors con on con.constructorId = qua.constructorId
where (rac.raceid = 1020) AND (qua.q1 <> '');
