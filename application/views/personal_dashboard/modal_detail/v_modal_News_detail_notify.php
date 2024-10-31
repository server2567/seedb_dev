<style>
    .carousel-control-prev,
    .carousel-control-next {
        color: black;
        border: none;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: black;
    }
</style>

<div class="card-body" style="height: 100%;">
    <?php
    function truncateText($text, $limit = 5)
    {
        $words = explode(' ', $text);
        if (count($words) > $limit) {
            return implode(' ', array_slice($words, 0, $limit)) . '...';
        } else {
            return $text;
        }
    }
    ?>

    <div class="card">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators bg-dark mb-5">
                <?php for ($index = 0; $index < count($news); $index++) : ?>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-label="Slide <?= $index + 1 ?>" <?= $index === 0 ? 'aria-current="true"' : '' ?>></button>
                <?php endfor; ?>
            </div>

            <div class="carousel-inner">
                <?php for ($index = 0; $index < count($news); $index++) : ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="card p-4">
                            <div class="card-body">
                                <div class="text-dark">
                                    <h1><?= $news[$index]->news_name ?></h1>
                                    <p><?= truncateText($news[$index]->news_text) ?>
                                        <a href="#" onclick="view_detail(<?= $news[$index]->news_id ?>)">อ่านเพิ่มเติม</a>
                                    </p>
                                </div>
                            </div>
                            <div class="mx-auto p-5 mb-5">
                                <div class="row">
                                    <div class="col-12 d-flex align-items-center justify-content-center">
                                        <button type="button" class="btn" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        </button>
                                        <div class="flex-shrink-1 mx-3">
                                            <img class="border border-danger img-thumbnail" src="<?= site_url($this->config->item('ums_dir') . 'getIcon?type=' . $this->config->item('ums_news_dir') . 'img&image=' . ($news[$index]->news_img_name != '' ? $news[$index]->news_img_name : 'default.png')) ?>" alt="News Image" class="img-fluid">
                                        </div>
                                        <button type="button" class="btn" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

        </div>
    </div>
</div>

<script>
    function view_detail(id) {
        $.ajax({
            method: "post",
            url: 'Home/view_detail',
            data: {
                id: id,
                ck: 1,
            }
        }).done(function(returnData) {
            $('.modaltitle').html(returnData.title);
            console.log(returnData.title);
            $('#mainModalBody').html(returnData.body);
            $('#ck').html(returnData.footer);
            $('#mainModal').modal('show');
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX request failed: ' + textStatus, errorThrown);
        });
    }

    function view(id) {
        $.ajax({
            method: "POST",
            url: 'Home/getmodal',
            data: {
                id: id
            }
        }).done(function(returnData) {
            $('.modaltitle').html(returnData.title);
            console.log(returnData.title);
            $('#mainModalBody').html(returnData.body);
            $('#ck').html(returnData.footer);
            $('#mainModal').modal('show');
            $('#print').prop('disabled', false);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX request failed: ' + textStatus, errorThrown);
        });
    }
</script>
