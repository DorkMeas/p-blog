<?php
require_once 'include/header.php';
$category = $_GET['category'] ?? '';
?>

<div class="container mt-5" ng-app="blogApp" ng-controller="BlogController">
    <div class="row">
        <?php if (empty($category)): ?>
            <div class="row g-2">

                <!-- Featured Post -->
                <div class="col-lg-8">
                    <h2 class="mb-3">
                        Featured Post
                    </h2>
                    <div class="card">
                        <div class="card-body"
                            ng-repeat="post in posts | limitTo:1">
                            <h3>
                                {{post.title}}
                            </h3>
                            <p class="text-muted">
                                {{post.created_at}} • {{post.category}}
                            </p>
                            <p>
                                {{post.content | limitTo:200}}...
                            </p>
                            <a href="post.php?id={{post.id}}"
                                class="btn btn-primary">
                                Read More →
                            </a>
                        </div>
                    </div>
                </div>


                <!-- Categories -->
                <div class="col-lg-4">
                    <h2 class="mb-3">
                        Categories
                    </h2>

                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between"
                                ng-repeat="cat in categories">
                                {{cat}}
                                <span class="badge bg-primary">
                                    {{getCount(cat)}}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        <?php endif; ?>
    </div>

    <!-- All Posts -->
    <h2 class="mt-5">
        <?php if ($category !== ''): ?>
            <?= htmlspecialchars($category) ?> Posts
        <?php else: ?>
            All Posts
        <?php endif; ?>
    </h2>
    <div class="row">
        <div class="col-md-4 mb-4" ng-repeat="post in posts">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{post.title}}</h5>
                    <p class="card-text">{{post.content | limitTo:100}}...</p>
                    <small class="text-muted">{{post.category}}</small>
                </div>
                <div class="card-footer">
                    <a href="post.php?id={{post.id}}" class="btn btn-sm btn-primary">Read Full</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AngularJS -->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
<script>
    var app = angular.module('blogApp', []);

    app.controller('BlogController', function($scope, $http) {
        $scope.posts = [];
        $scope.categories = [];

        $http.get('api.php').then(function(response) {
            var posts = response.data;
            var category = "<?= $category ?>";

            if (category !== "") {
                posts = posts.filter(function(p) {
                    return p.category === category;
                });
            }

            $scope.posts = posts;

            $scope.categories = [...new Set(response.data.map(function(p) {
                return p.category;
            }))];

        });

        $scope.getCount = function(cat) {
            return $scope.posts.filter(function(p) {
                return p.category === cat;
            }).length;
        };
    });
</script>

<?php require_once 'include/footer.php'; ?>