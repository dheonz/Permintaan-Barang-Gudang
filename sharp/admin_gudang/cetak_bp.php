<?php 
  
  include "../fungsi/koneksi.php";
  include "../fungsi/fungsi.php";

  ob_start(); 
  $id  = isset($_GET['id']) ? $_GET['id'] : false;


  $unit = $_GET['unit'];
  $tgl= $_GET['tgl'];
    
  date_default_timezone_set('Asia/Jakarta');// change according timezone
  $currentTime = date( 'd-m-Y', time () );
  $currentTime1 = date( 'm/Y', time () );
?>
<html>
<head>
  <title>Cetak BPB</title>
<!-- Setting CSS bagian header/ kop -->
<style type="text/css">
  table.page_header {width: 1020px; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
  table.page_footer {width: 1020px; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}
  
 
</style>
<!-- Setting Margin header/ kop -->
  <!-- Setting CSS Tabel data yang akan ditampilkan -->
  <style type="text/css">
  .tabel2 {
    border-collapse: collapse;
    margin-left: 145px;
    
  }
  .tabel2 th, .tabel2 td {
      padding: 5px 5px;
      border: 1px solid #000;

  }

   table.isi {
    margin: 0 150px;

  }

  .isi td {
    padding: 15px 15px;
  }

  div.kanan {
     width:300px;
	 float:right;
     margin-left:250px;
     margin-top:-170px;
  }

  div.tengah {
    position: absolute;
     bottom: 440px;
     right: 330px;
     
  }

  div.kiri {
	  width:300px;
	  float:left;
	  margin-left:20px;
	  display:inline;
  }
  div.kiri-kanan {
	  float:center;
	  margin-left:20px;
    margin-right:50px;
	  display:inline;
  }
  </style>
  </head>
  <body>
  <table>
    <tr>
      <th rowspan="3"><img src="../gambar/kop.png" style="width:150px;height:80px" /></th>
    <th></th>
    <td align="right;" style="width: 575px;"><font style="font-size: 14px"><b>PT. SHARP ELECTRONIC INDONESIA</b></font>
    <font style="font-size: 10px"><br>Kawasan Industri Karawang International Industry City<br>Lot F3. Jalan Tol Jakarta - Cikampek KM. 47<br>Karawang - 413761, Jawa Barat - Indonesia<br> Phone : (62-21) 8901512 (Hunting), (62-267) 644675 - 76 <br> Fax : (0711) 355180</font></td>
    </tr>
  </table>
  <hr>
  <br><br>
  <p align="center" style="font-size: 16px;"><b><u>BUKTI PENYERAHAN BARANG</u></b><br>No: ....../SHARP-Adm/BP/<?= $currentTime1; ?></p><br><br>
  
 
  <div class="isi" style="margin: 0 -145;">
   <table class="tabel2">
    <thead>
      <tr>
        <td style="text-align: center; "><b>No.</b></td>
        <td style="text-align: center; "><b>Tanggal</b></td>
        <td style="text-align: center; "><b>Jam Kerja</b></td>        
        <td style="text-align: center; "><b>Pastcode</b></td>
        <td style="text-align: center; "><b>Nama Barang</b></td>
		<td style="text-align: center; "><b>Satuan</b></td> 
        <td style="text-align: center; "><b>Jumlah</b></td>                                        
      </tr>
    </thead>
    <tbody>
      <?php
       $query = mysqli_query($koneksi, "SELECT permintaan.nama_karyawan, permintaan.kode_brg, unit, nama_brg, jumlah, satuan, tgl_permintaan, sift FROM permintaan INNER JOIN stokbarang ON permintaan.kode_brg = stokbarang.kode_brg  WHERE unit='$unit' AND  status=1 AND tgl_permintaan='$tgl' "); 
      $i   = 1;
      while($data=mysqli_fetch_array($query))
      {
      ?>
      <tr>
        <td style="text-align: center;"><?php echo $i; ?></td>
        <td style="text-align: center;"> <?php echo tanggal_indo($data['tgl_permintaan']); ?> </td>  
        <td style="text-align: center;"><?php echo $data['sift']; ?></td>             
        <td style="text-align: center;"><?php echo $data['kode_brg']; ?></td>
        <td style="text-align: left;"><?php echo $data['nama_brg']; ?></td>
		<td style="text-align: center;"><?php echo $data['satuan']; ?></td>  
    <td style="text-align: center;"><?php echo $data['jumlah']; ?></td>                            
  </tr>
  <?php
    $i++;
  }
  ?>
    </tbody>
  </table>
  <br>
  </div>
  <?php 
  $query2 = mysqli_query($koneksi, "SELECT permintaan.nama_karyawan FROM permintaan WHERE unit='$unit' AND  status=1 AND tgl_permintaan='$tgl' ");  
  $data2 = mysqli_fetch_assoc($query2);
  ?>

  <p>Terhitung tanggal Permintaan Barang: <b> <?=  tanggal_indo($tgl); ?></b> telah dikeluarkan serta serah terima barang berupa seperti yang tersebut di atas.</p>
  <p>Karyawan yang mengambil barang ke Gudang : <?php echo $data2['nama_karyawan']; ?></p>

  <br>
  <?php 
      $query2 = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$unit' ");
      if ($query2){                
        $data = mysqli_fetch_assoc($query2);

      } else {
        echo 'gagal';
      }
   ?>
   <br><br>
   <div class="kiri">
      <p><br>Leader Produksi</p>
      <br>
      <br>
      <br>
      <p><b><u><?= $data['nama'] ?></u><br>NIK : 197810170371</b></p>
  </div>
  <div class="tengah">
      <p><br>Stock Keeper</p>
      <br>
      <br>
      <br>
      <p><b><u>M. Azharuddin, S.T</u><br>NIK : 197810170371</b></p>
  </div>
  <div class="kanan">
      <p>Karawang, <?=  $currentTime; ?><br><br>Admin Gudang </p>
      <br>
      <br>
      <br>
      <b><p><u>Irwan Saputra, A.Md</u></p></b>
  </div>
    </body>
    </html>
<!-- Memanggil fungsi bawaan HTML2PDF -->
<?php
$html = ob_get_contents();
ob_get_clean();

require '../assets/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

   $html2pdf = new HTML2PDF('P', 'letter', 'en', false, 'UTF-8', array(10, 10, 4, 10));
   $html2pdf->pdf->SetDisplayMode('fullpage');
   $html2pdf->writeHTML($html);
   $html2pdf->Output('BP.pdf');

?>