<div class="dropdown d-inline-block">
    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
        <img src="<?=PATH?>/assets/img/lang/<?= $this->language['code']?>.png" alt="">
    </a>
    <ul class="dropdown-menu" id="languages">
        <?php foreach ($this->languages as $key => $value):?>
            <?php if ($this->language['code'] == $key) continue; ?>
                <li>
                    <button class="dropdown-item" data-langcode="<?= $key;?>">
                        <img src="<?=PATH?>/assets/img/lang/<?= $key;?>.png" alt="">
                        <?= $value['title'];?></button>
                </li>
            <?php endforeach;?>
    </ul>
</div>