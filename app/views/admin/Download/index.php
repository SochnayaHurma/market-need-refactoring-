<div class="card">
    <div class="card-header">
        <a href="<?=ADMIN.'/download/add'?>" class="btn btn-default btn-flat">
            <i class="fas fa-plus"></i>
        </a>
    </div>

    <div class="card-body">
        <?php if (!empty($downloads)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Наименование</th>
                        <th>Оригинальное имя</th>
                        <th width="50"><i class="far fa-trash-alt"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($downloads as $download):?>
                        <tr>
                            <td><?=$download['name']?></td>
                            <td><?=$download['original_name']?></td>
                            <td width="50">
                                <a 
                                    href="<?=ADMIN.'/download/delete?id='.$download['id']?>" 
                                    class="btn btn-danger btn-sm delete">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12">
                    <p><?= count($downloads) . 'файл(ов) из: '. $total ?></p>
                    <?php if ($pagination->countPages > 1):?>
                        <?=$pagination?>
                    <?php endif?>
                </div>
            </div>
        <?php else:?>
            <p>Файлов для загрузки не найдено...</p>
        <?php endif?>
    </div>
</div>