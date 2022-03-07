<?php
require('config.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');

// read data from postgresql
$query = 'SELECT AVG("Custom SQL Query"."minutes_spent") AS "avg:minutes_spent:ok",
"Custom SQL Query"."name" AS "name",
SUM("Custom SQL Query"."minutes_spent") AS "sum:minutes_spent:ok",
(CAST(DATE_TRUNC(\'DAY\', CAST("Custom SQL Query"."created" AS TIMESTAMP)) AS DATE) - (((7 + CAST(EXTRACT(DOW FROM "Custom SQL Query"."created") AS BIGINT) - 1) % 7) * INTERVAL \'1 DAY\')) AS "twk:created:ok",
"Custom SQL Query"."worker_initials" AS "worker_initials"
FROM (
select id, worker_initials, name, created, minutes_spent
from tasks
where is_active is false
and worker_initials in (select worker_initials from freelancers where is_bot is false and ready_for_receiving_tasks)
--group by 1, 2, 3
--having (count(*) > 4) and avg(minutes_spent) is not null and avg(minutes_spent) > 0
order by 2, 3, 1
) "Custom SQL Query"
INNER JOIN (
SELECT "Custom SQL Query"."name" AS "name"
FROM (
  select id, worker_initials, name, created, minutes_spent
  from tasks
  where is_active is false
  and worker_initials in (select worker_initials from freelancers where is_bot is false and ready_for_receiving_tasks)
  --group by 1, 2, 3
  --having (count(*) > 4) and avg(minutes_spent) is not null and avg(minutes_spent) > 0
  order by 2, 3, 1
) "Custom SQL Query"
GROUP BY 1
HAVING (SUM("Custom SQL Query"."minutes_spent") > 60)
) "t0" ON ("Custom SQL Query"."name" IS NOT DISTINCT FROM "t0"."name")
GROUP BY 2,
4,
5
';
$result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());

// print data
$data = array();
while ($row = pg_fetch_row($result)) {
    $data[] = $row;
}

print_r(json_encode($data));
