<?php  
      include "../fungsi/koneksi.php";
      
      if (isset($_GET['aksi']) && isset($_GET['id'])) {
              //die($id = $_GET['id']);
              $id = $_GET['id'];        
      
              if ($_GET['aksi'] == 'edit') {
                  header("location:?p=edituser&id=$id");
              } else if ($_GET['aksi'] == 'hapus') {
                  header("location:?p=hapususer&id=$id");
              } 
          }
          
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE level!='manager' AND level!='upengadaan' ORDER BY level DESC");	
      
?>


<!-- Main content -->
<section class="content">
<!-- Small boxes (Stat box) -->
	<div class="row">
		<div class="col-sm-12">
			 <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Pengolahan User</h3>
                </div>                
                <div class="box-body">
               <div class="row">
                    <div class="col-md-2">
                    <a class="btn btn-primary" data-toggle="modal" href="#tambahuser"><i class="icon fa fa-plus"></i> Tambah User</a> 
                    </div>
                </div>                  
                	<div class="table-responsive">
                		<table class="table text-center" id="user">
                			<thead  > 
	                			<tr>
	                				<th>No</th>
	                				<th>Username</th>
                                    <th>Nama</th>	                					                				
                                    <th>Jabatan</th>
                                    <th>Bagian</th>
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
                						<td> <?= $row['username']; ?> </td>
                                        <td> <?= $row['nama']; ?> </td>                                        
                						<td> <?= $row['jabatan']; ?> </td>
                                        <td> <?= $row['bagian']; ?> </td>
                						
                                         <td>
                                            <a href="?p=user&aksi=edit&id=<?= $row['id_user']; ?>"><span data-placement='top' data-toggle='tooltip' title='Edit'><button  class="btn btn-info">Edit</button></span></a>                     

                                            <a href="?p=user&aksi=hapus&id=<?= $row['id_user']; ?>"><span data-placement='top' data-toggle='tooltip' title='Hapus'><button  class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button></span></a>                    
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

</section>

<script>
    $(function(){
        $("#user").DataTable({
             "language": {
            "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
            "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script> 

<!-- Modal Tambah User-->
<?php
if(isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
  $password = md5($_POST['password']);
  $level = $_POST['level'];
  $jabatan = $_POST['jabatan'];
  $bagian = $_POST['bagian'];

  $query = mysqli_query($koneksi, "INSERT INTO user VALUES ('', '$nama', '$username', '$password', '$level','$jabatan','$bagian') ");        
  if ($query) {
      header("location:index.php?p=user");
  } else {
      echo 'gagal : ' . mysqli_error($koneksi);
  }
}
?>
                    
<div id="tambahuser" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="text-center"><b>Data User</b></h4>
</div>
<div class="modal-body">
<div class="row">
                <form method="post"  action="" class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group ">
                            <label for="nama" class="col-sm-offset-1 col-sm-3 control-label">Nama</label>
                            <div class="col-sm-4">
                                <input  required type="text"  class="form-control" name="nama">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="username" class="col-sm-offset-1 col-sm-3 control-label">Username</label>
                            <div class="col-sm-4">
                                <input  required type="text"  class="form-control" name="username">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="paswword"class="col-sm-offset-1 col-sm-3 control-label">Password</label>
                            <div class="col-sm-4">
                                <input required type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="jabatan" class="col-sm-offset-1 col-sm-3 control-label">Jabatan</label>
                            <div class="col-sm-4">
                                <input  required type="text"  class="form-control" name="jabatan">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="bagian" class="col-sm-offset-1 col-sm-3 control-label">Bagian</label>
                            <div class="col-sm-4">
                                <input  required type="text"  class="form-control" name="bagian">
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label id="tes"for="nama_brg" class="col-sm-offset-1 col-sm-3 control-label">Level</label>
                            <div class="col-sm-4">
                                <select required name="level" class="form-control">
                                    <option >--Pilih Level--</option>
                                    <option value="produksi">Produksi</option>
                                    <option value="admin_gudang">Admin Gudang</option>
                                </select>
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
<div class="modal-footer">
</div>
</div>
    </div>
        </div>
