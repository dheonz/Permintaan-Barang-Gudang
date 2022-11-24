<?php  
    include "../fungsi/koneksi.php";
	include "../fungsi/fungsi.php";
    
    
    
    $query = mysqli_query($koneksi, "SELECT MAX(kode_brg) from stokbarang");
    $kode_brg = mysqli_fetch_array($query);    
    if ($kode_brg) {
        
        $nilaikode = substr($kode_brg[0], 2);
        
        $kode = (int) $nilaikode;
        
        //setiap kode ditambah 1
        $kode = $kode + 1;
        $kode_otomatis = "SHARP".str_pad($kode, 4, "0", STR_PAD_LEFT);                   
        
        
    } else {
        $kode_otomatis = "SHARP001";
    }
	
    
    if (isset($_GET['aksi']) && isset($_GET['id'])) {
        //die($id = $_GET['id']);
        $id = $_GET['id'];
        echo $id;
        
        if ($_GET['aksi'] == 'edit') {
            header("location:?p=edit&id=$id");
        } else if ($_GET['aksi'] == 'hapus') {
            header("location:?p=hapus&id=$id");
        } 
    }
    
    if(isset($_GET['id_jenis'])){
        $id_jenis = $_GET['id_jenis'];
        $query = mysqli_query($koneksi, "SELECT * FROM stokbarang WHERE id_jenis='$id_jenis' ");    
    } else {
        $query = mysqli_query($koneksi, "SELECT * FROM stokbarang");        
    }

    ?>
<!-- Main content -->
<section class="content">
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-sm-12">
			 <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Pengolahaan Stok Barang </h3>
            </div>              
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-2">
                        <a class="btn btn-primary" data-toggle="modal" href="#tambahstok"><i class="icon fa fa-plus"></i> Tambah Data Stok</a><br>						
                    </div>
                    <div class="col-md-2 pull-right">
                        <a class="btn btn-block btn-success" data-toggle="modal" href="#cetakstok"><i class="icon fa fa-print"></i> Cetak Stok Barang</a><br>						
                    </div>               	
                </div>        
            <div class="box-body">                                      
                <div class="table-responsive">
                <table class="table text-center"  id="barang" class="table table-bordered table-hover">
                            <thead  > 
                                <tr>
                                <th>No</th>	  
									<th>Tanggal Masuk</th>									
                                    <th>Pastcode</th>        				
	                				<th>Nama Barang</th>
									<th>Satuan</th>
	                				<th>Stok Awal</th>
                                    <th>Keluar</th>
                                    <th>Sisa</th>
                                    
	                				<th>Aksi</th>	           
	                			</tr>
                			</thead>
                			<tbody>
                				<tr>
                					<?php 
                						$no =1 ;
                						if (mysqli_num_rows($query)) {
                							while($row=mysqli_fetch_assoc($query)):

                					 ?>
                						<td> <?= $no; ?> </td>      
										<td> <?= tanggal_indo($row['tgl_masuk']); ?> </td>
                                        <td> <?= $row['kode_brg']; ?> </td>          					
                						<td> <?= $row['nama_brg']; ?> </td>
										<td> <?= $row['satuan']; ?> </td>
                						<td> <?= $row['stok']; ?> </td>
                                        <td> <?= $row['keluar']; ?> </td>                                        
                                        <td> <?= $row['sisa']; ?> </td>                                        
                                        
                						<td>
                                            <a href="?p=barang&aksi=edit&id=<?= $row['kode_brg']; ?>"><span data-placement='top' data-toggle='tooltip' title='Update'><button  class="btn btn-info">Update</button></span></a>                     

                                            <a href="?p=barang&aksi=hapus&id=<?= $row['kode_brg']; ?>"><span data-placement='top' data-toggle='tooltip' title='Hapus'><button  class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus ?')">Hapus</button></span></a>                    
                                        </td>              					
                				</tr>
                			<?php $no++; endwhile; } ?>
                			</tbody>
                		</table>
                	</div>                	
                </div>
            </div>
		</div>
	</div>
