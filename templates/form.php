<div class="formOfContact">
<form action="<?php the_permalink(); ?>" method="post">

<?php if($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
	<?php if(empty($_POST["form_name"])): ?>
		 <div class="error">
		  <p>
                    Sorry but you need to enter your name and email to complete your request.
		  </p>
		</div>
        <?php else: ?>
		<div class="success">
		  <p>
		    Thank you <strong> <?php echo $_POST['form_name'];?></strong>, for your inquiry. You will be contacted shortly.
		  </p>
		</div>
		<?php
		    $name = sanitize_text_field($_POST['form_name']);
		    $email = sanitize_email($_POST['form_email']);
		    $message = sanitize_text_field($_POST['form_message']);

		    global $wpdb;
		    $tableName = $wpdb->prefix . 'contact_list';
		    $wpdb->insert(
			 $tableName,
			 array(
			   'name'=>$name,
			   'email'=>$email,
			   'message'=>$message, 
			 ) 
		    ); 

		    $adminEmail = get_option('admin_email');
		    wp_mail($adminEmail,"Website Inquiry",$message); 
		?>
		
	<?php endif;?>
<?php endif; ?>


	<div class="row">
	 <div class="small-12 medium-12 columns">
	   <label>Name</label>
	  <input type="text" name="form_name" />
	 </div>
	</div>

	<div class="row">
	 <div class="small-12 medium-12 columns">
	   <label>Email</label>
	   <input type="email" name="form_email"/>
	 </div>
	</div>

	<div class="row">
	 <div class="small-12 medium-12 columns">
	   <label>Message</label>
	    <textarea cols="20" rows="10" name="form_message"></textarea>
	 </div>
	</div>

	<div class="row">
	 <div class="small-12 medium-12 columns">
	<input type="submit" value="Send Message" name="submit" class="button"/>
	 </div>
	</div>
</form>
</div>
