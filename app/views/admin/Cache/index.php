<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Описание</th>
                    <th width="50"><i class="far fa-trash-alt"></i></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Кэш категорий
                    </td>
                    <td>Меню категорий на сайте. Кэшгируется на 1 час.</td>
                    <td width="50">
                        <a 
                          href="<?=ADMIN.'/cache/delete?cache=category'?>" 
                          class="btn btn-danger btn-sm delete">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Кэш страниц</td>
                    <td>Меню страниц в футере. Кэшируется на 1 час.</td>
                    <td width="50">
                        <a 
                          href="<?=ADMIN.'/cache/delete?cache=page'?>" 
                          class="btn btn-danger btn-sm delete">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Кэш слайдера</td>
                    <td>Изображения слайдера. Кэшируется на 1 неделю.</td>
                    <td width="50">
                        <a 
                          href="<?=ADMIN.'/cache/delete?cache=slider'?>" 
                          class="btn btn-danger btn-sm delete">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Удалить весь кэш</td>
                    <td></td>
                    <td width="50">
                        <a 
                          href="<?=ADMIN.'/cache/delete?cache=all'?>" 
                          class="btn btn-danger btn-sm delete">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>