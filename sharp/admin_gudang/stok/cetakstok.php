<?php ob_start();
	include "../../fungsi/fungsi.php";
  include "../../fungsi/koneksi.php";

date_default_timezone_set('Asia/Jakarta');// change according timezone
$currentTime = date( 'Y-m-d', time () );



 ?>
<!-- Setting CSS bagian header/ kop -->
<style type="text/css">
  table.page_header {width: 1020px; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
  table.page_footer {width: 1020px; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}
  h1 {color: #000033}
  h2 {color: #000055}
  h3 {color: #000077}
</style>
<!-- Setting Margin header/ kop -->
  <!-- Setting CSS Tabel data yang akan ditampilkan -->
  <style type="text/css">
  .tabel2 {
    border-collapse: collapse;
    margin-left: 35px;
  }
  .tabel2 th, .tabel2 td {
      padding: 5px 5px;
      border: 1px solid #000;
  }

    div.kanan {
     width:300px;
	 float:right;
     margin-left:210px;
     margin-top:-140px;
  }

  div.kiri {
	  width:300px;
	  float:left;
	  margin-left:30px;
	  display:inline;
  }
  
  </style>
  <!-- Mengambil Data Dari Database ke Tabel data yang akan ditampilkan -->
  <table>
  <?php 
      $id = isset($_GET['idjenis']) ? $_GET['idjenis'] : "";
      switch($id) {
        case 1 :
            $barang = "Assesories";
             break;
        case 2 :
            $barang = "Oli/Pelumas";
            break;
        case 3 :
            $barang = "Spare Part";
            break;
        default:
            $barang = "";
      }

   ?>

    <tr>
      <th rowspan="3"><img src="../../gambar/kop.png" style="width:150px;height:80px"></th>
    <th></th>
    <td align="right;" style="width: 575px;"><font style="font-size: 14px"><b>PT. SHARP ELECTRONIC INDONESIA</b></font>
    <font style="font-size: 10px"><br>Kawasan Industri Karawang International Industry City<br>Lot F3. Jalan Tol Jakarta - Cikampek KM. 47<br>Karawang - 413761, Jawa Barat - Indonesia<br> Phone : (62-21) 8901512 (Hunting), (62-267) 644675 - 76 <br> Fax : (0711) 355180</font></td>
    </tr>
  </table>
  <hr>
  <p align="center" style="font-weight: bold; font-size: 18px;"><u>LAPORAN DATA STOK BARANG </u></p>
  <p style="color: black; text-align: left;"><b>Cetak Type: <?= $barang;  ?></b></p>
  <table class="tabel2">
    <thead>
      <tr>
        <td style="text-align: center; "><b>No.</b></td>
        <td style="text-align: center; "><b>Pastcode</b></td>
        <td style="text-align: center; "><b>Nama Barang</b></td>
	    	<td style="text-align: center; "><b>Satuan</b></td>
        <td style="text-align: center; "><b>Stok Awal</b></td>
        <td style="text-align: center; "><b>Keluar</b></td>
        <td style="text-align: center; "><b>Sisa</b></td>        
      </tr>
    </thead>
    <tbody>

      <?php    
      $sql = mysqli_query($koneksi, "SELECT * FROM stokbarang WHERE id_jenis = '$id' ");  
      $i   = 1;
      while($data=mysqli_fetch_array($sql))
      {
      ?>

      <tr>
        <td style="text-align: center; width=15px;"><?php echo $i; ?></td>
        <td style="text-align: center; width=80px;"><?php echo $data['kode_brg']; ?></td>
        <td style="text-align: center; width=120px;"><?php echo $data['nama_brg']; ?></td>
		    <td style="text-align: center; width=70px;"><?php echo $data['satuan']; ?></td> 
        <td style="text-align: center; width=70px;"><?php echo $data['stok']; ?></td>
        <td style="text-align: center; width=70px;"><?php echo $data['keluar']; ?></td>
        <td style="text-align: center; width=70px;"><?php echo $data['sisa']; ?></td>       
      </tr>

    <?php
    $i++;
    }
    ?>

    </tbody>
  </table>
    <br><br><br>
  <p style="margin: 0 540;">Karawang, <?=  tanggal_indo($currentTime); ?></p>
  <div class="kiri">
      <p>Mengetahui :<br>Leader Gudang</p>
      <br>
      <br>
      <br>
      <p><b><u>M. Azharuddin, S.T</u><br>NIK : 197810170371</b></p>
  </div>

  <div class="kanan">
      <p>Mengetahui :<br>Manajer Gudang </p>
      <br>
      <br>
      <br>
      <p><b><u>Irwan Saputra, A.Md</u><br>NIK : 198108300482</b></p>
  </div>

<!-- Memanggil fungsi bawaan HTML2PDF -->
<?php
$content = ob_get_clean();
 require '../../assets/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

    $html2pdf = new HTML2PDF('P', 'Letter', 'en', false, 'UTF-8', array(10, 10, 4, 10));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->Output('Laporan_stok_Barang.pdf');

?>