angular.module("app", [])
    .controller("userAccessController", function($scope, $http, $filter) {

        $('#menu').on('change', function() {

            var menu_name = $("#menu :selected").text();
            $("#menu_name").val(menu_name);

        })

        $scope.showPermissions = function() {

            if ($("#role").val() === "" || $("#menu").val() === "") {

                sweetAlert("Message", 'Please select Role and Menu Name First', "info");

            } else {

                var url = 'template/ua/role_menu_validation.php?role_id=' + $('#role').val() + '&menu_id=' + $('#menu').val();

                $http.get(url).success(function(response) {

                    var x = response.status;

                    if (x == 'Proceed') {
                        $("#permissions").show();
                        $("#b2").show();
                        $("#b3").show();
                        $("#b1").hide();
                        $('#b3').prop('disabled', true);
                        $("select").prop("disabled", true);
                    } else {
                        $("select").prop("disabled", false);
                        sweetAlert("Message", 'Already This Role and Menu and Permissions Exist', "info");
                    }

                });

            }
        }

        $scope.hidePermissions = function() {
            $("#permissions").hide();
            $("#b2").hide();
            $("#b3").hide();
            $("#b1").show();
            $("#role").prop("readonly", false);
            $("#menu").prop("readonly", false);

            $('.chkbox').attr("checked", false);
            $("select").prop("disabled", false);
        }

        $("input:checkbox[class=chkbox]").on("click", function() {
            $('#b3').prop("disabled", false);
        });

        var selected_check_boxes = [];

        $scope.save = function() {

            selected_check_boxes = [];

            $("input:checkbox[class=chkbox]:checked").each(function() {

                if ($(this).prop("checked") == true) {

                    selected_check_boxes.push($(this).val());
                }

            });

            if (selected_check_boxes.length > 0) {
                $("select").prop("disabled", false);
                $('#b4').trigger('click');
                // angular.element('#b4').triggerHandler('click');
            } else {
                $("select").prop("disabled", true);
                sweetAlert("Alert", 'Please select atleast one permission', "info");
            }
        }
    });

angular.bootstrap(document.getElementById("App2"), ['app']);