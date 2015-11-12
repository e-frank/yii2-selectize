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

    public $items        = [];
    public $selection    = null;
    public $prompt       = null;
    public $inputOptions = ['class' => 'selectize'];

    public function run() {
        $this->view->registerJs(sprintf("$('#%1\$s').selectize(%2\$s);", $this->id, Json::encode($this->options)), View::POS_READY);

        $this->inputOptions['id']   = $this->id;
        if (!isset($this->inputOptions['name']))
            $this->inputOptions['name'] = Html::getInputName($this->model, $this->attribute);

        if (false || empty($this->items))
            return Html::input('text', $this->inputOptions['name'], $this->selection, $this->inputOptions);
        else
            return Html::dropDownList($this->inputOptions['name'], $this->selection, $this->items, $this->inputOptions);
    }

    public function init() {
        parent::init();
        SelectizeAsset::register($this->view);
    }

}

?>
