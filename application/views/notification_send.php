<div class="row">
    <div class="col-lg-offset-1 col-md-4">
        <form class="form">
            <div class="card">
                <div class="card-head style-primary">
                    <header>Send Notification</header>
                </div>
                <div class="card-body floating-label">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" autocomplete="false" >
                        <label for="title">Title</label>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="message" autocomplete="false">
                        <label for="message">Message</label>
                    </div>
                </div><!--end .card-body -->
                <div class="card-actionbar">
                    <div class="card-actionbar-row">
                        <button type="submit" class="btn btn-flat btn-primary ink-reaction">Send Notification</button>
                    </div>
                </div>
            </div><!--end .card -->
        </form>
    </div>
    <div class="col-lg-offset-1 col-md-4">
            <div class="pTitle" style="position: absolute;top: 150px;left: 120px;color: #FFF;width:250px">Title</div>
            <div class="pMsg" style="position: absolute;top: 180px;left: 120px;color: #FFF;width:250px">Message</div>
            <img src="<?php echo site_url('img/simple.png')?>"  width="380" height="784">
    </div>
</div>