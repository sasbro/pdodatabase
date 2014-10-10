PHP - Class PDO Database
------------------------

> #### Setup the Class

```php

	require_once 'lib/database.class.php';  
	$db = new Database('host', 'user', 'password', 'database_name');
```

#### Content
* [PDO -> Insert](https://github.com/sasbro/pdodatabase#insert "jump!")
* [PDO -> Select (Single)](https://github.com/sasbro/pdodatabase#select-single "jump!")
* [PDO -> Select (Multiple)](https://github.com/sasbro/pdodatabase#select-multiple "jump!")
* [PDO -> Update](https://github.com/sasbro/pdodatabase#update "jump!")
* [PDO -> Transaction](https://github.com/sasbro/pdodatabase#transaction "jump!")
* [PDO -> Bind Array](https://github.com/sasbro/pdodatabase#bind-array "jump!")

Usage
-----
> ####Insert

```php

	$db->query('INSERT INTO mytable 
					(name, 
					 age, 
					 gender) 
				VALUES 
					(:bName, 
					 :bAge, 
					 :bGender)');

	$db->bind(':bName', 'Someone');
	$db->bind(':bAge', 30);
	$db->bind(':bGender', $_POST['gender']);
	
	$db->execute();
	$last_insert_id = $db->lastInsertId();
```

> ####Select (Single)

```php

	$db->query('SELECT * FROM mytable 
				WHERE 
					name = :bName');

	$db->bind(':bName', 'Someone');
	$row = $db->single();
	
	echo $row['name'];
```

> ####Select (Multiple)

```php

	$db->query('SELECT * FROM mytable 
				WHERE 
					name = :bName');

	$db->bind(':bName', 'Someone');
	$row = $db->resultset();
	$row_count = $db->rowCount();
	
	foreach ($row as $result) {
	    echo $result['name'];
	}
```

> ####Update

```php

	$db->query('UPDATE mytable SET 
	            	name=:bName, 
	                age=:bAge, 
	            WHERE
	                id=:bId');
	
	$db->bind(':bName', 'Someone');
	$db->bind(':bAge', 30);
	$db->bind(':bId', $_POST['id']);
	
	$db->execute();
```

> ####Transaction

```php

	$db->beginTransaction();
	
	$db->query('INSERT INTO mytable 
					(name, age) 
				VALUES 
					(:bName, :bAge)');
	
	$db->bind(':bName', 'Someone');
	$db->bind(':bAge', 30);
	
	$db->execute();
	
	$db->bind(':bName', 'Anyone');
	$db->bind(':bAge', 25);
	
	$db->execute();
	$last_insert_id = $db->lastInsertId();
	
	$db->endTransaction();
```

> ####Bind Array()

```php

	$param_array = array(
	    ':title' => 'Some value',
	    ':data' => 'Another value'
	);
	
	$db->bind_all($param_array);
```

* Inspired by an Article from Philip Brown (2012)


