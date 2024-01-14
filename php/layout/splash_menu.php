<div class="container">
    <div class="row mb-3">
        <div class="col-12 mb-4 rounded-3">
            <div class="container-fluid hero p-5 rounded-3">
                <div class="row">
                    <div class="col-lg-3 d-none d-lg-block">
                        <img class="rounded-2" src="<?php echo $site['logo_filename']; ?>" style="max-width: 100%">
                    </div>
                    <div class="col-lg-9 col-md-12">
                        <img class="float-start me-2 mb-2 rounded-2 d-lg-none" src="<?php echo $site['logo_filename']; ?>" style="width: 30%">
                        <h1 class="display-5 fw-bold"><?php echo $site['brand'];?></h1>
                        <p class="fs-4"><?php echo $site['full_name']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="rounded-3 p-3 hero text-center mb-3">
                <h4 class="splash_links fs-5"><a href="#event_date" class="text-decoration-none">Next meeting date</a></h4>
            </div>
        </div>

        <div class="col-md-4">
            <div class="rounded-3 p-2 hero text-center mb-3">
                <form action="/subscribe" method="post">
                    <div class="input-group my-2">
                        <input id="reg_email" name="reg_email" type="email" class="form-control" placeholder="mailing list">
                        <button type="submit" class="btn btn-secondary">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="rounded-3 p-3 hero text-center mb-3">
                <h4 class="splash_links fs-5"><a href="/sessions" class="text-decoration-none">Past sessions</a></h4>
            </div>
        </div>
    </div>
</div>
