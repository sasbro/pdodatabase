<?php
require ('lib/database.class.php');

$db = new Database('host', 'user', 'pass', 'dbname');

/**
 * -------------------
 * INSERT
 * -------------------
 */
$db->query('INSERT INTO mytable (name, age, gender) VALUES (:bName, :bAge, :bGender)');

$db->bind(':bName', 'Someone');
$db->bind(':bAge', 30);
$db->bind(':bGender', $_POST['gender']);

$db->execute();
$last_insert_id = $db->lastInsertId();

/**
 * -------------------
 * SELECT SINGLE
 * -------------------
 */
$db->query('SELECT * FROM mytable WHERE name = :bName');

$db->bind(':bName', 'Someone');
$row = $db->single();

echo $row['name'];

/**
 * -------------------
 * SELECT MULTIPLE
 * -------------------
 */
$db->query('SELECT * FROM mytable WHERE name = :bName');

$db->bind(':bName', 'Someone');
$row = $db->resultset();
$row_count = $db->rowCount();

foreach ($row as $result) {
    echo $result['name'];
}

/**
 * -------------------
 * UPDATE
 * -------------------
 */
$db->query('UPDATE mytable SET name=:bName, WHERE id=:Id');

$db->bind(':bName', 'Someone');
$db->bind(':bAge', 30);
$db->bind(':bId', $_POST['id']);

$db->execute();

/**
 * -------------------
 * TRANSACTION
 * -------------------
 */
$db->beginTransaction();

$db->query('INSERT INTO mytable (name, age) VALUES (:bName, :bAge)');

$db->bind(':bName', 'Someone');
$db->bind(':bAge', 30);

$db->execute();

$db->bind(':bName', 'Anyone');
$db->bind(':bAge', 25);

$db->execute();
$last_insert_id = $db->lastInsertId();

$db->endTransaction();

/**
 * -------------------
 * BIND ARRAY
 * -------------------
 */
$param_array = array(
    ':title' => 'Some value',
    ':data' => 'Another value'
);

$db->bind_all($param_array);