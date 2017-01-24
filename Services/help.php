<?php 

class InDataBase
{

	function AddWishList($idgoods, $iduser)
	{
		$connection = new CConnectDataBase();
		$connection = $connection->Connection;
		$sql = "SELECT `id` FROM `wishlist` WHERE `idgoods` ='" . $idgoods . "' AND `iduser`='" . $iduser . "'";
		$query = mysqli_query($connection, $sql);
		if (mysqli_num_rows($query) > 0) {
			return "Такой товар уже есть в списке желаемых покупок!";
		}
		$sql = "INSERT INTO `wishlist` 
		(`id`,`idgoods`,`iduser`) VALUES 
		(NULL,'" . $idgoods . "','" . $iduser . "')";

		$query = mysqli_query($connection, $sql);

		if ($query) {
			return true;
		} else {
			return false;
		}
		mysqli_close($connection);
	}

	function DisplayWishList($iduser)
	{
		$connection = new CConnectDataBase();
		$connection = $connection->Connection;
		$sql = "SELECT goods.name as name FROM `wishlist` 
		LEFT JOIN `goods` ON `wishlist.idgoods` = `goods.id` 
		WHERE `iduser`='" . $iduser . "'";

		$query = mysqli_query($connection, $sql);

		while ($myrow = mysqli_fetch_array($query)) {
			$goodsarray[] = array(
				'name' => ($myrow["name"])
				);
		}
		mysqli_close($connection);
		return $goodsarray;
	}

	function DelWishList($iduser, $idgoods)
	{
		$connection = new CConnectDataBase();
		$connection = $connection->Connection;
		$sql = "DELETE FROM `wishlist` WHERE `iduser` = '" . $iduser . "' AND `idgoods`= '" . $idgoods . "'";

		$query = mysqli_query($connection, $sql);
		if ($query) {
			return "Товар удален";
		} else {
			return false;
		}
		mysqli_close($connection);
	}

	function SearchSite($name)
	{
		$connection = new CConnectDataBase();
		$connection = $connection->Connection;
		$query = mysqli_query($connection, "set names utf8");

		$sql = "SELECT `id` FROM `goods` WHERE `name` LIKE '%$name%'";
		error_log($sql);

		$query = mysqli_query($connection, $sql);
		while ($myrow = mysqli_fetch_array($query)) {
			$goodsarray[] = array(
				'id' => ($myrow["id"])
				);
		}
		mysqli_close($connection);
		return $goodsarray;
	}

	function AddTrash($iduser, $idgoods, $count)
	{
		$connection = new CConnectDataBase();
		$connection = $connection->Connection;

		$sql = "SELECT `price` FROM `goods` WHERE `id`='" . $idgoods . "'";
		$query = mysqli_query($connection, $sql);
		$price = mysqli_fetch_assoc($query);
		$prices = number_format($price["price"], 2, '.', ' ');
		$totalprice = $prices * $count;

		$sql = "INSERT INTO `trash` 
		(`id`,`iduser`,`idgoods`,`price`,`count`,`totalprice`) VALUES 
		(NULL,'" . $iduser . "','" . $idgoods . "','" . $prices . "','" . $count . "','" . $totalprice . "')";
		$query = mysqli_query($connection, $sql);
		if ($query) {
			return "Товар добавлен";
		} else {
			return false;
		}

		mysqli_close($connection);

	}

	function DelTrash($iduser, $idgoods)
	{
		$connection = new CConnectDataBase();
		$connection = $connection->Connection;

		$sql = "DELETE FROM `trash` WHERE `iduser`='" . $iduser . "' AND `idgoods`='" . $idgoods . "' ";
		$query = mysqli_query($connection, $sql);
		if ($query) {
			return "Товар удален";
		} else {
			return false;
		}
		mysqli_close($connection);
	}

