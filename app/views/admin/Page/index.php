<div class="card">
    <div class="card-header">
        <a href="<?=ADMIN.'/page/add'?>" class="btn btndefault btn-flat">
            <i class="fas fa-plus">Добавить страницу</i>
        </a>
    </div>
    <div class="card-body">
        <?php if (!empty($pages)): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Наименование</th>
                            <td width="50"><i class="fas fa-pencil-alt"></i></td>
                            <td width="50"><i class="far fa-trash-alt"></i></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pages as $page):?>
                            <tr>
                                <td><?=$page['id']?></td>
                                <td><?=$page['title']?></td>
                                <td width="50">
                                    <a 
                                      href="<?=ADMIN.'/page/edit?id='.$page['id']?>" 
                                      class="btn btn-info btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                                <td width="50">
                                    <a 
                                      href="<?=ADMIN.'/page/delete?id='.$page['id'].'&cache=true'?>" 
                                      class="btn btn-danger btn-sm delete">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <?=count($pages).' страниц(а) из '.$total?>
                    </p>
                    <?php if ($pagination->countPages > 1):?>
                        <?=$pagination?>
                    <?php endif?>
                </div>
            </div>
        <?php else:?>
            <p>Страниц не найдено...</p>
        <?php endif?>
    </div>
</div>