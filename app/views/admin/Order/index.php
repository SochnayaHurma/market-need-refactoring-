<div class="card">
    <div class="card-body">
        <?php if (!empty($orders)):?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID заказа</th>
                            <th>Статус</th>
                            <th>Создан</th>
                            <th>Изменен</th>
                            <th>Сумма</th>
                            <th width="50"><i class="fas fa-pencil-alt"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order):?>
                            <tr <?= $order['status'] ? 'class="table-info"' : ''?>>
                                <td><?=$order['id']?></td>
                                <td><?=$order['status'] ? 'Завершен' : 'Новый' ?></td>
                                <td><?=$order['created_at']?></td>
                                <td><?=$order['updated_at']?></td>
                                <td><?=$order['total']?></td>
                                <td width="50">
                                    <a 
                                      href="<?=ADMIN.'/order/edit?id='.$order['id']?>"
                                      class="btn btn-info btn-sm">
                                      <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p><?=count($orders).' заказ(ов) из: '.$total?></p>
                    <?php if ($pagination->countPages > 1 ):?>
                        <?=$pagination?>
                    <?php endif?>
                </div>
            </div>
        <?php else:?>
            <p> Заказов не найдено...</p>
        <?php endif?>
    </div>
</div>