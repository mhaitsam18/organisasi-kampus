            <!-- Footer -->
            <footer class="sticky-footer" style="background-color: #781010 !important;">
                <div class="container my-auto">
                    <div class="copyright text-center text-white my-auto">
                        <?php $dashboard = $this->db->get('dashboard')->row_array(); ?>
                        <span>Copyright &copy; Proyek Akhir <?= $dashboard['footer'].' '.date('Y') ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <!-- <script src="<?= base_url('assets/') ?>vendor/chart.js/Chart.min.js"></script> -->


    <!--Chart Js-->
    <!-- <script src="<?= base_url('assets/'); ?>js/Chart.js"></script> -->

    <!-- Page level custom scripts -->
    <!-- <script src="<?= base_url('assets/'); ?>js/demo/chart-area-demo.js"></script> -->
    <!-- <script src="<?= base_url('assets/'); ?>js/demo/chart-pie-demo.js"></script> -->

    <script type="text/javascript" src="<?= base_url('assets/js/timeSolver-master/timeSolver.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <script src="<?= base_url('assets/') ?>js/demo/datatables-demo.js"></script>
    <!-- <script src="<?= base_url('assets/') ?>js/demo/datatables2-demo.js"></script> -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/') ?>dist/sweetalert2.all.js"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 -->
    <script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
    <script type="text/javascript">
        const flashData = $('.flash-data').data('flashdata');
        const objek = $('.flash-data').data('objek');
        if (flashData) {
            //'Data ' + 
            Swal.fire({
                title: objek,
                text: flashData,
                icon: 'success'
            });
        }
        $('.tombol-hapus').on('click', function(e) {
            const hapus = $(this).data('hapus');
            const href = $(this).attr('href');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data " + hapus + " akan dihapus!",
                icon: 'warning',
                confirmButtonText: 'Hapus',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            })
        });

        $('.tombol-terima').on('click', function(e) {
            const href = $(this).attr('href');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Pesanan yang diterima, tidak dapat dikembalikan!",
                icon: 'warning',
                confirmButtonText: 'diterima',
                showCancelButton: true,
                confirmButtonColor: '#32a852',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            })
        });
        $('.tombol-yakin').on('click', function(e) {
            const href = $(this).attr('href');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "",
                icon: 'warning',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                showCancelButton: true,
                confirmButtonColor: '#32a852',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            })
        });
        $('.minta-password').on('click', function(e) {
            Swal.fire({
                title: 'Masukkan Password',
                input: 'password',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Look up',
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    return fetch(`//api.github.com/users/${login}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error}`
                            )
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: `${result.value.login}'s avatar`,
                        imageUrl: result.value.avatar_url
                    })
                }
            })
        });
    </script>

    <script type="text/javascript">
        $('.custom-file-input').on('change', function(){
            let filename = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(filename);
        });

        $(function() {
            $('.newMenuModalButton').on('click', function(){
                $('#newMenuModalLabel').html('Add New Menu');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', '<?= base_url() ?>menu');
            });

            $('.updateMenuModalButton').on('click', function() {
                $('#newMenuModalLabel').html('Edit Menu');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', '<?= base_url() ?>menu/updateMenu');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>menu/getUpdateMenu',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#menu').val(data.menu);
                        $('#active').attr("checked", true);
                        if(data.active == 1){
                            $('#active').attr("checked", true);
                        } else{
                            $('#active').attr("checked", false);
                        }
                    }
                });
            });
        });

        $(function() {
            $('.newRoleModalButton').on('click', function(){
                $('#newRoleModalLabel').html('Add New Role');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', '<?= base_url() ?>Admin/role/');
            });

            $('.updateRoleModalButton').on('click', function() {
                $('#newRoleModalLabel').html('Edit Role');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', '<?= base_url() ?>Admin/updateRole');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>admin/getUpdateRole',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#role').val(data.role);
                    }
                });
            });
        });

        $(function() {
            $('.setRoleButton').on('click', function() {
                $('#setRoleLabel').html('Set User Role');
                $('.modal-footer button[type=submit]').html('Save');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>admin/getUserData',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#name').val(data.name);
                        $('#role_id').val(data.role_id);
                    }
                });
            });
        });

        $(function() {
            $('.newSubMenuModalButton').on('click', function(){
                $('#newSubMenuModalLabel').html('Add New SubMenu');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', '<?= base_url() ?>menu/subMenu');
            });

            $('.updateSubMenuModalButton').on('click', function() {
                $('#newSubMenuModalLabel').html('Edit SubMenu');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', '<?= base_url() ?>menu/updateSubMenu');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>menu/getUpdateSubMenu',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#title').val(data.title);
                        $('#menu_id').val(data.menu_id);
                        $('#url').val(data.url);
                        $('#icon').val(data.icon);
                        $('#is_active').attr("checked", true);
                        if(data.is_active == 1){
                            $('#is_active').attr("checked", true);
                        } else if(data.is_active == 0){
                            $('#is_active').attr("checked", false);
                        }
                    }
                });
            });
        });

        $(function() {
            $('.checkoutModalButton').on('click', function() {
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>Member/getJsonTiketById',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id_tiket').val(data.id);
                        // $('#harga').val(data.harga);
                        // $('#id_acara').val(data.id_acara);
                        // $('#stok_tiket').val(data.stok_tiket);
                        // $('#jumlah_terjual').val(data.jumlah_terjual);
                    }
                });
            });
        });

        $(function() {
            $('.daftarPanitiaModalButton').on('click', function() {
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>Member/getJsonRekruitasiById',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id_rekruitasi').val(data.id);
                        // $('#id_acara').val(data.id_acara);
                        // $('#batas_waktu').val(data.batas_waktu);
                        // $('#catatan').val(data.catatan);
                    }
                });
            });
        });

        $(function() {
            $('.panitiaModalButton').on('click', function() {
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>Pengurus/getJsonPanitiaById',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        // $('#nim').val(data.nim);
                        // $('#nama_lengkap').val(data.nama_lengkap);
                        // $('#file_cv').val(data.file_cv);
                        // $('#id_pilihan_divisi_1').val(data.id_pilihan_divisi_1);
                        // $('#id_pilihan_divisi_2').val(data.id_pilihan_divisi_2);
                        // $('#divisi').val(data.divisi);
                        // $('#id_rekruitasi').val(data.id_rekruitasi);
                        $('#status').val(data.status);
                    }
                });
            });
        });

        $(function() {
            $('.newAgamaModalButton').on('click', function(){
                $('#newAgamaModalLabel').html('Add New Religion');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', '<?= base_url() ?>DataMaster/agama');
            });

            $('.updateAgamaModalButton').on('click', function() {
                $('#newAgamaModalLabel').html('Edit Religion');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', '<?= base_url() ?>DataMaster/updateAgama');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>DataMaster/getUpdateAgama',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#agama').val(data.agama);
                    }
                });
            });
        });

        $(function() {
            $('.newAcaraModalButton').on('click', function(){
                $('#newAcaraModalLabel').html('Add New Event');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', '<?= base_url() ?>Pengurus/acara');
            });

            $('.updateAcaraModalButton').on('click', function() {
                $('#newAcaraModalLabel').html('Edit Event');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', '<?= base_url() ?>Pengurus/updateAcara');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>Pengurus/getUpdateAcara',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        // $('#id_pengurus').val(data.id_pengurus);
                        $('#id_organisasi').val(data.id_organisasi);
                        $('#nama_acara').val(data.nama_acara);
                        $('#penyelenggara').val(data.penyelenggara);
                        $('#tanggal_dimulai').val(data.tanggal_dimulai);
                        $('#waktu_dimulai').val(data.waktu_dimulai);
                        $('#tanggal_berakhir').val(data.tanggal_berakhir);
                        $('#waktu_berakhir').val(data.waktu_berakhir);
                        $('#poster').val(data.poster);
                        $('#keterangan').val(data.keterangan);
                    }
                });
            });
        });

        $(function() {
            $('.newTiketModalButton').on('click', function(){
                $('#newTiketModalLabel').html('Add New Ticket');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', '<?= base_url() ?>Pengurus/tiket');
            });

            $('.updateTiketModalButton').on('click', function() {
                $('#newTiketModalLabel').html('Edit Ticket');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', '<?= base_url() ?>Pengurus/updateTiket');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>Pengurus/getUpdateTiket',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#harga').val(data.harga);
                        $('#id_acara').val(data.id_acara);
                        $('#stok_tiket').val(data.stok_tiket);
                        $('#jumlah_terjual').val(data.jumlah_terjual);
                    }
                });
            });
        });

        $(function() {
            $('.newRekruitasiModalButton').on('click', function(){
                $('#newRekruitasiModalLabel').html('Add New Recruitment');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', '<?= base_url() ?>Pengurus/rekruitasi');
            });

            $('.updateRekruitasiModalButton').on('click', function() {
                $('#newRekruitasiModalLabel').html('Edit Recruitment');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', '<?= base_url() ?>Pengurus/updateRekruitasi');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>Pengurus/getUpdateRekruitasi',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#id_acara').val(data.id_acara);
                        var data_waktu = new Date(data.batas_waktu);
                        console.log(data_waktu);
                        console.log(timeSolver.getString(data_waktu, "YYYY-MM-DD"));
                        // $('#batas_tanggal').val(data_waktu.getFullYear()+'-0'+(data_waktu.getMonth()+1)+'-'+data_waktu.getDate());
                        $('#batas_tanggal').val(timeSolver.getString(data_waktu, "YYYY-MM-DD"));
                        // $('#batas_jam').val(data_waktu.getHours()+':'+data_waktu.getMinutes()+':'+data_waktu.getSeconds());
                        $('#batas_jam').val(timeSolver.getString(data_waktu, "HH:MM:SS"));
                        // $('#batas_waktu').val(data.batas_waktu);
                        $('#catatan').val(data.catatan);
                        // timeSolver.getString(date, "YYYY-MM-DD");
                    }
                });
            });
        });

        $(function() {
            $('.newDivisiModalButton').on('click', function(){
                $('#newDivisiModalLabel').html('Add New Division');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', '<?= base_url() ?>Pengurus/divisi');
            });

            $('.updateDivisiModalButton').on('click', function() {
                $('#newDivisiModalLabel').html('Edit Division');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', '<?= base_url() ?>Pengurus/updateDivisi');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>Pengurus/getUpdateDivisi',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#id_rekruitasi').val(data.id_rekruitasi);
                        $('#nama_divisi').val(data.nama_divisi);
                    }
                });
            });
        });

        $(function() {
            $('.newPertanyaan1ModalButton').on('click', function(){
                $('#newPertanyaan1ModalLabel').html('Add New Question 1');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', '<?= base_url() ?>/DataMaster/pertanyaan/1');
            });

            $('.updatePertanyaan1ModalButton').on('click', function() {
                $('#newPertanyaan1ModalLabel').html('Edit Question 1');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', '<?= base_url() ?>/DataMaster/updatePertanyaan/1');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>/DataMaster/getUpdatePertanyaan1',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id1').val(data.id);
                        $('#pertanyaan1').val(data.pertanyaan);
                    }
                });
            });
        });

        $(function() {
            $('.newPertanyaan2ModalButton').on('click', function(){
                $('#newPertanyaan2ModalLabel').html('Add New Question 2');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', '<?= base_url() ?>/DataMaster/pertanyaan/2');
            });

            $('.updatePertanyaan2ModalButton').on('click', function() {
                $('#newPertanyaan2ModalLabel').html('Edit Question 2');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', '<?= base_url() ?>/DataMaster/updatePertanyaan/2');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>/DataMaster/getUpdatePertanyaan2',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id2').val(data.id);
                        $('#pertanyaan2').val(data.pertanyaan);
                    }
                });
            });
        });

        $(function() {
            $('.newRekeningModalButton').on('click', function(){
                $('#newRekeningModalLabel').html('Add New Bank Account');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', '<?= base_url() ?>Pengurus/rekening');
            });

            $('.updateRekeningModalButton').on('click', function() {
                $('#newRekeningModalLabel').html('Edit Bank Account');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', '<?= base_url() ?>Pengurus/updateRekening');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>Pengurus/getUpdateRekening',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#id_tiket').val(data.id_tiket);
                        $('#no_rekening').val(data.no_rekening);
                        $('#bank').val(data.bank);
                        $('#atas_nama').val(data.atas_nama);
                        $('#email').val(data.email);
                    }
                });
            });
        });

        $(function() {
            $('.newMetodeBayarModalButton').on('click', function(){
                $('#newMetodeBayarModalLabel').html('Add New Payment');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', '<?= base_url() ?>DataMaster/metodeBayar');
            });

            $('.updateMetodeBayarModalButton').on('click', function() {
                $('#newMetodeBayarModalLabel').html('Edit Payment');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', '<?= base_url() ?>DataMaster/updateMetodeBayar');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>DataMaster/getUpdateMetodeBayar',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#metode_bayar').val(data.metode_bayar);
                    }
                });
            });
        });

        $(function() {
            $('.newKategoriOrganisasiModalButton').on('click', function(){
                $('#newKategoriOrganisasiModalLabel').html('Add New Category');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', '<?= base_url() ?>DataMaster/kategoriOrganisasi');
            });

            $('.updateKategoriOrganisasiModalButton').on('click', function() {
                $('#newKategoriOrganisasiModalLabel').html('Edit Category');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', '<?= base_url() ?>DataMaster/updateKategoriOrganisasi');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>DataMaster/getUpdateKategoriOrganisasi',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#kategori_organisasi').val(data.kategori_organisasi);
                    }
                });
            });
        });

        $(function() {
            $('.newKontenModalButton').on('click', function(){
                $('#newKontenModalLabel').html('Add New Content');
                $('.modal-footer button[type=submit]').html('Add');
                $('.modal-content form')[0].reset();
                $('.modal-content form').attr('action', '<?= base_url() ?>DataMaster/konten');
            });

            $('.updateKontenModalButton').on('click', function() {
                $('#newKontenModalLabel').html('Edit Content');
                $('.modal-footer button[type=submit]').html('Save');
                $('.modal-content form').attr('action', '<?= base_url() ?>DataMaster/updateKonten');
                const id = $(this).data('id');
                jQuery.ajax({
                    url: '<?= base_url() ?>DataMaster/getUpdateKonten',
                    data: {id : id},
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#title').val(data.title);
                        $('#header').val(data.header);
                        $('#konten').val(data.content);
                        $('#footer').val(data.footer);
                    }
                });
            });
        });

        $(function() {
            $('.akses_role').on('click', function() {
                const menuId = $(this).data('menu');
                const roleId = $(this).data('role');

                $.ajax({
                    url: "<?= base_url('admin/changeaccess') ?>",
                    type: 'post',
                    data: {
                        menuId: menuId,
                        roleId: roleId
                    },
                    success: function() {
                        document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
                    }
                });
            });
        });
        
    </script>

    <script>
        $(document).ready(function() {
            setInterval(function() {
                $('#show').load('<?= base_url('User/notifikasi') ?>')
            }, 10000);
        });

        function notifikasi() {
            $.ajax({
                type: "POST",
                url: '<?= base_url('User/readAllNotification') ?>',
                data:{action:'call_this'},
                success:function(html) {

                }
            });
        }

        function kirimUndangan(idUser, idOrganisasi) {
            // const idUser = $(this).data('idUser');
            // const idOrganisasi = $(this).data('idOrganisasi');
            console.log(idUser);
            $.ajax({
                type: "POST",
                url: '<?= base_url('Pengurus/kirimUndangan/') ?>',
                data:{
                    action:'call_this',
                    idUser:idUser,
                    idOrganisasi:idOrganisasi
                },
                success:function(html) {
                    history.go(0);
                    // window.location.reload();
                    // window.location.href=window.location.href;
                    var modal = document.getElementById('kirimUndanganModal');
                    modal.style.display = "block";

                }
            });
        }

        function cariChat(id_teman) {
            $.ajax({
                type  : 'post',
                url   : '<?= base_url('User/getChat/')?>',
                data  : {id_teman:id_teman},
                // async : false,
                // dataType : 'json',
                success : function(data){
                    var html = data;
                    var i;
                    // for(i=0; i<data.length; i++){
                    //     html += '<tr>'+
                    //     '<td>'+data[i].barang_kode+'</td>'+
                    //     '<td>'+data[i].barang_nama+'</td>'+
                    //     '<td>'+data[i].barang_harga+'</td>'+
                    //     '</tr>';
                    // }
                    $('#show_chat').html(html);
                }
            });
        }
        
        <?php if ($this->uri->segment(2) == "chat"): ?>
            <?php if ($id_tmn): ?>
                cariChat(<?= $id_tmn ?>);
            <?php endif ?>
        <?php endif ?>

         function bukaChat(id_teman) {
            $.ajax({
                type  : 'post',
                url   : '<?= base_url('User/getChat/')?>',
                data  : {id_teman:id_teman},
                // async : false,
                // dataType : 'json',
                success : function(data){
                    document.location.href = "<?= base_url('user/chat/'); ?>" + id_teman;
                    var html = data;
                    var i;
                    // for(i=0; i<data.length; i++){
                    //     html += '<tr>'+
                    //     '<td>'+data[i].barang_kode+'</td>'+
                    //     '<td>'+data[i].barang_nama+'</td>'+
                    //     '<td>'+data[i].barang_harga+'</td>'+
                    //     '</tr>';
                    // }
                    $('#show_chat').html(html);
                }
            });
         }

         function kirimChat(id_teman) {
            var pesan = document.getElementById("pesan").value;
            $.ajax({
                type  : 'post',
                url   : '<?= base_url('User/kirimChat/')?>',
                data  : {
                    id_teman:id_teman,
                    pesan:pesan
                },
                // async : false,
                // dataType : 'json',
                success : function(data){
                    $('#pesan').val('');
                    var html = data;
                    var i;
                    // for(i=0; i<data.length; i++){
                    //     html += '<tr>'+
                    //     '<td>'+data[i].barang_kode+'</td>'+
                    //     '<td>'+data[i].barang_nama+'</td>'+
                    //     '<td>'+data[i].barang_harga+'</td>'+
                    //     '</tr>';
                    // }
                    $('#scroll').html(html);
                    $('#scroll').scrollTop($('#scroll')[0].scrollHeight);
                }
            });
         }
    </script>
    
</body>

</html>