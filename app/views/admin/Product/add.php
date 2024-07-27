<?php 

$languages = \dopler_core\App::$app->getProperty('languages');

?>

<div class="card">
    <div class="card-body">
        <form action="" method="post">
            <div class="form-group">
                <label for="category_id" class="required">Категории</label>
                <?php new \app\widgets\menu\Menu([
                    'cache' => 0,
                    'cacheKey' => 'admin_menu_select',
                    'class' => 'form-control',
                    'container' => 'select',
                    'attrs' => [
                        'name' => 'category_id',
                        'required' => 'required',
                        'id' => 'category_id'
                    ], 
                    'tpl' => APP . '/widgets/menu/admin_select_tpl.php'
                ])?>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="price" class="required">Цена</label>
                        <input type="text" 
                            name="price" 
                            class="form-control"
                            placeholder="Цена"
                            value="<?=get_field_value('price') ?: 0 ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="old_price">Старая цена</label>
                        <input type="text" 
                            name="old_price" 
                            class="form-control" 
                            id="old_price"
                            placeholder="Старая цена"
                            value="<?=get_field_value('old_price')?:0?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input 
                        type="checkbox" 
                        name="status" 
                        class="custom-control-input"
                        id="status"
                        checked>
                    <label for="status" class="custom-control-label">Показывать на сайте</label>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="hit" id="hit" class="custom-control-input">
                    <label for="hit" class="custom-control-label">Акция</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="is_download">
                            Прикрепите загружаемый файл, чтобы товар стал цифровым
                        </label>
                        <select 
                            name="is_download" 
                            id="is_download" 
                            class="form-control select2 is-download"
                            style="width:100%"></select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Основное фото</h3>
                        </div>
                        <div class="card-body">
                            <button 
                                class="btn btn-success"
                                id="add-base-img"
                                onclick="popupBaseImage(); return false;">
                                загрузить
                            </button>
                            <div id="base-img-output" class="upload-images base-image"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Дополнительные фото</h3>
                        </div>
                        <div class="card-body">
                            <button 
                                class="btn btn-success"
                                id="add-gallery-img"
                                onclick="popupGalleryImage(); return false;">
                                загрузить
                            </button>
                            <div id="gallery-img-output" class="upload-images gallery-image"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-info card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <?php foreach($languages as $k => $lang):?>
                            <li class="nav-item">
                                <a 
                                    href="#<?=$k?>" 
                                    class="nav-link"
                                    data-toggle="pill"
                                    <?php if ($lang['base']) echo 'active'?>>
                                    <img src="<?=PATH.'/assets/img/lang/'.$k.'.png'?>">
                                </a>
                            </li>
                        <?php endforeach?>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <?php foreach($languages as $k => $lang): ?>
                            <div 
                                id="<?=$k?>"
                                class="tab-pane fade <?php if ($lang['base']) echo 'active show'?>">
                                <div class="form-group">
                                    <label for="title" class="required">Наименование</label>
                                    <input 
                                        type="text"
                                        name="product_description[<?=$lang['id']?>][title]"
                                        class="form-control"
                                        id="title"
                                        placeholder="Наименование товара"
                                        value="<?=get_field_array_value('product_description', $lang['id'], 'title')?>">
                                </div>
                                <div class="form-group">
                                    <label for="description" class="required">Описание</label>
                                    <input 
                                        type="text"
                                        name="product_description[<?=$lang['id']?>][description]"
                                        class="form-control"
                                        id="description"
                                        placeholder="Мета-товара"
                                        value="<?=get_field_array_value('product_description', $lang['id'], 'description')?>">
                                </div>
                                <div class="form-group">
                                    <label for="keywords" class="required">Ключевые слова</label>
                                    <input 
                                        type="text"
                                        name="product_description[<?=$lang['id']?>][keywords]"
                                        class="form-control"
                                        id="keywords"
                                        placeholder="Ключевые слова"
                                        value="<?=get_field_array_value('product_description', $lang['id'], 'keywords')?>">
                                </div>
                                <div class="form-group">
                                    <label for="exerpt" class="required">Краткое описание</label>
                                    <input 
                                        type="text"
                                        name="product_description[<?=$lang['id']?>][exerpt]"
                                        class="form-control"
                                        id="exerpt"
                                        placeholder="Краткое описание"
                                        value="<?=get_field_array_value('product_description', $lang['id'], 'exerpt')?>">
                                </div>
                                <div class="form-group">
                                    <label for="content" class="required">Описание</label>
                                    <textarea 
                                        name="product_description[<?=$lang['id']?>][content]"
                                        class="form-control editor"
                                        id="content"
                                        placeholder="Описание товара">
                                        <?=get_field_array_value('product_description', $lang['id'], 'content')?>
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
    function popupBaseImage() {
        CKFinder.popup({
            chooseFiles: true,
            onInit: ( finder ) => {
                finder.on('files:choose', (evt) => {
                    const file = evt.data.files.first();
                    const baseImgOutput = document.getElementById('base-img-output');
                    baseImgOutput.innerHTML = `
                        <div class="product-img-upload">
                            <img width="100%" src="${file.getUrl()}"/>
                            <input type="hidden" name="img" value="${file.getUrl()}"/>
                            <button class="del-img btn btn-app bg-danger">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>`;
                });
                finder.on('file:choose:resizedImage', (evt) => {
                    const baseImgOutput = document.getElementById('base-img-output');
                    baseImgOutput.innerHTML = `
                    <div class="product-img-upload">
                        <img width="100%" src="${evt.data.resizedUrl}">
                        <input type="hidden" name="img" value="${evt.data.resizedUrl}">
                        <button class="del-img btn-app bg-danger">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>
                    `;
                })
            }
        })
    }
