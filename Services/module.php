<?php
define("PER_Page",12);
class CConnectDataBase
{
    public $Connection;

    public function __construct()
    {
        $db_host = 'localhost';        // Сервер
        $db_user = 'root';    // Имя пользователя
        $db_password = '123';    // Пароль пользователя
        $db_name = 'test';            // Имя базы данных

        $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);
        $query = mysqli_query($connection, "set names utf8");

        $this->Connection = $connection;
    }
}

class InDataBase
{

    function GetGoods()
    {
        $connection = new CConnectDataBase();
        $connection = $connection->Connection;

        $sql = "SELECT * FROM goods LIMIT 0,".PER_Page;
        $query = mysqli_query($connection, $sql);
        if (mysqli_num_rows($query) == 0) {
            return false;
        }
        while ($myrow = mysqli_fetch_array($query)) {
            $goodsarray[] = array(
                'id' => ($myrow["id"]),
                'name' => ($myrow["name"]),
                'category' => ($myrow["category"]),
                'price' => ($myrow["price"]),
                'images' => ($myrow["images"])
                );
        }
        mysqli_close($connection);
        return $goodsarray;
    }

    function GetGoodsid($id)
    {
        $connection = new CConnectDataBase();
        $connection = $connection->Connection;

        $sql = "SELECT * FROM goods  WHERE id=".$id;
        error_log($sql);
        $query = mysqli_query($connection, $sql);
        if (mysqli_num_rows($query) == 0) {
            return false;
        }
        while ($myrow = mysqli_fetch_array($query)) {
            $goodsarray[] = array(
                'id' => ($myrow["id"]),
                'name' => ($myrow["name"]),
                'category' => ($myrow["category"]),
                'price' => ($myrow["price"]),
                'images' => ($myrow["images"]),
                'description' => ($myrow["description"])
                
                );
        }
        mysqli_close($connection);
        return $goodsarray;
    }

    function GetGoodsCategory($category)
    {
        error_log(print_r( "----", true));
        error_log(print_r( $category, true));
        $hrefArr = explode('/', $category);
        $hrefArr = array_diff($hrefArr, array(''));
        error_log(print_r( $hrefArr, true));
        $categorytext =array_pop($hrefArr);
        error_log(print_r( $categorytext, true));

        $connection = new CConnectDataBase();
        $connection = $connection->Connection;

        $sql = "SELECT goods.price,
        goods.id as id,
        goods.images,
        category.id as idcategory,
        category.alias as alias,
        goods.name as name,
        category.name as category
        FROM goods LEFT JOIN category ON goods.category=category.id WHERE alias = '" .$categorytext. "'  ";
        
        $query = mysqli_query($connection, $sql);
        if (mysqli_num_rows($query) == 0) 
        {
            return array();
        }
        while ($myrow = mysqli_fetch_array($query)) 
        {
            $goodsarraycat[] = array(
            'id' => ($myrow["id"]),
            'name' => ($myrow["name"]),
            'category' => ($myrow["category"]),
            'price' => ($myrow["price"]),
            'images' => ($myrow["images"]),
              'alias' => ($myrow["alias"])
            );
        }
        mysqli_close($connection);
        error_log(print_r($goodsarraycat, true));
        return $goodsarraycat;
    }

    function Page()
    {
        $connection = new CConnectDataBase();
        $connection = $connection->Connection;

        $res = mysqli_query($connection,"SELECT COUNT(*) AS rownum FROM goods");
        $res = mysqli_fetch_assoc($res);
        $res=ceil($res['rownum']/PER_Page);
        mysqli_close($connection);

        return $res;
        $ress ="";
        for($i=0; $i <$res; $i++)
        {
            $ress  .='<a href="#!!"> ' .($i+1)." </a>";
        }
        return $ress;
    }

    function GetCategory()
    {
        $connection = new CConnectDataBase();
        $connection = $connection->Connection;

        $sql = "SELECT * FROM category WHERE `id_parent`=0 ORDER BY NAME ASC "   ;
        $query = mysqli_query($connection, $sql);
        if(mysqli_num_rows($query) == 0)	{
            return false;
        }

        while ($myrow = mysqli_fetch_array($query)) {
            $categoryarray[] = array(
                'id' => ($myrow["id"]),
                'id_parent' => ($myrow["id_parent"]),
                'name' => ($myrow["name"]),
                'alias' => ($myrow["alias"])
                );
        }
        mysqli_close($connection);
        return $categoryarray;
    }

    function SearchSite($name,$slider,$sliderTo)
    {


        $connection = new CConnectDataBase();
        $connection = $connection->Connection;
        $query = mysqli_query($connection, "set names utf8");
// SELECT * FROM `goods` WHERE `name` LIKE '%ш%' AND `price` between 300 and 1000

        if($slider>0){
            $sql = "SELECT * FROM `goods` WHERE `name` LIKE '%$name%' AND price BETWEEN '$slider' AND '$sliderTo'  ";
        }        
        else
        {
            $sql = "SELECT * FROM `goods` WHERE `name` LIKE '%$name%' ";
        

        }    

        error_log($sql);

        $query = mysqli_query($connection, $sql);
        if (mysqli_num_rows($query) == 0) 
        {
            return false;
        }
        while ($myrow = mysqli_fetch_array($query)) 
        {
            $goodsarray[] = array(
                'id' => ($myrow["id"]),
                'name' => ($myrow["name"]),
                'category' => ($myrow["category"]),
                'price' => ($myrow["price"]),
                'images' => ($myrow["images"])
                );
        }
        mysqli_close($connection);
        return $goodsarray;
    }
}
