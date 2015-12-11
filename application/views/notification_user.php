<div class="col-lg-12">
    <div class="table-responsive">
        <table id="datatable1" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Registration Id</th>
                    <th>Registration Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($x = 0; $x <= 190; $x++) {
                    ?>
                    <tr>
                        <td>mew@a.com</td>
                        <td>31246321987462166901</td>
                        <td>12/12/12 12:12PM</td>
                        <td><button class="btn ink-reaction btn-raised btn-primary">Send Notification</button></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div><!--end .table-responsive -->
</div><!--end .col -->
</div><!--end .row -->
<!-- END DATATABLE 1 -->
