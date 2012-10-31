<?php

$test_data = (object) array(
    array(
    	'id' => 23,
    	'firstname' => 'Sally',
    	'lastname' => 'Mally',
    	'created' => '2011-01-18 11:12:44',
    	'product_sales' => 26.52,
    	'event_sales' => 102.87
    ),
    array(
    	'id' => 57,
    	'firstname' => 'Billy',
    	'lastname' => 'Mister',
    	'created' => '1985-09-12 08:08:53',
    	'product_sales' => 52.00,
    	'event_sales' => 43.98
    ),
    array(
    	'id' => 82,
    	'firstname' => 'Tammy',
    	'lastname' => 'Wilkson',
    	'created' => '1969-06-14 05:09:32',
    	'product_sales' => 72.65,
    	'event_sales' => 5.96
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
			'title' => 'Item',
			'func' => 'item'
		),
		array(
			'func' => 'firstname',
			'dbval' => 'firstname',
			'title' => 'First Name',
			'style' => 'width:140px;',
			'class' => 'column_class',
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
			'title' => 'Date',
			'func' => 'created'
		),
		array(
			'value' => '<img id="{{id}}" src="https://www.google.com/images/srpr/logo3w.png" />'
		),
		array(
			'title' => 'Empty',
			'style' => 'width: 100px;'
		)
	)
));
$table->set_body(array(
	'even_class' => 'odd',
	'odd_class' => 'even',
	'funcs' => array(
		'item' => function() {
			return 'hello';
		},
		'created' => function($table) {
			return date('F j, Y, g:i a', strtotime($table->replace_data('{{created}}')));
		},
		'firstname' => function($table) {
			return '{{firstname}} {{lastname}}'." ".($table->replace_data('{{product_sales}}') + $table->replace_data('{{event_sales}}'));
		}
	)
));

echo $table->generate();

?>