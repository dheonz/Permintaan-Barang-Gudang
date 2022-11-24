<?php ob_start();
	include "../fungsi/fungsi.php";
  include "../fungsi/koneksi.php";

date_default_timezone_set('Asia/Jakarta');// change according timezone
$currentTime = date( 'Y-m-d', time () );
$currentTime1 = date( 'm/Y', time () );



 ?>
<!-- Setting CSS bagian header/ kop -->
<style type="text/css">
  table.page_header {width: 1020px; border: none; background-color: #3C8DBC; color: #fff; border-bottom: solid 1mm #AAAADD; padding: 2mm }
  table.page_footer {width: 1020px; border: none; background-color: #3C8DBC; border-top: solid 1mm #AAAADD; padding: 2mm}
  h1 {color: #000033}
  h2 {color: #000055}
  h3 {color: #000077}
</style>
<!-- Setting Margin header/ kop -->
  <!-- Setting CSS Tabel data yang akan ditampilkan -->
  <style type="text/css">
  .tabel2 {
    border-collapse: collapse;
    margin-left: 20px;    
  }
  .tabel2 th, .tabel2 td {
      padding: 5px 5px;
      border: 1px solid #959595;
  }

   div.kanan {
     width:300px;
	 float:right;
     margin-left:250px;
     margin-top:-140px;
  }

  div.kiri {
	  width:300px;
	  float:left;
	  margin-left:20px;
	  display:inline;
  }
  
  </style>
<table>
    <tr>
      <th rowspan="3"><img src="../gambar/kop.png" style="width:150px;height:80px" /></th>
    <th></th>
    <td align="right;" style="width: 575px;"><font style="font-size: 14px"><b>PT. SHARP ELECTRONIC INDONESIA</b></font>
    <font style="font-size: 10px"><br>Kawasan Industri Karawang International Industry City<br>Lot F3. Jalan Tol Jakarta - Cikampek KM. 47<br>Karawang - 413761, Jawa Barat - Indonesia<br> Phone : (62-21) 8901512 (Hunting), (62-267) 644675 - 76 <br> Fax : (0711) 355180</font></td>
    </tr>
  </table>
  <hr>
  <p align="center" style="font-size: 18px;"><b><u>LAPORAN PERMINTAAN BARANG</u></b><br>
No : ....../Sharp-Adm/BP/<?= $currentTime1; ?></p><br><br>
  <?php
       $from=$_POST['from'];
       $end=$_POST['end'];
       $query = mysqli_query($koneksi, "SELECT tgl_keluar FROM pengeluaran WHERE (tgl_keluar BETWEEN '$from' AND '$end')"); 
  ?>
  <p style="color: black; text-align: left;"><b>Periode Cetak : <?=  tanggal_indo($from); ?> s/d <?=  tanggal_indo($end); ?></b></p>
  <table class="tabel2">
    <thead>
      <tr>
        <td style="text-align: center; "><b>No.</b></td>
		<td style="text-align: center; "><b>Tanggal Keluar</b></td>
        <td style="text-align: center; "><b>Akun</b></td>
        <td style="text-align: center; "><b>Pastcode</b></td>
        <td style="text-align: center; "><b>Nama Barang</b></td>
		<td style="text-align: center; "><b>Satuan</b></td>
        <td style="text-align: center; "><b>Jumlah</b></td>
      </tr>
    </thead>
    <tbody>
      <?php
       $from=$_POST['from'];
       $end=$_POST['end'];
       $query = mysqli_query($koneksi, "SELECT pengeluaran.kode_brg, unit, nama_brg, jumlah, satuan, tgl_keluar FROM pengeluaran INNER JOIN stokbarang ON pengeluaran.kode_brg = stokbarang.kode_brg WHERE (tgl_keluar BETWEEN '$from' AND '$end')"); 
      $i   = 1;
      while($data=mysqli_fetch_array($query))
      {
      ?>
      <tr>
        <td style="text-align: center; width=15px;"><?php echo $i; ?></td>
		<td style="text-align: center; width=70px;"><?php echo tanggal_indo($data['tgl_keluar']); ?></td>
        <td style="text-align: center; width=70px;"><?php echo $data['unit']; ?></td>        
        <td style="text-align: center; width=120px;"><?php echo $data['kode_brg']; ?></td>
        <td style="text-align: left; width=120px;"><?php echo $data['nama_brg']; ?></td>
		<td style="text-align: center; width=70px;"><?php echo $data['satuan']; ?></td> 
        <td style="text-align: center; width=50px;"><?php echo $data['jumlah']; ?></td>                   
      </tr>
    <?php
    $i++;
    }
    ?>
    </tbody>
  </table>
  <br>
  <p style="margin: 0 560;">Karawang, <?=  tanggal_indo($currentTime); ?></p>
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
 require '../assets/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

    $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(10, 10, 4, 10));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->Output('Laporan.pdf');
?>
