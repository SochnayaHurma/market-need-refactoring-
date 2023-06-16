<?php 
if (!empty($names)):
    foreach ($names as $name):
?>
<?= "<h1>$name->id -- $name->name</h1>" ?>
<?php
    endforeach;
endif;

echo $this->getDbLogs();
?>