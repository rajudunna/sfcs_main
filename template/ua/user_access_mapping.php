






    <div class="panel panel-primary" style="height:150px;">

        <div class="panel-heading">Role Based Access Control System</div>

            <div class="panel-body">

                <div ng-controller="userAccessController">
                    {{firstname}}
                </div>

            </div>

        </div>

    </div>
    <script src="<?= getFullURLLevel($_GET['r'],'assets/js/ua_rbac.js',2,'R') ?>"></script>
