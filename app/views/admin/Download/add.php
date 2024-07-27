<div class="card">
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" action="" class="form-horizontal">
            <?php foreach (\dopler_core\App::$app->getProperty('languages') as $k => $lang):?>
                <div class="forn-group row">
                    <label for="name" class="col-sm-3 col-form-label required">
                        <img src="<?=PATH.'/assets/img/lang/'.$k.'.png'?>">
                        Наименование
                    </label>
                    <div class="col-sm-9">
                        <input 
                            type="text" 
                            name="download_description[<?=$lang['id']?>][name]"
                            class="form-control"
                            id="name"
                            placeholder="Наименование файла">
                    </div>
                </div>
            <?php endforeach?>
            <hr>
            <span class="text-info">
                Допустимые для загрузки расширения .jpg, .jpeg, .png, .zip, .pdf, .txt
            </span>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                    <label for="exampleInputFile" class="custom-file-label required">Choose file</label>
                </div>
                <div class="input-group-append">
                    <span class="input-group-text">Upload</span>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
</div>