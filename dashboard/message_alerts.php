<li class="header">You have <?php print apply_filters('the_unread_inbox_count', $_profile['username'], $_conn); ?> messages</li>
<li>
	<!-- inner menu: contains the actual data -->
	<ul class="menu">
		<?php 
			add_filter ( 'get_inbox', 'getInbox', 10, 2 );
			add_filter ( 'get_unread_inbox', 'getUnreadInbox', 10, 2 );
		
			$_messages = apply_filters ( 'get_unread_inbox', $_profile['username'], $_conn );
			
			foreach ( $_messages as $_message ) {
				if ($_message['status'] == 1) {
					$_message ['subject'] = '<b>' . $_message ['subject'] . '</b>';
					$_avatar = get_gravatar($_profile['email']);
				} else {
					$_message ['subject'] = $_message ['subject'];
					$_avatar = get_gravatar($_profile['email']);
				}
				print '
					<li><a href="' . BASE_URL . 'dashboard/messages/inbox/?pa=read&id=' . $_message ['id'] . '">
							<div class="pull-left">
								<img src="' . $_avatar . '" class="img-circle"
									alt="avatar" />
							</div>
							<h4>
								' . $_message ['subject'] . ' <small><i class="fa fa-clock-o"></i> ' . getTime($_message ['date']) . '</small>
							</h4>
							<p><small>From: ' . $_message ['from'] . '</small></p>
					</a></li>							
				';			
			}			
		?>
		</ul>
	</li>
	<li class="footer"><a href="<? print BASE_URL . 'dashboard/messages/inbox/'; ?>">See All Messages</a></li>
</ul></li>