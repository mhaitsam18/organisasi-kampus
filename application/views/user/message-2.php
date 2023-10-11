<ul class="chat-box chatContainerScroll">
	<?php foreach ($chat as $ball): ?>
		<?php if ($ball->id_user_from == $teman['id']): ?>
			<li class="chat-left">
				<div class="chat-avatar">
					<img src="<?= base_url('assets/img/profile/'.$teman['image']) ?>" alt="Retail Admin">
					<div class="chat-name"><?= $teman['name'] ?></div>
				</div>
				<?php if ($ball->is_read != 1): ?>
					<small class="text-center">Pesan Baru dibaca</small>
				<?php endif ?>
				<div class="chat-text"><?= $ball->message ?></div>
				<div class="chat-hour">
					<?php $date = date('Y-m-d', strtotime($ball->time)); ?>
					<?php if ($date == date('Y-m-d')): ?>
						<?= date('H:i', strtotime($ball->time)); ?>
					<?php elseif($date == date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-d'))))): ?>
						Kemarin<br>
						<?= date('H:i', strtotime($ball->time)); ?>
					<?php else: ?>
						<?= date('d/m/Y', strtotime($ball->time)) ?><br>
						<?= date('H:i', strtotime($ball->time)); ?>
					<?php endif ?>
					<?php if ($ball->is_read == 1): ?>
						<span class="fa fa-check-circle"></span>
					<?php else: ?>
						<span class="fa fa-check-circle text-secondary"></span>
					<?php endif ?>
				</div>
			</li>
		<?php else: ?>
			<li class="chat-right">
				<div class="chat-hour">
					<?php $date = date('Y-m-d', strtotime($ball->time)); ?>
					<?php if ($date == date('Y-m-d')): ?>
						Hari ini<br>
						<?= date('H:i', strtotime($ball->time)); ?>
					<?php elseif($date == date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-d'))))): ?>
						Kemarin<br>
						<?= date('H:i', strtotime($ball->time)); ?>
					<?php else: ?>
						<?= date('d/m/Y', strtotime($ball->time)) ?><br>
						<?= date('H:i', strtotime($ball->time)); ?>
					<?php endif ?>
					<?php if ($ball->is_read == 1): ?>
						<span class="fa fa-check-circle"></span>
					<?php else: ?>
						<span class="fa fa-check-circle text-secondary"></span>
					<?php endif ?>
				</div>
				<div class="chat-text" style="background-color: #bcf7ce;"><?= $ball->message ?></div>
				<div class="chat-avatar">
					<img src="<?= base_url('assets/img/profile/'.$user['image']) ?>" alt="Retail Admin">
					<div class="chat-name">Saya</div>
				</div>
			</li>
		<?php endif ?>
	<?php endforeach ?>
</ul>
<script type="text/javascript">
	// $('#scroll').scrollTop($('#scroll')[0].scrollHeight);
</script>