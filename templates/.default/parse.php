<?php
$iteration = $arResult['ITERATION'];

CAdminMessage::ShowMessage(array(
    "MESSAGE" => "Обработка файла",
    "DETAILS" => "Шаг №{$step}",
    "TYPE" => "OK"
));
?>
    <input type="hidden" name="ACTION" value="PARSE"/>
    <input type="hidden" name="FILE_ID" value="<?= $arResult['FILE_ID']?>"/>
    <input type="hidden" name="ITERATION" value="<?= $iteration?>"/>

    <script>
        setTimeout(function () {
            $('#parser-form').find('[type="submit"]').trigger("click");
        }, 1000);
    </script>
<?php
