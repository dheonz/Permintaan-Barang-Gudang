 
<?php 
  
    $page = isset($_GET['p']) ? $_GET['p'] : "";

            if ($page=="") {
        include_once "main.php";
    } else if ($page=="datapesanan") {
        include_once "pesanan/datapesanan.php";
	} else if($page == "detil"){
        include_once "pesanan/detilpesan.php";
    }  else if ($page=="barang") {
        include_once "stok/barang.php";
    }  else if ($page=="barang2") {
        include_once "stok/barang2.php";
    }  else if ($page=="edit") {
        include_once "stok/editbarang.php";
    } else if ($page=="hapus") {
        include_once "stok/hapusbarang.php";
    } else if ($page=="tambahbarang") {
        include_once "stok/tambahbarang.php";
    } else if ($page=="cetakstok") {
        include_once "halcetak.php";
    } else if ($page=="user") {
        include_once "user/user.php";
    } else if ($page=="edituser") {
        include_once "user/edituser.php";
    } else if ($page=="tambahuser") {
        include_once "user/tambahuser.php";
    } else if ($page=="hapususer") {
        include_once "user/hapususer.php";
    } else if ($page=="pesanan") {
        include_once "pesanan/pesanan.php";
    } else if ($page=="editpesan") {
        include_once "pesanan/editpesan.php";
    } else if ($page=="setuju") {
        include_once "pesanan/setuju.php";        
    } else if ($page=="tidaksetuju") {
        include_once "pesanan/tidaksetuju.php";
    } else if ($page=="disetujui") {
        include_once "pesanan/disetujui.php";
    } else if($page == "datapesananmasuk"){
        include_once "pesanan/datapesananmasuk.php";
    } else if($page == "detilpesanmasuk"){
        include_once "pesanan/detilpesanmasuk.php";
    } else if($page == "detilpesanan"){
        include_once "detilpesanan.php";
    } else if($page == "edit_proses"){
        include_once "stok/edit_proses.php";
    } else if($page == "laporan"){
        include_once "pesanan/laporan.php";
    } else if($page == "add-proses"){
        include_once "stok/add-proses.php";
    }
 ?>
 
