<?= \kato\DropZone::widget([
    'options' => [
        'url' => 'index.php?r=branches/upload',
        'maxFilesize' => '2', // 2 mega bites
    ],
    'clientEvents' => [
        'complete' => "function(file){console.log(file)}",
        'removedfile' => "function(file){alert(file.name + ' is removed')}"
    ],
]);

?>