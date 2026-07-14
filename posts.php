<?php
require_once 'include/header.php';
?>

<div class="container mt-5" ng-app="blogApp" ng-controller="BlogController">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>All Posts</h2>
        <span class="badge bg-primary">
            {{posts.length}} Posts
        </span>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4" ng-repeat="post in posts">
            <div class="card h-100">

                <div class="card-body">
                    <h5>{{post.title}}</h5>
                    <p class="text-muted small">
                        {{post.category}}
                        •
                        {{post.created_at}}
                    </p>
                    <p>
                        {{post.content | limitTo:120}}...
                    </p>
                </div>

                <div class="card-footer">
                    <a class="btn btn-primary btn-sm"
                        href="post.php?id={{post.id}}">
                        Read More →
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>

<script>
    var app = angular.module('blogApp', []);
    app.controller('BlogController', function($scope, $http) {
        $scope.posts = [];
        $http.get('api.php')
            .then(function(response) {
                $scope.posts = response.data;
            });
    });
</script>

<?php
require_once 'include/footer.php';
?>