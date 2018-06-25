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

	$jsonFile = file_get_contents(realpath("../config-builder/saved_fields/fields.json"));
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
			}
		};
		$steps[] = $tmpStep;
		$index++;
	}

	$steps[] =  [
		"name" => "Database settings",
		"fields"=> [
			
			array(
				'type' => 'info',
				'value' => 'Trial version cannot be processed further.',
			),

			array(
				'type' => 'info',
				'value' => 'Specify your database settings here. Please note that the database for our software must be created prior to this step. If you have not created one yet, do so now.',
			),
			array(
				'label' => 'Database hostname',
				'name' => 'db_hostname',
				'type' => 'text',
				'default' => 'localhost',
				'validate' => array(
					array('rule' => 'required'), // make it "required"
				),
			),
			array(
				'label' => 'Database username',
				'name' => 'db_username',
				'type' => 'text',
				'default' => '',
				'validate' => array(
					array('rule' => 'required'), // make it "required"
				),
			),
			array(
				'label' => 'Database password',
				'name' => 'db_password',
				'type' => 'text',
				'default' => '',
				'validate' => array(
					array('rule' => 'required'), // make it "required"
				),
			),
			array(
				'label' => 'Database Port',
				'name' => 'db_port',
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
			  'name' => 'databaseSetUP', 
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