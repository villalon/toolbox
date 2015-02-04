<?php
//Procedure actualizado el 19/enero/2012
//Debe estar en toolbox/db/procedure.php

global $CFG;
$prefix = $CFG->prefix;



$sqlCreate="
CREATE PROCEDURE getCursosScore()
BEGIN
	CREATE TABLE IF NOT EXISTS ".$prefix."local_uai_toolbox_score(
	id_score INT AUTO_INCREMENT NOT NULL,
	id_facultad INT NOT NULL,
	id_curso INT NOT NULL,
	id_tool ENUM('Foro','Cuestionario','Calificacion') NOT NULL,
	id_profesor INT NOT NULL,
	Puntaje INT NOT NULL,
	PRIMARY KEY(id_score))
	ENGINE = InnoDB;
	
	TRUNCATE TABLE ".$prefix."local_uai_toolbox_score;
	

	INSERT INTO ".$prefix."local_uai_toolbox_score(id_curso, Puntaje, id_tool, id_facultad, id_profesor) SELECT cid,

    case
        when avg(participacion) > 0.8 then 3
        when avg(participacion) > 0.5 then 2
        when avg(participacion) > 0 then 1
        when sum(cuestionarios) > 0 then 1
        else 0
    end as indice,
    'Cuestionario' as indicador,
	id_facultad,
	id_profesor
    from (
SELECT co.category as id_facultad, ra.userid as id_profesor, co.id as cid, q.id, count(distinct a.userid)/count(*) as participacion, count(distinct q.id) as cuestionarios
FROM ".$prefix."course as co
#inner join ".$prefix."course_categories as cc on (co.category = cc.id and (cc.id = 281 or cc.path like '%/281' or cc.path like '%/281/%'))
INNER JOIN ".$prefix."context as cnt ON (co.id = cnt.instanceid)
INNER JOIN ".$prefix."role_assignments as ra ON (cnt.id = ra.contextid AND ra.roleid IN ('3'))
inner join ".$prefix."context as c on (c.instanceid = co.id)
INNER JOIN ".$prefix."role_assignments as raalum ON (c.contextlevel=50 and c.id = raalum.contextid and raalum.roleid=5)
left join ".$prefix."quiz as q on (q.course=c.instanceid)
left join ".$prefix."quiz_attempts as a on (q.id = a.quiz and a.userid = raalum.userid and a.attempt=1)
group by co.id, ra.userid, q.id) as t
group by cid, id_profesor

union all

select cid,
    case
        when avg(participacion) > 0.8 then 3
        when avg(participacion) > 0.5 then 2
        when avg(participacion) > 0 then 1
        when sum(foros) > 0 then 1
        else 0
    end as indice,
    'Foro' as indicador,
	id_facultad,
	id_profesor
    from (
SELECT co.category as id_facultad, ra.userid as id_profesor, co.id as cid, fd.id, count(distinct fp.userid)/st.students as participacion, count(distinct fd.id) as foros, students
FROM ".$prefix."course as co
#inner join ".$prefix."course_categories as cc on ((cc.id = 281 or cc.path like '%/281' or cc.path like '%/281/%') and co.category = cc.id)
INNER JOIN ".$prefix."context as cnt ON (co.id = cnt.instanceid)
INNER JOIN (SELECT count(*) as students, courseid
       FROM ".$prefix."user u
       JOIN ".$prefix."user_enrolments ue ON (ue.userid = u.id  AND ue.enrolid)
       JOIN ".$prefix."enrol e ON (e.id = ue.enrolid)
       GROUP BY courseid) as st ON (co.id = st.courseid)
INNER JOIN ".$prefix."role_assignments as ra ON (cnt.id = ra.contextid AND ra.roleid IN ('3'))
left join ".$prefix."forum as f on (f.course = co.id)
left join ".$prefix."forum_discussions as fd on (fd.course = co.id and fd.forum = f.id)
left join ".$prefix."forum_posts as fp on (fp.discussion = fd.id)
group by co.id, ra.userid, fd.id) as t
group by cid, id_profesor

union all

select cid,
    case
        when avg(participacion) > 0.8 then 3
        when avg(participacion) > 0.5 then 2
        when avg(participacion) > 0 then 1
        when sum(notas) > 0 then 1
        else 0
    end as indice,
    'Calificacion' as indicador,
	id_facultad,
	id_profesor
    from (
SELECT co.category as id_facultad, ra.userid as id_profesor, co.id as cid, gi.id, count(distinct gg.userid)/count(*) as participacion, count(distinct gi.id) as notas
FROM ".$prefix."course as co
#inner join ".$prefix."course_categories as cc on (AND (cc.id = 281 or cc.path like '%/281' or cc.path like '%/281/%') and co.category = cc.id)
INNER JOIN ".$prefix."context as cnt ON (co.id = cnt.instanceid)
INNER JOIN ".$prefix."role_assignments as ra ON (cnt.id = ra.contextid AND ra.roleid IN ('3'))
left join ".$prefix."grade_items as gi on (gi.courseid = co.id)
left join ".$prefix."grade_grades as gg on (gg.itemid = gi.id)
group by co.id, ra.userid, gi.id) as t
group by cid, id_profesor;

END;";

?>