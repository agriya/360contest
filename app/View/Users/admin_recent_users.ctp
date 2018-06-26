<section class="thumbnail no-pad top-mspace sep">
            <div class="no-mar no-bor clearfix box-head space sep-bot">
              <h5 class="pull-left"><i class="icon-user pinkc no-bg"></i> <?php echo __l('Recently Registered Users'); ?></h5>
            </div>
            <section class="space">
              
							<?php
							if (!empty($recentUsers)):
							$users = '';
							foreach ($recentUsers as $user):
							$users .= sprintf('%s, ',$this->Html->link($this->Html->cText($user['User']['username'], false), array('controller'=> 'users', 'action' => 'view', $user['User']['username'], 'admin' => false),array('title'=>$this->Html->cText($user['User']['username'], false))));
							endforeach;
							echo '<p>'.substr($users, 0, -2).'</p>';
							else:
							?>
							<p class="notice"><?php echo __l('Recently no users registered');?></p>
							<?php
							endif;
							?>
							</section>
          </section>