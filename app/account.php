<?php
/**
 * bugspray issue tracking software
 * Copyright (c) 2009-2010 a2h - http://a2h.uni.cc/
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Under section 7b of the GNU General Public License you are
 * required to preserve this notice. Additional attribution may be
 * found in the NOTICES.txt file provided with the Program.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// todo: move stuff into a template

include("functions.php");

if (isset($_GET['id']) && $_GET['id'] != $_SESSION['uid'])
{
	if (is_numeric($_GET['id']))
	{
		if ($users->client->is_admin)
		{
			$id = $_GET['id'];
		}
		else
		{
			$id = false;
		}
	}
}
else
{
	$id = $_SESSION['uid'];
}

$profile = db_query_single("SELECT users.*, groups.name AS group_name FROM users LEFT JOIN groups ON groups.id = users.group WHERE users.id = '$id'");

// bad id? non-admin? don't go through! oh, and make sure the profile exists!
if ($id && $profile)
{
$page->setType('account');
$page->setTitle($profile['username'] . '\'s account');

$subpage = $_GET['p'];
?>

<div class="imgtitle imgtitle-32">
	<img class="image" src="<?php echo $location['images']; ?>/titles/account.png" alt="" />
	<img src="<?php echo getav($id); ?>" style="position: absolute; top: 16px; left: 16px; width: 16px; height: 16px;" alt="" />
	<div class="text">
		<h1><?php echo $profile['username']; ?>'s account</h1>
	</div>
	<div class="clear"></div>
</div>

<div class="tabs">
	<a href="account.php"<?php echo !$subpage ? ' class="sel"' : '' ?>>Home</a>
	<a href="account.php?p=pms"<?php echo $subpage == 'pms' ? ' class="sel"' : '' ?>><s>Private Messages</s></a>
	<a href="account.php?p=avatar"<?php echo $subpage == 'avatar' ? ' class="sel"' : '' ?>>Avatar</a>
	<a href="account.php?p=login"<?php echo $subpage == 'login' ? ' class="sel"' : '' ?>>Login</a>
	<div class="fc"></div>
</div>

<?php
if (!$subpage)
{
	$subpage = 'home';
}

switch ($subpage)
{
	case 'home':
		echo '<p>This is a temporary home page for your account settings.
		There\'s nothing to show here yet, perhaps later in mintytracker\'s life there will be. Until then, take a look at the tabs above.</p>';
		break;
	
	case 'avatar':
		echo '
		<form action="" method="post">			
			<p>
				<input type="radio" name="avatar-type" id="avatar-custom" tabindex="1" value="local" checked />
				<label for="avatar-custom">
				<img src="' . getav($id) . '" alt="" style="width: 32px; height: 32px;" />
				<img src="' . getav($id) . '" alt="" style="width: 16px; height: 16px;" />
				Custom
				</label>
				<a href="#" tabindex="2">(change)</a>
				<br />
				
				<input type="radio" name="avatar-type" id="avatar-gravatar" tabindex="3" value="gravatar" />
				<label for="avatar-gravatar">
				<img src="http://www.gravatar.com/avatar/' . md5($users->client->info['email']) . '?s=32" alt="" />
				<img src="http://www.gravatar.com/avatar/' . md5($users->client->info['email']) . '?s=16" alt="" />
				Gravatar
				</label>
				<a href="http://gravatar.com/" tabindex="4">(change)</a>
			</p>
			<p>
				<input type="submit" value="Save" disabled />
			</p>
		</form>';
		break;
		
	case 'login':
		echo '
		<form class="config" action="" method="post">
			<p>
				<label class="big" for="email">Email</label>
				<input class="big unchanged" type="text" id="email" name="email" tabindex="5" value="' . $users->client->info['email'] . '" />
				
				<input type="checkbox" id="email-show" name="email-show" tabindex="6" /> <label for="email-show">Public</label>
			</p>
			<p>
				<label class="big" for="password">Password</label>
				<input class="big unchanged" type="password" id="password" name="password" tabindex="7" value="you spin me right round" />
			</p>
			<p>
				<input type="submit" value="Save" disabled />
			</p>
		</form>';
		break;
}

}
// bad id? non-admin? non-existent profile? it am be 404 tiem
else
{
$page->setType('error');
?>
<div class="imgtitle imgtitle-32">
	<img class="image" src="<?php echo $location['images']; ?>/titles/error.png" alt="" />
	<div class="text">
		<h1>Error!</h1>
	</div>
	<div class="clear"></div>
</div>
<p>Oh dear! It looks like you either don't have permission to access this page, or it doesn't exist!</p>
<p>If perhaps your problem is due to permissions, have a look-see if you're logged in. If you are, perhaps
this is a restricted page.</p>
<p>Perhaps it's not permissions? If you typed out the address to this page manually, be sure to check if your spllnig is correct!
Otherwise, pop around to the <a href="./">home page</a> and try and see if you can find what you were looking for.</p>
<?php
}
?>