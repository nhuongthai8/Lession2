<?php

class homeController extends controller
{
    // function Index()
    // {
    //     //model
    //     $cate = $this->model("homeModel");
    //     $pid = $this->model("homeModel");
    //     if (isset($_GET['search'])) {
    //         $search_term = $_GET['search'];
    //         $Cate = $cate->Search($search_term);
    //     } else {
    //         $Cate = $cate->GetAllCategory();
    //         $search_term = '';
    //     }
    //     //view
    //     $this->view("homeView", ["Cate" => $Cate, "ParentId" => $pid->GetAllParentId(), "search_term" => $search_term]);
    // }

    function Index()
    {
        //model
        $cate = $this->model("homeModel");
        $pid = $this->model("homeModel");
        $all = $this->model("homeModel");
        //pagination
        $limit = 10;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($page - 1) * $limit;


        if (isset($_GET['search'])) {
            $search_term = $_GET['search'];
            $Cate = $cate->Search($search_term);
        } else {
            $Cate = $cate->GetAllCategoryWithPaginate($start, $limit);
            $search_term = '';
        }

        //pagination
        $total_records = $cate->CountAllCategory();
        $total_pages = ceil($total_records / $limit);
        if ($total_pages < 1) {
            $total_pages = 1;
        }

        //view
        $this->view("homeView", ["Cate" => $Cate, "ParentId" => $pid->GetAllParentId(), "search_term" => $search_term, "total_pages" => $total_pages, "page" => $page, "all"=>$all->CountAllCategory()]);
    }


    function Delete($id)
    {
        //model
        $cate = $this->model("homeModel");
        $result = $cate->DeleteCategory($id);
        //view
        if ($result) {
            header("Location: /phpmvc");
        } else {
            echo "Gặp lỗi xóa Category";
        }
    }
    function Add()
    {
        $cate = $this->model("homeModel");
        if (isset($_POST['submit'])) {
            $parent_id = isset($_POST['parent_id']) && $_POST['parent_id'] !== '' ? $_POST['parent_id'] : 0;
            $result = $cate->AddCategory($parent_id, $_POST['TenLSP']);
            if ($result) {
                header("Location: /phpmvc");
            } else {
                echo "Lỗi";
            }
        }
    }
    public function Detail($id)
    {
        //model
        $cate = $this->model("homeModel");
        $data = $cate->GetCategoryById($id);
        $this->view("homeView", $data);
    }
    public function Update($id)
    {
        $cate = $this->model("homeModel");
        $findCate = $cate->GetCategoryById($id);
        if (isset($_POST['submit'])) {
            $update = $cate->EditCategory($id, $_POST['parent_id'], $_POST['TenLSP']);
            if ($update) {
                header("location: /phpmvc");
            } else {
                echo "Lỗi";
            }
        }
        $this->view('homeView', ['findCate' => $findCate]);
    }
}
