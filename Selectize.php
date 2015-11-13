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
    public $template     = null;
    public $templateId   = null;
    public $ajax         = null;
    public $method       = 'GET';
    public $valueField   = 'id';
    public $labelField   = 'text';
    public $searchField  = 'text';

    public function run() {

        $view = $this->view;




        $templateCode = '';

        if ($this->template !== null || $this->templateId !== null) {
            \x1\handlebars\HandlebarsAsset::register($view);
            if ($this->template !== null) {
                $templateCode = Json::encode($this->template);
            } else if ($this->templateId !== null) {
                $templateCode = sprintf("$('#%s').html()", $this->templateId);
            }

            if (!isset($this->options['render'])) {
                $this->options['render'] = [];
            }

            $this->options['render']['option'] = new JsExpression(sprintf("Handlebars.compile(%s)", $templateCode));
        }

        if ($this->ajax !== null) {
            $this->options['load'] = new JsExpression(sprintf(<<<EOD
function(query, callback) {
    %3\$s
    $.ajax({
        url:      '%1\$s?q=' + encodeURIComponent(query),
        type:     '%2\$s',
        dataType: 'json',
        error:    function() {
            callback();
        },
        success: function(res) {
            callback(res);
        }
    });
}
EOD
, $this->ajax, $this->method, ($this->options['preload'] ? '' : 'if (!query.length) return callback();')));
        }


        $view->registerJs(sprintf("$('#%1\$s').selectize(%2\$s);", $this->id, Json::encode($this->options)), View::POS_READY);

        $this->inputOptions['id']   = $this->id;
        if (!isset($this->inputOptions['name']))
            $this->inputOptions['name'] = Html::getInputName($this->model, $this->attribute);

        $options                       = [];
        $this->inputOptions['options'] = [];
        foreach ($this->items as $value) {
            $options[$value[$this->options['valueField']]]                       = $value[$this->options['labelField']];
            $this->inputOptions['options'][$value[$this->options['valueField']]] = ['data-data' => Json::encode($value)];
        }

        return Html::dropDownList($this->inputOptions['name'], $this->selection, $options, $this->inputOptions);

        if (false && empty($this->items))
            return Html::input('text', $this->inputOptions['name'], $this->selection, $this->inputOptions);
    }

    public function init() {
        parent::init();

        if (!isset($this->options['valueField']))
            $this->options['valueField'] = $this->valueField;
        if (!isset($this->options['labelField']))
            $this->options['labelField'] = $this->labelField;
        if (!isset($this->options['searchField']))
            $this->options['searchField'] = $this->searchField;

        // load field's value, if no default data is set
        if (!isset($this->options['items']) && $this->items == null) {
            $value = $this->model->{$this->attribute};
            if ($value !== null)
                $this->options['items'] = $value;
        }

        $this->options['preload'] = ArrayHelper::getValue($this->options, 'preload', empty($this->items));;

        SelectizeAsset::register($this->view);
    }

}

?>
