<?php

$test_data = (object) array(
    array(
    	'id' => 23,
    	'firstname' => 'Sally',
    	'lastname' => 'Mally',
    	'created' => '2011-01-18 11:12:44'
    ),
    array(
    	'id' => 57,
    	'firstname' => 'Billy',
    	'lastname' => 'Mister',
    	'created' => '1985-09-12 08:08:53'
    ),
    array(
    	'id' => 82,
    	'firstname' => 'Tammy',
    	'lastname' => 'Wilkson',
    	'created' => '1969-06-14 05:09:32'
    )
);

include_once('hyper_table.php');

$table = new hyper_table();
$table->set_info($test_data);
$table->set_table(array(
    'id' => 'table_id',
    'class' => 'table_class',
    'style' => '',
    'border' => '5',
    'padding' => '10',
    'spacing' => '1'
));
$table->set_header(array(
	'columns' => array(
		array(
			'title' => ''
		),
		array(
			'dbval' => 'firstname',
			'title' => 'First Name',
			'style' => 'width:140px;',
			'atag' => array(
				'href' => 'http://www.hello.com',
				'title' => 'title firstname',
				'class' => 'a_firstname'
			)
		),
        array(
        	'dbval' => 'lastname',
			'title' => 'Last Name',
			'class' => 'last_class',
			'style' => 'width:180px;'
		),
		array(
			'dbval' => 'created',
			'title' => 'Date'
		),
		array(
			'title' => 'buttons',
			'value' => '<img id="{{firstname}}" src="https://www.google.com/images/srpr/logo3w.png" />'
		),
		array(
			'style' => 'width: 100px;'
		)
	)
));
$table->set_body(array(
	'even_class' => 'odd',
	'odd_class' => 'even',
	'funcs' => array(
		'created' => function($date) {
			return date('F j, Y, g:i a', strtotime($date));
		},
		'firstname' => function($firstname) {
			return $firstname.' {{lastname}}';
		}
	)
));

echo $table->generate();

?>