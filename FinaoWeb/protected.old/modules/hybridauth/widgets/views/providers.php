<!--<div id="hybridauth-openid-div">
	<!--<p>Enter your OpenID identity or provider:</p>
	<form action="<?php echo $this->config['baseUrl'];?>/default/login/" method="get" id="hybridauth-openid-form" >
		<input type="hidden" name="provider" value="openid"/>
		<input type="text" name="openid-identity" size="30"/>
	</form>
</div>-->
 <div id="hybridauth-confirmunlink">
	<!--<p>Unlink provider?</p>-->
	<form action="<?php echo $this->config['baseUrl'];?>/default/unlink" method="post" id="hybridauth-unlink-form" >
		<input type="hidden" name="hybridauth-unlinkprovider" id="hybridauth-unlinkprovider" value=""/>
	</form>
</div>

<?php foreach (Yii::app()->user->getFlashes() as $key => $message): ?>
	<div class="flash-error"> <?php //echo $message ?> </div>
<?php endforeach; ?>		
<!--Added by varam on 08-01-13 at 5.40pm to get only facebook icon for registering at friends page -->

<?php if(isset($isFb)&& ($isFb == "facebook" || $isFb == "all")):?>
	<ul class='hybridauth-providerlist'>
		<li>
				<a id="hybridauth-<?php echo $providers ?>" href="<?php echo $baseUrl?>/default/login/?provider=<?php echo $providers ?>" >
					
					<img src="<?php echo Yii::app()->baseUrl;?>/images/login_icons/<?php echo strtolower($providers);?>.png" alt="<?php echo strtolower($providers);?>" title="<?php echo strtolower($providers);?>" id="<?php echo strtolower($providers);?>"/>
				</a>
			</li>
	</ul>
<?php else:?>
<ul class='hybridauth-providerlist'>
	<?php foreach ($providers as $provider => $settings): ?>
		<?php if($settings['enabled'] == true): ?> 
			<li <?php if ($settings['active']==true): ?>
					class='active'					
				<?php else: ?>
					class='inactive'
				<?php endif; ?>
			>
				<a id="hybridauth-<?php echo $provider ?>" href="<?php echo $baseUrl?>/default/login/?provider=<?php echo $provider ?>" >
					<!--<img src="<?php echo $assetsUrl ?>/images/<?php echo strtolower($provider)?>.png"/>-->
					<img src="<?php echo Yii::app()->baseUrl;?>/images/login_icons/<?php echo strtolower($provider);?>.png" alt="<?php echo strtolower($provider);?>" title="<?php echo strtolower($provider);?>" id="<?php echo strtolower($provider);?>"/>
				</a>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>
<?php endif;?>
