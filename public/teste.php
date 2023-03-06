<?php

$json = array(
	[
		'title'           => 'All Day Event',
		'start'           => '2022-12-01',
		'end'             => '2022-12-03',
		'backgroundColor' => '#ff0000',
		'borderColor'     => '#ff0000',
	],
	[
		'title' => 'teste',
		'start' => '2023-01-02',
	],
	[
		'title' => 'All Day Event',
		'start' => '2022-12-01',
	],
	[
		'title' => 'Long Event',
		'start' => '2022-12-07',
		'end'   => '2022-12-10',
	],
	[
		'groupId' => 999,
		'title'   => 'Repeating Event',
		'start'   => '2022-12-09T16:00:00',
	],
	[
		'groupId' => 999,
		'title'   => 'Repeating Event',
		'start'   => '2022-12-16T16:00:00',
	],
	[
		'title' => 'Conference',
		'start' => '2022-12-11',
		'end'   => '2022-12-13',
	],
	[
		'title' => 'Meeting',
		'start' => '2022-12-12T10:30:00',
		'end'   => '2022-12-12T12:30:00',
	],
	[
		'title' => 'Lunch',
		'start' => '2022-12-12T12:00:00',
	],
	[
		'title' => 'Meeting',
		'start' => '2022-12-12T14:30:00',
	],
	[
		'title' => 'Happy Hour',
		'start' => '2022-12-12T17:30:00',
	],
	[
		'title' => 'Dinner',
		'start' => '2022-12-12T20:00:00',
	],
	[
		'title' => 'Birthday Party',
		'start' => '2022-12-13T07:00:00',
	],
	[
		'title' => 'Click for Google',
		'url'   => 'http://google.com/',
		'start' => '2022-12-28',
	],
);

echo json_encode($json);
