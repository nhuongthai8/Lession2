<?php

class homeModel extends db
{
    //lấy tất cả category
    public function GetAllCategory()
    {
        $query = "SELECT * from category";
        return mysqli_query($this->con, $query);
    }

    //phân trang
    public function GetAllCategoryWithPaginate($start, $limit)
    {
        $query = "SELECT * FROM category LIMIT $start, $limit";
        return mysqli_query($this->con, $query);
    }

    public function CountAllCategory()
    {
        $query = "SELECT COUNT(*) as total FROM category";
        $result = mysqli_query($this->con, $query);
        $row = mysqli_fetch_assoc($result);
        $total = $row['total'];
        return $total;
    }

    //lấy parent_id
    public function GetAllParentId()
    {
        $query = "SELECT DISTINCT id from category";
        return mysqli_query($this->con, $query);
    }
    //chức năng xóa cate
    public function DeleteCategory($id)
    {
        $query = "DELETE FROM category WHERE id = '$id'";
        return mysqli_query($this->con, $query);
    }
    //chức năng thêm mới cate
    public function AddCategory($pid, $cname)
    {
        $query = "INSERT INTO category(parent_id,TenLSP) VALUES($pid,'$cname')";
        return mysqli_query($this->con, $query);
    }
    //chức năng tìm kiếm
    public function Search($search_term)
    {
        $search_term = mysqli_real_escape_string($this->con, $search_term);
        $query = "SELECT * FROM category WHERE TenLSP LIKE '%$search_term%'";
        $result = mysqli_query($this->con, $query);

        return $result;
    }
    //tìm kiếm cate theo id
    public function GetCategoryById($id)
    {
        $query = "SELECT * FROM category WHERE id = $id";
        $result = mysqli_query($this->con, $query);
        return mysqli_fetch_array($result);
    }
    //chỉnh sửa cate
    public function EditCategory($id, $parent_id, $name)
    {
        $query = "UPDATE category SET TenLSP='$name', parent_id='$parent_id' WHERE id=$id";
        return mysqli_query($this->con, $query);
    }
}
