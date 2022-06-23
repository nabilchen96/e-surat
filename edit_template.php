<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if(isset($_REQUEST['submit'])){

                $id_template_surat = $_REQUEST['id_template_surat'];
                $nama_template = $_REQUEST['nama_template'];
                $jenis_template = $_REQUEST['jenis_template'];
                $berkas_template = $_REQUEST['berkas_template'];
                $id_user = $_SESSION['admin'];

                //validasi form kosong
        
                $query = mysqli_query($config, "UPDATE tbl_template_surat SET nama_template='$nama_template', jenis_template='$jenis_template', berkas_template='$berkas_template', id_user='$id_user' WHERE id_template_surat='$id_template_surat'");

                if($query != false){
                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                    header("Location: ./admin.php?page=template");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">window.history.back();</script>';
                }

        } else {

            $id_template_surat = mysqli_real_escape_string($config, $_REQUEST['id_template_surat']);
            $query = mysqli_query($config, "SELECT * FROM tbl_template_surat WHERE id_template_surat='$id_template_surat'");
            if(mysqli_num_rows($query) > 0){
                $no = 1;
                while($row = mysqli_fetch_array($query))
                if($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2){
                    echo '<script language="javascript">
                            window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
                            window.location.href="./admin.php?page=ref";
                          </script>';
                } else {?>

                    <!-- Row Start -->
                    <div class="row">
                        <!-- Secondary Nav START -->
                        <div class="col s12">
                            <nav class="secondary-nav">
                                <div class="nav-wrapper blue-grey darken-1">
                                    <ul class="left">
                                        <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Klasifikasi Surat</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <!-- Secondary Nav END -->
                    </div>
                    <!-- Row END -->

                    <?php
                        if(isset($_SESSION['errEmpty'])){
                            $errEmpty = $_SESSION['errEmpty'];
                            echo '<div id="alert-message" class="row">
                                    <div class="col m12">
                                        <div class="card red lighten-5">
                                            <div class="card-content notif">
                                                <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errEmpty.'</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            unset($_SESSION['errEmpty']);
                        }
                        if(isset($_SESSION['errQ'])){
                            $errQ = $_SESSION['errQ'];
                            echo '<div id="alert-message" class="row">
                                    <div class="col m12">
                                        <div class="card red lighten-5">
                                            <div class="card-content notif">
                                                <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errQ.'</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            unset($_SESSION['errQ']);
                        }
                    ?>

                    <!-- Row form Start -->
                    <div class="row jarak-form">

                        <!-- Form START -->
                        <form class="col s12" method="post" action="?page=template&act=edit">

                            <!-- Row in form START -->
                            <div class="row">
                                <div class="input-field col s3 tooltipped" data-position="top" data-tooltip="Isi dengan huruf, angka, spasi dan titik(.)">
                                    <input type="hidden" value="<?php echo $row['id_template_surat']; ?>" name="id_template_surat">
                                    <i class="material-icons prefix md-prefix">font_download</i>
                                    <input id="kd" type="text" class="validate" name="nama_template" maxlength="30" value="<?php echo $row['nama_template']; ?>" required>
                                       
                                    <label for="kd">Nama Template</label>
                                </div>
                                <div class="input-field col s9">
                                    <i class="material-icons prefix md-prefix">text_fields</i>
                                    <input id="nama" type="text" class="validate" name="jenis_template" value="<?php echo $row['jenis_template']; ?>" required>
                                      
                                    <label for="nama">Jenis Template</label>
                                </div>
                                <!-- <div class="input-field col s12">
                                    <i class="material-icons prefix md-prefix">text_fields</i>
                                    <textarea id="uraian" class="materialize-textarea" name="berkas_template" required><?php //echo $row['berkas_template']; ?></textarea>
                                       
                                    <label for="uraian">Berkas Template</label>
                                </div> -->
                                <div class="input-field col s12">
                                <div class="file-field input-field tooltipped" data-position="top" data-tooltip="Jika tidak ada file/scan gambar surat, biarkan kosong">
                                    <div class="btn light-green darken-1">
                                        <span>File</span>
                                        <input type="file" id="file" name="berkas_template">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" value="<?php echo $row['berkas_template']; ?>" type="text" placeholder="Upload file/scan gambar surat masuk">
                                        <small class="red-text">*Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 2 MB!</small>
                                    </div>
                                </div>
                            </div>
                            <!-- Row in form END -->
                            <div class="row">
                                <div class="col 6">
                                    <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                </div>
                                <div class="col 6">
                                    <a href="?page=ref" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                </div>
                            </div>

                        </form>
                        <!-- Form END -->

                    </div>
                    <!-- Row form END -->

<?php
                }
            }
        }
    }
?>
