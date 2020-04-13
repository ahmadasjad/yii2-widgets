<?php


namespace ahmadasjad\yii2Widgets;


use yii\bootstrap\BootstrapAsset as BootstrapAssetV3;
use yii\bootstrap4\BootstrapAsset as BootstrapAssetV4;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\InputWidget;

class PlusMinusInput extends InputWidget
{
    public $plugin_options = [];

    public $value = 0;

    public $bs_version = 3;

    public function init()
    {
        parent::init();
        $this->options = ArrayHelper::merge(['class' => 'form-control'], $this->options);
        $id = $this->getId();
        $default_plugin_options = [
            'val_min' => 0,
            'val_max' => 1000,
            'step' => 1,
            'parser' => 'parseInt',
            'container' => ['class' => 'input-group', 'id' => $id . '-container'],
            'plus' => ['id' => $id . '-plus', 'class' => 'btn btn-success', 'label' => '+',],
            'minus' => ['id' => $id . '-minus', 'class' => 'btn btn-danger', 'label' => '-',],
        ];
        $this->plugin_options = ArrayHelper::merge($default_plugin_options, $this->plugin_options);
        $this->plugin_options['minus']['data-step'] = -$this->plugin_options['step'];
        $this->plugin_options['plus']['data-step'] = $this->plugin_options['step'];
    }

    public function run()
    {
        $this->registerClientScript();
        return $this->renderInputHtml('text');
    }

    protected function renderInputHtml($type)
    {
        $out = Html::beginTag('div', $this->plugin_options['container']);
        $out .= $this->renderMinus($this->plugin_options['minus']);
        $out .= parent::renderInputHtml('text');
        $out .= $this->renderPlus($this->plugin_options['plus']);
        $out .= Html::endTag('div');
        return $out;
    }

    protected function renderPlus($options)
    {
        $out = Html::beginTag('span', ['class' => 'input-group-btn']);
        $label = $options['label'];
        unset($options['label']);
        $out .= Html::button($label, $options);
        $out .= Html::endTag('span');
        return $out;
    }

    protected function renderMinus($options)
    {
        $out = Html::beginTag('span', ['class' => 'input-group-btn']);
        $label = $options['label'];
        unset($options['label']);
        $out .= Html::button($label, $options);
        $out .= Html::endTag('span');
        return $out;
    }

    public function registerClientScript()
    {
        $id = $this->getId();
        $minus_id = $this->plugin_options['minus']['id'];
        $plus_id = $this->plugin_options['plus']['id'];
        $parser = $this->plugin_options['parser'];
        $js = <<< JSCRIPT
        jQuery('#{$plus_id}, #{$minus_id}').click(function(){
            var cur_val = {$parser}(jQuery('#{$id}').val());
            if(isNaN(cur_val)){
                cur_val = 0;
            }
            cur_val += {$parser}(jQuery(this).attr('data-step'));
            if(cur_val < {$this->plugin_options['val_min']}){
                cur_val = {$this->plugin_options['val_min']}
            }
            if(cur_val > {$this->plugin_options['val_max']}){
                cur_val = {$this->plugin_options['val_max']}
            }
            jQuery('#{$id}').val(cur_val);
        });
JSCRIPT;
        $view = $this->getView();
        JqueryAsset::register($view);
        if($this->bs_version >= 3 && $this->bs_version < 4){
            BootstrapAssetV3::register($view);
        }elseif ($this->bs_version >= 4){
            BootstrapAssetV4::register($view);
        }
        $view->registerJs($js);
    }

}
