<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 2){
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk menambahkan data");
                    window.location.href="./admin.php?page=ref";
                  </script>';
        } else {

            if(isset($_REQUEST['submit'])){

                $ekstensi = array('jpg','png','jpeg','doc','docx','pdf', 'xlsx');
                $file = rand(1,10000).$_FILES['berkas_template']['name'];
                $x = explode('.', $file);
                $eks = strtolower(end($x));
                $ukuran = $_FILES['berkas_template']['size'];
                $target_dir = "upload/template_surat/";

                $nama_template = $_REQUEST['nama_template'];
                $jenis_template = $_REQUEST['jenis_template'];
                // $berkas_template = $_REQUEST['berkas_template'];
                $id_user = $_SESSION['admin'];

                // var_dump($file);
                // die;

                if(in_array($eks, $ekstensi) == true){
                    if($ukuran < 2500000){

                        move_uploaded_file($_FILES['berkas_template']['tmp_name'], $target_dir.$file);

                        // $query = mysqli_query($config, "INSERT INTO tbl_surat_masuk(no_surat,asal_surat,tujuan_surat,kode,tgl_surat,
                        //     tgl_diterima,file,keterangan,jenis_surat,id_user)
                        //         VALUES('$no_surat','$asal_surat','$tujuan_surat','$nkode','$tgl_surat',NOW(),'$nfile','$keterangan','$jenis','$id_user')");

                        $query = mysqli_query($config, "INSERT INTO tbl_template_surat(nama_template,jenis_template,berkas_template,id_user) 
                        VALUES('$nama_template','$jenis_template','$file','$id_user')");

                        if($query == true){
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            header("Location: ./admin.php?page=template");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            // echo '<script language="javascript">window.history.back();</script>';
                        }
                    } else {
                        $_SESSION['errSize'] = 'Ukuran file yang diupload terlalu besar!';
                        echo '<script language="javascript">window.history.back();</script>';
                    }
                } else {
                    $_SESSION['errFormat'] = 'Format file yang diperbolehkan hanya *.JPG, *.PNG, *.DOC, *.DOCX atau *.PDF!';
                    echo '<script language="javascript">window.history.back();</script>';
                }

                // if($query != false){
                //     $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                //     header("Location: ./admin.php?page=template");
                //     die();
                // } else {
                //     $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                //     echo '<script language="javascript">window.history.back();</script>';
                // }
            } else {?>
                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue-grey darken-1">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="?page=ref&act=add" class="judul"><i class="material-icons">bookmark</i> Tambah Template Surat</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <!-- Secondary Nav END -->
                </div>
                <!-- Row END -->

                <?php
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
                ?>

                <!-- Row form Start -->
                <div class="row jarak-form">

                    <!-- Form START -->
                    <form class="col s12" method="post" action="?page=template&act=add" enctype="multipart/form-data">

                        <!-- Row in form START -->
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix md-prefix">text_fields</i>
                                <input id="nama" type="text" class="validate" name="nama_template" required>
                                   
                                <label for="nama">Nama Template</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix md-prefix">text_fields</i>
                                <textarea id="uraian" class="materialize-textarea" name="jenis_template" required></textarea>
                                    
                                <label for="uraian">Keterangan Template</label>
                            </div>
                            <!-- <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">text_fields</i>
                                <textarea id="uraian" class="materialize-textarea" name="berkas_template" required></textarea>
                                    
                                <label for="uraian">Dokumen Template</label>
                            </div> -->
                            <div class="input-field col s12">
                            <div class="file-field input-field tooltipped" data-position="top" data-tooltip="Jika tidak ada file/scan gambar surat, biarkan kosong">
                                <div class="btn light-green darken-1">
                                    <span>File</span>
                                    <input type="file" id="file" name="berkas_template">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Upload file/scan gambar surat masuk">
                                    <small class="red-text">*Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 2 MB!</small>
                                </div>
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
?>
