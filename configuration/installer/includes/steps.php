<?php

function makeSteps(){

	$filedsNames = [
		"checkbox-group"=>"checkbox",
		"paragraph"=>"info",
		"header"=>"header",
		"select"=>"select",
		"text"=>"text",
		"textarea"=>"textarea",
	];

	//echo(realpath("../API/saved_fields/fields.json"));
	//die();
	
	$jsonFile = file_get_contents(realpath("../API/saved_fields/fields.json"));
	$fields = json_decode($jsonFile, true);
	$steps = [];
	$index = 1;

	foreach ($fields['steps'] as $key => $step) {
		$tmpStep = [
			"name"=>"Step" . $index,
			"fields"=>[],
			"callbacks"=>[
				[
					'name'=>'stepCallBack',
					'execute'=>'after',
					'params'=> [
						'stepIndex'=>$key,
					],
				]
			],
		];

		foreach ($step as $ValueKey => $field) {
			$tmpField = [];
			$tmpField['type'] = $filedsNames[$field['type']];
			$tmpField['label'] = $field['label'];
			$tmpField['validate'] = array(
				array('rule' => 'required')
			);
			$tmpField['name'] = isset($field['name'])?$field['name']:$tmpField['type']."_".$index;
			if( $field['type'] == 'text' ){
				//text field processinh
				//$tmpField['default'] = isset($field['value'])?$field['value']:'';

				$tmpStep["fields"][] = $tmpField;
			}else if( $field['type'] == 'header' ){
				//header field processing
				$tmpStep["name"] = $field["label"];
			}else if( $field['type'] == 'checkbox-group' ){
				//checkbox-group field processing
				$items = [];
				foreach ($field['values'] as $label => $labelValue) {
					$items[$labelValue['value']] = $labelValue['label'];
				}

				//$tmpField['default'] = isset($field['value'])?$field['value']:'';
				$tmpField['items'] = $items;
				$tmpStep["fields"][] = $tmpField;

			}else if( $field['type'] == 'paragraph' ){
				//paragraph field processing
				$tmpField['value'] = $field['label'];
				$tmpStep["fields"][] = $tmpField;

			}else if( $field['type'] == 'select' ){
				//select field processing
				$items = [];
				foreach ($field['values'] as $label => $labelValue) {
					$items[$labelValue['value']] = $labelValue['label'];
				}
				$tmpField['items'] = $items;
				//$tmpField['default'] = isset($field['value'])?$field['value']:'';
				$tmpStep["fields"][] = $tmpField;

			}else if( $field['type'] == 'textarea' ){
				$tmpStep['callbacks'] = [
					[
						'name'=>'stepCallBack',
						'execute'=>'after',
						'params'=> [
							'stepIndex'=>$key,
							'callBackName' =>$field['name'],
						],
					]
				];
			}else{
				$tmpStep['callbacks'] = [
					[
						'name'=>'stepCallBack',
						'execute'=>'after',
						'params'=> [
							'stepIndex'=>$key
						],
					]
				];
			}
		};
		$steps[] = $tmpStep;
		$index++;
	}

	$steps[] =  [
		"name" => "MySQL Database settings",
		"fields"=> [
			array(
				'type' => 'info',
				'value' => 'Specify your MySQL database settings here. Please note that the database for our software must be created prior to this step. If you have not created one yet, do so now.',
			),
			array(
				'label' => 'Database hostname',
				'name' => 'mysql_db_hostname',
				'type' => 'text',
				'default' => 'localhost',
				'validate' => array(
					array('rule' => 'required'), // make it "required"
				),
			),
			array(
				'label' => 'Database username',
				'name' => 'mysql_db_username',
				'type' => 'text',
				'default' => '',
				'validate' => array(
					array('rule' => 'required'), // make it "required"
				),
			),
			array(
				'label' => 'Database password',
				'name' => 'mysql_db_password',
				'type' => 'text',
				'default' => '',
				'validate' => array(
					array('rule' => 'required'), // make it "required"
				),
			),
			array(
				'label' => 'Database Port',
				'name' => 'mysql_db_port',
				'type' => 'text',
				'default' => '3306',
				'validate' => array(
					array('rule' => 'required'), // make it "required"
					array('rule' => 'numeric'), // make it "required"
				),
			),
		],
		'callbacks' => array( 
			array( 
			  'name' => 'mysqldatabaseSetUP', 
			  'execute' => 'after',
			  'params' => array()
			) 
		) 
	];

	$steps[] =  [
		"name" => "MSSQL Database settings",
		"fields"=> [
			array(
				'type' => 'info',
				'value' => 'Specify your MSSQL database settings here. Please note that the database for our software must be created prior to this step. If you have not created one yet, do so now.',
			),
			array(
				'label' => 'Server Name',
				'name' => 'mssql_db_hostname',
				'type' => 'text',
				'default' => 'localhost',
				'validate' => array(
					array('rule' => 'required'), // make it "required"
				),
			),
			array(
				'label' => 'Database username',
				'name' => 'mssql_db_username',
				'type' => 'text',
				'default' => '',
				'validate' => array(
					array('rule' => 'required'), // make it "required"
				),
			),
			array(
				'label' => 'Database password',
				'name' => 'mssql_db_password',
				'type' => 'text',
				'default' => '',
				// 'validate' => array(
				// 	array('rule' => 'required'), // make it "required"
				// ),
			),
			array(
				'label' => 'Database Port',
				'name' => 'mssql_db_port',
				'type' => 'text',
				'default' => '1433',
				'validate' => array(
					array('rule' => 'required'), // make it "required"
					array('rule' => 'numeric'), // make it "required"
				),
			),
		],
		'callbacks' => array( 
			array( 
			  'name' => 'MSSQLdatabaseSetUP', 
			  'execute' => 'after',
			  'params' => array()
			) 
		) 
	];

	$steps[] =  [
		"name" => "MSSQL Linked Server Details",
		"fields"=> [
			array(
				'type' => 'info',
				'value' => 'Specify your Linked server SP Details.',
			),
			array(
				'label' => 'Server',
				'name' => 'mssql_ls_server',
				'type' => 'text',
				'default' => '',
				'validate' => array(
					array('rule' => 'required') // make it "required"
				),
			),
			array(
				'label' => 'Remote User',
				'name' => 'mssql_ls_rmtuser',
				'type' => 'text',
				'default' => '',
				'validate' => array(
					array('rule' => 'required') // make it "required"
				),
			),
			array(
				'label' => 'Remote Password',
				'name' => 'mssql_ls_rmtpass',
				'type' => 'text',
				'default' => '',
				'validate' => array(
					array('rule' => 'required') // make it "required"
				),
			),
		],
		'callbacks' => array( 
			array( 
			  'name' => 'MSSQLlinkedServerSP', 
			  'execute' => 'after',
			  'params' => array()
			) 
		)
	];

	$steps[] =  [
		"name" => "MySQL Linked Server Details",
		"fields"=> [
			array(
				'type' => 'info',
				'value' => 'Specify your Linked server SP Details.',
			),
			array(
				'label' => 'Server',
				'name' => 'mysql_ls_server',
				'type' => 'text',
				'default' => '',
				'validate' => array(
					array('rule' => 'required'), // make it "required"
				),
			),
			array(
				'label' => 'Remote User',
				'name' => 'mysql_ls_rmtuser',
				'type' => 'text',
				'default' => '',
				'validate' => array(
					array('rule' => 'required'), // make it "required"
				),
			),
			array(
				'label' => 'Remote Password',
				'name' => 'mysql_ls_rmtpass',
				'type' => 'text',
				'default' => '',
				'validate' => array(
					array('rule' => 'required'), // make it "required"
				),
			),
		],
		'callbacks' => array( 
			array( 
			  'name' => 'MySQLlinkedServerSP', 
			  'execute' => 'after',
			  'params' => array()
			) 
		)
	];
	return $steps;
}


// echo (json_encode(makeSteps()));
// die();

$steps = makeSteps();

array_unshift($steps, array(
	// Step name
	'name' => 'Configuration Requirements Checks',

	// Items we're going to display
	'fields' => array(

		// Simple text
		array( 
			'type' => 'info', 
			'value' => 'Please verify that these requirements have been met.', 
		), 
		array( 
			'type' => 'php-config', 
			'label' => 'PHP settings', 
			'items' => array( 
			  'php_version' => array('>=7.0', 'PHP Version'), 
			  'max_execution_time' => ">=1200",
			  'max_input_time' => ">=1200",
			) 
		),
		array( 
			'type' => 'php-modules', 
			'label' => 'PHP modules', 
			'items' => array( 
				'mysqli' => array(true, 'MySQLi'),
				//'pdo_sqlsrv' => array(true, 'PDO MSSQL')
			)
		)
	),
));

$steps[] =	array(
	// Step name
	'name' => 'Completed',

	// Items we're going to display
	'fields' => array(

		// Simple text
		array(
			'type' => 'info',
			'value' => 'Successfully configured.',
		),
		array(
			'type' => 'info',
			'value' => 'Please open the portal "{}".',
		),
	),
);