</script>

<script>
    function popupGalleryImage() {
        CKFinder.popup({
            chooseFiles: true,
            onInit: ( finder ) => {
                finder.on('files:choose', (evt) => {
                    const file = evt.data.files.first();
                    const galleryImgOutPut = document.getElementById('gallery-img-output');
                    
                    const html = `
                        <div class="product-img-upload">
                            <img width="100%" src="${file.getUrl()}">
                            <input type="hidden" name="gallery[]" value="${file.getUrl()}">
                            <button class="del-img btn btn-app bg-danger">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    `;
                    if (galleryImgOutPut.innerHTML) {
                        galleryImgOutPut.innerHTML += html;
                    } else {
                        galleryImgOutPut.innerHTML = html;
                    }
                })
                finder.on('file:choose:resizedImage', (evt) => {
                    const baseImgOutPut = document.GetElementById('base-img-output');
                    const html = `
                        <div class="product-img-upload">
                            <img width="100%" src="${evt.data.resizedUrl}">
                            <input name="gallery[]" type="hidden" value="${evt.data.resizedUrl}">
                            <button class="del-img btn btn-app bg-danger">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    `
                    if (baseImgOutPut.innerHTML) {
                        baseImgOutPut.innerHTML += html
                    } else {
                        baseImgOutPut.innerHTML = html
                    }
                })
            }
        })
    }
</script>

<script>
    window.editors = {};

    document.querySelectorAll('.editor').forEach((node, index) => {
        ClassicEditor
            .create(node, {
                ckfinder: {
                    uploadUrl: `<?=PATH?>
                        /adminLTE/ckfinder/core/connector/php/connector.php
                        ?command=QuickUpload&type=Files&responseType=json`
                },
                toolbar: ['ckfinder', 
                    '|', 'heading', 
                    '|', 'bold', 'italic', 
                    '|', 'undo', 'redo',
                    '|', 'link', 'blockQuote'],
                image: {
                    toolbar: ['imageTextAlternative',
                        '|', 'imageStyle:alignLeft',
                        'imageStyle:alignCenter',
                        'imageStyle:alignRight'
                    ],
                    styles: [
                        'alignLeft',
                        'alignCenter',
                        'alignRight'
                    ]
                }
            })
            .then(newEditor => {
                window.editors[index] = newEditor;
            })
            .catch(error => {
                console.log(error)
            })
    })
</script>