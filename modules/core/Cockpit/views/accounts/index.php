<style>
    .app-panel-box { min-height: 210px; }
</style>

<div data-ng-controller="accounts">

    <nav class="uk-navbar uk-margin-large-bottom">
        <span class="uk-navbar-brand">Accounts</span>
        <div class="uk-navbar-content">
            <form class="uk-form uk-margin-remove uk-display-inline-block">
                <div class="uk-form-icon">
                    <i class="uk-icon-filter"></i>
                    <input type="text" placeholder="Filter by name..." data-ng-model="filter">
                </div>
            </form>
        </div>
        <ul class="uk-navbar-nav">
            <li><a href="@route('/accounts/create')" title="Create account" data-uk-tooltip="{pos:'right'}"><i class="uk-icon-plus-circle"></i></a></li>
        </ul>
    </nav>


    <div class="uk-grid" data-uk-grid-margin data-uk-grid-match>
        <div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4" data-ng-repeat="account in accounts" data-ng-show="matchName(account.user)">

            <div class="app-panel app-panel-box uk-text-center uk-visible-hover">

                <div class="uk-margin">
                    <img class="uk-rounded" ng-src="http://www.gravatar.com/avatar/@@ account.md5email @@?d=mm&s=60" width="60" height="60" alt="gravatar">
                </div>


                <strong>@@ account.user @@</strong>

                <div class="uk-margin uk-hidden uk-animation-fade">
                    <span class="uk-button-group">
                        <a class="uk-button uk-button-small" href="@route('/accounts/account')/@@ account._id @@" title="Edit account" data-uk-tooltip="{pos:'bottom'}"><i class="uk-icon-pencil"></i></a>
                        <a class="uk-button uk-button-danger uk-button-small" data-ng-click="remove($index, account)" href="#" title="Delete account" data-uk-tooltip="{pos:'bottom'}"><i class="uk-icon-minus-circle"></i></a>
                    </span>
                </div>
            </div>
        </div>
    </div>


</div>

<script>

    App.module.controller("accounts", function($scope, $rootScope, $http){

        $scope.accounts = {{ json_encode($accounts) }};
        $scope.current  = {{ json_encode($current) }};

        $scope.remove = function(index, account){

            if(account._id == $scope.current) {
                App.notify("You can't delete yourself!", "danger");
                return;
            }

            if(confirm("Are you sure?")) {

                $http.post(App.route("/accounts/remove"), {

                    "account": angular.copy(account)

                }, {responseType:"json"}).success(function(data){

                    $scope.accounts.splice(index, 1);

                    App.notify("Account removed", "success");

                }).error(App.module.callbacks.error.http);
            }
        };


        $scope.filter = "";

        $scope.matchName = function(name) {
            return (name && name.indexOf($scope.filter) !== -1);
        };

    });


</script>