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
<h1>Rightfont 5 Icon Set Generator for FontAwesome 5 Pro</h1>
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
		'brands' => 'fa-brands-400.ttf',
		'duotone' => 'fa-duotone-900.ttf',
		'light' => 'fa-light-300.ttf',
		'regular' => 'fa-regular-400.ttf',
		'solid' => 'fa-solid-900.ttf',
	];

	foreach ($files as $type => $file) {

		$label = ucfirst($type);
		$out = [
			"location" => "Font Awesome 5 Pro/".$file,
			"style" => $label,
			"weight" => 0,
			"familyGroup" => "Font Awesome 5 Pro ".$label,
			"postscriptName" => "FontAwesome5Pro-".$label,
			"isRegularStyle" => 0,
			"modified" => microtime(true),
			"modifiedBy" => "",
			"kind" => "RFFont",
			"uuid" => "FontAwesome5Pro-".$label,
			"category" => 9,
			"version" => "330.498 (Font Awesome version: 5.11.2)",
			"name" => "FontAwesome5Pro-".$label,
			"fileName" => $file,
			"createdBy" => "",
			"vendorURL" => "https://fontawesome.com",
			"starred" => 0,
			"isItalicStyle" => 0,
			"family" => "Font Awesome 5 Pro",
			"encodingValue" => 0,
			"format" => 3,
			"popularity" => 0,
			"width" => 0,
			"notes" => "The web's most popular icon set and toolkit.",
			"copyright" => "Copyright (c) Font Awesome",
			"fullName" => "Font Awesome 5 Pro ".$label,
			"created" => microtime(true)
		];
		$excluded = ['f4e6'];
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
			$value['index'] = $index + 3;
			unset($value);
		}
		$out['glyphs'] = $glyphs;
		$data = json_encode($out,JSON_PRETTY_PRINT);

		$fileName = 'FontAwesome5Pro-'.$label.'.rightfontmetadata';
		echo "exporting file: ".$fileName."\n";

		$f3->write($fileName,$data);
	}
	echo "DONE."."\n";
	echo "Copy the ´.rightfontmetadata´ files to your RightFont library at:"."\n"."\n"
		." ~/RightFont/Icon Fonts.rightfontlibrary/metadata/fonts/"."\n"."\n";
	echo "And copy the ´fa-*.ttf´ files as well to:"."\n"."\n"
		." ~/RightFont/Icon Fonts.rightfontlibrary/fonts/Font Awesome 5 Pro/"."\n"."\n";

});


$f3->run();
