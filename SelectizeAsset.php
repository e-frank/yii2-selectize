<?
namespace x1\selectize;

class SelectizeAsset extends \yii\web\AssetBundle
{
	public $sourcePath = '@vendor/bower/selectize/dist';
	
	public $js         = [
		'js/standalone/selectize.js' => 'js/standalone/selectize.min.js',
	];

	public $css        = [
		'css/selectize.css',
		'css/selectize.default.css',
	];

	public $depends = [
		'yii\web\JqueryAsset'
	];
}
?>