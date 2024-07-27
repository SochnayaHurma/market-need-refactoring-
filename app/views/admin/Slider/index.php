<div class="card">
    <div class="card-body">
        <form action="" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <div class="card-title">Фото слайдера</div>
                        </div>
                        <div class="card-body">
                            <button 
                              class="btn btn-success" 
                              id="add-gallery-img"
                              onclick="popupGalleryImage(); return false;">
                                Загрузить
                            </button>
                            <div id="gallery-img-output" class="upload-images gallery-image">
                                <?php if (!empty($gallery)):?>
                                    <?php foreach ($gallery as $item):?>
                                        <div class="product-img-upload">
                                            <img src="<?=$item?>" width="100%">
                                            <input type="hidden" name="gallery[]" value="<?=$item?>">
                                            <button class="del-img btn btn-app bg-danger">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    <?php endforeach?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
</div>

<script>

    function popupGalleryImage() {
        CKFinder.popup({
            chooseFiles: true,
            onInit: function (finder) {
                finder.on('files:choose', function (evt) {
                    const file = evt.data.files.first();
                    const galleryImgOutput = document.getElementById('gallery-img-output');
                    const html = `
                        <div class="product-img-upload">
                            <img src="${file.getUrl()}" width="100%">
                            <input type="hidden" name="gallery[]" value="${file.getUrl()}">
                            <button class="del-img btn btn-app bg-danger">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>`
                    if (galleryImgOutput.innerHTML) {
                        galleryImgOutput.innerHTML += html;
                    } else {
                        galleryImgOutput.innerHTML = html;
                    }
                })
                finder.on('file:choose:resizedImage', function (evt) {
                    const file = evt.data.files.first();
                    const baseImgOutput = document.getElementById('base-img-output');
                    const html = `
                        <div class="product-img-upload upload-images">
                            <img src="${file.getUrl()}" width="100%">
                            <input type="hidden" name="gallery[]" value="${file.getUrl()}">
                            <button class="del-img btn btn-app bg-danger">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>`
                    if (galleryImgOutput.innerHTML) {
                        galleryImgOutput.innerHTML += html;
                    } else {
                        galleryImgOutput.innerHTML = html;
                    }
                })
            }
        })
    }
</script>