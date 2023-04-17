<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>

<body>

    <div class="container mt-3">
        <button type="button" class="btn btn-secondary">Product</button>
        <a href="/phpmvc"><button type="button" class="btn btn-primary">Category</button></a>
        <form method="GET">
            <div class="d-flex">
                <input class="form-control mt-3 mr-2" id="myInput" type="text" autocomplete="off" placeholder="Search.." name="search" value="<?php echo isset($data['search_term']) ? $data['search_term'] : ''; ?>">
                <button type="submit" class="btn btn-primary mt-3">Search</button>
            </div>
        </form>

        <br>
        <div class="d-flex justify-content-between align-items-center">
            <div class="mr-4 mb-2 mb-md-0">Hiện có tổng cộng <span class="font-weight-bold"><?php echo $data['all']; ?></span> Category</div>
            <div>Hiện trên màn hình <span class="font-weight-bold"><?php echo mysqli_num_rows($data['Cate']); ?></span> Category</div>
            <button type="button" class="btn btn-primary ml-auto" data-toggle="modal" data-target="#addCategoryModal">
                <span class="fa fa-plus"></span>
            </button>
        </div>

        <!-- Thêm category mới -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="homeController/Add" method="post">
                            <div class="form-group">
                                <label for="TenLSP">Category Name</label>
                                <input type="text" class="form-control" id="TenLSP" name="TenLSP" placeholder="Nhập tên Category" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="parent_id">Parent Category</label>
                                <select class="form-control" id="parent_id" name="parent_id">
                                    <option value="">0</option>
                                    <?php while ($row = mysqli_fetch_array($data["ParentId"])) { ?>
                                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["id"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Thêm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- --- -->
        <br>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Parent_id</th>
                    <th>Tên danh mục</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="myTable">
                <?php while ($row = mysqli_fetch_array($data["Cate"])) { ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["parent_id"]; ?></td>
                        <td><?php echo $row["TenLSP"]; ?></td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#editCategoryModal_<?php echo $row["id"]; ?>">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="homeController/Delete/<?php echo $row["id"]; ?>" onclick="return confirm('Bạn có chắc là muốn xóa Category này không?');">
                                <i class="fa fa-trash-o"></i>
                            </a>
                            <a href="#" data-toggle="modal" data-target="#categoryModal_<?php echo $row["id"]; ?>">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <!-- chi tiết cate -->
                    <div class="modal fade" id="categoryModal_<?php echo $row["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel_<?php echo $row["id"]; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="categoryModalLabel_<?php echo $row["id"]; ?>">Chi tiết Category</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>ID: <?php echo $row["id"]; ?></p>
                                    <p>Parent ID: <?php echo $row["parent_id"]; ?></p>
                                    <p>Tên Category: <?php echo $row["TenLSP"]; ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- chỉnh sửa cate -->
                    <div class="modal fade" id="editCategoryModal_<?php echo $row["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="editCategoryModal_<?php echo $row["id"]; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form method="post" action="/phpmvc/homeController/Update/<?php echo $row["id"]; ?>">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCategoryModal_<?php echo $row["id"]; ?>">Sửa thông tin Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="TenLSP">Tên Category</label>
                                            <input type="text" class="form-control" id="TenLSP" name="TenLSP" value="<?php echo $row["TenLSP"]; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="parent_id">Parent Category</label>
                                            <select class="form-control" id="parent_id" name="parent_id">
                                                <option value="">0</option>
                                                <?php while ($row = mysqli_fetch_array($data["ParentId"])) { ?>
                                                    <option value="<?php echo $row["id"]; ?>"><?php echo $row["id"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="submit">Lưu thay đổi</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- --- -->
                <?php } ?>
            </tbody>
        </table>
        <ul class="pagination justify-content-center">
            <?php if (isset($page) && $page > 1) : ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo ($page - 1); ?>">Previous</a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= (isset($total_pages) ? $total_pages : 1); $i++) : ?>
                <li class="page-item <?php if ($page == $i) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
            <?php if (isset($page) && isset($total_pages) && $page < $total_pages) : ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo ($page + 1); ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </div>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>


</html>