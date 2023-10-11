	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<!-- <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1> -->
		<div class="row">
			<div class="col-lg-6">
				<?= $this->session->flashdata('message'); ?>
				<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>" data-objek="Profil"></div>

			</div>
		</div>
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
		<style type="text/css">
			body {
				margin-top: 20px;
			}

			/*************** 1.Variables ***************/


			/* ------------------ Color Pallet ------------------ */


			/*************** 2.Mixins ***************/


			/************************************************
			    ************************************************
													Search Box
				************************************************
			************************************************/

			.chat-search-box {
				-webkit-border-radius: 3px 0 0 0;
				-moz-border-radius: 3px 0 0 0;
				border-radius: 3px 0 0 0;
				padding: .75rem 1rem;
			}

			.chat-search-box .input-group .form-control {
				-webkit-border-radius: 2px 0 0 2px;
				-moz-border-radius: 2px 0 0 2px;
				border-radius: 2px 0 0 2px;
				border-right: 0;
			}

			.chat-search-box .input-group .form-control:focus {
				border-right: 0;
			}

			.chat-search-box .input-group .input-group-btn .btn {
				-webkit-border-radius: 0 2px 2px 0;
				-moz-border-radius: 0 2px 2px 0;
				border-radius: 0 2px 2px 0;
				margin: 0;
			}

			.chat-search-box .input-group .input-group-btn .btn i {
				font-size: 1.2rem;
				line-height: 100%;
				vertical-align: middle;
			}

			@media (max-width: 767px) {
				.chat-search-box {
					display: none;
				}
			}


			/************************************************
				************************************************
												Users Container
				************************************************
			************************************************/

			.users-container {
				position: relative;
				padding: 1rem 0;
				border-right: 1px solid #e6ecf3;
				height: 100%;
				display: -ms-flexbox;
				display: flex;
				-ms-flex-direction: column;
				flex-direction: column;
			}


			/************************************************
				************************************************
														Users
				************************************************
			************************************************/

			.users {
				padding: 0;
			}

			.users .person {
				position: relative;
				width: 100%;
				padding: 10px 1rem;
				cursor: pointer;
				border-bottom: 1px solid #f0f4f8;
			}

			.users .person:hover {
				background-color: #ffffff;
				/* Fallback Color */
				background-image: -webkit-gradient(linear, left top, left bottom, from(#e9eff5), to(#ffffff));
				/* Saf4+, Chrome */
				background-image: -webkit-linear-gradient(right, #e9eff5, #ffffff);
				/* Chrome 10+, Saf5.1+, iOS 5+ */
				background-image: -moz-linear-gradient(right, #e9eff5, #ffffff);
				/* FF3.6 */
				background-image: -ms-linear-gradient(right, #e9eff5, #ffffff);
				/* IE10 */
				background-image: -o-linear-gradient(right, #e9eff5, #ffffff);
				/* Opera 11.10+ */
				background-image: linear-gradient(right, #e9eff5, #ffffff);
			}

			.users .person.active-user {
				background-color: #ffffff;
				/* Fallback Color */
				background-image: -webkit-gradient(linear, left top, left bottom, from(#f7f9fb), to(#ffffff));
				/* Saf4+, Chrome */
				background-image: -webkit-linear-gradient(right, #f7f9fb, #ffffff);
				/* Chrome 10+, Saf5.1+, iOS 5+ */
				background-image: -moz-linear-gradient(right, #f7f9fb, #ffffff);
				/* FF3.6 */
				background-image: -ms-linear-gradient(right, #f7f9fb, #ffffff);
				/* IE10 */
				background-image: -o-linear-gradient(right, #f7f9fb, #ffffff);
				/* Opera 11.10+ */
				background-image: linear-gradient(right, #f7f9fb, #ffffff);
			}

			.users .person:last-child {
				border-bottom: 0;
			}

			.users .person .user {
				display: inline-block;
				position: relative;
				margin-right: 10px;
			}

			.users .person .user img {
				width: 48px;
				height: 48px;
				-webkit-border-radius: 50px;
				-moz-border-radius: 50px;
				border-radius: 50px;
			}

			.users .person .user .status {
				width: 10px;
				height: 10px;
				-webkit-border-radius: 100px;
				-moz-border-radius: 100px;
				border-radius: 100px;
				background: #e6ecf3;
				position: absolute;
				top: 0;
				right: 0;
			}

			.users .person .user .status.online {
				background: #9ec94a;
			}

			.users .person .user .status.offline {
				background: #c4d2e2;
			}

			.users .person .user .status.away {
				background: #f9be52;
			}

			.users .person .user .status.busy {
				background: #fd7274;
			}

			.users .person p.name-time {
				font-weight: 600;
				font-size: .85rem;
				display: inline-block;
			}

			.users .person p.name-time .time {
				font-weight: 400;
				font-size: .7rem;
				text-align: right;
				color: #8796af;
			}

			@media (max-width: 767px) {
				.users .person .user img {
					width: 30px;
					height: 30px;
				}

				.users .person p.name-time {
					display: none;
				}

				.users .person p.name-time .time {
					display: none;
				}
			}


			/************************************************
				************************************************
												Chat right side
				************************************************
			************************************************/

			.selected-user {
				width: 100%;
				padding: 0 15px;
				min-height: 64px;
				line-height: 64px;
				border-bottom: 1px solid #e6ecf3;
				-webkit-border-radius: 0 3px 0 0;
				-moz-border-radius: 0 3px 0 0;
				border-radius: 0 3px 0 0;
			}

			.selected-user span {
				line-height: 100%;
			}

			.selected-user span.name {
				font-weight: 700;
			}

			.chat-container {
				position: relative;
				padding: 1rem;
			}

			.chat-container li.chat-left,
			.chat-container li.chat-right {
				display: flex;
				flex: 1;
				flex-direction: row;
				margin-bottom: 40px;
			}

			.chat-container li img {
				width: 48px;
				height: 48px;
				-webkit-border-radius: 30px;
				-moz-border-radius: 30px;
				border-radius: 30px;
			}

			.chat-container li .chat-avatar {
				margin-right: 20px;
			}

			.chat-container li.chat-right {
				justify-content: flex-end;
			}

			.chat-container li.chat-right>.chat-avatar {
				margin-left: 20px;
				margin-right: 0;
			}

			.chat-container li .chat-name {
				font-size: .75rem;
				color: #999999;
				text-align: center;
			}

			.chat-container li .chat-text {
				padding: .4rem 1rem;
				-webkit-border-radius: 4px;
				-moz-border-radius: 4px;
				border-radius: 4px;
				background: #ffffff;
				font-weight: 300;
				line-height: 150%;
				position: relative;
			}

			.chat-container li .chat-text:before {
				content: '';
				position: absolute;
				width: 0;
				height: 0;
				top: 10px;
				left: -20px;
				border: 10px solid;
				border-color: transparent #ffffff transparent transparent;
			}

			.chat-container li.chat-right>.chat-text {
				text-align: right;
			}

			.chat-container li.chat-right>.chat-text:before {
				right: -20px;
				border-color: transparent transparent transparent #ffffff;
				left: inherit;
			}

			.chat-container li .chat-hour {
				padding: 0;
				margin-bottom: 10px;
				font-size: .75rem;
				display: flex;
				flex-direction: row;
				align-items: center;
				justify-content: center;
				margin: 0 0 0 15px;
			}

			.chat-container li .chat-hour>span {
				font-size: 16px;
				color: #9ec94a;
			}

			.chat-container li.chat-right>.chat-hour {
				margin: 0 15px 0 0;
			}

			@media (max-width: 767px) {

				.chat-container li.chat-left,
				.chat-container li.chat-right {
					flex-direction: column;
					margin-bottom: 30px;
				}

				.chat-container li img {
					width: 32px;
					height: 32px;
				}

				.chat-container li.chat-left .chat-avatar {
					margin: 0 0 5px 0;
					display: flex;
					align-items: center;
				}

				.chat-container li.chat-left .chat-hour {
					justify-content: flex-end;
				}

				.chat-container li.chat-left .chat-name {
					margin-left: 5px;
				}

				.chat-container li.chat-right .chat-avatar {
					order: -1;
					margin: 0 0 5px 0;
					align-items: center;
					display: flex;
					justify-content: right;
					flex-direction: row-reverse;
				}

				.chat-container li.chat-right .chat-hour {
					justify-content: flex-start;
					order: 2;
				}

				.chat-container li.chat-right .chat-name {
					margin-right: 5px;
				}

				.chat-container li .chat-text {
					font-size: .8rem;
				}
			}

			.chat-form {
				padding: 15px;
				width: 100%;
				left: 0;
				right: 0;
				bottom: 0;
				background-color: #ffffff;
				border-top: 1px solid white;
			}

			ul {
				list-style-type: none;
				margin: 0;
				padding: 0;
			}

			.card {
				border: 0;
				background: #f4f5fb;
				-webkit-border-radius: 2px;
				-moz-border-radius: 2px;
				border-radius: 2px;
				margin-bottom: 2rem;
				box-shadow: none;
			}
		</style>
		<div class="container">
			<!-- Page header start -->
			<div class="page-title">
				<div class="row gutters">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
						<h5 class="title">Chat App</h5>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"> </div>
				</div>
			</div>
			<!-- Page header end -->

			<!-- Content wrapper start -->
			<div class="content-wrapper">

				<!-- Row start -->
				<div class="row gutters">

					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

						<div class="card m-0">

							<!-- Row start -->
							<div class="row no-gutters">
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-3">
									<button type="button" class="btn btn-primary btn-sm mt-3 ml-3" data-toggle="modal" data-target="#buatChatModal">
										<i class="fas fa-plus"></i> Buat Chat Baru
									</button>
									<div class="users-container">
										<form action="<?= base_url('User/chat/') ?>" method="get">
											<div class="chat-search-box">
												<div class="input-group">
													<input type="text" class="form-control" name="search" id="search" placeholder="Search">
													<div class="input-group-btn">
														<button type="submit" class="btn btn-info">
															<i class="fa fa-search"></i>
														</button>
													</div>
												</div>
											</div>
										</form>
										<ul class="users" style="height: 500px; overflow: auto; width: 100%;">
											<?php foreach ($chat as $c) : ?>
												<li class="person" data-chat="person1" onclick="cariChat(<?= $c->id_user ?>)">
													<div class="user">
														<img src="<?= base_url('assets/img/profile/' . $c->image) ?>" alt="Retail Admin">
														<?php
														$this->db->where('id_user_from', $c->id_user);
														$this->db->where('id_user_to', $user['id']);
														$this->db->where('is_read', 0);
														$cek_read = $this->db->get('chat')->num_rows();
														?>
														<?php if ($cek_read > 0) : ?>
															<span class="status busy"></span>
														<?php endif ?>
													</div>
													<p class="name-time">
														<span class="name"><?= $c->name ?></span>
														<?php $date = date('Y-m-d', strtotime($c->max_time)); ?>
														<?php if ($date == date('Y-m-d')) : ?>
															<span class="time"><?= date('H:i', strtotime($c->max_time)) ?></span>
														<?php elseif ($date == date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-d'))))) : ?>
															<span class="time">Kemarin</span>
														<?php else : ?>
															<span class="time"><?= date('d/m/Y', strtotime($c->max_time)) ?></span>
														<?php endif ?>
													</p>
												</li>
											<?php endforeach ?>
											<!-- <li class="person" data-chat="person1">
		                                        <div class="user">
		                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar1.png" alt="Retail Admin">
		                                            <span class="status offline"></span>
		                                        </div>
		                                        <p class="name-time">
		                                            <span class="name">Steve Bangalter</span>
		                                            <span class="time">15/02/2019</span>
		                                        </p>
		                                    </li>
		                                    <li class="person active-user" data-chat="person2">
		                                        <div class="user">
		                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar2.png" alt="Retail Admin">
		                                            <span class="status away"></span>
		                                        </div>
		                                        <p class="name-time">
		                                            <span class="name">Peter Gregor</span>
		                                            <span class="time">12/02/2019</span>
		                                        </p>
		                                    </li>
		                                    <li class="person" data-chat="person3">
		                                        <div class="user">
		                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
		                                            <span class="status busy"></span>
		                                        </div>
		                                        <p class="name-time">
		                                            <span class="name">Jessica Larson</span>
		                                            <span class="time">11/02/2019</span>
		                                        </p>
		                                    </li>
		                                    <li class="person" data-chat="person4">
		                                        <div class="user">
		                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar4.png" alt="Retail Admin">
		                                            <span class="status offline"></span>
		                                        </div>
		                                        <p class="name-time">
		                                            <span class="name">Lisa Guerrero</span>
		                                            <span class="time">08/02/2019</span>
		                                        </p>
		                                    </li>
		                                    <li class="person" data-chat="person5">
		                                        <div class="user">
		                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar5.png" alt="Retail Admin">
		                                            <span class="status away"></span>
		                                        </div>
		                                        <p class="name-time">
		                                            <span class="name">Michael Jordan</span>
		                                            <span class="time">05/02/2019</span>
		                                        </p>
		                                    </li> -->
										</ul>
									</div>
								</div>
								<div class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-9" id="show_chat">
									<div class="selected-user">
										<span>To: <span class="name">
												<!-- Emily Russell -->
											</span></span>
									</div>
									<div class="chat-container">
										<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		                            	<div style="height: 500px; overflow: auto; width: 100%;" id="scroll">
			                                <ul class="chat-box chatContainerScroll">
			                                    <li class="chat-left">
			                                        <div class="chat-avatar">
			                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
			                                            <div class="chat-name">Russell</div>
			                                        </div>
			                                        <div class="chat-text">Hello, I'm Russell.
			                                            <br>How can I help you today?</div>
			                                        <div class="chat-hour">08:55 <span class="fa fa-check-circle"></span></div>
			                                    </li>
			                                    <li class="chat-right">
			                                        <div class="chat-hour">08:56 <span class="fa fa-check-circle"></span></div>
			                                        <div class="chat-text">Hi, Russell
			                                            <br> I need more information about Developer Plan.</div>
			                                        <div class="chat-avatar">
			                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
			                                            <div class="chat-name">Sam</div>
			                                        </div>
			                                    </li>
			                                    <li class="chat-left">
			                                        <div class="chat-avatar">
			                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
			                                            <div class="chat-name">Russell</div>
			                                        </div>
			                                        <div class="chat-text">Are we meeting today?
			                                            <br>Project has been already finished and I have results to show you.</div>
			                                        <div class="chat-hour">08:57 <span class="fa fa-check-circle"></span></div>
			                                    </li>
			                                    <li class="chat-right">
			                                        <div class="chat-hour">08:59 <span class="fa fa-check-circle"></span></div>
			                                        <div class="chat-text">Well I am not sure.
			                                            <br>I have results to show you.</div>
			                                        <div class="chat-avatar">
			                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar5.png" alt="Retail Admin">
			                                            <div class="chat-name">Joyse</div>
			                                        </div>
			                                    </li>
			                                    <li class="chat-left">
			                                        <div class="chat-avatar">
			                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
			                                            <div class="chat-name">Russell</div>
			                                        </div>
			                                        <div class="chat-text">The rest of the team is not here yet.
			                                            <br>Maybe in an hour or so?</div>
			                                        <div class="chat-hour">08:57 <span class="fa fa-check-circle"></span></div>
			                                    </li>
			                                    <li class="chat-right">
			                                        <div class="chat-hour">08:59 <span class="fa fa-check-circle"></span></div>
			                                        <div class="chat-text">Have you faced any problems at the last phase of the project?</div>
			                                        <div class="chat-avatar">
			                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar4.png" alt="Retail Admin">
			                                            <div class="chat-name">Jin</div>
			                                        </div>
			                                    </li>
			                                    <li class="chat-left">
			                                        <div class="chat-avatar">
			                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
			                                            <div class="chat-name">Russell</div>
			                                        </div>
			                                        <div class="chat-text">Actually everything was fine.
			                                            <br>I'm very excited to show this to our team.</div>
			                                        <div class="chat-hour">07:00 <span class="fa fa-check-circle"></span></div>
			                                    </li>
			                                    <li class="chat-left">
			                                        <div class="chat-avatar">
			                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
			                                            <div class="chat-name">Russell</div>
			                                        </div>
			                                        <div class="chat-text">Actually everything was fine.
			                                            <br>I'm very excited to show this to our team.</div>
			                                        <div class="chat-hour">07:00 <span class="fa fa-check-circle"></span></div>
			                                    </li>
			                                    <li class="chat-left">
			                                        <div class="chat-avatar">
			                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
			                                            <div class="chat-name">Russell</div>
			                                        </div>
			                                        <div class="chat-text">Actually everything was fine.
			                                            <br>I'm very excited to show this to our team.</div>
			                                        <div class="chat-hour">07:00 <span class="fa fa-check-circle"></span></div>
			                                    </li>
			                                    <li class="chat-left">
			                                        <div class="chat-avatar">
			                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
			                                            <div class="chat-name">Russell</div>
			                                        </div>
			                                        <div class="chat-text">Actually everything was fine.
			                                            <br>I'm very excited to show this to our team.</div>
			                                        <div class="chat-hour">07:00 <span class="fa fa-check-circle"></span></div>
			                                    </li>
			                                    <li class="chat-left">
			                                        <div class="chat-avatar">
			                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
			                                            <div class="chat-name">Russell</div>
			                                        </div>
			                                        <div class="chat-text">Actually everything was fine.
			                                            <br>I'm very excited to show this to our team.</div>
			                                        <div class="chat-hour">07:00 <span class="fa fa-check-circle"></span></div>
			                                    </li>
			                                </ul>
		                            	</div>
		                                <div class="form-group mt-3 mb-0">
		                                	<form action="" method="">
			                                    <textarea class="form-control" rows="3" placeholder="Type your message here..."></textarea>
			                                    <button type="submit" class="btn btn-info float-right mt-1">Kirim</button>
		                                	</form>
		                                </div> -->
									</div>
								</div>
							</div>
							<!-- Row end -->
						</div>

					</div>

				</div>
				<!-- Row end -->

			</div>
			<!-- Content wrapper end -->

		</div>
	</div>
	<!-- /.container-fluid -->
	</div>
	<!-- Button trigger modal -->

	<!-- Modal -->
	<div class="modal fade" id="buatChatModal" tabindex="-1" aria-labelledby="buatChatModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="buatChatModalLabel">Buat Chat Baru</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style="height: 340px; overflow: auto; width: 100%;">
					<?php foreach ($pertemanan as $p) : ?>
						<ul class="users">
							<li class="person" onclick="cariChat(<?= $p['idu'] ?>)" data-dismiss="modal">
								<img class="img-profile rounded-circle" src="<?= base_url("assets/img/profile/$p[image]"); ?>" style="height: 50px;">
								<span class="text-muted"><?= $p['name'] ?></span>
							</li>
						</ul>
						<hr>
					<?php endforeach ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
				</div>
			</div>
		</div>
	</div>
	<!-- End of Main Content -->
	<script type="text/javascript">
		$('#scroll').scrollTop($('#scroll')[0].scrollHeight);
	</script>