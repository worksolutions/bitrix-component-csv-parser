<?php

/** @var Exception $exception */
/** @var array $arResult */
$exception = $arResult['EXCEPTION'];

CAdminMessage::ShowMessage($exception->getMessage());

require __DIR__ . "/form.php";
