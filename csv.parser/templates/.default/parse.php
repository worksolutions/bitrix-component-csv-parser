<?php
$step = $arResult['STEP'];

CAdminMessage::ShowMessage(array(
    "MESSAGE" => "��������� �����",
    "DETAILS" => "��� �{$step}",
    "TYPE" => "OK"
));
?>
    <input type="hidden" name="ACTION" value="PARSE"/>
    <input type="hidden" name="FILE_ID" value="<?= $arResult['FILE_ID']?>"/>
    <input type="hidden" name="STEP" value="<?= $step?>"/>

    <script>
        setTimeout(function () {
            $('#parser-form').find('[type="submit"]').trigger("click");
        }, 1000);
    </script>
<?php
