<?
namespace x1\selectize;

class HandlebarsAsset extends \yii\web\AssetBundle
{
	public $sourcePath = '@vendor/bower/handlebars';
	
	public $js         = [
		'handlebars.js' => 'handlebars.min.js',
	];

	public $css        = [
	];

	public $depends = [
	];
}
?>