<?php  

	if (isset($_SESSION['login'])) {
		if ($_SESSION['level'] == "produksi") {
			header("location:produksi/index.php");
		} else if ($_SESSION['level'] == "admin_gudang"){
			header("location:admin_gudang/index.php");
		} else {
			header("location:index.php");
		}
	}

?>