<?php

require_once('vendor/autoload.php');

/** @var \Base $f3 */
$f3 = \Base::instance();

$f3->set('AUTOLOAD', 'app/');

$f3->route('GET /',function($f3){
	$html = <<<'HTML'
<html>
<head>
<title>Rightfont ICON Set Generator for Font Awesome Pro</title>
</head>
<body>
<h1>Rightfont 6 Icon Set Generator for FontAwesome 6 Pro</h1>
<p>From your console run: <br><br><code>php index.php generate</code></p>
</body>
</html>

HTML;
	echo $html;
});

$f3->route('GET /generate [cli]',function( Base $f3, $params) {

	while (@ob_end_flush())
		ob_implicit_flush(true);

	$icons_yml = 'icons.yml';

	echo "Parsing $icons_yml..."."\n";

	if (!file_exists($icons_yml)) {
		echo "File not existing. Aborting."."\n";
		$f3->error(500);
	}

	$iconData = Spyc::YAMLLoad($icons_yml);

	echo "Icon schema loaded successfully"."\n";

	$files = [
		'thin' => 'fa-thin-100.ttf',
		'solid' => 'fa-solid-900.ttf',
		'regular' => 'fa-regular-400.ttf',
		'light' => 'fa-light-300.ttf',
		'duotone' => 'fa-duotone-900.ttf',
		'brands' => 'fa-brands-400.ttf',
	];
	$indexStart = [
		'thin' => 1,
		'solid' => 1,
		'regular' => 1,
		'light' => 1,
		'duotone' => 1,
		'brands' => 39,
	];

	foreach ($files as $type => $file) {

		$label = ucfirst($type);
		$out = [
			"location" => "Font Awesome 6 Pro/".$file,
			"style" => $label,
			"weight" => 0,
			"familyGroup" => "Font Awesome 6 Pro ".$label,
			"postscriptName" => "FontAwesome6Pro-".$label,
			"isRegularStyle" => 0,
			"modified" => microtime(true),
			"modifiedBy" => "",
			"kind" => "RFFont",
			"uuid" => "FontAwesome6Pro-".$label,
			"category" => 9,
			"version" => "330.498 (Font Awesome version: 6.1.0)",
			"name" => "FontAwesome6Pro-".$label,
			"fileName" => $file,
			"createdBy" => "",
			"vendorURL" => "https://fontawesome.com",
			"starred" => 0,
			"isItalicStyle" => 0,
			"family" => "Font Awesome 6 Pro",
			"encodingValue" => 0,
			"format" => 3,
			"popularity" => 0,
			"width" => 0,
			"notes" => "The web's most popular icon set and toolkit.",
			"copyright" => "Copyright (c) Font Awesome",
			"fullName" => "Font Awesome 6 Pro ".$label,
			"created" => microtime(true)
		];
		$excluded = ['e2d0'];
		$glyphs = [];
		foreach ($iconData as $name => $config) {
			if (in_array($type,$config['styles']) && !in_array($config['unicode'],$excluded)) {
				$index = hexdec($config['unicode']);
				$glyphs[$index] = [
					'index' => $index,
					'unicode' => $config['unicode'],
					'name' => $config['label']
				];
			}
		}
		sort($glyphs);
		$glyphs = array_values($glyphs);
		foreach ($glyphs as $index => &$value) {
			$value['index'] = $index + $indexStart[$type];
			unset($value);
		}
		$out['glyphs'] = $glyphs;
		$data = json_encode($out,JSON_PRETTY_PRINT);

		$fileName = 'FontAwesome6Pro-'.$label.'.rightfontmetadata';
		echo "exporting file: ".$fileName."\n";

		$f3->write($fileName,$data);
	}
	echo "DONE."."\n";
	echo "Copy the ´.rightfontmetadata´ files to your RightFont library at:"."\n"."\n"
		." ~/RightFont/Icon Fonts.rightfontlibrary/metadata/fonts/"."\n"."\n";
	echo "And copy the ´fa-*.ttf´ files as well to:"."\n"."\n"
		." ~/RightFont/Icon Fonts.rightfontlibrary/fonts/Font Awesome 6 Pro/"."\n"."\n";

});


$f3->run();