	function BaseArticle()
	{
		$ftext="";
		$connection = new CConnectDataBase();
		$connection = $connection->Connection;
		$sql = "SELECT * FROM articles ";
		$query = mysqli_query($connection, $sql);
		if(mysqli_num_rows($query) == 0)	{
			return false;
		}

		while ($myrow = mysqli_fetch_array($query)) {
			$articlesarray[] = array(
				'id' => ($myrow["id"]),
				'name' => ($myrow["name"]),
				'text' => ($myrow["text"])

				);
		}
		mysqli_close($connection);
		return $articlesarray;
	}

	function UpdateName($id,$name)
	{
		$connection = new CConnectDataBase();
		$connection = $connection->Connection;
		$sql = "Update goods SET name='$name' WHERE `id` = '" . $id . "'";
		$query = mysqli_query($connection, $sql);
        //Если вставка прошла успешно
		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
		error_log('success registration');
		mysqli_close($connection);
	}

	function UpdatePrice($id,$price)
	{
		$connection = new CConnectDataBase();
		$connection = $connection->Connection;
		$sql = "Update goods SET price='$price' WHERE `id` = '" . $id . "'";
		$query = mysqli_query($connection, $sql);
        //Если вставка прошла успешно
		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
		error_log('success registration');
		mysqli_close($connection);
	}

	function ExportExcel()
	{	
		$connection = new CConnectDataBase();
		$connection = $connection->Connection;
		if (!defined("ExcelExport"))
		{
			define("ExcelExport", 1);

			class ExportToExcel
			{
				var $xlsData = "";
				var $fileName = "";
				var $countRow = 0;
				var $countCol = 0;
            var $totalCol = 2;//общее число  колонок в Excel

            //конструктор класса
            function __construct()
            {
            	$this->xlsData = pack("ssssss", 0x809, 0x08, 0x00, 0x10, 0x0, 0x0);
            }

            // Если число
            function RecNumber($row, $col, $value)
            {
            	$this->xlsData .= pack("sssss", 0x0203, 14, $row, $col, 0x00);
            	$this->xlsData .= pack("d", $value);
            	return;
            }

            //Если текст
            function RecText($row, $col, $value)
            {
            	$len = strlen($value);
            	$this->xlsData .= pack("s*", 0x0204, 8 + $len, $row, $col, 0x00, $len);
            	$this->xlsData .= $value;
            	return;
            }

            // Вставляем число
            function InsertNumber($value)
            {
            	if ($this->countCol == $this->totalCol) {
            		$this->countCol = 0;
            		$this->countRow++;
            	}
            	$this->RecNumber($this->countRow, $this->countCol, $value);
            	$this->countCol++;
            	return;
            }

            // Вставляем текст
            function InsertText($value)
            {
            	if ($this->countCol == $this->totalCol) {
            		$this->countCol = 0;
            		$this->countRow++;
            	}
            	$this->RecText($this->countRow, $this->countCol, $value);
            	$this->countCol++;
            	return;
            }

            // Переход на новую строку
            function GoNewLine()
            {
            	$this->countCol = 0;
            	$this->countRow++;
            	return;
            }

            //Конец данных
            function EndData()
            {
            	$this->xlsData .= pack("ss", 0x0A, 0x00);
            	return;
            }

            // Сохраняем файл
            function SaveFile($fileName)
            {
            	$this->fileName = $fileName;
            	$this->SendFile();

            }

            // Отправляем файл
            function SendFile()
            {
            	$this->EndData();
               // header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
               // header("Cache-Control: no-store, no-cache, must-revalidate");
               // header("Pragma: no-cache");
               // header("Content-type: application/x-msexcel");
            	header("Content-Disposition: attachment; fileName=$this->fileName.xls");
            	print $this->xlsData;
            }
          }
        }
    $filename = 'Файл_с_id_' . $id; // задаем имя файла
    $excel = new ExportToExcel(); // создаем экземпляр класса

    $sql = "SELECT * FROM goods ";
    $rez = mysqli_query($connection, $sql);

    $excel->InsertText('id');
    $excel->InsertText('login');
    $excel->GoNewLine();
    While ($row = mysqli_fetch_assoc($rez))
     {
    	$excel->InsertNumber($row['id']);
    	$excel->InsertText($row['login']);
    	$excel->GoNewLine();
     }
    $excel->SaveFile($filename);
     }

}






?>