
<?php  
    include "../fungsi/koneksi.php";
	include "../fungsi/fungsi.php";

    if (isset($_GET['aksi']) && isset($_GET['id'])) {
        //die($id = $_GET['id']);
        $id = $_GET['id'];
        echo $id;

        if ($_GET['konfirmasi'] == 'edit') {
            header("location:?p=edit&id=$id");
        } else if ($_GET['aksi'] == 'hapus') {
            header("location:?p=hapus&id=$id");
        } 
    }

    
    $query = mysqli_query($koneksi, "SELECT permintaan.id_permintaan, permintaan.kode_brg, tgl_permintaan, unit, nama_brg, jumlah, satuan, sift, status FROM permintaan INNER JOIN stokbarang ON permintaan.kode_brg = stokbarang.kode_brg WHERE status=1 ORDER BY tgl_permintaan DESC "); 

    
?>

<script type="text/javascript" src="../../assets/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="../../assets/DataTables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../../assets/DataTables/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="../../assets/DataTables/Buttons/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="../../assets/DataTables/Buttons/js/buttons.bootstrap4.min.js"></script>
    <script type="text/javascript" src="../../assets/DataTables/JSZip/jszip.min.js"></script>
    <script type="text/javascript" src="../../assets/DataTables/pdfmake/pdfmake.min.js"></script>
    <script type="text/javascript" src="../../assets/DataTables/pdfmake/vfs_fonts.js"></script>
    <script type="text/javascript" src="../../assets/DataTables/Buttons/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="../../assets/DataTables/Buttons/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="../../assets/DataTables/Buttons/js/buttons.colVis.min.js"></script>

<!-- Main content -->
<!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
             <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Data Permintaan Barang</h3>
                </div>    
                <div class="box-body"> 
				<a href="cetak_laporan.php" target="_blank" style="margin:10px;" class="btn btn-success"><i class='fa fa-print'> Cetak Laporan</i></a>
                </div> 
                    <section class="content">     
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center" id="datapesanan">
                            <thead  > 
                                <tr>
                                    <th>No</th> 
									<th>Tanggal</th>
                                    <th>Akun</th>                                                                
                                    <th>Nama Barang</th>
									<th>Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Sift</th>                                                            
                                    <th>Status</th>                                    
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
										<td> <?= tanggal_indo($row['tgl_permintaan']); ?> </td>										
                                        <td> <?= $row['unit']; ?> </td>
                                        <td> <?= $row['nama_brg']; ?> </td> 
										<td> <?= $row['satuan']; ?> </td>										
                                        <td> <?= $row['jumlah']; ?> </td>
                                        <td> <?= $row['sift']; ?> </td>
                                        <td > <?php
                                                if ($row['status'] == 0){
                                                    echo '<span class=text-warning>Belum Disetujui</span>';
                                                } elseif ($row['status'] == 1) {
                                                    echo '<span class=text-primary>Telah Disetujui</span>';
                                                } else {
                                                    echo '<span class=text-danger>Tidak Disetujui</span>';
                                                }
                                               ?> 
                                         </td>     
                                                                                                                                   
                            </tr>
                            <?php $no++; endwhile; }else {echo "<tr><td colspan=9>Belum ada permintaan disetujui</td></tr>" . mysqli_error($koneksi);} ?>
                            </tbody>
                        </table>
                    </div>                  
                </div>
            </div>
        </div>
    </div>



</section>


