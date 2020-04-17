# yii2-widgets

######Installation

```
composer require ahmadasjad/yii2-widgets
```

#####Usage Example

```php
<?php
echo \ahmadasjad\yii2Widgets\PlusMinusInput::widget([
    'name' => 'name_test',
    'plugin_options' => ['parser'=>'parseFloat', 'step'=>0.5]
]);
?>
```

**Options to customize the plugin in `plugin_options` param:**

```php
[
    'val_min' => 0,
    'val_max' => 1000,
    'step' => 1,
    'parser' => 'parseInt',
    'container' => ['class' => 'input-group', 'id' => 'your-custom-id-container'],
    'plus' => ['id' => 'your-custom-id-plus', 'class' => 'btn btn-success', 'label' => '+',],
    'minus' => ['id' => 'your-custom-id-minus', 'class' => 'btn btn-danger', 'label' => '-',],
]
```

`val_min` Minimum value allowed for input

`val_max` Maximum value allowed for input

`step` How much value to be increased/decreased on press of plus/minus button

`parser` Javascript function to parse the input data. For example `parseInt`, `parseFloat`, etc.

`plus` configuration for plus button
`minus` configuration for plus button
