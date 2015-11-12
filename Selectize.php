<?
namespace x1\selectize;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Url;


class Selectize extends \yii\widgets\InputWidget {

    public static $autoIdPrefix  = 'selectize';

    public $inputOptions = ['class' => 'selectize'];

    public function run() {
        $this->view->registerJs(sprintf("$('#%1\$s').selectize(%2\$s);", $this->id, Json::encode($this->options)), View::POS_READY);

        $this->inputOptions['id'] = $this->id;   
        return Html::beginTag('div', $this->inputOptions).Html::endTag('div');
    }

    public function init() {
        parent::init();
        SelectivityAsset::register($this->view);
    }

}

?>
