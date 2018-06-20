


    <div class="panel panel-primary" ng-app="app" id="App2">

        <div class="panel-heading">Role Based Access Control System</div>

            <div class="panel-body">

                <div ng-controller="userAccessController">
                    {{firstname}}
                </div>

            </div>

        </div>

    </div>
    <script src="<?= getFullURLLevel($_GET['r'],'assets/js/ua_rbac.js',2,'R') ?>"></script>
