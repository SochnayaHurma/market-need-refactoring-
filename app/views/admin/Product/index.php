<div class="card">
    <div class="card-header">
        <a class="btn btn-default btn-flat" href="<?=ADMIN?>/product/add">
            <i class="fas fa-plus"></i>
            Добавить товар
        </a>
    </div>

    <div class="card-body">
        <?php if (!empty($products)):?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Фото</th>
                            <th>Наименование</th>
                            <th>Цена</th>
                            <th>Статус</th>
                            <th>Цифровой товар</th>
                            <th width="50"><i class="fas fa-pencil-alt"></i></th>
                            <th width="50"><i class="fas fa-trash-alt"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $product):?>
                            <tr>
                                <td><?=$product['id']?></td>
                                <td>
                                    <img src="<?=PATH?>/<?=$product['img']?>" height="40">
                                </td>
                                <td><?=$product['title']?></td>
                                <td><?=$product['price']?></td>
                                <td>
                                    <?php if ($product['status']):?>
                                        <i class="far fa-eye"></i>
                                    <?php else:?>
                                        <i class="far fa-eye-slash"></i>
                                    <?php endif?>
                                </td>
                                <td><?=$product['is_download'] ? 'Цифровой товар' : 'Обычный товар'?></td>
                                <td width="50">
                                    <a href="<?=ADMIN.'/product/edit?id='.$product['id']?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                                <td width="50">
                                    <a href="<?=ADMIN.'/product/delete?id='.$product['id']?>" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p><?=count($products) ?> товар(ов) из: <?=$count_products?></p>
                    <?php if ($pagination->countPages > 1):?>
                        <?=$pagination?>
                    <?php endif?>
                </div>
            </div>
        <?php else:?>
            <p>Товаров не найдено...</p>
        <?php endif?>
    </div>
</div>