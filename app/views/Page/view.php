<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            
            <li class="breadcrumb-item">
                <a href="<?= baseUrl();?>"><i><i class="fas fa-home"></i></i></a>
            </li>
            <li class="breadcrumb-item">
                <?= $page['title']?>
            </li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?= $page['title']?></h3>

           <p> <?= $page['content']?></p>
        </div>

    </div>
</div>
