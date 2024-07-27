<div class="card">
    <div class="card-body">
        <form action="" method="POST">
            <div class="form-group">
                <label for="parent_id" class="required">Родительская категория</label>
                <?php 
                new \app\widgets\menu\Menu([
                    'cache' => 0,
                    'cacheKey' => 'admin_menu_select',
                    'class' => 'form-control',
                    'container' => 'select',
                    'attrs' => [
                        'name' => 'parent_id',
                        'id' => 'parent_id',
                        'required' => 'required',
                    ],
                    'prepend' => '<option value="0">Самостоятельная категория</option>',
                    'tpl' => APP.'/widgets/menu/admin_select_tpl.php',
                ])?>
            </div>
            <div class="card card-info card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <?php foreach(\dopler_core\App::$app->getProperty('languages') as $k => $lang):?>
                            <li class="nav-item">
                                <a 
                                    class="nav-link <?php if ($lang['base']) echo 'active'?>"
                                    href="#<?=$k?>"
                                    data-toggle="pill">
                                    
                                    <img src="<?=PATH?>/assets/img/lang/<?=$k?>.png" alt="<?=$lang['title']?>">
                                </a>
                            </li>
                        <?php endforeach?>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <?php foreach (\dopler_core\App::$app->getProperty('languages') as $k => $lang):?>
                            <div class="tab-pane fade <?php if ($lang['base']) echo 'active show'?>" id="<?=$k?>">
                                <div class="form-group">
                                    <label for="title" class="required">Наименование</label>
                                    <input 
                                        type="text" 
                                        name="category_description[<?=$lang['id']?>][title]" 
                                        class="form-control"
                                        id="title"
                                        placeholder="Наименование категории"
                                        value="<?=$category[$lang['id']]['title']?>" >
                                </div>
                                <div class="form-group">
                                    <label for="description">Мета-описание</label>
                                    <input 
                                        type="text" 
                                        name="category_description[<?=$lang['id']?>][description]" 
                                        class="form-control"
                                        id="description"
                                        placeholder="Мета-описание"
                                        value="<?=$category[$lang['id']]['description']?>">
                                </div>
                                <div class="form-group">
                                    <label for="keywords">Ключевые слова</label>
                                    <input 
                                        type="text" 
                                        name="category_description[<?=$lang['id']?>][keywords]" 
                                        class="form-control"
                                        id="keywords"
                                        placeholder="Ключевые слова"
                                        value="<?=$category[$lang['id']]['keywords']?>">
                                </div>
                                <div class="form-group">
                                    <label for="content">Описание категории</label>
                                    <textarea 
                                        name="category_description[<?=$lang['id']?>][content]" 
                                        class="form-control editor"
                                        id="content"
                                        rows="3"
                                        placeholder="Описание категории">
                                        <?=$category[$lang['id']]['title']?>
                                    </textarea>
                                </div>
                            </div>
                        <?php endforeach?>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
        <?php 
            if (isset($_SESSION['form_data'])) {
                unset($_SESSION['form_data']);
            }
        ?>
    </div>
</div>

<script>
    // https://question-it.com/questions/3558262/kak-ja-mogu-sozdat-neskolko-redaktorov-s-imenem-klassa
    // https://ckeditor.com/docs/ckfinder/demo/ckfinder3/samples/ckeditor.html
    window.editor = {};
    document.querySelectorAll('.editor').forEach((node, index) => {
        ClassicEditor
            .create(node, {
                ckfinder: {
                    uploadUrl: `<?=PATH?>
                                /adminlte/ckfinder/core/connector/php/connector.php
                                ?command=QuickUpload&type=Files&responseType=json`,
                },
                toolbar: ['ckfinder', '|', 'heading', '|', 'bold', 'italic',
                '|', 'undo', 'redo', '|', 'link', 'bulletedList', 'numberedList',
                'insertTable', 'blockQuote'],
                image: {
                    toolbar: ['imageTextAlternative', '|', 'imageStyle:alignLeft',
                    'imageStyle:alignCenter', 'imageStyle:alignRight'],
                    styles: [
                        'alignLeft',
                        'alignCenter',
                        'alignRight'
                    ]
                }
            })
            .then((newEditor) => {
                window.editors[index] = newEditor
            })
            .catch((error) => {
                console.error(error)
            })
    })
</script>