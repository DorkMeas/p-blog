<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
</head>

<body ng-app="adminApp" ng-controller="AdminController">
    <div class="container mt-4">
        <h1 class="mb-4">Admin Panel</h1>
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Public</a>

        <!-- Add New Post -->
        <div class="card mb-4">
            <div class="card-header">Create New Post</div>
            <div class="card-body">
                <form ng-submit="addPost()">
                    <div class="mb-3">
                        <input
                            type="text"
                            class="form-control"
                            ng-model="newPost.title"
                            placeholder="Title"
                            required>
                    </div>
                    <div class="mb-3">
                        <textarea
                            class="form-control"
                            ng-model="newPost.content"
                            rows="4"
                            placeholder="Content"
                            required>
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <input
                            type="text"
                            class="form-control"
                            ng-model="newPost.category"
                            placeholder="Category"
                            required>
                    </div>
                    <button type="submit" class="btn btn-success">Save Post</button>
                </form>
            </div>
        </div>

        <!-- Posts List -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Posts List</h3>
            <input
                type="text"
                class="form-control w-25"
                placeholder="Search..."
                ng-model="searchText">
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="post in posts | filter:searchText">
                    <td>{{post.id}}</td>
                    <td>{{post.title}}</td>
                    <td>{{post.category}}</td>
                    <td>
                        <button
                            class="btn btn-sm btn-warning"
                            ng-click="editPost(post)">
                            Edit
                        </button>
                        <button
                            class="btn btn-sm btn-danger"
                            ng-click="deletePost(post.id)">
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Post</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input
                                type="text"
                                class="form-control"
                                ng-model="editPostData.title">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea
                                class="form-control"
                                ng-model="editPostData.content"
                                rows="5">
                            </textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <input
                                type="text"
                                class="form-control"
                                ng-model="editPostData.category">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button
                            type="button"
                            class="btn btn-primary"
                            ng-click="saveEdit()">
                            Save Changes
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var app = angular.module('adminApp', []);

        app.controller('AdminController', function($scope, $http) {
            $scope.posts = [];
            $scope.newPost = {};
            $scope.editPostData = {};

            $scope.searchText = "";

            function loadPosts() {
                $http.get('api.php').then(function(response) {
                    $scope.posts = response.data;
                });
            }

            loadPosts();

            $scope.addPost = function() {
                $http.post('api.php', $scope.newPost).then(function() {
                    loadPosts();
                    $scope.newPost = {};
                });
            };

            $scope.editPost = function(post) {
                $scope.editPostData = angular.copy(post);
                var modal = new bootstrap.Modal(document.getElementById('editModal'));
                modal.show();
            };

            $scope.saveEdit = function() {
                $http.put('api.php', $scope.editPostData).then(function() {
                    loadPosts();
                    bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                });
            };

            $scope.deletePost = function(id) {
                if (confirm('Delete this post?')) {
                    $http.delete('api.php?id=' + id).then(function() {
                        loadPosts();
                    });
                }
            };
        });
    </script>
</body>

</html>