</div>
</section>
<script>
    $(function(){
        $("#barang").DataTable({
             "language": {
            "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
            "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>
<script>
$(document).ready(function(){
    $('.tanggal').datepicker({
        format:"yyyy-mm-dd",
        autoclose:true
    });
});

</script>
    
<!-- Modal Tambah Stok --> 
<div id="tambahstok" class="modal fade" role="dialog">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="text-center"><b>Tambah Stok Barang</b></h4>
        </div>
      <div class="modal-body">
        <div class="row">
            <form method="post"  action="index.php?p=add-proses" class="form-horizontal">
               <div class="box-body">
                    <div class="form-group">
                       <label for="jumlah" class="col-sm-offset-1 col-sm-3 control-label">Tanggal Masuk</label>
                         <div class="col-sm-4">
                            <input type="text" class="form-control tanggal" name="tgl_masuk">
                        </div>
                    </div>
                        <div class="form-group ">
                            <label for="nama_brg" class="col-sm-offset-1 col-sm-3 control-label">Pastcode</label>
                            <div class="col-sm-4">
                                <input type="text" value="<?= $kode_otomatis; ?>" class="form-control" name="kode_brg" readonly>
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="jenis_brg" class="col-sm-offset-1 col-sm-3 control-label">Jenis Barang </label>
                            <div class="col-sm-4">
                                <select id="jenis_brg" required="isikan dulu" class="form-control" name="id_jenis">
                                <option value="">--Pilih Jenis Barang --</option>
                                <?php  
                                    
                                    $queryJenis = mysqli_query($koneksi, "select * from jenis_barang");
                                    if (mysqli_num_rows($queryJenis)) {
                                        while($row=mysqli_fetch_assoc($queryJenis)):
                                    ?>                                        
                                        <option value="<?= $row['id_jenis']; ?>"><?= $row['jenis_brg']; ?></option>
                                    <?php endwhile; } ?>                                      
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label id="tes"for="nama_brg" class="col-sm-offset-1 col-sm-3 control-label">Nama Barang </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nama_brg">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jumlah" class="col-sm-offset-1 col-sm-3 control-label">Satuan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="satuan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jumlah" class="col-sm-offset-1 col-sm-3 control-label">Jumlah</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="jumlah">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="suplier" class="col-sm-offset-1 col-sm-3 control-label">Nama Suplier</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="suplier">
                            </div>
                    </div>
                </div>
            </div>
                        <div class="form-group">
                            <input type="submit" name="simpan" class="btn btn-primary col-sm-offset-4 " value="Simpan" > 
                            &nbsp;
                            <input type="reset" class="btn btn-danger" value="Reset">                                                                              
                        </div>
                     </div>    
                </form>
                </div>    
        </div>
    </div>
</div>
<div class="modal-footer">
            </div>    
        </div>
    </div>
</div>

<!-- Modal Cetak Stok-->
<div id="cetakstok" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- konten modal-->
			<div class="modal-content">
				<!-- heading modal -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="text-center"><b>Cetak Sesuai Jenis Barang </b></h4>
				</div>
				<!-- body modal -->
				<div class="modal-body">
                        <ul class="nav">
                                    <li><a type="button" class="btn bg-purple margin" target="_blank" href="stok/cetakstok.php?idjenis=1" >Cetak Assesories</a></li>
                                    <li><a type="button" class="btn bg-navy margin" target="_blank" href="stok/cetakstok.php?idjenis=2" >Cetak Oli/Pelumas</a></li>
                                    <li><a type="button" class="btn bg-olive margin" target="_blank" href="stok/cetakstok.php?idjenis=3" ></i>Cetak Sparepart</a></li>
                                    <li><a type="button" class="btn bg-maroon margin" target="_blank" href="stok/cetak_stok_semua.php" ></i>Cetak Semua Stok</a></li>
                        </ul>    
                        </div>                	
				<!-- footer modal -->
				<div class="modal-footer">
			</div>
		</div>
	</div>