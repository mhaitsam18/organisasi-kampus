        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                    <div class="row">
                        <div class="col-lg-6">
                            <?= $this->session->flashdata('message'); ?>
                            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Profil"></div>
                        </div>
                    </div>
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="<?= base_url("assets/img/profile/$user[image]") ?>" class="card-img" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $user['name']; ?></h5>
                                    <p class="card-text"><?= $user['email']; ?></p>
                                    <div class="row">
                                        <div class="col-md-5">
                                            Agama
                                        </div>
                                        <div class="col-md-7">
                                            : <?= $user['agama'] ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            Tanggal Lahir
                                        </div>
                                        <div class="col-md-7">
                                            : <?= cari_tanggal($user['birthday']); ?>
                                        </div>
                                    </div>
                                    <p class="card-text"><small class="text-muted">Member since <?= date('d F Y', $user['date_created']) ?></small></p>
                                    <?php if ($user['role_id']==2): ?>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($this->session->userdata('role_id') != 3): ?>
                        <h1 class="h3 mb-4 text-gray-800">Mengurus Organisasi : </h1>
                        <div class="row">
                            <?php foreach ($admin_organisasi as $ao): ?>
                                <div class="col-md-4 ml-2">
                                    <div class="card mb-3">
                                        <div class="row no-gutters">
                                            <div class="col-md-4">
                                                <img src="<?= base_url("assets/img/logo-organisasi/$ao[logo]") ?>" class="card-img" alt="Logo">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $ao['nama_organisasi']; ?></h5>
                                                    <p class="card-text"><?= $ao['singkatan']; ?></p>
                                                    <a href="<?= base_url('Pengurus/organisasi/'.$ao['id']); ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-pencil-alt"></i> Edit Organisasi</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                    
                    <h1 class="h3 mb-4 text-gray-800">Organisasi yang diikuti: </h1>
                    <div class="row">
                        <?php foreach ($organisasi_diikuti as $row): ?>
                        <div class="card mb-3 mr-3" style="width: 45%;">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="<?= base_url('assets/img/logo-organisasi/').$row['logo'] ?>" alt="<?= $row['logo'] ?>" style="width: 180px;">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <a href="<?= base_url('User/organisasi/'.$row['ido']) ?>">
                                            <h4 class="card-title" style="color: #a36362;"><?= $row['nama_organisasi'] ?> (<?= $row['singkatan'] ?>)</h5>
                                        </a>
                                        <p class="card-text">
                                            <?= $row['deskripsi'] ?>
                                        </p>
                                        <p class="card-text">
                                            <?= numPengikut($row['id']); ?> Pengikut
                                        </p>
                                        <?php if (getIkutiOrganisasi($row['id'], $user['id']) > 0): ?>
                                            <a href="<?= base_url('member/batalMengikuti/'.$row['id']) ?>" class="btn btn-secondary btn-sm">mengikuti</a>
                                        <?php else: ?>
                                            <a href="<?= base_url('member/ikutiOrganisasi/'.$row['id']) ?>" class="btn btn-primary btn-sm">Ikuti</a>
                                        <?php endif ?>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#pengikutModal<?= $row['id'] ?>">
                                            Lihat Pengikut
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    </div>
                    
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->